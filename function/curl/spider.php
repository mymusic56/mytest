<?php
/**
 * Created by PhpStorm.
 * Date: 2018/12/15
 * Time: 10:55
 */

$url = "https://www.d1xz.net/test/aiqing";
function cnew()
{
    $filename = 'test-chf.html';
    if (!file_exists($filename)) {
        $content = file_get_contents('http://news.fx678.com/column/chf');
        file_put_contents($filename, $content);
    }

    $content = file_get_contents($filename);
    // set error level
    $internalErrors = libxml_use_internal_errors(true);

    // load HTML
    $doc = new \DOMDocument();
    $doc->loadHTML($content);

    // handle errors
    libxml_clear_errors();

    // Restore error level
    libxml_use_internal_errors($internalErrors);


    $xpath = new \DOMXPath($doc);

    $query = '//*[@id="news_list"]/li';
    $elements = $xpath->query($query);
    $data = [];
    foreach ($elements as $item) {
        $tmpEle1 = $xpath->query($query.'/div[1]/a/img');//缩略图
        $tmpEle2 = $xpath->query($query.'/a/h3');//标题
        $tmpEle3 = $xpath->query($query.'/a/p');//短描述
        $tmpEle4 = $xpath->query($query.'/a');
        $tmpEle5 = $xpath->query($query.'/div[2]/i/text()');
        $tmpEle6_0 = $xpath->query($query.'/div[2]/a');
        $tmpEle6 = $xpath->query($query.'/div[2]/a/img');
        $tmpEle7 = $xpath->query($query.'/div[2]/a/span');
        $tmpEle8 = $xpath->query($query.'/div[2]/em');

        $author_host = $tmpEle6_0->item(0)->getAttribute('href');
        $author_id = explode('/', $author_host);

        $content_url = $tmpEle4->item(0)->getAttribute('href');
        $news_id = explode('/', $content_url);
        $news_id = array_pop($news_id);
        $news_id = substr($news_id, 0, strripos($news_id, '.'));
        $publish = $tmpEle5->item(0)->textContent;

        $data[] = [
            'thumbnails' => $tmpEle1->item(0)->getAttribute('data-original'),
            'title' => $tmpEle2->item(0)->textContent,
            'short_content' => $tmpEle3->item(0)->textContent,
            'ori_url' => $content_url,
            'curl_news_id' => $news_id,
            'publish_time' => $publish.':00',
            'author_id' => array_pop($author_id),
            'author_avatar' => $tmpEle6->item(0)->getAttribute('data-original'),
            'author_name' => $tmpEle7->item(0)->textContent,
            'scan' => $tmpEle8->item(0)->textContent,
        ];
    }

    var_dump($data);
    var_dump($elements);die;

}

cnew();