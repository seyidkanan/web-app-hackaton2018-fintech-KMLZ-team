<?php

namespace Repository;

use Entity\LangEntity;

require_once 'core/Database.php';

class LangRepository {

    public $db;
    private $data = array();

    function __construct() {
        $this->db = \Database::getDB();
    }

    public function getLangs() {
        $result = new \Entity\ResultEntity();


        try {
            $query = $this->db->query("SELECT * FROM `lang` ORDER BY `LANG_ID` ASC");
            $fetch = $query->fetchAll();
            foreach ($fetch as $row) {
                $le = new \Entity\LangEntity();
                $le->lang_id = $row['LANG_ID'];
                $le->lang_shortcode = $row['LANG_SHORTCODE'];
                $this->data[] = $le;
            }
            $result->body = $this->data;
            $result->code = true;
        } catch (Exception $ex) {
            $result->msg = $ex;
            $result->code = false;
        }
        return $result;
    }

    public function addLang(LangEntity $le) {
        $results = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `lang` WHERE `LANG_SHORTCODE`=?");
        try {
            $query->execute(array($le->lang_shortcode));
            if ($query->rowCount() > 0) {
                $results->code = false;
                $results->msg = 'This language shortcode already taken';
            } else {
                $insert = $this->db->prepare("INSERT INTO `lang`(`LANG_SHORTCODE`) VALUES (?)");
                try {
                    if ($insert->execute(array($le->lang_shortcode))) {
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

    public function getLang(LangEntity $le) {
        $result = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `lang` WHERE `LANG_ID` = ? ");
        try {
            $query->execute(array($le->lang_id));
            if ($query->rowCount() > 0) {
                $fetch = $query->fetch();
                $le->lang_shortcode = $fetch['LANG_SHORTCODE'];
                $result->code = true;
                $result->body = $le;
            } else {
                $result->code = false;
                $result->msg = 'Lang not found!';
            }
        } catch (Exception $ex) {
            $result->code = false;
            $result->msg = $ex;
        }
        return $result;
    }

    public function updateLang(LangEntity $le) {
        $result = new \Entity\ResultEntity();
        $query = $this->db->prepare("SELECT * FROM `lang` WHERE `LANG_SHORTCODE`=?");
        try {
            $query->execute(array($le->lang_shortcode));
            if ($query->rowCount() == 0) {


                $update = $this->db->prepare("UPDATE `lang` SET `LANG_SHORTCODE`= ?  WHERE `LANG_ID`=?");
                try {

                    if ($update->execute(array($le->lang_shortcode, $le->lang_id))) {
                        $result->code = true;
                        $result->msg = "Language successfully updated!";
                    } else {
                        $result->code = false;
                        $result->msg = "Language  not updated!";
                    }
                } catch (Exception $e) {
                    $result->code = FALSE;
                    $result->msg = $e;
                }
            } else {
                $result->code = false;
                $result->msg = "Lang shortcode already taken";
            }
        } catch (Exception $ex) {
            $result->code = false;
            $result->msg = $ex;
        }
        return $result;
    }

    public function deleteLang(LangEntity $le) {
        $result = new \Entity\ResultEntity();
        $select = $this->db->prepare("SELECT * FROM `lang` WHERE `LANG_ID`=?");
        try {
            $select->execute(array($le->lang_id));
            if ($select->rowCount() > 0) {
                $delete = $this->db->prepare("DELETE FROM `lang` WHERE `LANG_ID`=?");
                if ($delete->execute(array($le->lang_id))) {
                    $result->code = true;
                    $result->msg = 'Language successfully deleted';
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

}
