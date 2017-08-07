<?php
class HttpRequest {
	public static function sendCurl($url,$data) {
		$ch = curl_init ();
		$header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return $output;
	}
	/**
	 * 静态方式发送HTTP请求，勉得生成对象
	 * @param string $url 请求地址
	 * @param string $method 请求方式 GET/POST
	 * @param string $refererUrl 请求来源地址
	 * @param array $data 发送数据
	 * @param string $contentType
	 * @param string $timeout
	 * @param string $proxy
	 * @return boolean
	 */
	public static function sendHttpRequest($url, $data, $refererUrl = '', $method = 'GET', $contentType = 'application/json', $timeout = 30, $proxy = false,$header=[]) {
	    $ch = null;
	    if('POST' === strtoupper($method)) {
	        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_HEADER,1 );
	        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	        if ($refererUrl) {
	            curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
	        }
	        if($contentType) {
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
	        }
	        if(is_string($data)){
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        } else {
	            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	        }
	    } else if('GET' === strtoupper($method)) {
	        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
	        if(is_string($data)) {
	            $real_url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
	        } else {
	            $real_url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
	        }
	        $ch = curl_init($real_url);
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	        if ($refererUrl) {
	            curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
	        }
	    } else {
	        $args = func_get_args();
	        return false;
	    }
	    if($proxy) {#设置代理
	        curl_setopt($ch, CURLOPT_PROXY, $proxy);
	    }
	    if($header)
	    {
	        //var_dump($header);
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
	    }
	    $info = curl_getinfo($ch);
	    $ret = curl_exec($ch);
	    $contents = array(
	            'httpInfo' => array(
	                    'send' => $data,
	                    'url' => $url,
	                    'ret' => $ret,
	                    'http' => $info,
	            )
	    );
	    $body = null;
	    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
	        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	        $header = substr($ret, 0, $headerSize);
	        $body = substr($ret, $headerSize);
	        //            MLoger::write('ChinaMobileSecondApi/sendRequest', $data. "\n ".$headerSize. "\n ".$header.$body."\n");
	    }else{
	        $curlErrorNo = curl_errno($ch);
	        $curlError = curl_error($ch);
	        $curlInfoCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        $message =  "\n ".$url."\n ".$data. "\n curl_info_http_code:".$curlInfoCode.', curl_error: '.$curlErrorNo.' '.$curlError;
	        curl_close($ch);
	        return ['http_curl_error_code' => $curlInfoCode.'-'.$curlErrorNo, 'http_curl_error_msg' => $curlError];
	    }
	    curl_close($ch);
	    return $body;
	}
}