<?php
namespace Repository;

use Entity\CategoriesEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class CategoriesRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }

    public function listAll(){
        $results = new ResultEntity();
        $query = $this->db->query("Select * from `expense_categories`");


        if($query->rowCount()>0){
            $results->body = $query->fetchAll(\PDO::FETCH_ASSOC);
            $results->code = "1020"; //categories found

        }else{
            $results->body = NULL;
            $results->code = "1021"; // categories not found

        }
        return $results;
    }


}