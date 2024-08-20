<?php

class CommonResponse {
    private $status;
    private $message;
    private $data;
    private $timestamp;

    public function __construct($status, $message, $data, $timestamp) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->timestamp = $timestamp;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getData(){
        return $this->data;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

    public function __toString(){
        return json_encode($this);
    }
    
    public function setStatus( $status ){
        $this->status = $status;
    }

    public function setStatusMessage( $message ){
        $this->message = $message;
    }

    public function setData( $data ){
        $this->data = $data;
    }

    public function setTimestamp( $timestamp ){
        $this->timestamp = $timestamp;
    }
}