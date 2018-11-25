<?php
namespace UserWorkflow;

use Entity\CategoriesEntity;
use Entity\ResultEntity;

use Repository\CategoriesRepository;

use Models\CategoriesModel;

class CategoriesWorkflow{
    public $data = array();

    public function listAll() {
        $resultModel = new \Models\ResultModel();
        $repo = new CategoriesRepository();
        $listResp = $repo->listAll();
        $resultModel->code = $listResp->code;
        $resultModel->body = $listResp->body;
        return $resultModel;
    }
    

}

