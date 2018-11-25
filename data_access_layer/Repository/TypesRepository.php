<?php
namespace Repository;

use Entity\TypesEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class TypesRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    
    public function listAll(){
        $results = new ResultEntity();
        $query = $this->db->query("Select * from `types`");


        if($query->rowCount()>0){
            $results->body = $query->fetchAll(\PDO::FETCH_ASSOC);
            $results->code = "1019"; //types found

        }else{
            $results->body = NULL;
            $results->code = "1018"; // types not found

        }
        return $results;
    }


}