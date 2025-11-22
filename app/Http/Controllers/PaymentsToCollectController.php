<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsToCollectController extends Controller
{
    public function payment_index(){
        
        return view("payments.payments-to-collect.index");
    }
       public function payment_comments(){
        
        return view("payments.payments-to-collect.comments");
    }
     public function release_index(){
        
        return view("payments.payments-to-release.index");
    }
     public function payments_history(){
        
        return view("payments.payments-to-release.payments-history");
    }
}
