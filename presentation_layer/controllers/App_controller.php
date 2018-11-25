<?php
class App{
    public $data = array();
    public $errors = array();
    
    public function index(){
        
    }

    public function askregister(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty(file_get_contents("php://input"))){
                $data = json_decode(file_get_contents("php://input"),true);
                $cm = new \Models\CustomerModel;
                $workflow = new \UserWorkflow\CustomerWorkflow;
                $cm->user_email = $data['email'];
                $cm->user_password  = md5($data['pass']);
                $cm->user_number = $data['number'];
                $cm->user_lastname = $data['lastname'];
                $cm->user_firstname = $data['firstname'];
                $resp = $workflow->askregister($cm);
                $resp_json['code'] = $resp->code;

                header("Content-Type: application/json");
                echo json_encode($resp_json);

            }
         }
        
        
    }
    
    public function login(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty(file_get_contents("php://input") )){
                $json = json_decode(file_get_contents("php://input"),true);
                $mail = $json['email'];
                $pass = md5($json['pass']);
                $cm = new \Models\CustomerModel;
                $workflow = new \UserWorkflow\CustomerWorkflow;
                $cm->user_email = $mail;
                $cm->user_password = $pass;
                $resp = $workflow->login($cm);
                $resp_json['resp'] = $resp->body;

                header("Content-Type: application/json");
                echo json_encode($resp_json);
                
            }
            
        }
    }


    public function calculator(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = $json['token'];
                $cal_type = $json['cal_type'];
                $cal_loan = $json['cal_loan'];
                $cal_percent = $json['cal_percent'];
                $cal_period = $json['cal_period'];
                $tm = new \Models\TokenModel();
                $tm->token = $token;
                $token_workflow = new \UserWorkflow\TokenWorkflow;
                $resp_token = $token_workflow->checkToken($tm);
                if($resp_token->code==1000){
                    $cm = new \Models\CalculatorModel();
                    $cw = new \UserWorkflow\CalculatorWorkflow();
                    $cm->cal_percent = $cal_percent;
                    $cm->cal_loan = $cal_loan;
                    $cm->cal_period = $cal_period;
                    $cm->cal_type = $cal_type;
                    $cm->cal_user_id = $tm->user_id;
                    $resp_add = $cw->add($cm);
                    $resp_json['code']=$resp_add->code;
                    $resp_json['body'] = NULL;


                }else{
                    $resp_json['code']=$resp_token->code;
                    $resp_json['body'] = NULL;

                }

                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

    public function addExpense(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = $json['token'];
                $tm = new \Models\TokenModel();
                $tm->token = $token;
                $token_workflow = new \UserWorkflow\TokenWorkflow;
                $resp_token = $token_workflow->checkToken($tm);
                if($resp_token->code==1000){
                    $em = new \Models\ExpensesModel();
                    $ew = new \UserWorkflow\ExpensesWorkflow();
                    $em->expense_amount = $json['expense_amount'];
                    $em->expense_category = $json['expense_category'];
                    $em->expense_name = $json['expense_name'];
                    $em->expense_user_id = $tm->user_id;
                    $em->expense_time = time();
                    $resp_add = $ew->add($em);
                    $resp_json['code']=$resp_add->code;
                    $resp_json['body'] = NULL;


                }else{
                    $resp_json['code']=$resp_token->code;
                    $resp_json['body'] = NULL;

                }

                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

    public function getExpenses(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = $json['token'];
                $tm = new \Models\TokenModel();
                $tm->token = $token;
                $token_workflow = new \UserWorkflow\TokenWorkflow;
                $resp_token = $token_workflow->checkToken($tm);
                if($resp_token->code==1000){
                    $em = new \Models\ExpensesModel();
                    $ew = new \UserWorkflow\ExpensesWorkflow();
                    $em->expense_user_id = $tm->user_id;
                    $resp_get = $ew->getExpenses($em);
                    $resp_json['code']=$resp_get->code;
                    $resp_json['body'] = $resp_get->body;


                }else{
                    $resp_json['code']=$resp_token->code;
                    $resp_json['body'] = NULL;

                }

                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

    public function getOffers(){
        if($_SERVER['REQUEST_METHOD']='POST'){
            if(!empty(file_get_contents("php://input"))){
                $json = json_decode(file_get_contents("php://input"),true);
                $token = $json['token'];
                $tm = new \Models\TokenModel();
                $tm->token = $token;
                $token_workflow = new \UserWorkflow\TokenWorkflow;
                $resp_token = $token_workflow->checkToken($tm);
                if($resp_token->code==1000){
                    $om = new \Models\OffersModel();
                    $ow = new \UserWorkflow\OffersWorkflow();
                    $om->offer_user_id = $tm->user_id;
                    $resp_get = $ow->getOffers($om);
                    $resp_json['code']=$resp_get->code;
                    $resp_json['body'] = $resp_get->body;


                }else{
                    $resp_json['code']=$resp_token->code;
                    $resp_json['body'] = NULL;

                }

                header("Content-type: application/json");
                echo json_encode($resp_json,JSON_PRESERVE_ZERO_FRACTION);
            }
        }
    }

    public function listTypes(){
        if($_SERVER['REQUEST_METHOD']=='GET'){

                $workflow = new \UserWorkflow\TypesWorkflow();
                $resp = $workflow->listAll();
                $resp_json['resp'] = $resp->body;
                $resp_json['code'] = $resp->code;

                header("Content-Type: application/json");
                echo json_encode($resp_json);



        }
    }

    public function listCategories(){
        if($_SERVER['REQUEST_METHOD']=='GET'){

            $workflow = new \UserWorkflow\CategoriesWorkflow();
            $resp = $workflow->listAll();
            $resp_json['resp'] = $resp->body;
            $resp_json['code'] = $resp->code;

            header("Content-Type: application/json");
            echo json_encode($resp_json);



        }
    }
}
