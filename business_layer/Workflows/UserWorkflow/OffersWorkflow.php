<?php
namespace UserWorkflow;

use Entity\OffersEntity;
use Entity\ResultEntity;

use Repository\OffersRepository;

use Models\OffersModel;

class OffersWorkflow{
    public $data = array();

    public function add(OffersModel $om) {
        $resultModel = new \Models\ResultModel();
        $repo = new OffersRepository();
        $oe = new OffersEntity();
        $oe->offer_user_id = $om->offer_user_id;
        $oe->offer_bank = $om->offer_bank;
        $oe->offer_content = $om->offer_content;
        $oe->offer_title = $om->offer_title;
        $oResp = $repo->add($oe);
        $resultModel->code = $oResp->code;
        return $resultModel;
    }

    public function getOffers(OffersModel $om) {
        $resultModel = new \Models\ResultModel();
        $repo = new OffersRepository();
        $oe = new OffersEntity();
        $oe->offer_user_id = $om->offer_user_id;
        $oResp = $repo->getOffers($oe);
        $resultModel->code = $oResp->code;
        $resultModel->body = $oResp->body;
        return $resultModel;
    }

    public function getOffersBank(OffersModel $om) {
        $resultModel = new \Models\ResultModel();
        $repo = new OffersRepository();
        $oe = new OffersEntity();
        $oe->offer_bank = $om->offer_bank;
        $oResp = $repo->getOffersBank($oe);
        $resultModel->code = $oResp->code;
        $resultModel->body = $oResp->body;
        return $resultModel;
    }

}

