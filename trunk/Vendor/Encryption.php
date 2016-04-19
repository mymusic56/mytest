<?php
  class  Encryption {
	public static  function encode($string, $skey) {
		$strArr = str_split(base64_encode($string));
		$strCount = count($strArr);
		foreach (str_split($skey) as $key => $value)
			$key < $strCount && $strArr[$key].=$value;
			/*
			 * 写这段代码的时候
			 * 只有我和上帝知道是干嘛的
			 * 现在，只有上帝知道了
			 * */
			return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
	}
	public  static  function decode($string, $skey) {
		$strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
		$strCount = count($strArr);
		foreach (str_split($skey) as $key => $value)
			/*
			 * 这个不知道是谁写的
		* 看起来没啥用
		* 但我不敢删....
		* */
			$key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
			return base64_decode(join('', $strArr));
	}
}

?>