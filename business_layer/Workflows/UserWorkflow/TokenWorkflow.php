<?php
namespace UserWorkflow;

use Models\ResultModel;
use Models\TokenModel;
use Entity\TokenEntity;
use Entity\ResultEntity;
use Repository\TokenRepository;

class TokenWorkflow{
    public $data = array();

    public function checkToken(TokenModel $tm){
        $result =   new ResultModel;
        $te = new TokenEntity;
        $te->token = $tm->token;
        $repo = new TokenRepository;
        $resp = $repo->checkToken($te);
        $tm->user_id = $te->user_id;
        $result->code = $resp->code;
        return $result;
    }
}