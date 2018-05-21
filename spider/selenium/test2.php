<?php
namespace Facebook\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
require_once('../../vendor/autoload.php');

header("Content-Type: text/html; charset=UTF-8");
// start Firefox with 5 second timeout
$waitSeconds = 15;  //需等待加载的时间，一般加载时间在0-15秒，如果超过15秒，报错。
$host = 'http://localhost:4444/wd/hub'; // this is the default
//这里使用的是chrome浏览器进行测试，需到http://www.seleniumhq.org/download/上下载对应的浏览器测试插件
//我这里下载的是win32 Google Chrome Driver 2.25版：https://chromedriver.storage.googleapis.com/index.html?path=2.25/

$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 5000);

$driver->get('https://www.baidu.com/');
$element = $driver->findElement(WebDriverBy::id('kw'));

echo $element->getTagName();

$element = $driver->findElement(WebDriverBy::linkText('新闻'));

echo $element->getAttribute("name").'--'.$element->getTagName().'--'.$element->getText();
$locator = WebDriverBy::cssSelector('bg.s_btn_wr.bg.s_btn');

if (isElementExsit($driver, $locator)) {
    $element = $driver->findElement($locator);
    echo '----------'.$element->getAttribute("name");
} else {
    echo 'can not find the element.';
}

/**
 * 判断元素是否存在
 * @param WebDriver $driver
 * @param WebDriverBy $locator
 */
function isElementExsit($driver,$locator){
    try {
        $element = $driver->findElement($locator);
        return true;
    } catch (\Exception $e) {
        echo 'element is not found!';
        return false;
    }
}