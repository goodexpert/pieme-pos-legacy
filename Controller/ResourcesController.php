<?php

App::uses('AppController', 'Controller');

/**
 * references : `http://book.cakephp.org/2.0/en/models.html`
 */
class ResourcesController extends AppController
{

    // Authorized : Resources can access only admin
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

    public $uses = array('MerchantResource');

    public function index(){
        $this->MerchantResource->virtualFields['resource_name'] = 'ResourceTypes.name';
        $resources = $this->MerchantResource->find('all', array(
            'joins' => array(
                array(
                    'table' => 'resource_types',
                    'alias' => 'ResourceTypes',
                    'type' => 'INNER',
                    'conditions' => array(
                        'ResourceTypes.id = MerchantResource.resource_type_id'
                    )
              )
            ),
            'conditions' => array(
                'MerchantResource.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set('resources',$resources);

        if ($this->request->is('post') || $this->request->is('ajax')) {

            $this->layout = 'ajax';

            if($_POST['id']){

                if(count($this->request->data) > 1){
                    $this->MerchantResource->id = $_POST['id'];
                    $resources['resource_type_id'] = $_POST['resource_type_id'];
                    $resources['resource_name'] = $_POST['resource_name'];
                    $resources['name'] = $_POST['name'];
                    $resources['user_field_1'] = $_POST['user_field_1'];
                    $this->MerchantResource->save($resources);
                } else {
                    $this->MerchantResource->delete($_POST['id']);
                }
            }
            /**
            else {
                $this->MerchantResource->create();
                $resources['merchant_id'] = $this->Auth->user()['merchant_id'];
                $resources['resource_type_id'] = $_POST['resource_type_id'];
                $resources['name'] = $_POST['name'];
                $resources['user_field_1'] = $_POST['user_field_1'];
                $this->MerchantResource->save($resources);

                $result = array();
                $result['id'] = $this->MerchantResource->id;
                $this->serialize($result);
            }
             **/
        }
    }

    public function add(){
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                $data['retailer_id'] = $user['retailer_id'];
                $data['outlet_id'] = $user['outlet_id'];

                $this->MerchantResource->create();
                $this->MerchantResource->save($data);

                $result['success'] = true;
                $result['id'] = $this->MerchantResource->id;
                $result['data'] = $data;

            } catch (Exception $e) {
                $dataSource->rollback();

                if ($this->request->is('ajax')) {
                    $result['message'] = $e->getMessage();
                } else {
                    $this->Session->setFlash($e->getMessage());
                }
            }
            $this->serialize($result);
        }
    }

    public function edit(){
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                $data['retailer_id'] = $user['retailer_id'];
                $data['outlet_id'] = $user['outlet_id'];

                $this->MerchantResource->id = $data['to_edit'];
                $this->MerchantResource->save($data);

                $result['success'] = true;

            } catch (Exception $e) {
                $dataSource->rollback();

                if ($this->request->is('ajax')) {
                    $result['message'] = $e->getMessage();
                } else {
                    $this->Session->setFlash($e->getMessage());
                }
            }
            $this->serialize($result);
        }
    }

    /**
     * @param $id
     */
    public function delete() {
        $user = $this->Auth->user();

        if($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;

            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;

                $this->MerchantResource->delete($data['to_delete']);

                $result['success'] = true;

            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
    }
}
