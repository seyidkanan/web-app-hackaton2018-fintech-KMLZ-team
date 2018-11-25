<?php
namespace Repository;

use Entity\BanksEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class BanksRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    

    
    public function login(BanksEntity $be){
        $results = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `banks` WHERE `BANK_TOKEN`=? ");
        $query->execute(array($be->bank_token ));
           
        if($query->errorInfo()[1]==''){
            if($query->rowCount()>0){
                $fetch = $query->fetch( \PDO::FETCH_ASSOC );

                    $response['code'] = "1000"; //successfully logged in
                    $response['bank_id'] = $fetch['BANK_ID'];
                    $results->body = $response;

                
            }else{
                $response['code'] = "1002"; // user not found
                $response['token']= NULL;
                $results->body = $response;
            }
            
        }else{
            $results->code = true;
            $results->msg = 1001;
        }
        return $results;
    }
}