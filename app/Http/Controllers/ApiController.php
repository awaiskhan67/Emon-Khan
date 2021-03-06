<?php

namespace App\Http\Controllers;

use App\Agreement;
use Illuminate\Http\Request;
use App\Property;
use App\User;

class ApiController extends Controller
{
    // get properties by type
    public function properties(Request $request)
    {
        if($request){
            $properties = Property::where('type_id', $request->type)->get();
            if($properties){
                return response()->json($properties);
            }
        }
    }

    // get agreement information
    public function agreementInfo(Request $request)
    {
        if($request->has('agreement')){
            $agreement = Agreement::find($request->agreement);
            // $paid = [];
            // foreach ($agreement->payments as $payment) {
            //    $paid[] += $payment->month;
            // }
            // return $paid;
            $data = [];
            $data['type'] = $agreement->property->type->name ?? 'Deleted';
            $data['property'] = $agreement->property->name;
            $data['tent'] = $agreement->tent->fname.' '.$agreement->tent->lname;
            $data['rent'] = $agreement->property->rate;
            // $data['paid'] = $paid;
            if($data){
                return response()->json($data);
            }
        }
    }

// PAYMENT MONTH STATUS
    public function paymentMonthStatus(Request $request)
    {
        $agreement = Agreement::findOrFail($request->agreement);
        $payments = $agreement->payments->where('month',$request->month)->pluck('amount')->sum();
        $rent = $agreement->property->rate;

        if ($payments == $rent) {
           $data = 'Paid';
        }
        elseif($payments == 0){
            $data = 'Unpaid';
        }
        else{
          $data = -($rent - $payments);
        }

        if($data){
            return response()->json($data);
        }
    }

    // GET WALLET BALANCE
    public function walletBalance(Request $request)
    {
       return $data = User::find($request->user)->wallet;
        if($data){
            return response()->json($data);
        }
    }
}
