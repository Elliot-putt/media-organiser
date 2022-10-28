<?php

namespace App\Http\Controllers;

use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return \Inertia\Inertia::render('Home');
    }

    public function api()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVU0VSSUQiOiIyOTU1M0I2MC00RTYyLTRBOEMtQjdBMi1GNDkwMTZFODgyRTQiLCJpYXQiOjE2NDYzMTM5NTYsImV4cCI6MTk2MTg4OTk1Nn0.D19Ly4EqrHJpz7G6p2hivhlGcdcMHQcKwQw0yBpntzk';
//        $object = new \stdClass();
//        $object->merchantShopperReference = "f5819e1a-b759-494b-b1f4-c7b3bafafd7c";
//        $object->tokenType = 'Recurring';
//        $object->cardInformation = ['cardholderName' => "Mr Joe Doe", 'brand' => "Visa", 'cardNumber' => '4124356798123456', 'expiryYear' => '25', 'expiryMonth' => '12'];
//        $json = json_encode($object);
//        $response = \Illuminate\Support\Facades\Http::withBody($json, 'application/json')->withToken($token)->post("https://sandbox.unify.truevo.com/payments/tokens/register");

//        dd($response->json());



        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000562', 'tid' => '00009903'];
        $ob->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '4444333322221111', 'securityCode' => '651'];
        $ob->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json2 = json_encode($ob);
        $response2 = \Illuminate\Support\Facades\Http::withBody($json2, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID])->post("https://sandbox.unify.truevo.com/payments/sale");

        dd($response2->json());
    }

}
