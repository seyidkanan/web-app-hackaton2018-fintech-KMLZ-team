<?php
namespace Repository;

use Entity\CustomerEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class CustomerRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    
    public function askRegister(CustomerEntity $ce){
        $results = new ResultEntity();
        $query = $this->db->prepare("INSERT INTO `users`(`USER_EMAIL`,`USER_FIRSTNAME`,`USER_LASTNAME` ,`USER_NUMBER`, `USER_PASSWORD`) VALUES (?,?,?,?,?)");
          $query->execute(array($ce->user_email, $ce->user_firstname, $ce->user_lastname, $ce->user_number,$ce->user_password));
           
        if($query->errorInfo()[1]==1062){
            $results->code = "1011"; // user already exists

        }else{
            $results->code = "1010"; //successfully registered

        }
        return $results;
    }
    
    public function login(CustomerEntity $ce){
        $results = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `USER_EMAIL`=? AND  `USER_PASSWORD`=?");
        $query->execute(array($ce->user_email,$ce->user_password ));
           
        if($query->errorInfo()[1]==''){
            if($query->rowCount()>0){
                $fetch = $query->fetch( \PDO::FETCH_ASSOC );
                $fetch['USER_PASSWORD'] = '';
                $token = md5(randomString());
                $insert_token = $this->db->prepare("INSERT INTO `tokens`(`TOKEN`, `USER_ID`, `CREATED_DATE`, `EXP_DATE`) VALUES (?,?,?,?)");
                $insert_token->execute(array($token,$fetch['USER_ID'],time(),strtotime("+1 month")));
                if($insert_token->errorInfo()[1]==''){
                    $response['code'] = "1000"; //successfully logged in
                    $response['token']= $token;
                    $response['user_data'] = $fetch;
                    $results->body = $response;
                }
                
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