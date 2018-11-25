<?php
namespace UserWorkflow;

use Entity\BanksEntity;
use Entity\ResultEntity;

use Repository\BanksRepository;

use Models\BanksModel;

class BanksWorkflow{
    public $data = array();

    public function login(BanksModel $bm) {
        $resultModel = new \Models\ResultModel();
        $repo = new BanksRepository();
        $be = new BanksEntity();
        $be->bank_token = $bm->bank_token;
        $loginResp = $repo->login($be);
        $resultModel->body = $loginResp->body;
        return $resultModel;
    }
    

}

