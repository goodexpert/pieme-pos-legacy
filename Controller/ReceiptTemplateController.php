<?php

App::uses('AppController', 'Controller');

class ReceiptTemplateController extends AppController {

    // Authorized : ReceiptTemplate can access only admin
    public function isAuthorized($user = null) {
        if (isset($user['user_type_id'])) {
            return (bool)($user['user_type_id'] === 'user_type_admin');
        }
        // Default deny
        return false;
    }

/**
 * Components property.
 *
 * @var array
 */
    public $components = array('RequestHandler');

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'home';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
        'MerchantReceiptTemplate',
        'MerchantRegister',
        'ReceiptStyle'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add(){
        $user = $this->Auth->user();
        
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantReceiptTemplate->getDataSource();
            $dataSource->begin();
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                
                $this->MerchantReceiptTemplate->create();
                $this->MerchantReceiptTemplate->save($data);
                
                $dataSource->commit();
                $result['success'] = true;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }

        $styles = $this->ReceiptStyle->find('all');
        $this->set('styles',$styles);
    }

    public function edit($id){
        $user = $this->Auth->user();
        
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantReceiptTemplate->getDataSource();
            $dataSource->begin();
            try {
                $data = $this->request->data;
                
                if(isset($data['request']) && $data['request'] == 'delete') {
                    $availability = $this->MerchantRegister->findByReceiptTemplateId($id);
                    if(empty($availability)) {
                        $this->MerchantReceiptTemplate->delete($id);
                        
                        $dataSource->commit();
                        $result['success'] = true;
                    } else {
                        $result['message'] = 'More than one register using this template';
                    }
                } else {
                    $this->MerchantReceiptTemplate->id = $id;
                    $this->MerchantReceiptTemplate->save($data);
                    
                    $dataSource->commit();
                    $result['success'] = true;
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
        
        $template = $this->MerchantReceiptTemplate->findById($id);
        $this->set('template',$template);
        
        $styles = $this->ReceiptStyle->find('all');
        $this->set('styles',$styles);
    }
}
