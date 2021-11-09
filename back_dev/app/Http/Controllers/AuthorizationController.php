<?php

namespace App\Http\Controllers;

use App\AuthorizationCode;
use App\AuthorizationCodeDesignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
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
    public function check(){
        $data = $this->request->all();
        $authorization_code = AuthorizationCode::where('code',$data['code'])->get()->first();
        if(!empty($authorization_code)){
            $authorization_code_designation = AuthorizationCodeDesignation::where('authorization_code_id',$authorization_code['id'])->get()->first();
            if(!empty($authorization_code_designation))
                return response($authorization_code_designation,200);
            return response('Internal Server Error',500);
        }
        return response('Internal Server Error',500);
    }
}
