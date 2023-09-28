<?php
    class response {
        //Default response
        public $response = [
            'status' => "OK",
            'status_code' => "200",
            'result' => array(),
        ];

        public function message_handler($message, $code, $status){
            $this->$response['status'] = $status;
            $this->$response['status_code'] = $code;
            $this->$response['result'] = $message;

            return $this->$response;
        }
    }
?>