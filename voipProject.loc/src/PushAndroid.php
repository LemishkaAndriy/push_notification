<?php
namespace Src;

class PushAndroid {

    // API access key from Google API's Console
    const GOOGLE_ACCESS_KEY = 'AAAA5EI9g-g:APA91bG5JcGd5_4oA__SOgLz_fqB0y77QFN9L2PpvxsXdkgJjMDT0VYVMI1oa5BfYqgSdEM-cqD6J_aYJnn61-CYfvNFGalaANzefnduF8uIphCEIrRBJBlej0UIn6VFcCxhl-V1Mp0b';
    // Phone Id
    const DEVICE_ID = "f_RL2KBlsaA:APA91bExYihSVZkU99K-gQqfaZR-MEJyMNZ3lM3IJ5XRD69mvBR_ot7K2uNjgqdCohwinBhaTcHxUHA256lZQc43vD7VdSCRrUKPS2ypCFFI9BBYVNoznHqjWLbQIagnrQUNkfy7HG-E";
    // URL where send push notification
    const URL_OF_GCM = 'https://fcm.googleapis.com/fcm/send';

    public function sendAnd($message = null)
    {
//        $logger = new \Monolog\Logger('name');
//        $logger->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

        // prep the bundle
        $msg = array
        (
            'title' => 'Calling...',
            'body' => $message ? $message : 'Message not exist'
        );
        $fields = array
        (
            'to' => self::DEVICE_ID,
            'priority' => 'high',
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
//        echo $result;
    }

}

