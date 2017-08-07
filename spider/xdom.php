<?php
$oldSetting = libxml_use_internal_errors( true );
libxml_clear_errors();
require_once '../Tool/HttpRequest.class.php';
require_once '../Tool/TextCompress.class.php';
/**
 *
 * -+-----------------------------------
 * |PHP5 Framework - 2011
 * |Web Site: www.iblue.cc
 * |E-mail: mejinke@gmail.com
 * |Date: 2012-10-12
 * -+-----------------------------------
 *
 * @desc HTML解析器
 * @author jingke
 */
class XF_HtmlDom
{
    private $_xpath = null;
    private $_nodePath = '';
    
    public function __construct($xpath = null, $nodePath = '')
    {
        $this->_xpath = $xpath;
        $this->_nodePath = $nodePath;
    }
    
    public function loadHtml($url)
    {
        ini_set('user_agent', 'Mozilla/5.0 (Linux; U; Android 2.1; en-us; Nexus One Build/ERD62) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17 –Nexus');
        $content = '';
        if(strpos(strtolower($url), 'http')===false)
        {
            $content = file_get_contents($url);
        }
        else
        {
            $ch = curl_init();
            $user_agent = "Baiduspider+(+http://www.baidu.com/search/spider.htm)";
            $user_agent1='Mozilla/5.0 (Windows NT 5.1; rv:6.0) Gecko/20100101 Firefox/6.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            $content =curl_exec($ch);
            curl_close($ch);
        }
        $html = new DOMDocument();
        $html->loadHtml($content);
        $this->_xpath = new DOMXPath( $html );
        //return $this;
        
    }
    
    public function find($query, $index = null)
    {
        $nodes = $this->findNodePath($query, $index);
        $text = [];
        foreach ($nodes as $item){
            $text[] = TextCompress::compress_html($item->text());
        }
        return $text;
    }
    
    public function findNodePath($query, $index=null){
        
        if($this->_nodePath == ''){
            $this->_nodePath = '//';
        }else{
            $this->_nodePath .= '/';
        }        
        $nodes = $this->_xpath->query($this->_nodePath.$query);
        //echo $nodes->item(0)->getNodePath();exit;
        
        if ($index == null && !is_numeric($index))
        {
            $tmp = array();
            foreach ($nodes as $node)
            {
                $tmp[] = new XF_HtmlDom($this->_xpath, $node->getNodePath());
            }
            return $tmp;
        }
        
        return array(new XF_HtmlDom($this->_xpath,$this->_xpath->query($this->_nodePath.$query)->item($index)->getNodePath()));
    }
    /**
     * 获取内容
     */
    public function text()
    {
        if ($this->_nodePath != '' && $this->_xpath != null )
            return $this->_xpath->query($this->_nodePath)->item(0)->textContent;
            else
                return false;
    }
    
    /**
     * 获取属性值
     */
    public function getAttribute($name)
    {
        if ($this->_nodePath != '' && $this->_xpath != null )
            return $this->_xpath->query($this->_nodePath)->item(0)->getAttribute($name);
            else
                return false;
    }
    
    public function __get($name)
    {
        if($name == 'innertext')
            return $this->text();
            else
                return $this->getAttribute($name);
    }
}
$xp = new xf_HtmlDom();
// $xp->loadHtml('http://www.aizhan.com/siteall/www.opendir.cn/');
// $rows = $xp->find("td[@id='baidu']/a", 0)->innertext;
// print_r($rows);  

$xp->loadHtml('https://book.douban.com/tag/%E5%B0%8F%E8%AF%B4');
$t1 = microtime(true);
$rows = $xp->find("div[@class='info']/h2/a");
$t2 = microtime(true);

var_dump($rows, $t2-$t1);