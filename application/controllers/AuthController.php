<?php
class AuthController extends Zend_Controller_Action
{
 
    public function init()
    {
        
    }

    public function loginAction()
    {
        $form = new Application_Form_Login();

        if( $this->getRequest()->isPost() ){
            
            if( $form->isValid( $this->_getAllParams() )) {
                
                $authAdapter = new Zend_Auth_Adapter_DbTable();
                $authAdapter
                    ->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');

                $authAdapter
                    ->setIdentity($form->getValue('username'))
                    ->setCredential(md5($form->getValue('password')));

                $auth = Zend_Auth::getInstance();

                
                $result = $auth->authenticate($authAdapter);
                
                if(  $result->isValid() ){
                    $storage = $auth->getStorage();
                    $dataUser = $authAdapter->getResultRowObject(array(
                        'id', 'username', 'realname', 'contact_id', 'role'
                        ));
                    $storage->write($dataUser);


                    return $this->_redirect('/dashboard');
                }else{
                    $form->username->addErrorMessage('Datos Incorrectos');
                }
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_redirect('/auth/login');
    }

}