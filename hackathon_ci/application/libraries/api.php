<?php
/**
 * Created by PhpStorm.
 * User: Weikiat
 * Date: 3/7/14
 * Time: 10:56 PM
 */

class api {
    public function response($output,$response_code){
        header('HTTP/1.1 '.$response_code);
        header('Content-Type: application/json');
        echo json_encode($output,JSON_NUMERIC_CHECK);
    }
}

?>
