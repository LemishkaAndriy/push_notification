<?php

use CodeMonkeysRu\GCM;

//use CodeMonkeysRu\GCM\Sender;

require_once('pushNotification\PushAndroid.php');
require_once('pushNotification\PushIOS.php');

$deviceToken = 'b5d91dcb142e8d2cda08adba887e9ab1c6674d3c89aed97539e1534ad7d2af84';
$passphrase = '';
$message = "hello !";

$sendToIOS = new PushAndroid();
$sendToIOS->sendAnd('asdasd');
$sendToAnd = new PushIOS();
$sendToAnd->sendToIOS($deviceToken, $passphrase, $message);
//fnSendAndroid();
