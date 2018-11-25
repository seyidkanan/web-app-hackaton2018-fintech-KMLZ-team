<?php
namespace AdminWorkflow;

use Entity\UserEntity;
use Entity\ResultEntity;

use Repository\UserRepository;

use Models\UserModel;

class UserWorkflow{
    public $data = array();
    
    public function deleteUser(UserModel $um){
        $resultModel = new \Models\ResultModel;
        $repo = new \Repository\UserRepository;
        $ue = new \Entity\UserEntity;
        $ue->user_id = $um->user_id;
        $deleteResp = $repo->deleteUser($ue);
        if($deleteResp->code){
            $resultModel->msg  = $deleteResp->msg;
            $resultModel->code = true;
            
            
        }else{
            $resultModel->code=false;
            $resultModel->msg = $deleteResp->msg;
        }
        return $resultModel ;
    }
    
    public function login(UserModel $um) {
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\UserRepository();
        $ue = new \Entity\UserEntity();
        $ue->user_email = $um->user_email;
        $ue->user_pass = $um->user_pass;
        $loginResp = $repo->login($ue);
        if($loginResp->code){
            $um->user_id = $ue->user_id;
            $resultModel->code = true;
            
        }else{
            $resultModel->code=false;
            $resultModel->msg = $loginResp->msg;
        }
        return $resultModel;
    }
    
    public function addUser(UserModel $um){
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\UserRepository();
        $ue = new \Entity\UserEntity;
        $ue->user_email = $um->user_email;
        $ue->user_pass = $um->user_pass;
        $addResp = $repo->addUser($ue);
        if($addResp->code){
            $resultModel->code =true;
        }else{
            $resultModel->code = FALSE;
            $resultModel->msg = $addResp->msg;
        }
        return $resultModel;
    }
    
    public function getUser(UserModel $um){
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\UserRepository();
        $ue = new \Entity\UserEntity();
        $ue->user_id = $um->user_id;
        $resp = $repo->getUser($ue);
        if($resp->code){
            $resultModel->code=true;
            $resultModel->body =$resp->body;
            
            
        }else{
            $resultModel->code=false;
            $resultModel->msg = $resp->msg;
        }
        return $resultModel;
    }
    
    public function updateUser(UserModel $um){
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\UserRepository();
        $ue = new \Entity\UserEntity();
        $ue->user_id = $um->user_id;
        $ue->user_email = $um->user_email;
        $ue->user_pass = $um->user_pass;
        $result = $repo->updateUser($ue);
        if($result->code){
            $resultModel->code=true;
            $resultModel->msg=$result->msg;
            
        }else{
            $resultModel->code=false;
            $resultModel->msg=$result->msg;
        }
        return $resultModel;
        
    }
    
    public function getUsers(){
        $resultModel = new \Models\ResultModel();
        $repo = new \Repository\UserRepository();
        $resp = $repo->getUsers();
        if($resp->code){
            $resultModel->code=true;
            $resultModel->body =$resp->body;
            
        }else{
            $resultModel->code = false;
            $resultModel->msg = $resp->msg;
        }
        return $resultModel;
        
    }
    
    public function changePass(UserModel $um){
        $resultModel = new \Models\ResultModel;
        $repo = new \Repository\UserRepository();
        $ue = new \Entity\UserEntity;
        $ue->user_id = $um->user_id;
        $ue->data = $um->data;
        $resp = $repo->changePass($ue);
        if($resp->code){
            $resultModel->code = $resp->code;
            $resultModel->msg = $resp->msg;
            
        }else{
            $resultModel->code = $resp->code;
            $resultModel->msg = $resp->msg;
        }
        return $resultModel;
    }
}

