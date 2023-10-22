<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function payment(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'amount' => 'required',
            "terms" => "required",
        ]);
        $tran_id = "juralacuity" . rand(1111111, 9999999); //unique transection id for every transection

        $currency = "BDT"; //aamarPay support Two type of currency USD & BDT

        $amount = $request->amount; //10 taka is the minimum amount for show card option in aamarPay payment gateway

        //For live Store Id & Signature Key please mail to support@aamarpay.com
        $store_id = "juralacuity";

        $signature_key = "5040d6590436ed0624ea88d8d7009742";
        $url = "https://secure.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "store_id": "' . $store_id . '",
            "tran_id": "' . $tran_id . '",
            "success_url": "' . route('success') . '",
            "fail_url": "' . route('fail') . '",
            "cancel_url": "' . route('cancel') . '",
            "amount": "' . $amount . '",
            "currency": "' . $currency . '",
            "signature_key": "' . $signature_key . '",
            "desc": "Merchant Registration Payment",
            "cus_name": "' . $request->first_name . ' ' . $request->last_name . '",
            "cus_email": "' . $request->email . '",
            "cus_add1": "' . $request->address . '",
            "cus_add2": "' . $request->address2 . '",
            "cus_city": "' . $request->city . '",
            "cus_state": "",
            "cus_postcode": "' . $request->post_code . '",
            "cus_country": "' . $request->country . '",
            "cus_phone": "' . $request->phone . '",
            "cus_company": "' . $request->company . '",
            "type": "json"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responseObj = json_decode($response);

        if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {
            try {
                Payment::create([
                    "name" => $request->first_name . ' ' . $request->last_name,
                    "address" => $request->address,
                    "address2" => $request->address2,
                    "city" => $request->city,
                    "invoice" => $request->invoice,
                    "country" => $request->country,
                    "company" => $request->company,
                    "phone" => $request->phone,
                    "email" => $request->email,
                    "amount" => $request->amount,
                    "tran_id" => $tran_id,
                    "status" => "pending",
                ]);
                $paymentUrl = $responseObj->payment_url;

                return redirect()->away($paymentUrl);
            } catch (\Exception $e) {

            }

        } else {
            echo $response;
        }

    }

    public function success(Request $request)
    {
        if ($request->pay_status == 'Successful') {
            Payment::where('tran_id', $request->tran_id)->update([
                'status' => 'success',
                'card_type' => $request->card_type,
                'currency' => $request->currency,
            ]);
        }
        $request_id = $request->mer_txnid;

        //verify the transection using Search Transection API

        $url = "http://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=juralacuity&signature_key=5040d6590436ed0624ea88d8d7009742&type=json";

        //For Live Transection Use "http://secure.aamarpay.com/api/v1/trxcheck/request.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        // to extrarnal url
        return redirect()->away("https: //juralacuity.com/");
    }

    public function fail(Request $request)
    {
        Payment::where('tran_id', $request->tran_id)->update([
            'status' => 'fail',
        ]);
        return back();
    }

    public function cancel()
    {
        return back();
    }
}
