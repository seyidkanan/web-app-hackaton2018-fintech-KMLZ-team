<?php
if(isset($_GET['url']) && !empty($_GET['url']) ){
    $url = rtrim($_GET['url'],'/');
    $explodeUrl = explode("/", $url);
    //Controller
    $class = ucfirst($explodeUrl[0]);
    if(isset($explodeUrl[0]) && !empty($explodeUrl[0]) && file_exists(DIRNAME.CON_DIR.$class.CON_SUF) ){
        $controllerName = ucfirst($explodeUrl[0]);
        
    }else{
        $controllerName = "Index";
        
    }
    require_once DIRNAME.CON_DIR.$controllerName.CON_SUF;
    
   
    $run = new $controllerName();
    //Method
    if(isset($explodeUrl[1]) && !empty($explodeUrl[1]) && method_exists($controllerName, $explodeUrl[1])  ){
        //value
        $methodName = $explodeUrl[1];
        if(isset($explodeUrl[2]) && !empty($explodeUrl[2]) ){
            $value = $explodeUrl[2];
            $run->$methodName($value);
            
        }else{
            $run->$methodName();
        }
        
    }else{
        $methodName = "index";
        $run->$methodName();
        
    }
    
    
}else{
    require_once DIRNAME.CON_DIR."Index".CON_SUF;
    
   
    $run = new Index();
}