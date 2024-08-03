<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

trait  SendSmsMisrTrait
{
  public function SendSmsMisr($mobile,$smscontent)
  {
    $SMSMISR_USERNAME  =config('smsmisr.username');
    $SMSMISR_PASSWORD  =config('smsmisr.password');
    $SMSMISR_SENDER    =config('smsmisr.sender');
    $LANGUAGE          =config('smsmisr.language');
    $ENVIRONMENT       =config('smsmisr.environment');
    $MOBILE            ='+2'.$mobile; // must be 11 digit
    $MESSAGE           =$smscontent;
    return  $response    = Http::post('https://smsmisr.com/api/SMS/?environment=2&username='.$SMSMISR_USERNAME.'&password='.$SMSMISR_PASSWORD.'&language='.$LANGUAGE.'&sender='.$SMSMISR_SENDER.'&mobile='.$MOBILE.'&message='.$MESSAGE/*.'&DelayUntil='.X*/ );

  }
  #=======================================================================================================================#
  public function CheckSendSmsMisrResponse($response,$success_message,$failed_message)
  {
    #check response
    if ($response->successful()) 
    {
      $responseData = $response->json();
      #1901 -->send sms done else not send
      ($responseData['code'] == '1901')?Log::info($success_message. json_encode($responseData)):Log::error($failed_message . $responseData['code']);
    }
    else 
    {
      Log::error('SMS API request failed. Status: ' . $response->status());
    }
  }
}
