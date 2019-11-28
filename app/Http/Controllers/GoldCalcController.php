<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Goutte\Client;
use Twilio\Rest\Client as TwilioClient;
use App\EmployeeModel;
use Illuminate\Support\Facades\DB;

class GoldCalcController extends Controller
{
    // Showign Calculator
    public function showCalc(){
        return view('USDToGoldCalc',["data"=>DB::table('employees')->whereNotNull('phone')->get()]);
    }


    // geting all price and sending back to calculator
    public function getGoldandUSDPrice(Request $request){
        $USDvalue = $request->USDvalue;
        $INRvalueIN1USD = $this->getINRto1USD();
        $INRto1gGold = $this->getINRto1gGOLD();

        $USDtoINRConverted = $USDvalue*$INRvalueIN1USD;
        $GoldQuientityIngForINR = $USDtoINRConverted/$INRto1gGold;
        return response()->json([
            'received'=>true,
            'data'=>[
                "USDtoINRConverted" => $USDtoINRConverted,
                "GoldQuientityIngForINR" => $GoldQuientityIngForINR,
                "INRvalueIN1USD" => $INRvalueIN1USD,
                "INRto1gGold" => $INRto1gGold,
            ],
        ],200);
    }
    // geting 1 USD value in INR
    private function getINRto1USD(){
        $client = new Client();

        $crawler = $client->request('GET', 'https://transferwise.com/in/currency-converter/usd-to-inr-rate');
        $USD_IN_1_INR = $crawler->filterXPath("//span[contains(@class,'text-success')]")->text();
        
        //removing , and converting to float
        $USD_IN_1_INR_R = floatval (str_replace(",","",$USD_IN_1_INR));
        return($USD_IN_1_INR_R);
    }

    // Geting 10g GOld Prince in INR
    private function getINRto1gGOLD(){
        $client = new Client();

        $crawler = $client->request('GET','https://www.policybazaar.com/gold-rate/');
        $INR_10g_Gold = $crawler->filterXPath("//div[contains(@class,'dailyGoldrate')]")->text();
        //removing , and converting to float
        $INR_10g_Gold_R = floatval (str_replace(",","",$INR_10g_Gold));
        return($INR_10g_Gold_R/10);
    }






    // Sending Message
    public function sendMessageToUser(Request $request){
        $selectMultiEMP = $request->selectMultiEMP;
        $INRvalueIN1USD = $request->INRvalueIN1USD;
        $INRto1gGold = $request->INRto1gGold;
        foreach ($selectMultiEMP as $key => $value) {
            $this->sendMessage('Hello current INR value is '.$INRvalueIN1USD.' and Gold value is '.$INRto1gGold,'+91'.$value);
        }

        return redirect()->route('Employee.index')->with('success','Message Sent to selected users.');
        
    }

    // Dispatching Message
    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new TwilioClient($account_sid, $auth_token);
        try {
            $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
            return(true);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return(false);
        }
        
    }
}
