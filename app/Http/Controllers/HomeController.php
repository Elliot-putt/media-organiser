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
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJVU0VSSUQiOiJGQjc3NkY4My0zRjI1LTQ1NjQtQjY1My1DQ0VFNENCNThBMjYiLCJleHAiOjE5ODI1OTA1ODR9.ZMZSakOwVCoe-j8ZYMIlk2BNnzvNvIpSTiycRM_GQeo';
        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 5.99, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $ob->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $ob->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json2 = json_encode($ob);
        $response = \Illuminate\Support\Facades\Http::withBody($json2, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID])->post("https://unify.truevo.com/payments/sale");

        $responseGet = \Illuminate\Support\Facades\Http::withToken($token)->get("https://unify.truevo.com/payments/status?transactionUniqueIdentifier={$response['transactionUniqueIdentifier']}");
        
        //refunds
        $GUID2 = Uuid::uuid();
        $obje = new \stdClass();
        $obje->idempotencyKey = $GUID2;
        $obje->transaction = ["originalTransactionUniqueIdentifier" => $response['transactionUniqueIdentifier'] , "merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $obje->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $obje->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $obje->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $obje->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json3 = json_encode($obje);
        $response2 = \Illuminate\Support\Facades\Http::withBody($json3, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID2])->post("https://unify.truevo.com/payments/linkedRefund");

        dd($response2->json());


    }
    public function wokring_production_payment()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJVU0VSSUQiOiJGQjc3NkY4My0zRjI1LTQ1NjQtQjY1My1DQ0VFNENCNThBMjYiLCJleHAiOjE5ODI1OTA1ODR9.ZMZSakOwVCoe-j8ZYMIlk2BNnzvNvIpSTiycRM_GQeo';
        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $ob->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $ob->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json2 = json_encode($ob);
        $response2 = \Illuminate\Support\Facades\Http::withBody($json2, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID])->post("https://unify.truevo.com/payments/sale");

//        dd($response2->json());
        //get request for trans status
        $response3 = \Illuminate\Support\Facades\Http::withToken($token)->get("https://unify.truevo.com/payments/status?transactionUniqueIdentifier={$response2['transactionUniqueIdentifier']}");

        dd($response3->json());


    }

    public function working_test_credentials()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVU0VSSUQiOiIyOTU1M0I2MC00RTYyLTRBOEMtQjdBMi1GNDkwMTZFODgyRTQiLCJpYXQiOjE2NDYzMTM5NTYsImV4cCI6MTk2MTg4OTk1Nn0.D19Ly4EqrHJpz7G6p2hivhlGcdcMHQcKwQw0yBpntzk';
        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000562', 'tid' => '00009903'];
        $ob->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $ob->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json2 = json_encode($ob);
        $response2 = \Illuminate\Support\Facades\Http::withBody($json2, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID])->post("https://sandbox.unify.truevo.com/payments/sale");
        //get request for trans status
        $response3 = \Illuminate\Support\Facades\Http::withToken($token)->get("https://sandbox.unify.truevo.com/payments/status?transactionUniqueIdentifier={$response2['transactionUniqueIdentifier']}");

        dd($response3->json());
    }

}


