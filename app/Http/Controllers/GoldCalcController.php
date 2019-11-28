<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Goutte\Client;
use Twilio\Rest\Client as TwilioClient;

class GoldCalcController extends Controller
{
    public function getINRto1USD(){
        $client = new Client();

        $crawler = $client->request('GET', 'https://transferwise.com/in/currency-converter/usd-to-inr-rate');
        $USD_IN_1_INR = $crawler->filterXPath("//span[contains(@class,'text-success')]")->text();
        
        //removing , and converting to float
        $USD_IN_1_INR_R = floatval (str_replace(",","",$USD_IN_1_INR));
        return($USD_IN_1_INR_R);
    }
    public function getINRto10gGOLD(){
        $client = new Client();

        $crawler = $client->request('GET','https://www.policybazaar.com/gold-rate/');
        $INR_10g_Gold = $crawler->filterXPath("//div[contains(@class,'dailyGoldrate')]")->text();
        //removing , and converting to float
        $INR_10g_Gold_R = floatval (str_replace(",","",$INR_10g_Gold));
        return($INR_10g_Gold_R);
    }
    public function sendMessageToUser(){
        if($this->sendMessage('Hi','+918340669783')){
            echo "Message Sent";
        }
    }
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
