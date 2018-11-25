<?php

namespace Repository;

use Entity\TokenEntity;

require_once 'core/Database.php';

class TokenRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }

    public function checkToken(TokenEntity $te){
        $result = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `tokens` WHERE `TOKEN`=?");
        $query->execute( array($te->token) );
        if($query->errorInfo()[1]=='' ){
            if($query->rowCount()>0){
                $fetch = $query->fetch();
                $exp_date = $fetch['EXP_DATE'];
                if($exp_date>time()){
                    $te->user_id = $fetch['USER_ID'];
                    $result->code = 1000; // success
                }else{
                    $result->code = 1096; // expired
                }
            }else{
                $result->code = 1052; // token not found
            }
        } else {
            $result->code = 1001; // database error
        }
        return $result;

    }
}