<?php
namespace UserWorkflow;

use Entity\TypesEntity;
use Entity\ResultEntity;

use Repository\TypesRepository;

use Models\TypesModel;

class TypesWorkflow{
    public $data = array();

    public function listAll() {
        $resultModel = new \Models\ResultModel();
        $repo = new TypesRepository();
        $listResp = $repo->listAll();
        $resultModel->code = $listResp->code;
        $resultModel->body = $listResp->body;
        return $resultModel;
    }
    

}

