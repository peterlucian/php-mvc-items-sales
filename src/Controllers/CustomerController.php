<?php
namespace Bookstore\Controllers;

use Bookstore\Exceptions\NotFoundException;
use Bookstore\Models\CustomerModel;

class CustomerController extends AbstractController {
    public function login(string $email = NULL): string {
        if (!$this->request->isPost()) {
            return $this->render('login.twig', []);
        }
        $params = $this->request->getParams();
        if (!$params->has('email') && !$params->has('password')) {
            $params = ['errorMessage' => 'No info provided.'];
            return $this->render('login.twig', $params);
        }
        $email = $params->getString('email');
        $password = $params->getInt('password');
        $customerModel = new CustomerModel($this->db);
        try {
            $customer = $customerModel->getByEmail($email, $password);
        } catch (NotFoundException $e) {
            //$this->log->warn('Customer email not found: ' . $email);
            $params = ['errorMessage' => 'Email not found.'];
            return $this->render('login.twig', $params);
        } 
        //setcookie('user', $customer->getId());
        $this->request->getSession()->set('user', $customer->getId());
        
        
        $newController = new ItemController($this->di, $this->request);
        return $newController->getAll();
    }

    public function logout(){
        $this->request->getSession()->clear();
        $this->request->getSession()->destroy();
        
        
        $newController = new ItemController($this->di, $this->request);
        return $newController->getAll();
    }
}