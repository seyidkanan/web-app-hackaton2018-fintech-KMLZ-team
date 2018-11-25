<?php
namespace UserWorkflow;

use Entity\CalculatorEntity;
use Entity\ResultEntity;

use Repository\CalculatorRepository;

use Models\CalculatorModel;

class CalculatorWorkflow{
    public $data = array();

    public function add(CalculatorModel $cm) {
        $resultModel = new \Models\ResultModel();
        $repo = new CalculatorRepository();
        $ce = new \Entity\CalculatorEntity();
        $ce->cal_type = $cm->cal_type;
        $ce->cal_user_id = $cm->cal_user_id;
        $ce->cal_period = $cm->cal_period;
        $ce->cal_loan = $cm->cal_loan;
        $ce->cal_percent = $cm->cal_percent;
        $addResp = $repo->add($ce);
        $resultModel->code = $addResp->code;
        return $resultModel;
    }
    

}

