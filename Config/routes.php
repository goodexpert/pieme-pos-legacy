<?php
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
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'home', 'action' => 'index'));

    Router::connect('/reports/stock/levels',
        array('controller' => 'reports', 'action' => 'stock_levels'));

    Router::connect('/reports/stock/low',
        array('controller' => 'reports', 'action' => 'stock_low'));

    Router::connect('/reports/stock/onhand',
        array('controller' => 'reports', 'action' => 'stock_onhand'));

    Router::connect('/reports/sales/:action/*', array('controller' => 'reports'));

    Router::connect('/product/:id',
        array('controller' => 'product', 'action' => 'view'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/product/:id/edit',
        array('controller' => 'product', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/product/:id/delete',
        array('controller' => 'product', 'action' => 'delete'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/stock/:id',
        array('controller' => 'stock', 'action' => 'view'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/stock/:id/cancel',
        array('controller' => 'stock', 'action' => 'cancel'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/inventory_count',
        array('controller' => 'stock', 'action' => 'inventoryCount'));

    Router::connect('/inventory_count/create',
        array('controller' => 'stock', 'action' => 'newInventoryCount'));

    Router::connect('/inventory_count/save',
        array('controller' => 'stock', 'action' => 'saveInventoryCount'));

    Router::connect('/inventory_count/start',
        array('controller' => 'stock', 'action' => 'startInventoryCount'));

    Router::connect('/inventory_count/:id',
        array('controller' => 'stock', 'action' => 'viewInventoryCount'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/inventory_count/:id/edit',
        array('controller' => 'stock', 'action' => 'editInventoryCount'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/inventory_count/:id/perform',
        array('controller' => 'stock', 'action' => 'performInventoryCount'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/inventory_count/:id/review',
        array('controller' => 'stock', 'action' => 'reviewInventoryCount'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/inventory_count/:id/items',
        array('controller' => 'stock', 'action' => 'getStockTakeItems'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/outlet/:id/edit',
        array('controller' => 'outlet', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/register/:id/edit',
        array('controller' => 'register', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/payments/:id/edit',
        array('controller' => 'payments', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/payments/:id/delete',
        array('controller' => 'payments', 'action' => 'delete'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

    Router::connect('/users/:id',
        array('controller' => 'users', 'action' => 'view'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));
        
    Router::connect('/users/:id/edit',
        array('controller' => 'users', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));
        
    Router::connect('/pricebook/:id/edit',
        array('controller' => 'pricebook', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));
        
    Router::connect('/quick_keys/:id/edit',
        array('controller' => 'quickkey', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));
        
    Router::connect('/receipt_template/:id/edit',
        array('controller' => 'receipttemplate', 'action' => 'edit'),
        array('pass' => array('id'), 'id' => '[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Setup new Default Resource Map for "correct" RESTFul routes.
 * You don't have to do this because these are the default
 * resourceMap routes.
 */
	Router::resourceMap(array(
		array('action' => 'index', 'method' => 'GET', 'id' => false),
		array('action' => 'view', 'method' => 'GET', 'id' => true),
		array('action' => 'add', 'method' => 'POST', 'id' => false),
		array('action' => 'delete', 'method' => 'DELETE', 'id' => true),
		array('action' => 'update', 'method' => 'PUT', 'id' => true)
	));

/**
 * map controller resources
 */
	Router::parseExtensions();

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
