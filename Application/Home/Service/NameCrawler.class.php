<?php
namespace Home\Service;
use Common\Lib\Tool\HttpRequest;
class NameCrawler {
    /**
     * 参考网址：http://xing.911cha.com/  百家姓.txt
     * 
     */
    public static function getFirtName0(){
        die('已完成');
        $file = 'D:\\work\\named\\'.iconv('utf-8', 'gbk', '百家姓').'.txt';
        $contents = file_get_contents($file);
        $contents = self::compressHtml($contents);
        preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $contents, $matches);
        $dataList = [];
        if($matches[0]){
            foreach ($matches[0] as $item){
                $temp['firstname'] = $item;
                $temp['type'] = mb_strlen($item, 'utf-8');
                $dataList[] = $temp;
            }
            if($dataList) M('my_family_names') -> addAll($dataList);
        }
        var_dump($matches);
    }
    
    
    /**
     * 数据来源： http://www.yw11.com/namelist.php
     */
    public static function getFirstName1(){
        $filecontent = file_get_contents('D:\work\named\named.txt');
        $contentArr = explode(PHP_EOL, $filecontent);
//         var_dump($contentArr);
        $time = time();
        foreach ($contentArr as $item){
            $start = stripos($item, 'http');
            $end = strripos($item, '.htm');
            $url = substr($item, $start, $end-$start+1).'htm';
            preg_match("/>\s*[\x{4e00}-\x{9fa5}]+\s*</u", $item, $matches);
            $name = '';
            if($matches){
                preg_match("/[\x{4e00}-\x{9fa5}]+/u", $matches[0], $matches);
                if($matches){
                    $name = $matches[0];
                }
            }
            $man_url = $url;
            $woman_url = str_replace('-0-', '-1-', $man_url);
            $res = M('aaa_copy')->where("firstname='$name'")->find();
            if(!$res){
                M('aaa_copy')->data(array('firstname' => $name, 'xtime' => $time))->add();
                var_dump($name);
            }
            $nameInfo = array(
                    array('firstname' => $name, 'link' => $man_url, 'sex' => 1),
                    array('firstname' => $name, 'link' => $woman_url, 'sex' =>2),
            );
            if($name){
                M('my_firstname')->addAll($nameInfo);
            }else{
                var_dump($item);
            }
        }
        var_dump('SUCCESS');
    }
    /**
     * 获取姓名
     * 另一个网址
     * @param unknown $url
     * @param unknown $filename
     */
    public static function getFirstName2($url, $filename){
        $url = 'http://www.resgain.net/xsdq.html';
        $filename = 'D:\work\named\name-2\firstname.html';
        // 		http://shangguan.resgain.net/name/boys_4.html
        $firstnameReg = '<div class="col-xs-12" style="padding-left: 25px;">\s*<a(.*?)\s*<\/div>';
        if(file_exists($filename)){
            exit($filename.' 已存在');
        }
        $header = array('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        $firstnaeContent = HttpRequest::sendHttpRequest($url, '');
        // 		$firstnaeContent = file_get_contents($url);
        
        $firstnaeContentCompress = HttpRequest::compress($firstnaeContent);
        file_put_contents($filename, $firstnaeContentCompress);
        preg_match('/<div class="col-xs-12" style="padding-left: 25px;">\s*.*?<\/div>/', $firstnaeContentCompress, $matches);
        if(isset($matches[0]) && $matches[0]){
            $arr = explode('</a>', $matches[0]);
            $error = [];
            foreach ($arr as $item){
                $nameInfo = [];
                $item = str_replace(['姓', '之','家', '个'], ['','','',''], $item);
                preg_match('/"http.*?"/', $item, $matchLink);
                
                if(isset($matchLink[0])){
                    $nameInfo['link'] = trim($matchLink[0], '"');;
                }
                preg_match('/\d{1,}">/', $item, $matchNum);
                if(isset($matchNum[0])){
                    $nameInfo['nnum'] = trim($matchNum[0], '">');
                }
                preg_match('/">[\x{4e00}-\x{9fa5}]+/u', $item, $matchName);
                if(isset($matchName[0])){
                    $nameInfo['firstname'] = trim($matchName[0], '">');
                }
                if(isset($nameInfo['firstname'])
                        && isset($nameInfo['nnum'])
                        && isset($nameInfo['link'])){
                            $data = array(
                                    array('firstname' => $nameInfo['firstname'], 'link' => $nameInfo['link'].'/name/boys.html', 'sex' => 1, 'nnum' => $nameInfo['nnum']),
                                    array('firstname' => $nameInfo['firstname'], 'link' => $nameInfo['link'].'/name/girls.html', 'sex' => 2, 'nnum' => $nameInfo['nnum']),
                            );
                            M('my_firstname')->addAll($data);
                }else{
                    $error[] = $item;
                }
            }
            var_dump(json_encode($error, JSON_UNESCAPED_UNICODE));die;
        }
    }
    /**
     * 参考网址：http://xm.99166.com/mzdq/  百家姓2.txt
     */
    public static function getFirtName4(){
        die('已完成');
        $file = 'D:\\work\\named\\'.iconv('utf-8', 'gbk', '百家姓').'2.txt';
        $contents = file_get_contents($file);
        $contents = self::compressHtml($contents);
        
        $lis = explode('</li>', $contents);
        $dataList = [];
        if($lis){
            foreach ($lis as $item){
                preg_match('/[\x{4e00}-\x{9fa5}]+/u', $item, $match_firstname);;
                if(!isset($match_firstname[0])){
                    continue;
                }
                $temp['firstname'] = $match_firstname[0];
                preg_match('/http.*html/', $item, $match_link);
                $temp['link'] = $match_link[0];
                
                
                if($temp['link'] && $temp['firstname']){
//                     var_dump($temp['link']);
                    preg_match('/\d+\.html/', $temp['link'], $m);
                    $suffix = $m[0];
                    $num = mb_strlen($temp['firstname'], 'utf8');
                    $dataList[] = array(
                            'link' => 'http://xm.99166.com/mzdq/nan'.$suffix,
                            'sex' => '1',
                            'firstname' => $temp['firstname'],
                            'unm' =>$num
                    );
                    $dataList[] = array(
                            'link' => 'http://xm.99166.com/mzdq/nv'.$suffix,
                            'sex' => '2',
                            'firstname' => $temp['firstname'],
                            'unm' =>$num
                    );
                }
//                 var_dump($dataList);die;
            }
            if($dataList) M('my_firstname_2') -> addAll($dataList);
        }
        var_dump($dataList);
    }
    public static function crawlerName(){
        $where['operationed'] = 0;
        $firstnames = M('my_firstname')->where($where)->select();
        $error = [];
        foreach ($firstnames as $item){
            $contents = '';
//             $contents = file_get_contents($item['link']);
            $contents = HttpRequest::sendHttpRequest($item['link'], '');
            if($contents){
                $filename = 'D:\work\named\name\\'.iconv('utf-8', 'gbk', $item['firstname']).'-'.$item['sex'].'.html';
                file_put_contents($filename, $contents);
                $str = str_replace(PHP_EOL, '', $contents);
                preg_match('/<div class="listbox1_text">\s*<ul>\s*.*\s*<div class="h2_content">/', $str, $matches);
                if(isset($matches[0]) && $matches[0]){
                    preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $matches[0], $lastMatch);
                }else {
                    $error[] = $item['firstname'];
                }
                
    //             preg_match_all('/<div class="listbox1_title">.*<div class="clear"><\/div>\s*<\/div>\s*<div class="h2_content">/', $contents, $matches);
    //             preg_match_all('/<li>.*<\/li>/', $contents, $matches);
                $gender = $item['sex'];
                $nameList = [];
                $firstname = $item['firstname'];
                if(isset($lastMatch[0]) && $lastMatch[0]){
                    $num = 0;
                    $pid = M('aaa_copy')->where("firstname='$firstname'")->field('id')->find();
                    foreach ($lastMatch[0] as $v){
                        $nameList[] = array(
                                'firstname' => $firstname,
                                'pid' => $pid['id'],
                                'sex' => $gender,
                                'name' => str_replace(['', '<li>', '</li>'], '', $v),
                        );
                        $num ++;
                    }
                    $res1 = M('my_name_list')->addAll($nameList);
                    $where = ['id' => $item['id']];
                    $res2 = M('my_firstname')->where($where)->setField(array('nnum' => $num, 'operationed' => 1));
                }else {
                    $error[] = $item['firstname'];
                }
                unset($matches);
                unset($lastMatch);
                \Think\Log::write('id:'.$item['id'].', firstname: '.$firstname.', addAll: '.$res1.', update: '.$res2.', count: '.$num, 'Notice', '', C('LOG_PATH').date('Y-m-d').'namelist.log');
    //             HttpRequest::sendHttpRequest($item['link'], $data);
    // die('success');
                sleep(1);
            }else {
                $error[] = $item['firstname'];
            }
        }
        \Think\Log::write(json_encode($error), 'Notice', '', C('LOG_PATH').date('Y-m-d').'namelist.log');
        var_dump($error, 'success');
    }
    public static function crawlerName2(){
        $where['operationed'] = 0;
        $firstnames = M('my_firstname')->where($where)->select();
        $error = [];
        foreach ($firstnames as $item){
            $contents = '';
            //             $contents = file_get_contents($item['link']);
            $contents = HttpRequest::sendHttpRequest($item['link'], '');
            if($contents){
                $filename = 'D:\work\named\name\\'.iconv('utf-8', 'gbk', $item['firstname']).'-'.$item['sex'].'.html';
                file_put_contents($filename, $contents);
                $str = str_replace(PHP_EOL, '', $contents);
                preg_match('/<div class="listbox1_text">\s*<ul>\s*.*\s*<div class="h2_content">/', $str, $matches);
                if(isset($matches[0]) && $matches[0]){
                    preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $matches[0], $lastMatch);
                }else {
                    $error[] = $item['firstname'];
                }
                
                //             preg_match_all('/<div class="listbox1_title">.*<div class="clear"><\/div>\s*<\/div>\s*<div class="h2_content">/', $contents, $matches);
                //             preg_match_all('/<li>.*<\/li>/', $contents, $matches);
                $gender = $item['sex'];
                $nameList = [];
                $firstname = $item['firstname'];
                if(isset($lastMatch[0]) && $lastMatch[0]){
                    $num = 0;
                    $pid = M('aaa_copy')->where("firstname='$firstname'")->field('id')->find();
                    foreach ($lastMatch[0] as $v){
                        $nameList[] = array(
                                'firstname' => $firstname,
                                'pid' => $pid['id'],
                                'sex' => $gender,
                                'name' => str_replace(['', '<li>', '</li>'], '', $v),
                        );
                        $num ++;
                    }
                    $res1 = M('my_name_list')->addAll($nameList);
                    $where = ['id' => $item['id']];
                    $res2 = M('my_firstname')->where($where)->setField(array('nnum' => $num, 'operationed' => 1));
                }else {
                    $error[] = $item['firstname'];
                }
                unset($matches);
                unset($lastMatch);
                \Think\Log::write('id:'.$item['id'].', firstname: '.$firstname.', addAll: '.$res1.', update: '.$res2.', count: '.$num, 'Notice', '', C('LOG_PATH').date('Y-m-d').'namelist.log');
                //             HttpRequest::sendHttpRequest($item['link'], $data);
                // die('success');
                sleep(1);
            }else {
                $error[] = $item['firstname'];
            }
        }
        \Think\Log::write(json_encode($error), 'Notice', '', C('LOG_PATH').date('Y-m-d').'namelist.log');
        var_dump($error, 'success');
    }
    
    public static function crawlerName3(){
        die('已完成');
        $where['operationed'] = 0;
        $firstname = M('my_firstname')->where($where)->select();
        $error = [];
        $insertError = [];
        foreach ($firstname as $fname){
            $content = file_get_contents('D:\\work\\named\\name-1\\'.iconv('utf-8', 'gbk', $fname['firstname']).'-'.$fname['sex'].'.html');
            $content = NameCrawler::compressHtml($content);
            preg_match('/<div class=\"listbox1_text\"><ul><li>.*?<\/li><\/ul>/', $content, $matches);
            if(!$matches){
                $error[]= $fname['firstname'];
            }
            if(isset($matches[0]) && $matches[0]){
                preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $matches[0], $lastMatch);
                $nameList = [];
                $num = 0;
                foreach ($lastMatch[0] as $v){
                    $nameList[] = array(
                            'firstname' => $fname['firstname'],
                            // 	                            'pid' => $pid['id'],
                            'sex' => $fname['sex'],
                            'name' => str_replace(['', '<li>', '</li>'], '', $v),
                    );
                    $num ++;
                }
                $res = '';
                $res = M('my_name_list')->addAll($nameList);
                if(!$res){
                    $insertError[] = $fname['firstname'];
                }
                var_dump($fname['firstname'].':'.count($nameList));
            }else{
                $error[]= $fname['firstname'];
            }
        }
        var_dump($error, $insertError);
        \Think\Log::write(json_encode($insertError, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.null.list.log');
        \Think\Log::write(json_encode($error, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.null.list.log');
    }
    /**
     * 
     * 姓氏没有名字 的姓氏重新抓取数据
     *
     */
    public static function crawlerName4(){
        die('已完成');
        $where['operationed'] = 0;
        $firstname = M('my_firstname_2')->where($where)->select();
        $error = [];
        $insertError = [];
        $outnames = M('aaa_copy_out')->field('firstname')->select();
        $tmp = [];
        foreach ($outnames as $v){
            $tmp[]  =  $v['firstname'];
        }
        $outnames = $tmp;
        unset($tmp);
        
        
        $dir = 'D:/work/named/name-3/';
        foreach ($firstname as $fname){
            if(!in_array($fname['firstname'], $outnames)){
                continue;
            }
            $content = HttpRequest::sendHttpRequest($fname['link'], '');
            $filename = $dir.iconv('utf-8', 'gbk', $fname['firstname']).'-'.$fname['sex'].'.html';
            
            
            $content = NameCrawler::compressHtml($content);
            file_put_contents($filename, $content);
            
            $content = iconv('gbk', 'utf-8', $content);
            
            preg_match('/<div class="nacon"><ul><li>(.*?)<\/li><\/ul>/', $content, $matches);
            if(!$matches){
                $error[]= $fname['firstname'];
            }
            if(isset($matches[0]) && $matches[0]){
                preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $matches[0], $lastMatch);
                $nameList = [];
                $num = 0;
                foreach ($lastMatch[0] as $v){
                    if(mb_strlen($v, 'utf-8') == 1){
                        continue;
                    }
                    $nameList[] = array(
                            'firstname' => $fname['firstname'],
                            // 	                            'pid' => $pid['id'],
                            'sex' => $fname['sex'],
                            'name' => str_replace(['', '<li>', '</li>'], '', $v),
                    );
                    $num ++;
                }
                $res = '';
                $res = M('my_name_list_out')->addAll($nameList);
                if(!$res){
                    $insertError[] = $fname['firstname'];
                }
                var_dump($fname['firstname'].':'.count($nameList));
            }else{
                $error[]= $fname['firstname'];
            }
            usleep(500);
        }
        var_dump($error);
        \Think\Log::write(json_encode($insertError, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.null.list.log');
        \Think\Log::write(json_encode($error, JSON_UNESCAPED_UNICODE), 'Notice', '', C('LOG_PATH').date('Y-m-d').'name.null.list.log');
    }
    
    /**
     * 获取没有抓取姓名的姓氏
     */
    public static function getFirstNameOut(){
        die('已完成');
        $firstnameList = M('aaa_copy')->field('firstname')->select();
        $need = [];
        foreach ($firstnameList as $key => $item){
            for ($i=1 ; $i <=2; $i++){
                $where = [
                        'firstname' => $item['firstname'],
                        'sex' => $i
                ];
                $count = M('my_name_list') -> where($where)-> count();
                if($count < 200){
                    $need[] = array('firstname' => $item['firstname'], 'sex' => $i, 'nnum' => $count);
                }
            }
        }
        $res = M('aaa_copy_out')->addAll($need);
        var_dump($res, count($need));
        die('SUCCESS');
    }
    public static function compressHtml($string) {
        return ltrim(rtrim(preg_replace(array(
                "/> *([^ ]*) *</",
                "//",
                "'/\*[^*]*\*/'",
                "/\r\n/",
                "/\n/",
                "/\t/",
                '/>[ ]+</'), array(
                        ">\\1<",
                        '',
                        '',
                        '',
                        '',
                        '',
                        '><'), $string)));
    }
}