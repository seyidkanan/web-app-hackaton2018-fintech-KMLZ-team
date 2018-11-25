<?php
function translate($key){
    global $lang;
    $sh_code = $_SESSION['lang'];
    return $lang[$sh_code][$key];
}

function load($template, $data = array()) {
    if (count($data) > 0) {
        extract($data);
    }
    if (file_exists(DIRNAME . VIEW_DIR . $template . VIEW_SUF)) {
        require_once DIRNAME . VIEW_DIR . $template . VIEW_SUF;
    } else {
        die("Template Not Found!");
    }
}

function secure($data) {
    $data = trim($data);
  //  $data = mysql_real_escape_string($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}

function crocus_hash($data) {
    $salt = sha1("crocushash");
    $data = md5($data . $salt);
    return $data;
}

function return_msg($errmsg, $type = NULL) {
    if ($type == NULL) {
        die("Message type not defined");
    } else {
        if ($type == 'danger') {
            $str = "Error";
        }
        if ($type == 'success') {
            $str = 'Success';
        }
    }
    return "<div class=\"alert alert-$type\">
        <button class=\"close\" data-close=\"alert\"></button>
                                            <strong>$str!</strong> $errmsg </div>";
}

function upload($file) {
    $foo = new Upload($file);
    if ($foo->uploaded) {
        $old_name = $file['name'];
        $ext = 'jpeg';
        $foo->image_convert = $ext;
        $foo->allowed = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
        $new_name = md5($old_name) . sha1(rand(0, 1024));
        //$foo->jpeg_quality = 40;
        $foo->file_new_name_body = $new_name;
        $foo->Process(UPLOADS_DIR);
        if ($foo->processed) {
            
        } else {
            
        }
    }
    return $new_name.".$ext";
}

function randomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 25; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}