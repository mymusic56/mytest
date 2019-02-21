<?php
require_once 'api-speech-1.6.0/ApiSpeech.php';

// 你的 APPID AK SK
const APP_ID = '14313670';
const API_KEY = 'NXLeQQOsFNFagDLpn2x9G5l9';
const SECRET_KEY = 'WtSu63svF9GfgCARtQKCffqygOBCHAw9 ';

$client = new AipSpeech(APP_ID, API_KEY, SECRET_KEY);
$res = $client->asr(file_get_contents('a1515860443786.wav'), 'wav', 16000, array(
    'dev_pid' => 1536,
));

var_dump($res);die;