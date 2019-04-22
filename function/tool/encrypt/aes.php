<?php
class Aes
{
    private $key = '8URK6BX9L20DY8V0';
    private $signKey = '8URK6BX9L20DY8V0';
    /**
     *
     * @param $key 		密钥
     * @return String
     */
/*    public function __construct($key = null, $signKey = null) {

        if(is_null($key)) {
            throw new \Exception('set sccret key please.');
        }
        if(is_null($signKey)) {
            throw new \Exception('set sign key please.');
        }
        $this->key = $key;
        $this->signKey = $signKey;

    }*/
    /**
     * 签名 php sha256 Java  HmacSHA256
     * @param String content 签名内容
     * @return hex
     */

    public function sign($content) {

        return strtoupper(hash_hmac('sha256', $content, $this->signKey));

    }

    /**
     * 验签
     * @param content 	签名内容
     * @param sign		待验签名
     * @return			true：合法； false：非法
     * @throws Exception
     */
    public function verify($content, $sign) {

        if($sign == $this->sign($content)) {
            return true;
        }
        return false;

    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = bin2hex($data);
        return $data;

    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {

        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);

    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,hex2bin($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
}

$input = '{"error":0,"message":"登录成功","data":{"user":{"id":7306,"unionid":17800,"imei":"68837f6b3c2683fd4b42a201072b987c","username":"","password":"aa0910bad6c7c95b2d114f69809c7582","accid":"60f4c6f2d1fd58e2c1878e3c6aad7732","yunxin_token":"238b5903a57723cde6de702726453003","nickname":"吃肉的兔子","salt":"8zdvUb","phone":"18580151305","is_validate_phone":1,"type":0,"gender":1,"age":27,"avatar":"7d2a39f785c8d2d31b7391827a517f5f.png","n_avatar":"","level":1,"charm":0,"proportion":90,"gift_proportion":90,"birthday":"1990\/11\/27","location":"重庆","province":0,"city":0,"area":0,"longitude":"106.502265","latitude":"29.60824","on_server":0,"activity":9,"sort_key":"C","reg_ip":"123.144.26.100","money":"287.00","gift_money":"0.00","diamond":18359,"wealth":0,"frozen_money":0,"income_money":"0.00","description":"","wechat_open_id":"","bind_id":"","access_token":"1yvzWeAIoqjuknU6w4fbPhm6qhtUb1hz_1511779350","ios_audit":0,"status":1,"warning_time":0,"equipment_alive":0,"last_login_time":1521092224,"login_ip":"192.168.88.1","online_status":0,"system":"android","version":"1.1.1","user_version":13,"channel":"default","is_vest":0,"created_at":1511779276,"updated_at":1521092224,"ad_post":0,"has_room":0},"need_perfect":0,"tag_count":0,"room":null}}';
$Aes = new Aes();
$t1 = microtime(true);
$aes_string = $Aes->encrypt($input);
$t2 = microtime(true);


$t3 = microtime(true);
$data = $Aes->decrypt($aes_string);
$t4 = microtime(true);

var_dump($t4-$t3, $t2- $t1);
var_dump($aes_string, $data);

var_dump(chr('65'));

/*
 * PHP 7
 */
$key = '8URK6BX9L20DY8V0';
//mcrypt_decrypt():  Only keys of sizes 16, 24 or 32 supported.
$data = openssl_encrypt($input, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
$decrypt_data = openssl_decrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

var_dump(bin2hex($data), $decrypt_data);