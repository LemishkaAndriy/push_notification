<?php
namespace Src;

use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;
use Monolog\Handler\StreamHandler;
class PushAndroid {

    // API access key from Google API's Console
    const GOOGLE_ACCESS_KEY = 'AAAA5EI9g-g:APA91bG5JcGd5_4oA__SOgLz_fqB0y77QFN9L2PpvxsXdkgJjMDT0VYVMI1oa5BfYqgSdEM-cqD6J_aYJnn61-CYfvNFGalaANzefnduF8uIphCEIrRBJBlej0UIn6VFcCxhl-V1Mp0b';
    // Phone Id
    const DEVICE_ID = "eGpbQX0eBWc:APA91bHJidLxA4XwLWPRQAaf-NtgrmwlDl-KKiWHXcWd9L_10LQcz6roaFf5lKUYHMaNI0UmeRey5K0TG3TR9B6U0CIwwczdU3XMvSrxiIXy77kO4vPXxEr9n64ajpZDsyJTfNF1uj0F";
    // URL where send push notification
    const URL_OF_GCM = 'https://fcm.googleapis.com/fcm/send';

    public function sendAnd($message = null)
    {
//        $logger = new \Monolog\Logger('name');
//        $logger->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

        // prep the bundle
        $msg = array
        (
            'message' => $message ? $message : 'Message not exist',
        );
        $fields = array
        (
            'to' => self::DEVICE_ID,
            'data' => $msg
        );

        $headers = array
        (
            'Authorization: key=' . self::GOOGLE_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL_OF_GCM);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

    }

}

