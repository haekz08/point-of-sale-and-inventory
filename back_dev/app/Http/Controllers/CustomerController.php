<?php

namespace App\Http\Controllers;

use App\Constants\CustomerLogTypes;
use App\Constants\PaymentModes;
use App\Customer;
use App\CustomerBalanceLogs;
use App\CustomerManualEntries;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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
        if(isset($this->request->per_page))
        {
            $data = Customer::where('name', 'like', '%'.$this->search.'%')
                    ->paginate($this->per_page);
        }elseif(isset($this->request->search)){
            $data = Customer::where('name', 'like', '%'.$this->search.'%')->get();
        }else{
            $data = Customer::all();
        }
        return response($data);
    }
    public function save(){
        $data = $this->request->all();
        $validate = Customer::where('name',$data['name'])
            ->when($data['id']!=-1, function($query) use ($data){
                $query->where('id','!=',$data['id']);
            })
            ->first();
        if($validate)
            return response('Record already exists.',422);

        if (isset($data['id']) && $data['id'] != -1) {
            $data['updated_by'] = $this->getUserId();
        } else {
            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();
        }

        $result = Customer::updateOrCreate(['id'=>$data['id']],$data);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function delete(){
        $data = $this->request->all();
        $result = Customer::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $result = Customer::find($data['id']);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function charged(){
        $data = $this->request->all();
        $result = Sale::
            when(!empty($data['search']), function($query) use ($data){
                $query->where('charged_number','like','%'.$data['search'].'%')
                    ->orWhereRaw("DATE_FORMAT(transaction_date, '%M %d, %Y') like ?", array('%' . $data['search'] . '%'));
            })
            ->where('payment_mode_id',PaymentModes::CHARGED)
            ->where('customer_id',$data['customer_id'])
            ->orderBy('transaction_date', 'desc')
            ->paginate($this->per_page);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function manualEntries(){
        $data = $this->request->all();
        $result = CustomerManualEntries::
            when(!empty($data['search']), function($query) use ($data){
                $query->where('remarks','like','%'.$data['search'].'%')
                    ->orWhereRaw("DATE_FORMAT(created_at, '%M %d, %Y') like ?", array('%' . $data['search'] . '%'));
            })
            ->where('customer_id',$data['customer_id'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->per_page);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function addManualEntries(){
        $data = $this->request->all();
        $data['created_by'] = $this->getUserId();
        $data['updated_by'] = $this->getUserId();
        DB::beginTransaction();
        try {
            CustomerManualEntries::create($data);

            $customer_logs = array(
                'customer_id'=>$data['customer_id'],
                'amount'=>$data['amount'],
                'remarks'=>CustomerLogTypes::TYPE5
            );
            $this->updateLogs($customer_logs);
            DB::commit();
            return response('Success',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
    }
    public function deleteManualEntries(){
        $data = $this->request->all();
        $result = CustomerManualEntries::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();

        $customer_logs = array(
            'customer_id'=>$result['customer_id'],
            'amount'=>$result['amount']['default'],
            'remarks'=>CustomerLogTypes::TYPE6
        );
        $this->updateLogs($customer_logs);
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }

    public function payments(){
        $data = $this->request->all();
        $result = Sale::
        when(!empty($data['search']), function($query) use ($data){
            $query->where('order_number','like','%'.$data['search'].'%')
                ->orWhereRaw("DATE_FORMAT(transaction_date, '%M %d, %Y') like ?", array('%' . $data['search'] . '%'));
        })
            ->where('is_payment',1)
            ->where('customer_id',$data['customer_id'])
            ->orderBy('transaction_date', 'desc')
            ->paginate($this->per_page);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }

    public function logs(){
        $data = $this->request->all();
        $result = CustomerBalanceLogs::
        when(!empty($data['search']), function($query) use ($data){
            $query->where('remarks','like','%'.$data['search'].'%')
                ->orWhereRaw("DATE_FORMAT(created_at, '%M %d, %Y') like ?", array('%' . $data['search'] . '%'));
        })
            ->where('customer_id',$data['customer_id'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->per_page);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function updateLogs($data){
        $customer = Customer::find($data['customer_id']);
        $data['current_balance'] = $customer['total_balance']['default'];
        $data['created_by'] = $this->getUserId();
        $data['updated_by'] = $this->getUserId();
        CustomerBalanceLogs::create($data);
    }
}
