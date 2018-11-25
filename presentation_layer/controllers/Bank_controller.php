<?php
class Bank
{
    public $data = array();
    public $errors = array();

    public function index(){}

    public function getCalcDatas(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = md5($json['token']);
                $bm = new \Models\BanksModel();
                $workflow = new \UserWorkflow\BanksWorkflow();
                $bm->bank_token = $token;
                $resp = $workflow->login($bm);
                $bank_id = $resp->body['bank_id'];

                $ow = new \UserWorkflow\OffersWorkflow();
                $om = new \Models\OffersModel();
                $om->offer_bank = $bank_id;
                $resp_calc = $ow->getOffersBank($om);
                $resp_json['code'] = $resp_calc->code;
                $resp_json['body'] = $resp_calc->body;




                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

    public function addOffer(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = md5($json['token']);
                $offer_user_id = $json['offer_user_id'];
                $offer_content = $json['offer_content'];
                $offer_title = $json['offer_title'];

                $bm = new \Models\BanksModel();
                $workflow = new \UserWorkflow\BanksWorkflow();
                $bm->bank_token = $token;
                $resp = $workflow->login($bm);
                $bank_id = $resp->body['bank_id'];

                $ow = new \UserWorkflow\OffersWorkflow();
                $om = new \Models\OffersModel();
                $om->offer_bank = $bank_id;
                $om->offer_user_id = $offer_user_id;
                $om->offer_content = $offer_content;
                $om->offer_title = $offer_title;
                $resp_calc = $ow->add($om);
                $resp_json['code'] = $resp_calc->code;




                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

}
