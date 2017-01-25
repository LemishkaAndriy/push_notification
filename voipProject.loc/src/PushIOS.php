<?php
namespace App;

class PushIOS
{

    const DEVICE_TOKEN = 'b5d91dcb142e8d2cda08adba887e9ab1c6674d3c89aed97539e1534ad7d2af84';
    const PASS_KEY = '';

    public function say()
    {
        return 'ios nad android';
    }

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

//        echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'title' => "Calling...",
            'body' => $message ? $message : 'Message not exist',
            'sound' => 'default'

        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        //Save status about delivery message
        $deliveringMessage = new LoggerMessage();
        echo($result);
        if (!$result) {
            $deliveringMessage->sendErrorMessage('Message did not delivered' . PHP_EOL);
        } else {
            $deliveringMessage->sendInfoMessage('Message successfully delivered' . PHP_EOL);
        }
        // Close the connection to the server
        fclose($fp);

    }
}
