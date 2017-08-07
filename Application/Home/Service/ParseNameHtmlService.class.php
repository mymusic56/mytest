<?php
namespace Home\Service;

class ParseNameHtmlService {
    public static function doaction1($content){
        $content = self::converToUtf8($content);
        $content = self::compress_html($content);
        #解析基本信息
        preg_match('/<div class="dafen_left"><li>.*?<div class="dr_desc">/', $content, $match);
        $nameInfo = [];
        if(isset($match[0])){
            $nameInfo['section1'] = self::parseNameBrief1($match[0]);
        }else{
            return [];
        }
        $nameBrief = [];
        preg_match_all('/<div class="c_1">.*?<\/div><\/div>/', $content, $matchAll);
        if($matchAll){
            $threeType = [];
            foreach ($matchAll[0] as $key => $item){
                switch ($key){
                    case 1 : 
                        $threeType = self::parseThreeType($item);
                        unset($matchAll[0][$key]);
                        break;#解析三才
                    case 2 : 
                        $nameBrief = self::parseNameDetail($item);
                        break;
                }
            }
            $nameInfo['section1']['fanti'] = $nameBrief['fanti'];
            $nameInfo['section1']['wuxing'] = $nameBrief['wuxing'];
            
            $nameInfo['section2'] = $threeType[2];
            
            $nameInfo['section3'] = $nameBrief['desc'];
            
            $nameInfo['section4'] = $threeType[0];
            $nameInfo['section5'] = $threeType[1];
        }else{
            return [];
        }
        return $nameInfo;
    }
    
    public static function analysisNameHtml($content){
        $content = self::converToUtf8($content);
        $content = self::compress_html($content);
//         \Think\Log::write($content, 'Notice', '', C('LOG_PATH').date('Y-m-d').'.log');
//         error_log("$content", 3,'D:\work\named\parse-template-3\name-analysis-template.compress.html');
//         file_put_contents('D:\work\named\parse-template-3\name-analysis-template.compress.html', $content);
        preg_match('/<form.*?<\/form>/i', $content, $match);
        
        $nameInfo = [];
        if(isset($match[0])){
            preg_match_all('/<table.*?<\/table>/i', $match[0], $matchAll);
            $nameInfo = [];
            if(isset($matchAll[0])){
                foreach ($matchAll[0] as $key => $item){
                    if($key == 0){
                        $nameInfo['baseInfo'] = self::analysisBaseInfo($item);
                    }elseif ($key == 1){
                        $nameInfo['notice'] = self::analysisNotice($item);
                    }elseif ($key == 7){
                        $nameInfo['wuxing'] = self::analysisWuxing($item);
                    }else{
                        continue;
                    }
                }
            }
        }
        $nameInfo['baseInfo']['nongLi'][1] = $nameInfo['wuxing']['date'][1];
        $nameInfo['baseInfo']['nongLi'][2] = $nameInfo['wuxing']['date'][2];
        return $nameInfo;
    }
    private static function analysisBaseInfo($string){
        $info = [];
        preg_match_all('/<td.*?<\/td>/i', $string, $matchTds);
        foreach ($matchTds[0] as $k => $td){
            $td = preg_replace('/<td.*?>|<\/td>/i', '', $td);
            $res = explode('：', $td);
            if($k == 0){
                $info['firstname'] = $res[1];
            }elseif ($k == 1){
                $info['wuxing'] = $res[1];
            }elseif ($k == 3){
                preg_match_all('/\d+/', $res[1], $dys);
                $dys = $dys[0];
                $info['gongLi'] = $dys;
                $info['nongLi'] = $dys;
            }else {
                continue;
            }
        }
        return $info;
    }
    
    private static function analysisNotice($string){
        $notice = '';
        preg_match_all('/<td.*?<\/td>/i', $string, $matchTds);
        if(isset($matchTds[0])){
            $notice = preg_replace('/<td.*?>|<\/td>/i', '', $matchTds[0][1]);
        }
        return $notice;
    }
    
