<?php
/**
 * 定义常量
 */
define('DS', DIRECTORY_SEPARATOR);
defined('SWOFT_PATH') || define('SWOFT_PATH', __DIR__);
defined('APP_PATH') || define('APP_PATH', dirname(SWOFT_PATH).DS.'app');
defined('ROOT_PATH') || define('ROOT_PATH', dirname(SWOFT_PATH).DS.'public');
defined('CONF_PATH') || define('CONF_PATH', dirname(SWOFT_PATH).DS.'conf');
defined('Core_PATH') || define('Core_PATH', SWOFT_PATH.DS.'Core');