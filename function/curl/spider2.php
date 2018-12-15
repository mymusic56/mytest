<?php
/**
 * Created by PhpStorm.
 * Date: 2018/12/15
 * Time: 10:55
 */
require '../../vendor/autoload.php';


class Xz
{
    public function getTikuList($page)
    {
        $url = "https://www.d1xz.net/test/aiqing/index_{$page}.aspx";
        $filename = 'index-'.$page.'.html';
        if (!file_exists($filename)) {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, ['verify' => false]);
            $content = (string)$response->getBody();
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

        $query = '//ul[@class="words_list_ui"]/li';
        $elements = $xpath->query($query);

        $data = [];
        foreach ($elements as $key => $item){
            $index = $key + 1;
            $e_a = $xpath->query($query.'['.$index.']/a');
            $href = $e_a->item(0)->getAttribute('href');
            $title = $e_a->item(0)->textContent;

            $e_desc = $xpath->query($query.'['.$index.']/div');
            $data[] = [
                'href' => 'https://www.d1xz.net'.$href,
                'title' => $title,
                'describe' => trim($e_desc->item(0)->textContent, '　')
            ];
        }
        return $data;

    }
}
$xz = new Xz();
$result = [];
for ($i=1; $i<3; $i ++) {
    $data = $xz->getTikuList($i);
    sleep(1);
    $result = array_merge($result, $data);
}

var_dump($result);
