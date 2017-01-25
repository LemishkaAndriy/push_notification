<?php
require __DIR__ . '/vendor/autoload.php';

use App\PushIOS;
use App\PushAndroid;
use App\Config;
use App\LoggerMessage;


function pushCall()
{
//    $config = new \Src\Config();
//    $config->get('androidApiKey');


    $deviceToken = '2fdd018c7f5a5a672ffcfec536c6e2e5c58ac0ae488e7752d352f60247b3d0e9';
    $passphrase = '';
    $log = new LoggerMessage();
    if (
//        isset($_GET["param1"]) && isset($_GET["param2"]) && isset($_GET["param3"]) && isset($_GET["param4"]) ||
//        isset($_GET["param5"]) && isset($_GET["param6"]) && isset($_GET["param7"]) && isset($_GET["param8"])
    true
    )
    {

            $info = $_GET["param1"] ? $_GET["param1"] : '' ;
            $callingparty = $_GET["param2"] ? $_GET["param1"] : null;
            $clirestr = $_GET["param3"] ? $_GET["param1"] : null;
            $calledparty = $_GET["param4"] ? $_GET["param1"] : 'telefon not exist';
            $roammsc = $_GET["param5"] ? $_GET["param1"] : null;
            $roammsccallid = $_GET["param6"] ? $_GET["param1"] : null;
            $seqnumber_out = $_GET["param7"] ? $_GET["param1"] : null;
            $usedquota_out = $_GET["param8"] ? $_GET["param1"] : null;
            // Save Request parameters
            $log->sendInfoMessage('Request parameters' , [$_GET["param2"],$_GET["param2"],$_GET["param3"],$_GET["param4"],$_GET["param5"]
            ,$_GET["param6"],$_GET["param7"],$_GET["param8"]]);

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
            //Save responce parameters
            $log->sendInfoMessage('Response parameters' , [$command_in, $roammsccal_in, $status_in, $destrout_in
            ,$duration, $seqNumber,$adcall_in]);

            return $command_in . " \n " . $roammsccal_in . "\n "
            . $status_in . " \n " . $destrout_in . " \n "
            . $duration . " \n " . $seqNumber . " \n " . $adcall_in;

    }
    else {
        $log->sendInfoMessage('Wrong request parameters' , [$_GET["param2"],$_GET["param2"],$_GET["param3"],$_GET["param4"],$_GET["param5"]
            ,$_GET["param6"],$_GET["param7"],$_GET["param8"]]);
        throw new \Exception('Some parameters did not send');
    }

}
echo 'call';
echo pushCall();





//http://localhost/push_notification/voipProject.loc/pushServer.php?param1=1&param2=37253131519&param3=1&param4=37253131520&param5=358508796&param6=401D413C04BF1E&param7=FFFF&param8=FF

