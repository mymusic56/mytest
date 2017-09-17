<?php
require "../vendor/autoload.php";
use telesign\sdk\phoneid\PhoneIdClient;
use telesign\sdk\messaging\MessagingClient;

class TeleSignTest{
    private $customer_id = '';
    private $api_key = '';
    public function __construct(){
        
    }
    
    public function voipTest(){
        $phone_number = "";
        $phone_type_voip = "5";
        
        $data = new PhoneIdClient($this->customer_id, $this->api_key);
        
        $response = $data->phoneid($phone_number);
        
        if ($response->ok) {
            if ($response->json['phone_type']['code'] == $phone_type_voip) {
                echo "Phone number $phone_number is a VOIP phone.";
            }
            else {
                echo "Phone number $phone_number is not a VOIP phone.";
            }
        }
        var_dump($response);
    }
    
    public function sendMsg(){
        $phone_number = "";
        $message = "You're scheduled for a dentist appointment at 2:30PM.";
        $message_type = "ARN";
        $messaging = new MessagingClient($this->customer_id, $this->api_key);
        $response = $messaging->message($phone_number, $message, $message_type);
        var_dump($response);
    }
}

$tst = new TeleSignTest();
$tst->voipTest();
// $tst->sendMsg();

