<?php
namespace Repository;

use Entity\CalculatorEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class CalculatorRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }
    
    public function add(CalculatorEntity $ce){
        $results = new ResultEntity();
        $query = $this->db->prepare("INSERT INTO `calculator`(`CAL_LOAN`, `CAL_PERCENT`, `CAL_PERIOD`, `CAL_USER_ID`, `CAL_TYPE`) VALUES (?,?,?,?,?)");
          $query->execute(array( $ce->cal_loan, $ce->cal_percent, $ce->cal_period, $ce->cal_user_id, $ce->cal_type ));

        if($query->errorInfo()[1]==''){
            $results->code = "1014"; //calculator data successfully added

        }else{
            $results->code = "1015"; // calculator data not added

        }
        return $results;
    }


}