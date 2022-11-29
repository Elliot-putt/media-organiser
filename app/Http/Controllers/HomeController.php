<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use Faker\Provider\Uuid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Sebdesign\VivaPayments\Enums\TransactionStatus;
use Sebdesign\VivaPayments\Facades\Viva;
use Sebdesign\VivaPayments\Requests\CreatePaymentOrder;
use Sebdesign\VivaPayments\Requests\Customer;
use Sebdesign\VivaPayments\VivaException;

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

    public function refund()
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
        $obje->transaction = ["originalTransactionUniqueIdentifier" => $response['transactionUniqueIdentifier'], "merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $obje->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $obje->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $obje->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $obje->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];
        $json3 = json_encode($obje);
        $response2 = \Illuminate\Support\Facades\Http::withBody($json3, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID2])->post("https://unify.truevo.com/payments/linkedRefund");

        dd($response2->json());


    }

    public function api(Request $request)
    {
        //env

        //VIVA_CLIENT_ID="1vwzg5unet444lc3nj4evhgygjgq71upi4d54one36up2.apps.vivapayments.com"
        //VIVA_CLIENT_SECRET="c6qG7PAihu3SoZqs7b6ME9jM0ftE3D"
        //VIVA_API_KEY="rU0UC@"
        //VIVA_MERCHANT_ID="5a48ceed-d5cb-47df-b8c3-295af70cc01e"
        //VIVA_ENVIRONMENT="demo"

        //services.php
        
//        'viva' => [
//        'api_key' => env('VIVA_API_KEY'),
//        'merchant_id' => env('VIVA_MERCHANT_ID'),
//        'environment' => env('VIVA_ENVIRONMENT', 'production'),
//        'client_id' => env('VIVA_CLIENT_ID'),
//        'client_secret' => env('VIVA_CLIENT_SECRET'),
//        'isv_partner_id' => env('VIVA_ISV_PARTNER_ID'),
//        'isv_partner_api_key' => env('VIVA_ISV_PARTNER_API_KEY'),
//    ],


        try
        {
            $orderCode = Viva::orders()->create(new CreatePaymentOrder(
                amount: 1000,
                customerTrns: 'Short description of purchased items/services to display to your customer',
                customer: new Customer(
                    email: 'johdoe@vivawallet.com',
                    fullName: 'John Doe',
                    countryCode: 'GB',
                    requestLang: 'en-GB',
                ),
            ));
        } catch(VivaException $e)
        {
            report($e);

            return back()->withErrors($e->getMessage());
        }

        $redirectUrl = Viva::orders()->redirectUrl(
            ref: $orderCode,
            color: '0000ff',
            paymentMethod: 23,
        );

        return redirect()->away($redirectUrl);
    }

    /**
     * Redirect from the checkout page and get the order details from the API.
     */
    public function confirm(Request $request)
    {
        try
        {
            $transaction = Viva::transactions()->retrieve($request->input('t'));

        } catch(VivaException $e)
        {
            report($e);

            return back()->withErrors($e->getMessage());
        }

        $status = match ($transaction->statusId)
        {
            TransactionStatus::PaymentPending => 'The order is pending.',
            TransactionStatus::PaymentSuccessful => 'The order is paid.',
            TransactionStatus::Error => 'The order was not paid.',
        };

        return to_route('home')->with('success_message', $status);
    }

    public function fullPaymentApi(Request $request)
    {
        dd($request->all());
        //Todo:: Add merchantShopperReference field to user migrations
        $merchantShopperReference = 'kick_comp_' . strtolower(auth()->user()->name) . '_' . auth()->user()->id;
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJVU0VSSUQiOiJGQjc3NkY4My0zRjI1LTQ1NjQtQjY1My1DQ0VFNENCNThBMjYiLCJleHAiOjE5ODI1OTA1ODR9.ZMZSakOwVCoe-j8ZYMIlk2BNnzvNvIpSTiycRM_GQeo';
        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "kick-comp", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $ob->card['tokenRegistration'] = ['merchantShopperReference' => $merchantShopperReference, 'tokenProvider' => 'Truevo',];
        $ob->card['manual'] = ['cardholderName' => 'Mr John putt', 'number' => '5284120000007791', 'securityCode' => '661'];
        $ob->card['manual']['expiry'] = ['month' => '03', 'year' => '26'];

        $json2 = json_encode($ob);
        //post first payment
        $response2 = \Illuminate\Support\Facades\Http::withBody($json2, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID])->post("https://unify.truevo.com/payments/sale");

