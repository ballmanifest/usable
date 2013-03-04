<?php

class Rest_UserController extends Zend_Rest_Controller {

    public function init() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        $server = new Zend_Rest_Server();
        $server->setClass('Application_Model_Rest');
        $server->handle();
    }

    public function getAction() {
    }

    public function postAction() {
    }

    public function putAction() {
    }

    public function deleteAction() {
    }

    public function headAction() {
    }

    public function apikeyAction() {
    }

}
