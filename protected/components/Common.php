<?php
    class Common {
    
        public static function pre($array , $exit=null){
            echo "<pre>";
            print_r($array);
            echo "</pre>";
            if($exit){
                exit;
            }
        } 
    }

?>