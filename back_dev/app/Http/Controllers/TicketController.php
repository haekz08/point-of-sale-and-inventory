<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
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
    public function save(){
        $data = $this->request->all();
        $ticket = Ticket::where('created_by',$this->getUserId())->first();
        $ticket->cashier_id = $data['cashier_id'];
        $ticket->payment_mode_id = $data['payment_mode_id'];
        $ticket->sales_rep_id = $data['sales_rep_id'];
        $ticket->transaction_date = $data['transaction_date'];
        $ticket->updated_by = $this->getUserId();
        $ticket->save();
        return empty($ticket) ? response('Internal Server Error',500) : response($ticket,200);
    }
    public function get(){
        $result = $this->getTicketWithDetails();
        if(empty($result)){
            //insert last settings
            $last_ticket = Ticket::withTrashed()->where('created_by',$this->getUserId())->latest()->first();
            $data=[];
            if($last_ticket)
                $data=$last_ticket->toArray();

            $data['created_by'] = $this->getUserId();
            $data['updated_by'] = $this->getUserId();
            $data['transaction_date'] = $last_ticket['transaction_date']['default'];
            Ticket::create($data);
            $result = $this->getTicketWithDetails();
        }
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function addDetails(){
        $data = $this->request->all();
        $data['created_by'] = $this->getUserId();
        $data['updated_by'] = $this->getUserId();
        $result = TicketDetail::create($data);
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function getTicketWithDetails(){
        return $result = Ticket::with([
            'ticket_details' => function ($query) {
                $query->with([
                    'product_location',
                    'product_unit' => function ($query) {
                        $query->with(['unit','product']);
                    },
                    'price_category',
                    'authorization_code_designation' => function ($query) {
                        $query->with(['staff','authorization_code']);
                    },
                ]);
            },
            'cashier',
            'sales_rep',
            'payment_mode'
        ])->where('created_by',$this->getUserId())->first();

    }
    public function deleteDetails(){
        $data = $this->request->all();
        $result = TicketDetail::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
}
