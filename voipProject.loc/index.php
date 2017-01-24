<?php

use CodeMonkeysRu\GCM;

//use CodeMonkeysRu\GCM\Sender;

require_once('lib\GCMMessage\library\CodeMonkeysRu\GCM\Message.php');
require_once('lib\GCMMessage\library\CodeMonkeysRu\GCM\Sender.php');
require_once('lib\GCMMessage\library\CodeMonkeysRu\GCM\Response.php');
require_once('lib\GCMMessage\library\CodeMonkeysRu\GCM\Exception.php');


function fnSendAndroid()
{


    $key = "AAAA5EI9g-g:APA91bG5JcGd5_4oA__SOgLz_fqB0y77QFN9L2PpvxsXdkgJjMDT0VYVMI1oa5BfYqgSdEM-cqD6J_aYJnn61-CYfvNFGalaANzefnduF8uIphCEIrRBJBlej0UIn6VFcCxhl-V1Mp0b";

    $token1 = "f_RL2KBlsaA:APA91bExYihSVZkU99K-gQqfaZR-MEJyMNZ3lM3IJ5XRD69mvBR_ot7K2uNjgqdCohwinBhaTcHxUHA256lZQc43vD7VdSCRrUKPS2ypCFFI9BBYVNoznHqjWLbQIagnrQUNkfy7HG-E";
    $token2 = "eGpbQX0eBWc:APA91bHJidLxA4XwLWPRQAaf-NtgrmwlDl-KKiWHXcWd9L_10LQcz6roaFf5lKUYHMaNI0UmeRey5K0TG3TR9B6U0CIwwczdU3XMvSrxiIXy77kO4vPXxEr9n64ajpZDsyJTfNF1uj0F";

//
//    $sender = new CodeMonkeysRu\GCM\Sender($key);
//    $message = new CodeMonkeysRu\GCM\Message($token1, array("message" => "tesMessage"));

    $sender = new GCM\Sender($key);
    $message = new CodeMonkeysRu\GCM\Message(
        array($token1),
        array("data1" => "123", "data2" => "string")
    );

    $message
        ->setNotification(array("title" => "foo", "body" => "bar"))
        ->setCollapseKey("collapse_key")
        ->setDelayWhileIdle(true)
        ->setTtl(4)
        ->setDryRun(true)
        ->setPriority(CodeMonkeysRu\GCM\Message::PRIORITY_HIGH);


    try {
        $response = $sender->send($message);

        if ($response->getFailureCount() > 0) {
            $invalidRegistrationIds = $response->getInvalidRegistrationIds();
            foreach ($invalidRegistrationIds as $invalidRegistrationId) {
                //Remove $invalidRegistrationId from DB
                // на входе значение APS91bFY-2CYrriS-Dt6y9_dGHhkPVwy7njqFpfgpzGYlDT4l0SQeqKr-lc1OM0a2DQ33S3EKwy2YJn-upKxOT6rNwgk350xUM3g8VX65rkGocOQX80Ta34pwXo6fyn-usoaGUAm4lzsqbCL-gkzHZZXRX39kUQfnA
                fnDeleteToken($invalidRegistrationId);
            }
        }
        if ($response->getSuccessCount()) {
            echo 'отправлено сообщений на ' . $response->getSuccessCount() . ' устройств';
        }
    } catch (CodeMonkeysRu\GCM\Exception $e) {

        switch ($e->getCode()) {
            case CodeMonkeysRu\GCM\Exception::ILLEGAL_API_KEY:
            case CodeMonkeysRu\GCM\Exception::AUTHENTICATION_ERROR:
            case CodeMonkeysRu\GCM\Exception::MALFORMED_REQUEST:
            case CodeMonkeysRu\GCM\Exception::UNKNOWN_ERROR:
            case CodeMonkeysRu\GCM\Exception::MALFORMED_RESPONSE:
//                fnLog('Ошибка отправления на андроид ' . $e->getCode() . ' ' . $e->getMessage());
                echo('Ошибка отправления на андроид ' . $e->getCode() . ' ' . $e->getMessage());
                break;
        }
    }
}

$deviceToken = 'b5d91dcb142e8d2cda08adba887e9ab1c6674d3c89aed97539e1534ad7d2af84';
$passphrase = '';
$message = "hello !";

function sendToIOS($deviceToken, $passphrase, $message)
{


    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $fp = stream_socket_client(
        'ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

    echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    $body['aps'] = array(
        'title' => "Tiitle",
        'body' => $message,
        'sound' => 'default',

    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result)
        echo 'Message not delivered' . PHP_EOL;
    else
        echo 'Message successfully delivered' . PHP_EOL;

    // Close the connection to the server
    fclose($fp);

}


function sendAnd()
{
    // API access key from Google API's Console
    define('API_ACCESS_KEY', 'AAAA5EI9g-g:APA91bG5JcGd5_4oA__SOgLz_fqB0y77QFN9L2PpvxsXdkgJjMDT0VYVMI1oa5BfYqgSdEM-cqD6J_aYJnn61-CYfvNFGalaANzefnduF8uIphCEIrRBJBlej0UIn6VFcCxhl-V1Mp0b');
    $registrationIds = ['f_RL2KBlsaA:APA91bExYihSVZkU99K-gQqfaZR-MEJyMNZ3lM3IJ5XRD69mvBR_ot7K2uNjgqdCohwinBhaTcHxUHA256lZQc43vD7VdSCRrUKPS2ypCFFI9BBYVNoznHqjWLbQIagnrQUNkfy7HG-E'];
// prep the bundle
    $msg = array
    (
        'message' => 'here is a message. message',

    );
    $fields = array
    (
        'registration_ids' => $registrationIds,
        'data' => $msg
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
}

sendToIOS($deviceToken, $passphrase, $message);
sendAnd();
//fnSendAndroid();
