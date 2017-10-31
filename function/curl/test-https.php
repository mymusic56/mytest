<?php
function curlPost($url, $data, $method='GET', $timeout = 30,$proxy='') {
    $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
    
    $opt = array(
        CURLOPT_HEADER  => 0,
        CURLOPT_RETURNTRANSFER  => 1,
        CURLOPT_TIMEOUT         => $timeout,
    );
    $method = strtoupper($method) ;
    if($method == 'POST'){
//         curl_setopt($ch, CURLOPT_POST, 1);
        $opt[CURLOPT_POST] = 1;
        $opt[CURLOPT_POSTFIELDS] = (array)$data;
    }elseif ($method == 'GET'){
        if(is_string($data)) {
            $url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
        } else {
            $url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
        }
    }
    
    if ($ssl){
        #设置证书
        /*
         * CURLOPT_SSL_VERIFYPEER 设置为true:
         * http_code = 0
         * curl_errno = 51
         * curl_error = string 'SSL: certificate subject name 'qm.com' does not match target host name 'www.qm.com'' 
         */
        $opt[CURLOPT_SSL_VERIFYPEER] = false;// 只信任CA颁布的证书
        /*
         * 绝对路径
         * 这个参数仅仅在和CURLOPT_SSL_VERIFYPEER一起使用时才有意义。
         */
        $opt[CURLOPT_CAINFO] = '/Windows/https/server.crt';// CA根证书（用来验证的网站证书是否是CA颁布）
        /*
         * 检查证书中是否设置域名，并且是否与提供的主机名匹配
         * 0 为不检查名称。 在生产环境中，这个值应该是 2（默认值）
         */
        $opt[CURLOPT_SSL_VERIFYHOST] = 0; 
        
        #不设置证书
//         $opt[CURLOPT_SSL_VERIFYHOST] = 2;
//         $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }
    
    $ch = curl_init($url);
    
    if($proxy){
        curl_setopt ($ch, CURLOPT_PROXY, $proxy);  
    }
    
    
    
    curl_setopt_array($ch, $opt);
    $ret = curl_exec($ch);
    $body = null;
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($ret, 0, $headerSize);
        $body = substr($ret, $headerSize);
        
        /*
         * 这种方式无法获取？？？？？
         */
        var_dump($ret, $body);
    }else{
        $curlErrorNo = curl_errno($ch);
        $curlError = curl_error($ch);
        $curlInfoCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['http_code'=>$curlInfoCode,'curl_errno' => $curlErrorNo, 'curl_error' => $curlError];
    }
    
    curl_close($ch);
    return $body;
}

// $proxy = 'http://192.168.11.177:8888';
$url = 'http://www.qm.com/api/apiaccess';
$data = array('name'=>'zhangsan');
$data = curlPost($url, $data, 'PSOT', 30, $proxy);
/**
 * 抓包后，为什么POST和GET都没有看到请求数据  ？？？？
 */
var_dump($data);

