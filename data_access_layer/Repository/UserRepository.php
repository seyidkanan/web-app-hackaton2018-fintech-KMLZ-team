<?php

namespace Repository;

use Entity\UserEntity;
use Entity\ResultEntity;

require_once 'core/Database.php';

class UserRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }

    public function login(UserEntity $ue) {
        $results = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `USER_EMAIL`=? AND `USER_PASS`=?");
        try {
            $query->execute(array($ue->user_email, $ue->user_pass));
            if ($query->rowCount() > 0) {
                $fetch_obj = $query->fetch();
                $ue->user_email = $fetch_obj['USER_EMAIL'];
                $ue->user_pass = $fetch_obj['USER_PASS'];
                $ue->user_id = $fetch_obj['USER_ID'];
                $results->code = true;
            } else {
                $results->code = FALSE;
                $results->msg = "Invalid Login Credentials";
            }
        } catch (Exception $ex) {
            $results->msg = $ex->getMessage();
            $results->code = false;
        }
        return $results;
    }

    public function addUser(UserEntity $ue) {
        $results = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `USER_EMAIL`=?");
        try {
            $query->execute(array($ue->user_email));
            if ($query->rowCount() > 0) {
                $results->code = false;
                $results->msg = 'This e-mail already taken';
            } else {
                $insert = $this->db->prepare("INSERT INTO `users`(`USER_EMAIL`, `USER_PASS`) VALUES (?,?)");
                try {
                    if ($insert->execute(array($ue->user_email, $ue->user_pass))) {
                        $results->code = true;
                    }
                } catch (Exception $ex) {
                    $results->msg = $ex->getMessage();
                    $results->code = false;
                }
            }
        } catch (Exception $e) {
            $results->msg = $e->getMessage();
            $results->code = false;
        }
        return $results;
    }

    public function deleteUser(UserEntity $ue) {
        $result = new \Entity\ResultEntity();
        $select = $this->db->prepare("SELECT * FROM `users` WHERE `USER_ID`=?");
        try {
            $select->execute(array($ue->user_id));
            if ($select->rowCount() > 0) {
                $delete = $this->db->prepare("DELETE FROM `users` WHERE `USER_ID`=?");
                if ($delete->execute(array($ue->user_id))) {
                    $result->code = true;
                    $result->msg = 'User successfully deleted';
                } else {
                    $result->code = false;
                    $result->msg = "Not deleted";
                }
            } else {
                $result->code = false;
                $result->msg = "This data not found";
            }
        } catch (Exception $ex) {
            $result->code = false;
            $result->msg = "Not deleted";
        }
        return $result;
    }

    public function getUser(UserEntity $ue) {
        $result = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `USER_ID` = ? ");
        try {
            $query->execute(array($ue->user_id));
            if ($query->rowCount() > 0) {
                $fetch = $query->fetch();
                $ue->user_email = $fetch['USER_EMAIL'];
                $ue->user_pass = $fetch['USER_PASS'];
                $result->code = true;
                $result->body = $ue;
            } else {
                $result->code = false;
                $result->msg = 'User not found!';
            }
        } catch (Exception $ex) {
            $result->code = false;
            $result->msg = $ex;
        }
        return $result;
    }

    public function updateUser(UserEntity $ue) {
        $result = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `USER_EMAIL`=?");
        try {
            $query->execute(array($ue->user_email));
            if ($query->rowCount() > 0) {
                $fetch = $query->fetch();
                if ($fetch['USER_EMAIL'] == $ue->user_email) {
                    $update = $this->db->prepare("UPDATE `users` SET `USER_EMAIL`= ? ,`USER_PASS`=? WHERE `USER_ID`=?");
                    try {
                        if ($update->execute(array($ue->user_email, $ue->user_pass, $ue->user_id))) {
                            $result->code = true;
                            $result->msg = "User successfully updated!";
                        } else {
                            $result->code = false;
                            $result->msg = "User not updated!";
                        }
                    } catch (Exception $e) {
                        $result->code = FALSE;
                        $result->msg = $e;
                    }
                }else{
                     $result->code = FALSE;
                        $result->msg = 'E-mail already taken';
                }
            } else {
                $update = $this->db->prepare("UPDATE `users` SET `USER_EMAIL`= ? ,`USER_PASS`=? WHERE `USER_ID`=?");
                try {
                    if ($update->execute(array($ue->user_email, $ue->user_pass, $ue->user_id))) {
                        $result->code = true;
                        $result->msg = "User successfully updated!";
                    } else {
                        $result->code = false;
                        $result->msg = "User not updated!";
                    }
                } catch (Exception $e) {
                    $result->code = FALSE;
                    $result->msg = $e;
                }
            }
        } catch (Exception $ex) {
            $result->code = false;
            $result->msg = $ex;
        }
        return $result;
    }
    
    public function getUsers(){
        $result = new \Entity\ResultEntity();
        
        
        try {
            $query = $this->db->query("SELECT * FROM `users`");
            $fetch = $query->fetchAll();
            foreach ($fetch as $row) {
                $ue = new \Entity\UserEntity;
                $ue->user_id = $row['USER_ID'];
                $ue->user_email = $row['USER_EMAIL'];
                $this->data[] = $ue;
                
            }
            $result->body = $this->data;
            $result->code = true;
            
            
        } catch (Exception $ex) {
            $result->msg = $ex;
            $result->code = false;
        }
        return $result;
    }
    
    public function changePass(UserEntity $ue){
        $result  = new \Entity\ResultEntity();
        $select = $this->db->prepare("SELECT * FROM `users` WHERE `USER_PASS`=? AND `USER_ID`=?");
        try {
            
            $select->execute( array( $ue->data['oldpass'],$_SESSION['user_id'] ) );
            
            if( $select->rowCount()> 0 ){
                $update = $this->db->prepare("UPDATE `users` SET `USER_PASS`=? WHERE `USER_ID`=?");
                $update->execute( array($ue->data['newpass'], $_SESSION['user_id']) );
                $result->code = true;
                $result->msg = "Your password successfully updated";
            }else{
                $result->code = false;
                $result->msg = "Please enter your past password correctly";
            }
            
        } catch (Exception $exc) {
            $result->code=false;
            $result->msg = $exc;
        }
        return $result;
            
    }

}
