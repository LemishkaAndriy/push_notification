<?php
require __DIR__ . '/vendor/autoload.php';

use App\PushIOS;
use App\PushAndroid;
use App\Config;

function pushCall()
{
//    $config = new \Src\Config();
//    $config->get('androidApiKey');


    $deviceToken = 'b5d91dcb142e8d2cda08adba887e9ab1c6674d3c89aed97539e1534ad7d2af84';
    $passphrase = '';


    $info = $_GET["param1"];
    $callingparty = $_GET["param2"];
    $clirestr = $_GET["param3"];
    $calledparty = $_GET["param4"];
    $roammsc = $_GET["param5"];
    $roammsccallid = $_GET["param6"];
    $seqnumber_out = $_GET["param7"];
    $usedquota_out = $_GET["param8"];


    $sendToIOS = new PushAndroid();
    $sendToIOS->sendToAndroid($calledparty);
    $sendToAnd = new PushIOS();
    $sendToAnd->sendToIOS($deviceToken, $passphrase, $calledparty);


    $command_in = 1;
    $roammsccal_in = $roammsccallid;
    $status_in = 4;
    $destrout_in = 37256100502;
    $duration = 300;
    $seqNumber = 0;
    $adcall_in = 37253131520;

    return $command_in . " \n " . $roammsccal_in . "\n "
    . $status_in . " \n " . $destrout_in . " \n "
    . $duration . " \n " . $seqNumber . " \n " . $adcall_in;


}

echo pushCall();





//http://localhost/push_notification/voipProject.loc/pushServer.php?param1=1&param2=37253131519&param3=1&param4=37253131520&param5=358508796&param6=401D413C04BF1E&param7=FFFF&param8=FF

