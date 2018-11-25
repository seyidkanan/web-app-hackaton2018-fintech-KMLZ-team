<?php
namespace UserWorkflow;

use Entity\CustomerEntity;
use Entity\ResultEntity;

use Repository\CustomerRepository;

use Models\CustomerModel;

class CustomerWorkflow{
    public $data = array();

    public function askRegister(CustomerModel $cm) {
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\CustomerRepository();
        $ce = new \Entity\CustomerEntity();
        $ce->user_email = $cm->user_email;
        $ce->user_password = $cm->user_password;
        $ce->user_number = $cm->user_number;
        $ce->user_firstname = $cm->user_firstname;
        $ce->user_lastname = $cm->user_lastname;
        $loginResp = $repo->askRegister($ce);
        $resultModel->code = $loginResp->code;
        return $resultModel;
    }


    public function login(CustomerModel $cm) {
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\CustomerRepository();
        $ce = new \Entity\CustomerEntity();
        $ce->user_email = $cm->user_email;
        $ce->user_password = $cm->user_password;
        $loginResp = $repo->login($ce);
        $resultModel->body = $loginResp->body;
        return $resultModel;
    }
    

}

