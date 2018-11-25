<?php
namespace Repository;

use Entity\ExpensesEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class ExpensesRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    
    public function add(ExpensesEntity $ee){
        $results = new ResultEntity();
        $query = $this->db->prepare("INSERT INTO `expenses`(`EXPENSE_NAME`, `EXPENSE_AMOUNT`, `EXPENSE_USER_ID`, `EXPENSE_TIME`, `EXPENSE_CATEGORY`) VALUES (?,?,?,?,?)");
          $query->execute(array( $ee->expense_name, $ee->expense_amount,$ee->expense_user_id,$ee->expense_time,$ee->expense_category ));

        if($query->errorInfo()[1]==''){
            $results->code = "1024"; // expense  data successfully added

        }else{
            $results->code = "1025"; // expense  data not added

        }
        return $results;
    }

    public function getExpenses(ExpensesEntity $ee){
        $results = new ResultEntity();
        $query = $this->db->prepare("SELECT `CAT_NAME`,`EXPENSE_NAME`,`EXPENSE_AMOUNT`,`EXPENSE_TIME` FROM `expenses` INNER JOIN `expense_categories` ON `expense_categories`.`CAT_ID`= `expenses`.`EXPENSE_CATEGORY` WHERE `EXPENSE_USER_ID`=?");
        $query->execute(array( $ee->expense_user_id ));

        if($query->rowCount()>0){
            //
            $data = $query->fetchAll(\PDO::FETCH_ASSOC);

            //

            $results->body = $data;



            $results->code = "1026"; // expense  data found

        }else{
            $results->body = NULL;
            $results->code = "1027"; // expense  data not found

        }
        return $results;
    }


}