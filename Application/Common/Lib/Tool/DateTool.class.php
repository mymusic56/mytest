<?php
namespace Common\Lib\Tool;
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(时间操作类)
 * @
 * @company
 * @copyright 本文件归属于
 * @date 2015-8-24 下午3:08:12
 * @version V1.0
 */
	class DateTool{

		/**
		 * 某一天的开时间戳时间格式必须保证是是2016?11?23 为好标识分割符
		 * @param string $date
		 * @param string $delimitation
		 * @return int
		 */
		public static function getOnedayStart($date='',$delimitation='-')
		{
			if(!$date){
				$Y = date('Y');
				$m = date('m');
				$d = date('d');
			}else{
				list($Y,$m,$d) = explode($delimitation,$date);
			}
			return mktime(0,0,0,$m,$d,$Y);
		}

		/**
		 * @param $dateString
		 * @return bool
		 */
		public static function  isDate( $dateString ) {
			return strtotime( date('Y-m-d', strtotime($dateString)) ) === strtotime( $dateString );
		}
		/**
		 * 某一天的束时间戳
		 * @param string $date
		 * @param string $delimitation
		 * @return int
		 */
		public static function getOnedayEnd($date='',$delimitation='-')
		{
			if(!$date){
				$Y = date('Y');
				$m = date('m');
				$d = date('d');
			}else{
				list($Y,$m,$d) = explode($delimitation,$date);
			}
			return mktime(0,0,0,$m,$d+1,$Y)-1;
		}
		/**
		 * @Title: getCHStimeDifference
		 * @Description: todo(获取显示中文的时间比:该文章已经发表 n天 x小时 y分z秒)
		 * @param 开始时间戳 $starttime
		 * @param 结束时间戳不传表示当前时间 $endtime
		 * @return string
		 * @throws
		 */
		public static function getCHStimeDifference($starttime,$endtime,$step)
		{
			// 判断结束时间是否传入，没有传入设置为当前时间
			if (empty($endtime)) {
				$endtime = time();
			}
			$resulttime = $endtime-$starttime;//取结束时间减去开始时间的差值
			$day = intval($resulttime/86400);//天
			$hour = intval(($resulttime-$day*86400)/3600);//小时
			$minute = intval(($resulttime-$day*86400-$hour*3600)/60);//分钟
			//$seconds = intval($resulttime-$day*86400-$hour*3600-$minute*60);//秒
			if($day){
				$str .= $day."天";
			}
			if($hour){
				$str .= $hour."时";
			}
			if($minute){
				$str .= $minute."分";
			}
			if($seconds){
				$str .= $seconds."秒";
			}
			return $str;
		}
		/**
		 * @Title: checkDateIsValid
		 * @Description: todo(检查一个日期格式是否合法)
		 * @param unknown_type $date
		 * @param unknown_type $formats
		 * @return boolean
		 * @
		 * @date 2015-8-24 下午2:17:58
		 * @throws
		 */
		public static function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d"))
		{
			$unixTime = strtotime($date);
			if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
				return false;
			}
			//校验日期的有效性，只要满足其中一个格式就OK
			foreach ($formats as $format) {
				if (date($format, $unixTime) == $date) {
					return true;
				}
			}
			//  	var_dump(checkDateIsValid("2013-09-10")); //输出true
			//  	var_dump(checkDateIsValid("2013-09-ha")); //输出false
			//  	var_dump(checkDateIsValid("2012-02-29")); //输出true
			//  	var_dump(checkDateIsValid("2013-02-29")); //输出false
			return false;
		}
		/**
		 * @Title: getlastMonthDays
		 * @Description: todo(获取某个月开始时间和结束时间)
		 * @param string $date
		 * @return multitype:string
		 * @
		 * @date 2015-8-24 下午3:13:46
		 * @throws
		 */
		public static function getlastMonthDays($date)
		{
			$date      = $date ? $date : date('Y-m-d',time());
			$timestamp = strtotime($date);
			$firstday  = date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
			$lastday   = date('Y-m-d',strtotime("$firstday +1 month -1 day"));
			return array('stime'=>$firstday,'etime'=>$lastday);
		}
		/**
		 * 获取指定月份的第一天开始和最后一天结束的时间戳
		 *
		 * @param int $y 年份 $m 月份
		 * @return array(本月开始时间，本月结束时间)
		 */
		public static function mFristAndLast($y="",$m="")
		{
			if($y=="") $y=date("Y");
			if($m=="") $m=date("m");
			$m=sprintf("%02d",intval($m));
			$y=str_pad(intval($y),4,"0",STR_PAD_RIGHT);

			$m>12||$m<1?$m=1:$m=$m;
			$firstday=strtotime($y.$m."01000000");
			$firstdaystr=date("Y-m-01",$firstday);
			$lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));
			return array("firstday"=>$firstday,"lastday"=>$lastday);
		}
		//今天开时间戳
		public static function gettodaystart()
		{
			return mktime(0,0,0,date('m'),date('d'),date('Y'));
		}
		//今天结束时间戳
		public static function gettodayend()
		{
			return mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		}
		//昨日开始时间戳
		public static function getyesterdaystart()
		{
			return mktime(0,0,0,date('m'),date('d')-1,date('Y'));
		}
		//昨日结束时间戳
		public static function getyesterdayend()
		{
			return mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
		}
		//获取上周起始时间戳
		public static function beginLastweek()
		{
			return mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
		}
		//获取上周结束时间戳
		public static function endLastweek()
		{
			return mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
		}
		//获取本月起始时间戳
		public static function beginThismonth()
		{
			return  mktime(0,0,0,date('m'),1,date('Y'));
		}
		//获取本月结束时间戳
		public static function endThismonth()
		{
			return mktime(23,59,59,date('m'),date('t'),date('Y'));
		}

		/**
		 * 获取昨天的日期
		 * @param string $dateformat
		 * @return bool|string
		 */
		public static function getYesTodayDate($dateformat="Y-m-d")
		{
			return (int)date($dateformat,strtotime("-1 day"));
		}

		/**
		 * 获取昨天的日期
		 * @param string $dateformat
		 * @return int
		 */
		public static function getTodayDate($dateformat="Y-m-d")
		{
			return (int)date($dateformat,strtotime("day"));
		}

		
		/**
		 * @param $month 当前月
		 * @param $year 当前年
		 * @return str  对传入的时间转换为黄历时间
		 */

		function lunarcalendar($month, $year)
		{
			global $lnlunarcalendar;
			/**  * Lunar calendar 博大精深的农历  * 原始数据和算法思路来自 S&S  */ /*  农历每月的天数。  每个元素为一年。每个元素中的数据为：  [0]是闰月在哪个月，0为无闰月；  [1]到[13]是每年12或13个月的每月天数；  [14]是当年的天干次序，  [15]是当年的地支次序  */
			$everymonth = array(
				0 => array(8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 29, 30, 7, 1),
				1 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 0, 8, 2),
				2 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 0, 9, 3),
				3 => array(5, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 10, 4),
				4 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 0, 1, 5),
				5 => array(0, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 30, 0, 2, 6),
				6 => array(4, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 3, 7),
				7 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 4, 8),
				8 => array(0, 30, 29, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 0, 5, 9),
				9 => array(2, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 30, 6, 10),
				10 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 0, 7, 11),
				11 => array(6, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 8, 12),
				12 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 0, 9, 1),
				13 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 0, 10, 2),
				14 => array(5, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 1, 3),
				15 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 2, 4),
				16 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 3, 5),
				17 => array(2, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 4, 6),
				18 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 0, 5, 7),
				19 => array(7, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 6, 8),
				20 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 0, 7, 9),
				21 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 8, 10),
				22 => array(5, 30, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 9, 11),
				23 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 10, 12),
				24 => array(0, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 0, 1, 1),
				25 => array(4, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 2, 2),
				26 => array(0, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 3, 3),
				27 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 29, 30, 30, 30, 0, 4, 4),
				28 => array(2, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 30, 5, 5),
				29 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 0, 6, 6),
				30 => array(6, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 7, 7),
				31 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 8, 8),
				32 => array(0, 30, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 9, 9),
				33 => array(5, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 10, 10),
				34 => array(0, 29, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 0, 1, 11),
				35 => array(0, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 2, 12),
				36 => array(3, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 29, 3, 1),
				37 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 0, 4, 2),
				38 => array(7, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 5, 3),
				39 => array(0, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 6, 4),
				40 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 7, 5),
				41 => array(6, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 8, 6),
				42 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 9, 7),
				43 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 10, 8),
				44 => array(4, 30, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 1, 9),
				45 => array(0, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 0, 2, 10),
				46 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 0, 3, 11),
				47 => array(2, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 4, 12),
				48 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 5, 1),
				49 => array(7, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 6, 2),
				50 => array(0, 29, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 0, 7, 3),
				51 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 8, 4),
				52 => array(5, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 9, 5),
				53 => array(0, 29, 30, 29, 29, 30, 30, 29, 30, 30, 29, 30, 29, 0, 10, 6),
				54 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 0, 1, 7),
				55 => array(3, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 2, 8),
				56 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 0, 3, 9),
				57 => array(8, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 29, 4, 10),
				58 => array(0, 30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 5, 11),
				59 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 0, 6, 12),
				60 => array(6, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 7, 1),
				61 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 0, 8, 2),
				62 => array(0, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 9, 3),
				63 => array(4, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 10, 4),
				64 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 0, 1, 5),
				65 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 0, 2, 6),
				66 => array(3, 30, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 3, 7),
				67 => array(0, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 30, 0, 4, 8),
				68 => array(7, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 5, 9),
				69 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 6, 10),
				70 => array(0, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 0, 7, 11),
				71 => array(5, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 30, 8, 12),
				72 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 0, 9, 1),
				73 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 0, 10, 2),
				74 => array(4, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 1, 3),
				75 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 0, 2, 4),
				76 => array(8, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 3, 5),
				77 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 0, 4, 6),
				78 => array(0, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 5, 7),
				79 => array(6, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 6, 8),
				80 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 0, 7, 9),
				81 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 0, 8, 10),
				82 => array(4, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 9, 11),
				83 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 10, 12),
				84 => array(10, 30, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 1, 1),
				85 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 2, 2),
				86 => array(0, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 0, 3, 3),
				87 => array(6, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 29, 4, 4),
				88 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 5, 5),
				89 => array(0, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 0, 6, 6),
				90 => array(5, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 30, 7, 7),
				91 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 0, 8, 8),
				92 => array(0, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 9, 9),
				93 => array(3, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 10, 10),
				94 => array(0, 30, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 1, 11),
				95 => array(8, 29, 30, 30, 29, 30, 29, 30, 30, 29, 29, 30, 29, 30, 2, 12),
				96 => array(0, 29, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 29, 0, 3, 1),
				97 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 4, 2),
				98 => array(5, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 29, 30, 5, 3),
				99 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 0, 6, 4),
				100 => array(0, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 0, 7, 5),
				101 => array(4, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 8, 6),
				102 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 9, 7),
				103 => array(0, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 0, 10, 8),
				104 => array(2, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 1, 9),
				105 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 2, 10),
				106 => array(7, 30, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 3, 11),
				107 => array(0, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 0, 4, 12),
				108 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 0, 5, 1),
				109 => array(5, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 6, 2),
				110 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 7, 3),
				111 => array(0, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 8, 4),
				112 => array(4, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 9, 5),
				113 => array(0, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 0, 10, 6),
				114 => array(9, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 1, 7),
				115 => array(0, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 29, 0, 2, 8),
				116 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 0, 3, 9),
				117 => array(6, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 4, 10),
				118 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 0, 5, 11),
				119 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 0, 6, 12),
				120 => array(4, 29, 30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 7, 1)
			);
			// 忘了加上这个：农历用字
			$lnlunarcalendar = array(
				'tiangan' => array("未知", "甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸"), 'dizhi' => array("未知", "子年（鼠）", "丑年（牛）", "寅年（虎）", "卯年（兔）", "辰年（龙）", "巳年（蛇）", "午年（马）", "未年（羊）", "申年（猴）", "酉年（鸡）", "戌年（狗）", "亥年（猪）"), 'month' => array("闰", "正", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二", "月"), 'day' => array("未知", "初一", "初二", "初三", "初四", "初五", "初六", "初七", "初八", "初九", "初十", "十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十", "廿一", "廿二", "廿三", "廿四", "廿五", "廿六", "廿七", "廿八", "廿九", "三十")
			);
			$mten = $lnlunarcalendar['tiangan'];
			// 农历天干
			$mtwelve = $lnlunarcalendar['dizhi'];
			// 农历地支
			$mmonth = $lnlunarcalendar['month'];
			// 农历月份
			$mday = $lnlunarcalendar['day'];
			// 农历日  // 阳历总天数 至1900年12月21日
			$total = 69 * 365 + 17 + 11;
			//1970年1月1日前的就不算了
			if ($year == "" || $month == "" || ($year < 1970 or $year > 2020)) return '';
			//超出这个范围不计算  // 计算到所求日期阳历的总天数-自1900年12月21日始

			for ($y = 1970; $y < $year; $y++) {
				// 先算年的和
				$total += 365;
				if ($y % 4 == 0) $total++;
			}
			// 再加当年的几个月
			$total += gmdate("z", gmmktime(0, 0, 0, $month, 1, $year));
			// 用农历的天数累加来判断是否超过阳历的天数
			$flag1 = 0;
			//判断跳出循环的条件
			$lcj = 0;
			while ($lcj <= 120) {
				$lci = 1;
				while ($lci <= 13) {
					@$mtotal += $everymonth[$lcj][$lci];
					if ($mtotal >= $total) {
						$flag1 = 1;
						break;
					}
					$lci++;
				}
				if ($flag1 == 1) break;
				$lcj++;
			}
			// 由上，得到的 $lci 为当前农历月， $lcj 为当前农历年  // 计算所求月份1号的农历日期
			$fisrtdaylunar = $everymonth[$lcj][$lci] - ($mtotal - $total);
			$results['year'] = $mten[$everymonth[$lcj][14]] . $mtwelve[$everymonth[$lcj][15]];
			$results['moth'] = $mmonth[$everymonth[$lcj][14]];
			//当前是什么年
			$daysthismonth = gmdate("t", gmmktime(0, 0, 0, $month, 1, $year));
			//当前月共几天
			$op = 1;
			for ($i = 1; $i <= $daysthismonth; $i++) {
				$possiblelunarday = $fisrtdaylunar + $op - 1;
				//理论上叠加后的农历日
				if ($possiblelunarday <= $everymonth[$lcj][$lci]) {
					// 在本月的天数范畴内
					$results[$i] = $mday[$possiblelunarday];
					$op += 1;
				} else {
					// 不在本月的天数范畴内

					$results[$i] = $mday[1];
					//退回到1日

					$fisrtdaylunar = 1;
					$op = 2;
					$curmonthnum = ($everymonth[$lcj][0] != 0) ? 13 : 12;
					//当年有几个月
					if ($lci + 1 > $curmonthnum) {
						// 第13/14个月了，转到下一年
						$lci = 1;
						$lcj = $lcj + 1;
						// 换年头了，把新一年的天干地支也写上
						$results['year'] .= '/' . $mten[$everymonth[$lcj][14]] . $mtwelve[$everymonth[$lcj][15]];
					} else {
						// 还在这年里
						$lci = $lci + 1;
						$lcj = $lcj;
					}
				}
				if ($results[$i] == $mday[1]) {
					// 每月的初一应该显示当月是什么月
					if ($everymonth[$lcj][0] != 0) {
						// 有闰月的年
						$monthss = ($lci > $everymonth[$lcj][0]) ? ($lci - 1) : $lci;
						//闰月后的月数-1
						if ($lci == $everymonth[$lcj][0] + 1) {
							// 这个月正好是闰月
							$monthssshow = $mmonth[0] . $mmonth[$monthss];
							//前面加个闰字
							$runyue = 1;
						} else {
							$monthssshow = $mmonth[$monthss];
						}
					} else {
						$monthss = $lci;
						$monthssshow = $mmonth[$monthss];
					}
					if ($monthss <= 10 && @$runyue != 1) {
						//只有1个字的月加上‘月'字
						$monthssshow .= $mmonth[13];
					}
					$results[$i] = $monthssshow;
				}
			}
			return $results;
		}
	}