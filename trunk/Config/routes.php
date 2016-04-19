<?php

Router::connect('/', array('controller' => 'users', 'action' => 'login'));
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Mobiles',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Mobiles/home.old.ctp.bak)...
 */

// Router::connect('/', array('controller' => 'Coffees', 'action' => 'index'));

/**
 * ...and connect the rest of 'Mobiles' controller's URLs.
 */
Router::parseExtensions('json', 'jsonp', 'xml');

/*Router::connect(
    '/provider/:id',
    array('controller' => 'mobiles', 'action' => 'provider'),
    array('pass' => array('id'), 'id' => '[0-9]+')
);*/

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */

CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
/** @noinspection PhpIncludeInspection */
require CAKE . 'Config' . DS . 'routes.php';