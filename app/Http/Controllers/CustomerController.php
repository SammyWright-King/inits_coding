<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotification;
use App\Mail\ShippingOrder;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Paystack;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = ['Uk', 'US'];
        $modes = ['Air', 'Sea'];
        return view('index', ['countries' => $countries, 'modes' => $modes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //save to customers table
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email_,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
            'country' => $request->country
        ]);

        //save to shipping table
        $shipping = $customer->shipping_order()->create([
            'product' => $request->product,
            'description' => $request->description,
            'pickup' => $customer->country,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'shipping_mode' => $request->mode
        ]);

        if($request->country == "Us"){
            $flat_rate = 1500;
        }else{
            $flat_rate = 800;
        }

        if($request->mode == 'Air'){
            $base_fare = 50000;
            $weighted_cost = $request->weight * 10000;
        }else{
            $base_fare = 15000;
            $weighted_cost = $request->weight * 2000;
        }

        $cal_sum = $base_fare + $flat_rate + $weighted_cost;
        $tax_per = 0.1 * $cal_sum;
        $final_sum = $cal_sum + $tax_per;

        $ref = uniqid('user_');

        $billing = $shipping->billing()->create([
            'base_fare' => $base_fare,
            'weighted_cost' => $weighted_cost,
            'origin_cost' => $flat_rate,
            'calculated_sum' => $cal_sum,
            'tax_per' => 10,
            'total_pay' => $final_sum,
            'ref' => $ref,
            'status' => 0
        ]);

        //mail to customer
        Mail::to($customer)->send(new ShippingOrder($shipping, 'customer'));

        //mail to default admin
        Mail::to('Sammywright.010@gmail.com', 'SuperFreighters')->send(new ShippingOrder($shipping, 'admin'));

        return $ref;
    }

    //handle pay redirection to url
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }

    public function handleCallBack(){
        $paymentDetails = Paystack::getPaymentData();
//        dd($paymentDetails);

        if($paymentDetails['status'] == TRUE){
            $ref = $paymentDetails['data']['reference'];

            Billing::where('ref', $ref)
                ->update(['status' => 1]);


            return "Thank you for choosing SuperFreighters, Your shipping Order has been Authorized";
        }else{
            return "There was a problem Authorizing your transactions. Shipping Order could not be completed";
        }

    }
}
