<?php

        
function __autoload($class) {
        //echo str_replace('\\', '/', $class);
      //  echo file_exists( DIRNAME.'business_layer/Workflows/' . str_replace('\\', '/', $class) . '.php' );
	// convert namespace to full file path
	if(file_exists( DIRNAME.'data_access_layer/' . str_replace('\\', '/', $class) . '.php' ) ){
            $class = DIRNAME.'data_access_layer/' . str_replace('\\', '/', $class) . '.php';
            require_once($class);
        }else{
          //  echo "blah";
        }
        
        if(file_exists( DIRNAME.'business_layer/Workflows/' . str_replace('\\', '/', $class) . '.php' ) ){
            $class = DIRNAME.'business_layer/Workflows/' . str_replace('\\', '/', $class) . '.php';
            //echo file_exists($class);
            require_once($class);
        }else{
            //echo "blah";
        }
        if(file_exists( DIRNAME.'business_layer/' . str_replace('\\', '/', $class) . '.php' ) ){
            $class = DIRNAME.'business_layer/' . str_replace('\\', '/', $class) . '.php';
            require_once($class);
        }else{
            //echo "blah";
        }
        
         
	

}
spl_autoload_register('__autoload');