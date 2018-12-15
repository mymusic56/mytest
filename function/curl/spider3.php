<?php
/**
 * Created by PhpStorm.
 * Date: 2018/12/15
 * Time: 10:55
 */
require '../../vendor/autoload.php';

class Xz
{

    /**
     * \DOMXPath
     * @var
     */
    private $xpath;

    private $questionType = 'jump';

    public function getHtmlContnet($url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url, ['verify' => false]);
        $content = (string)$response->getBody();

        return $content;
    }

    private function initXPath($content)
    {
        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        // load HTML
        $doc = new \DOMDocument();
        $doc->loadHTML($content);

        // handle errors
        libxml_clear_errors();

        // Restore error level
        libxml_use_internal_errors($internalErrors);


        $this->xpath = new \DOMXPath($doc);
    }

    public function cnew($url)
    {
        $content = $this->getHtmlContnet($url);
//        echo $content;die;
        $this->initXPath($content);
        $xpath = $this->xpath;

        $query = '//div[@class="common_det_con"]/p';

        $title_ele = $this->xpath->query('//h1[@class="art_detail_title"]');
        $data = [
            'question_type' => $this->questionType,
            'images' => [],
            'title' => $title_ele[0]->nodeValue,
            'desc' => '',
            'question_counts' => 1,
            'questions' => [],
            'result' => [],
        ];
        //获取所有图片
        $query_pic = $query.'/img';
        $elements_pic = $xpath->query($query_pic);

        foreach ($elements_pic as $item) {
            $data['images'][] = $item->attributes['href']->value;
        }

        $elements = $xpath->query($query);
        $a = 1;
        $b = 1;
        $c = 0;
        $data['result'] = [];
        foreach ($elements as $key => $item){
//            var_dump($item, $key);
            $item->nodeValue = trim($item->nodeValue, '　　');
            if (!$item->nodeValue) {
                continue;
            }
            if ($a == 1) {
                $data['desc'] = $item->nodeValue;
                $a = 2;
            }

            //问题和答案分界线
            if ($item->nodeValue == '测试答案：') {
                $b = 2;
                continue;
            }

            //问题
            if ($b == 1 && $a == 2) {
                $tmp = explode('　　', $item->nodeValue);
//            var_dump($tmp);
                $questions = $this->parseQuestions($item);
                if ($questions) {
                    $data['questions'][] = $questions;
                }
            }
            //答案
            if ($b == 2) {
//            var_dump($item->nodeValue);
                $tmp_result = $this->parseResult($item);
                if ($tmp_result) {
                    $data['result'][] = $tmp_result;
                }
            }
        }

        if (empty($data['result'])) {
            $data['result'] = $this->resultInNextPage($elements);
        }

        if (empty($data['questions'])) {
            $data['questions'] = $this->parseQuestionV2($elements);
        }
        $data['question_type'] = $this->questionType;
        $data['question_counts'] = isset($data['questions']) ? count($data['questions']) : 0;
        return $data;
    }

    /**
     * 问题、选项只有一个P标签，用</br>分隔开
     * @param $item
     * @return array
     */
    public function parseQuestions($item)
    {
        $tmp = explode('　　', $item->nodeValue);
//        var_dump($tmp);
        preg_match('/^\w+、/', $tmp[0], $matches);

        $answers = [];
        $answers_nos = ['I','H','G','F','E','D','C','B','A'];

        foreach ($tmp as $K => $v) {
            if ($K == 0) {
                continue;
            }
            $answer_tmp = explode('→', $v);
            $this->questionType = 'jump';
            $answer_tmp_count = count($answer_tmp);

            $answer_no = '';
            if ($this->questionType == 'jump' && $answer_tmp_count == 2) {
                preg_match('/^[A-Za-z]/', $answer_tmp[1], $matches_2);
                if ($matches_2) {
                    $answer_no = $answer_tmp[1];
                    $answer_tmp[1] = 'END-'.$answer_tmp[1];
                }
            }

            if ($this->questionType == 'jump' && $answer_tmp_count == 1) {
                preg_match('/^[A-Za-z]、/', $answer_tmp[0], $matches_2);
                $answer_tmp[0] = preg_replace('/^[A-Za-z]、/', '', $answer_tmp[0]);
                $answer_no = str_replace('、', '',$matches_2[0]);
                $answer_tmp[1] = 'END-'.$answer_no;
            }
            $answers[] = [
                'no' => $answer_no == '' ? array_pop($answers_nos) : $answer_no,
                'content' => $answer_tmp[0],
                'jumpto' => $answer_tmp[1],
            ];
        }

        if (!$answers) {
            return [];
        }

        return [
            'no' => $matches ? str_replace('、', '', $matches[0]) : '',
            'title' => preg_replace('/^\d+、/', '', $tmp[0]),
            'answers' => $answers
        ];
    }

    /**
     * 问题、选项分别占一个p标签
     * @param $elements
     * @return array
     */
    public function parseQuestionV2($elements)
    {
        $question = [];
        $title = '';
        foreach ($elements as $k => $item) {
//            var_dump($item->nodeValue);
            if ($k == 2) {
                $title = $item->nodeValue;
            }
            if ($item->nodeValue == '点击下一页查看答案！') {
                break;
            }

            if ($k > 2) {
                $answers_nos = ['I','H','G','F','E','D','C','B','A'];
                preg_match('/^[A-Za-z]、/', $item->nodeValue, $matches_2);
                $answer_tmp[0] = preg_replace('/^[A-Za-z]、/', '', $item->nodeValue);
                $answer_no = str_replace('、', '',$matches_2[0]);
                $answer_tmp[1] = 'END-'.$answer_no;

                $answers[] = [
                    'no' => $answer_no == '' ? array_pop($answers_nos) : $answer_no,
                    'content' => $answer_tmp[0],
                    'jumpto' => $answer_tmp[1],
                ];

            }
        }
        $question[] = [
            'no' => '',
            'title' => $title,
            'answers' => $answers
        ];
        return $question;
    }

    public function parseResult($item)
    {
        $item->nodeValue = trim($item->nodeValue, '　　');
        preg_match('/^\w+、/', $item->nodeValue, $matches);
//        var_dump($item->nodeValue);
        $item->nodeValue = preg_replace('/^\w+、/', '', $item->nodeValue);
        $tmp = explode('　　', $item->nodeValue);
        $count = count($tmp);
        $copyright = '（第一星座网原创文章，转载请联系网站管理人员，否则视为侵权。）';
        $result = [];
        if ($matches) {
            $result = [
                'no' => str_replace('、', '', $matches[0]),
                'title' => $count == 2 ? $tmp[0] : '',
                'desc' => $count == 2 ? str_replace($copyright, '', $tmp[1]) : $tmp[0],
            ];
        }
        return $result;
    }

    /**
     * 答案在下一页
     * @param $elements
     */
    public function resultInNextPage($elements)
    {
        $result = [];
        foreach ($elements as $k => $item) {

            $item->nodeValue = trim($item->nodeValue, '　　');
            if ($item->nodeValue == '点击下一页查看答案！') {
                //获取下一页内容
                $elment = $this->xpath->query('//div[@class="page"]/a');
                $next_page = 'https://www.d1xz.net'.$elment->item(0)->getAttribute('href');
                $content = $this->getHtmlContnet($next_page);
                $this->initXPath($content);
                $result_elements = $this->xpath->query('//div[@class="common_det_con"]/p');
//                var_dump($result_elements);
                foreach ($result_elements as $item2) {
                    $tmp_result = $this->parseResult($item2);
                    if ($tmp_result) {
                        $result[] = $tmp_result;
                    }
                }
            }
        }
        return $result;
    }
}

$url = "https://www.d1xz.net/test/aiqing/art256838.aspx";//每一个P标签一行数据， 共有一个问题，答案在下一页
//$url = "https://www.d1xz.net/test/aiqing/art258029.aspx";//答案在下一页
//$url = "https://www.d1xz.net/test/aiqing/art293936.aspx";//答案在同一页
//$url = "https://www.d1xz.net/test/aiqing/art294354.aspx";
$xz = new Xz();
$res = $xz->cnew($url);
var_dump($res);