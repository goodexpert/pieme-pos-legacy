<?php

App::uses('AppController', 'Controller');

class PricebookController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('MerchantProduct','MerchantPriceBook','MerchantPriceBookEntry');
	public $layout = 'home';

	public function index() {
		$books = $this->MerchantPriceBook->find('all',array(
			'conditions' => array(
				'MerchantPriceBook.merchant_id' => $this->Auth->user()['merchant_id']
			)
		));
		$this->set('books',$books);
	
	}
	public function add() {
	
		$items = $this->MerchantProduct->find('all');
		$this->set("items",$items);
	
	}
	public function view() {
	
		$this->MerchantPriceBookEntry->bindModel(array(
			'belongsTo' => array(
				'MerchantProduct' => array(
					'className' => 'MerchantProduct',
					'foreignKey' => 'product_id'
				)
			)
		));
	
		$this->MerchantPriceBook->bindModel(array(
			'hasMany' => array(
				'MerchantPriceBookEntry' => array(
					'className' => 'MerchantPriceBookEntry',
					'foreignKey' => 'price_book_id'
				)
			),
		));
		
		$this->MerchantPriceBook->recursive = 2;
	
		$book = $this->MerchantPriceBook->findById($_GET['r']);
		
		$this->set('book',$book);
	}
	/**
	 * Callback is called before any controller action logic is executed.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'add');
    }
}
