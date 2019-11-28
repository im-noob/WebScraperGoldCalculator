<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

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
}
