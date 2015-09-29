<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Cookie' => array(
            'name' => 'Session',
            'secure' => true
        ),
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'signin',
                'action' => 'index'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ),
                    'userModel' => 'MerchantUser'
                ),
                'Pincode' => array(
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ),
                    'userModel' => 'MerchantUser'
                )
            )
        ),
        'Xero' => array(
            /*
            // Production key
            'consumer_key' => 'PLCTPJLQ2FSH2JQDO6NDJ5GLUWMSFV',
            'shared_secret' => 'LDDWUKJT6E0DPMEZTCK1HPDQOHUKDE',
             */
        )
    );


/**
 * An array containing headers.
 *
 * @var array
 */
    protected $headers = array();

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        $this->headers = $this->readHeaders();
        $this->set('menu', '');
        $this->set('submenu', '');
    }

/**
 * Called after the controller action is run, but before the view is rendered. You can use this method
 * to perform logic or set view variables that are required on every request.
 *
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers.html#request-life-cycle-callbacks
 */
    public function beforeRender() {
        $this->response->disableCache();
    }

    private function makeSerialize($array) {
        if (is_array($array)) {
            $serialize = array();
            foreach ($array as $key => $value) {
                $serialize[] = $key;
            }
            $array['_serialize'] = $serialize;
            $array['_jsonp'] = true;
        }
        return $array;
    }

    public function serialize($response) {
        $this->set($this->makeSerialize($response));
    }

    public function file($name, $default = null) {
        return isset($_FILES[$name]) ?
            $_FILES[$name] : $default;
    }

    public function get($name, $default = null) {
        return isset($this->request->query[$name]) ?
            $this->request->query[$name] : $default;
    }

    public function post($name, $default = null) {
        return isset($this->request->data[$name]) ?
            $this->request->data[$name] : $default;
    }

    public function server($name, $default = null) {
        return isset($_SERVER[$name]) ?
            $_SERVER[$name] : $default;
    }

    public function header($name, $default = null) {
        return isset($this->headers[$name]) ?
            $this->headers[$name] : $default;
    }

    public function cookie($name, $default = null) {
        return isset($_COOKIE[$name]) ?
            $_COOKIE[$name] : $default;
    }

/**
 * Get a list of incoming HTTP headers.
 *
 * @return array an associative array of incoming request headers.
 */
    protected function readHeaders() {
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } elseif (function_exists('http_get_request_headers')) {
            $headers = http_get_request_headers();
        } else {
            $headers = array();
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $name = str_replace(array('HTTP_', '_'), array('', '-'), $name);
                    $headers[$name] = $value;
                }
            }
        }

        return $this->normalizeHeaders($headers);
    }

/**
 * Takes all of the headers and normalizes them in a canonical form.
 *
 * @param array $headers The request headers.
 * @return array An arry of headers with the header name normalized
 */
    protected function normalizeHeaders(array $headers) {
        $normalized = array();
        foreach ($headers as $key => $value) {
            $normalized[ucfirst($this->normalizeKey($key))] = $value;
        }

        return $normalized;
    }

/**
 * Transform header name into canonical form
 *
 * @param string $key
 * $return string
 */
    protected function normalizeKey($key) {
        $key = strtolower($key);
        $key = str_replace(array('-', '_'), ' ', $key);
        $key = preg_replace('#^http #', '', $key);
        $key = ucwords($key);
        $key = str_replace(' ', '-', $key);

        return $key;
    }

}
