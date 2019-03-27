<?php

namespace Swoft\Reload;
/**
 * Class Reload： 热加载文件
 * @package Swoft
 */
class FileMd5{
    private $md5;
    public $watchDir = [];

    private static $instance;
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function reload()
    {
        $md5 = $this->getMd5();
        if ($md5 != $this->md5) {
            $this->md5 = $md5;
            return true;
        }
        return false;
    }

    public function getMd5()
    {
        $md5 = '';
        foreach ($this->watchDir as $dir) {
            $md5 .= $this->md5File($dir);
        }

        return md5($md5);
    }

    private function md5File($dir)
    {
        if (!is_dir($dir)) {
            return '';
        }

        $md5File = [];
        $d = dir($dir);
        while (false !== ($entry = $d->read())) {
            if ($entry != '.' && $entry != '..') {
                if (is_dir($dir.DS.$entry)) {
                    $md5File[] = $this->md5File($dir.DS.$entry);
                } elseif (substr($entry, -4) == '.php') {
                    $md5File[] = md5_file($dir.DS.$entry);
                }
            }
        }

        $d->close();
        return md5(implode('', $md5File));
    }
}