    private static function analysisWuxing($string){
        $wuxing = [];
        $tag = ['desc','date', 'bazi', 'wuxing', 'nayin'];
        preg_match_all('/<tr.*?<\/tr>/i', $string, $matchTrs);
        if(isset($matchTrs[0])){
            foreach ($matchTrs[0] as $k => $tr){
                if($k == 0){
                    preg_match('/<td rowspan="5".*?<\/td>/i', $tr, $descTd);
                    if(isset($descTd[0])){
                        preg_replace('/<td.*?>|<\/td>|<p>.*?<\/p>/i', $descTd[0], $desc);
                        $wuxing['desc'] = $desc[0];
                    }
                }elseif($k == 1 || $k == 2 || $k == 3 ||$k == 4){
                    preg_match_all('/<td.*?<\/td>/i', $tr, $nongLi);
                    if(isset($nongLi[0])){
                        $tmp = preg_replace('/<td>|<\/td>/i','', $nongLi[0]);
                        unset($tmp[0]);
                        $wuxing[$tag[$k]] = array_merge($tmp);
                    }
                }
            }
        }
        return $wuxing;
    }
    private static function parseThreeType($string){
        preg_match_all('/<p>.*?<\/p>/', $string, $pAll);
        $threeType = [];
        $destinySummarize = [];
        
        $chance = [];
        
        if($pAll){
            foreach ($pAll[0] as $key => $item){
                $item = preg_replace('/<p>|<\/p>|\d+、|/', '', $item);
                $temp = [];
                switch ($key){
                    case 0: 
                        preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $item, $content);
                        $temp = array(
                                'title' => '三才配置',
                                'content' => $content[0][1]
                        );
                        break;
                    //吉凶分析
                    case 1:break;
                    //命格简批
                    case 2:
                        $item = str_replace(array('<font color="blue">', '</font>'), '', $item);
                        $item = explode('：', $item);
                        $destinySummarize = array(
                                'title' => $item[0],
                                'content' => $item[1],
                        );
                        break;
                    case 4: 
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                    case 12:
                    case 13:
                    case 14:
                    case 15:
                        $item = explode('：', $item);
                        $temp = array(
                                'title' => $item[0],
                                'content' => $item[1],
                        );
                        break;
                    case 16: break;
                    case 17:
                        $chance[] = array('title' => '对基础运的影响', 'content' => $item);
                        break;
                    case 18: break;
                    case 19: break;
                        $chance[] = array('title' => '对成功运的影响', 'content' => $item);
                        break;
                    case 20: break;
                    case 21:
                        $chance[] = array('title' => '对人际关系的影响', 'content' => $item);
                        break;
                    case 22: break;
                    case 23:
                        $chance[] = array('title' => '对性格的影响', 'content' => $item);
                        break;
                }
                if($temp) $threeType[] = $temp;
            }
        }
        return array($threeType, $chance, $destinySummarize);
//         var_dump($threeType, $chance, $destinySummarize);die;
    }
    private static function parseNameDetail(&$string){
        $string = str_replace(array(' align="left" style="font-size:12px;"', '<font color="#009900">', '</font>'), '', $string);
        preg_match_all('/<td>.*?<\/td>/', $string, $match);
        $nameBrief = ['name'=>'', 'pinyin'=> '', 'fanti' => '', 'wuxing' => '', 'desc' => []];
        if(isset($match[0])){
            $desc = [];
            foreach ($match[0] as $k => $v){
                $v = str_replace(array('<td>', '&nbsp;', '</td>', '<font color=#009900>'), '', $v);
                $remain = $k%6;
                switch ($remain){
                    case 0: $nameBrief['name'] .= ','.$v;break;
                    case 1: $nameBrief['fanti'] .= ','.$v;break;
                    case 2: $nameBrief['pinyin'] .= ','.$v;break;
                    case 3: $nameBrief['wuxing'] .= ','.$v;break;
//                     case 4: $nameBrief['bihua'] .= ','.$v;break;
                    case 5: $desc[] = $v;break;
                }
            }
            $nameBrief['name'] = ltrim($nameBrief['name'], ',');
            $nameBrief['fanti'] = ltrim($nameBrief['fanti'], ',');
            $nameBrief['pinyin'] = ltrim($nameBrief['pinyin'], ',');
            $nameBrief['wuxing'] = ltrim($nameBrief['wuxing'], ',');
//             $nameBrief['bihua'] = ltrim($nameBrief['bihua'], ',');
            $nameArr = explode(',', $nameBrief['name']);
            $tmpDesc = [];
            foreach ($desc as $k => $v){
                $tmpDesc[] = array('title' => $nameArr[$k], 'content' => $v);
            }
            $nameBrief['desc'] = $tmpDesc;
        }
        return $nameBrief;
    }
    private static function parseNameBrief1(&$string){
        #姓名
        preg_match('/<div class="dafen_left">.*?<\/li><\/div>/', $string, $match);
        $nameBrief = ['name'=>'', 'pinyin'=> '', 'bihua' => '', 'score' => 0];
        if(isset($match[0])){
            $str = preg_replace('/<div.*?>|<li>|<\/li><\/div>/', '', $match[0]);
            $str = str_replace(array('</div>', '</li>', '<br>'), ' ', $str);
            $arr = explode(' ', $str);
            foreach ($arr as $k => $v){
                $remain = $k%3;
                switch ($remain){
                    case 0: $nameBrief['name'] .= ','.$v;break;
                    case 1: $nameBrief['pinyin'] .= ','.$v;break;
                    case 2: $nameBrief['bihua'] .= ','.$v;break;
                }
            }
            $nameBrief['name'] = ltrim($nameBrief['name'], ',');
            $nameBrief['pinyin'] = ltrim($nameBrief['pinyin'], ',');
            $nameBrief['bihua'] = ltrim($nameBrief['bihua'], ',');
        }
        #得分
        preg_match('/<span>\d+<\/span>/', $string, $match);
        if(isset($match[0])){
            $nameBrief['score'] = str_replace(array('<span>', '</span>'), '', $match[0]);
        }
        return $nameBrief;
    }
    /**
     * 
     * @param unknown $content
     * @return array|string[][]|string[]|unknown[]
     */ 
    public static function doaction($content){
        $content = self::compress_html($content);
        preg_match('/<div class="mod_box_t3">.*?<div class="btn_tool_retest">/', $content, $matcth1);
        $nameInfo = [];
        if(isset($matcth1[0])){
            #截取姓名属性
            preg_match('/<li>.*?<\/ul>/', $matcth1[0], $matchName);
            if(isset($matchName[0]))
            {
                $nameBrief = self::parseNameBrief($matchName[0]);
                $nameInfo['left'][] = array('item' => array('title' => '笔画', 'con' => ltrim($nameBrief['bihua'], ',')));
                $nameInfo['left'][] = array('item' => array('title' => '五行', 'con' => ltrim($nameBrief['wuxing'], ',')));
                $nameInfo['xingming'] = $nameBrief['name'];
                $nameInfo['pinyin'] = ltrim($nameBrief['pinyin'], ',');
                $nameInfo['fanti'] = $nameBrief['fanti'];
                unset($nameBrief);
            }
            
            #五格概括
            
            
        }
        return $nameInfo;
    }
    private static function parseNameBrief($nameString){
        $nameBrief = ['name'=> '', 'fanti'=>'','pinyin'=>'','bihua'=>'','wuxing'=>'',];
        $res = preg_replace('/<li.*?>|\/ul>|<strong>|<\/strong>|<\/ul>/', '', $nameString);
        $res = explode('</li>', $res);
        if($res)
        {
            foreach ($res as $k => $v){
                if($k > 4){
                    $remain = $k%5;
                    switch ($remain){
                        case 0: $nameBrief['name'] .= $v;break;
                        case 1: $nameBrief['fanti'] .= $v;break;
                        case 2: $nameBrief['pinyin'] .= ','.$v;break;
                        case 3: $nameBrief['bihua'] .= ','.$v;break;
                        case 4: $nameBrief['wuxing'] .= ','.$v;break;
                    }
                }
            }
        }
        return $nameBrief;
    }
    
    private static function parseNameFiveBox(){
        
    }
    public static function compress_html($string) {
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
    
    public static function converToUtf8($string){
        $charset = mb_detect_encoding($string, array('UTF-8','GBK','GB2312'));
        
        if('CP936' == $charset){
            $charset='GBK';
        }
        
        if("UTF-8" != $charset){
            $string = iconv($charset,"UTF-8//IGNORE", $string);
        } 
        return $string;
    }
}