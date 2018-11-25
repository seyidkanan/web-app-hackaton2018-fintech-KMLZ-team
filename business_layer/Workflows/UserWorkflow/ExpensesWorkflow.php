<?php
namespace UserWorkflow;

use Entity\ExpensesEntity;
use Entity\ResultEntity;

use Repository\ExpensesRepository;

use Models\ExpensesModel;

class ExpensesWorkflow{
    public $data = array();

    public function add(ExpensesModel $em) {
        $resultModel = new \Models\ResultModel();
        $repo = new ExpensesRepository();
        $ee = new ExpensesEntity();
        $ee->expense_time = $em->expense_time;
        $ee->expense_user_id = $em->expense_user_id;
        $ee->expense_name = $em->expense_name;
        $ee->expense_category = $em->expense_category;
        $ee->expense_amount = $em->expense_amount;
        $eResp = $repo->add($ee);
        $resultModel->code = $eResp->code;
        return $resultModel;
    }

    public function getExpenses(ExpensesModel $em) {
        $resultModel = new \Models\ResultModel();
        $repo = new ExpensesRepository();
        $ee = new ExpensesEntity();
        $ee->expense_user_id = $em->expense_user_id;
        $eResp = $repo->getExpenses($ee);
        $resultModel->code = $eResp->code;
        $resultModel->body = $eResp->body;
        return $resultModel;
    }

}