//        dd($response2->json());
        //get request for trans status
        $response3 = \Illuminate\Support\Facades\Http::withToken($token)->get("https://unify.truevo.com/payments/status?transactionUniqueIdentifier={$response2['transactionUniqueIdentifier']}");

//        dd($response3->json());
        //get the users saves card details doesn't work
        $response4 = \Illuminate\Support\Facades\Http::withToken($token)->get("https://unify.truevo.com/payments/tokens?merchantShopperReference={$merchantShopperReference}");

//        dd($response4->json());
        //paying with a token
        $GUID2 = Uuid::uuid();
        $object = new \stdClass();
        $object->idempotencyKey = $GUID2;
        $object->transaction = ["merchantReference" => "kick-comp", 'paymentReference' => 'test-payment-token', 'source' => 'ECOMMERCE'];
        $object->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $object->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $object->card['tokenPayment'] = ['token' => $response3['tokenData']['token'], 'merchantShopperReference' => $merchantShopperReference, 'tokenProvider' => 'Truevo', 'tokenType' => 'OneClickPayment', 'securityCode' => '661'];
        $json3 = json_encode($object);

        //post second payment with token
        $response5 = \Illuminate\Support\Facades\Http::withBody($json3, 'application/json')->withToken($token)->withHeaders(['idempotencyKey' => $GUID2])->post("https://unify.truevo.com/payments/sale");

//        dd($response5->json());

        //get request for trans status
        $response6 = \Illuminate\Support\Facades\Http::withToken($token)->get("https://unify.truevo.com/payments/status?transactionUniqueIdentifier={$response5['transactionUniqueIdentifier']}");
        dd($response6->json());

        //TODO:: upon completing a first successful payment on the view ask if the user want's to save their card details if yes pass the below in the sale object
        //  $ob->card['tokenRegistration'] = ['merchantShopperReference' => 'kick_comp', 'tokenProvider' => 'Truevo',];
        // after this has been passed after using the flow get request form the payment use the array values tokenData save that token to the user profile and their ending numbers
        // the user will need a cvc number to proceed with the payment so in the view if they have a token and a card ending in "5678" then say fill in the cvc number that's belongs to that card
        // else have a button to change this payment method which will return another form where they are back to stage one.
        // as seen in the code above if they are paying via token payment and cvc pass a tokenPayment key instead of card details
    }

    public function successfull_transaction()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJVU0VSSUQiOiJGQjc3NkY4My0zRjI1LTQ1NjQtQjY1My1DQ0VFNENCNThBMjYiLCJleHAiOjE5ODI1OTA1ODR9.ZMZSakOwVCoe-j8ZYMIlk2BNnzvNvIpSTiycRM_GQeo';
        $GUID = Uuid::uuid();
        $ob = new \stdClass();
        $ob->idempotencyKey = $GUID;
        $ob->transaction = ["merchantReference" => "test-merchant-reference", 'paymentReference' => 'test-payment-reference', 'source' => 'ECOMMERCE'];
        $ob->transaction['amount'] = ["totalAmount" => 103.21, "currencyAlphaCode" => "GBP"];
        $ob->merchant = ['descriptor' => "Kick Comp 2", 'mid' => '00000596', 'tid' => '20000088'];
        $ob->tokenRegistration = ['merchantShopperReference' => "test-merchant-reference", 'tokenProvider' => 'Truevo',];
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

    public function tiny()
    {
        return Inertia::render('Auth/tiny');
    }

    public function mce()
    {
        return Inertia::render('Auth/mce');
    }

}


