<?php

namespace App\Http\Controllers;

use App\Constants\CustomerLogTypes;
use App\Constants\PaymentModes;
use App\Customer;
use App\PaymentMode;
use App\ProductLocation;
use App\Sale;
use App\SaleDetail;
use App\Staff;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    protected $request;
    protected $search='';
    protected $per_page;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->per_page = isset($request->per_page) ? $request->per_page : $this->per_page;
        $this->search = isset($request->search) ? $request->search : $this->search;
    }
    public function getUserId(){
        return Auth::id();
    }

    public function all(){
        $data = $this->request->all();
        $result = Sale::
            when(!empty($data['search']), function($query) use ($data){
                $query->where('order_number','like','%'.$data['search'].'%')
                    ->orWhereRaw("DATE_FORMAT(transaction_date, '%M %d, %Y') like ?", array('%' . $data['search'] . '%'))
                    ->orWhereRaw('charged_number','like','%'.$data['search'].'%')
                    ->orWhereHas('customer', function($query) use ($data){
                        $query->where('name', 'like', '%'.$data['search'].'%');
                    })
                    ->orWhereHas('sales_rep', function($query) use ($data){
                        $query->where('name', 'like', '%'.$data['search'].'%');
                    })
                    ->orWhereHas('cashier', function($query) use ($data){
                        $query->where('name', 'like', '%'.$data['search'].'%');
                    })
                    ->orWhereHas('payment_mode', function($query) use ($data){
                        $query->where('description', 'like', '%'.$data['search'].'%');
                    });
            })
            ->withTrashed()
            ->with(['customer','sales_rep','cashier','payment_mode'])
            ->orderBy('transaction_date', 'desc')
            ->paginate($this->per_page);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function get(){
        $data = $this->request->all();
        $sale = Sale::with(
            [
                'customer',
                'sales_rep',
                'cashier',
                'payment_mode',
                'sale_details' => function ($query) {
                    $query->with([
                        'product_location',
                        'product_unit' => function ($query) {
                            $query->with(['unit','product']);
                        },
                        'price_category',
                        'sale_return_detail',
                        'authorization_code_designation' => function ($query) {
                            $query->with(['staff','authorization_code']);
                        },
                    ])
                    ->withTrashed();
                },
            ])
            ->withTrashed()
            ->find($data['id']);
        $product_locations = ProductLocation::all();
        $result = array(
            'sale' => $sale,
            'product_locations' => $product_locations
        );
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function save(){
        $data = $this->request->all();
        DB::beginTransaction();
        try {
            $grand_total = $data['grand_total'];
            $nonVat=number_format($grand_total-($grand_total*.12), 2, '.', '');
            $vat=number_format($grand_total-$nonVat, 2, '.', '');
            $vatable=$nonVat;

            $sales_data = array(
                'transaction_date'=>$data['transaction_date']['default'],
                'sub_total'=>$data['sub_total'],
                'discount'=>$data['discount'],
                'grand_total'=>$grand_total,
                'vatable'=>$vatable,
                'vat'=>$vat,
                'payment_mode_id'=>$data['payment_mode_id'],
                'sales_rep_id'=>$data['sales_rep_id'],
                'cashier_id'=>$data['cashier_id'],
                'created_by'=>$this->getUserId(),
                'updated_by'=>$this->getUserId(),
            );

            if($data['payment_mode_id']==PaymentModes::CHARGED)
            {
                $sales_data['charged_number'] = $data['charged_number'];
            }else{
                $sales_data['order_number'] = $data['order_number'];
            }
            if(!empty($data['check_number']))
                $sales_data['check_number'] = $data['check_number'];

            if(!empty($data['remarks']))
                $sales_data['remarks'] = $data['remarks'];


            if(isset($data['is_payment']) && !empty($data['is_payment']))
                $sales_data['is_payment'] = $data['is_payment'];


            if(!empty($data['customer_id']) && $data['customer_id']!=-1)
                $sales_data['customer_id'] = $data['customer_id'];

            $sale = Sale::create($sales_data);
            if($data['payment_mode_id']==PaymentModes::CHARGED)
            {
                $customer_logs = array(
                    'customer_id'=>$data['customer_id'],
                    'amount'=>$grand_total,
                    'remarks'=>CustomerLogTypes::TYPE1
                );
                $customer_controller = new CustomerController($this->request);
                $customer_controller->updateLogs($customer_logs);
            }
            if(isset($data['is_payment']) && !empty($data['is_payment']))
            {
                $customer_logs = array(
                    'customer_id'=>$data['customer_id'],
                    'amount'=>$grand_total + $data['discount'],
                    'remarks'=>CustomerLogTypes::TYPE2
                );
                $customer_controller = new CustomerController($this->request);
                $customer_controller->updateLogs($customer_logs);
            }
            foreach($data['ticket_details'] as $row){
                $sale_details_data = array(
                    'sale_id'=>$sale['id'],
                    'authorization_code_designation_id'=>$row['authorization_code_designation_id'],
                    'price_type'=>$row['price_type'],
                    'location_starting_inventory_id'=>$row['location_starting_inventory_id'],
                    'product_location_id'=>$row['product_location_id'],
                    'product_unit_id'=>$row['product_unit_id'],
                    'base_unit_qty'=>$row['base_unit_qty'],
                    'qty'=>$row['qty'],
                    'price'=>$row['price'],
                    'total'=>$row['total'],
                    'created_by'=>$this->getUserId(),
                    'updated_by'=>$this->getUserId(),
                );
                SaleDetail::create($sale_details_data);
            }

            $ticket = Ticket::find($data['id']);
            $ticket->updated_by = $this->getUserId();
            $ticket->save();
            $ticket->delete();

            DB::commit();
            return response('Success',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
        //$result = Customer::create(['id'=>$data['id']],$data);
    }
    public function return(){
        $data = $this->request->all();
        return $collection = collect($data);
        $collection->sum('sale_details.');
        DB::beginTransaction();
        try {

            foreach($data['sale_details'] as $row){
                $sale_details_data = array(
                    'sale_id'=>$sale['id'],
                    'authorization_code_designation_id'=>$row['authorization_code_designation_id'],
                    'price_type'=>$row['price_type'],
                    'location_starting_inventory_id'=>$row['location_starting_inventory_id'],
                    'product_location_id'=>$row['product_location_id'],
                    'product_unit_id'=>$row['product_unit_id'],
                    'base_unit_qty'=>$row['base_unit_qty'],
                    'qty'=>$row['qty'],
                    'price'=>$row['price'],
                    'total'=>$row['total'],
                    'created_by'=>$this->getUserId(),
                    'updated_by'=>$this->getUserId(),
                );
                SaleDetail::create($sale_details_data);
            }
            DB::commit();
            return response('Success',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
        //$result = Customer::create(['id'=>$data['id']],$data);
    }
    public function settings(){

        $payment_modes = PaymentMode::all();
        $staffs = Staff::all();
        $result=array(
            'payment_modes'=>$payment_modes,
            'staffs'=>$staffs
        );
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function delete(){
        DB::beginTransaction();
        try
        {
            $data = $this->request->all();
            $result = Sale::find($data['id']);
            $result->updated_by = $this->getUserId();
            $result->save();
            $result->delete();
            $this->deleteChildren($data['id']);

            DB::commit();
            return response('Successfully Deleted Record',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function deleteChildren($id){

        $result = SaleDetail::where('sale_id',$id)->get();
        if(!empty($result)){
            foreach($result as $row){
                $result = SaleDetail::find($row['id']);
                $result->updated_by = $this->getUserId();
                $result->save();
                $result->delete();
            }
        }


    }
}
