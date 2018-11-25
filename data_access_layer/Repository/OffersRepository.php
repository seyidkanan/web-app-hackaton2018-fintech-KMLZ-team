<?php
namespace Repository;

use Entity\OffersEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class OffersRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    
    public function add(OffersEntity $oe){
        $results = new ResultEntity();
        $query = $this->db->prepare("INSERT INTO `offers`(`OFFER_USER_ID`, `OFFER_TITLE`, `OFFER_CONTENT`, `OFFER_BANK`) VALUES (?,?,?,?)");
          $query->execute(array( $oe->offer_user_id, $oe->offer_title, $oe->offer_content, $oe->offer_bank ));

        if($query->errorInfo()[1]==''){
            $results->code = "1030"; // offer  data successfully added

        }else{
            $results->code = "1031"; // offer  data not added

        }
        return $results;
    }

    public function getOffers(OffersEntity $oe){
        $results = new ResultEntity();
        $query = $this->db->prepare("SELECT `OFFER_ID`,`OFFER_TITLE`,`OFFER_CONTENT`,`BANK_NAME` FROM `offers` LEFT JOIN `banks` ON `banks`.`BANK_ID`=`offers`.`OFFER_BANK` WHERE `OFFER_USER_ID`=?");
        $query->execute(array( $oe->offer_user_id ));

        if($query->rowCount()>0){


            $data = $query->fetchAll(\PDO::FETCH_ASSOC);



            $results->body = $data;

            $results->code = "1032"; // offer  data found

        }else{
            $results->body = NULL;
            $results->code = "1033"; // offer  data not found

        }
        return $results;
    }

    public function getOffersBank(OffersEntity $oe){
        $results = new ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `banks` WHERE `BANK_ID`=?");
        $query->execute(array( $oe->offer_bank ));

        if($query->rowCount()>0){


            $data = $query->fetch(\PDO::FETCH_ASSOC);
            if($data['BANK_TYPE']==1){
                $offer_query = $this->db->query("SELECT `CAL_LOAN`,`CAL_ID`,`CAL_PERCENT`,`CAL_PERIOD`,`TYPE_NAME`,`USER_ID` FROM `calculator` INNER JOIN `users` ON `users`.`USER_ID`=`calculator`.`CAL_USER_ID` INNER JOIN `types` ON `calculator`.`CAL_TYPE`=	`types`.`TYPE_ID`");
                if($offer_query->rowCount()>0){
                    $fetch = $offer_query->fetchAll(\PDO::FETCH_ASSOC);
                    $results->body = $fetch;
                    $results->code = 1060;
                }else{
                    $results->body = NULL;
                    $results->code = 1061;
                }
            }else{
                $offer_query = $this->db->query("SELECT `USER_FIRSTNAME`,`USER_LASTNAME`,`USER_EMAIL`,`USER_NUMBER`,`CAL_LOAN`,`CAL_ID`,`CAL_PERCENT`,`CAL_PERIOD`,`TYPE_NAME`,`USER_ID` FROM `calculator` INNER JOIN `users` ON `users`.`USER_ID`=`calculator`.`CAL_USER_ID` INNER JOIN `types` ON `calculator`.`CAL_TYPE`=	`types`.`TYPE_ID`");
                if($offer_query->rowCount()>0){
                    $fetch = $offer_query->fetchAll(\PDO::FETCH_ASSOC);
                    $results->body = $fetch;
                    $results->code = 1060;
                }else{
                    $results->body = NULL;
                    $results->code = 1061;
                }
            }







        }else{
            $results->body = NULL;
            $results->code = "1051"; // bank not found

        }
        return $results;
    }





}