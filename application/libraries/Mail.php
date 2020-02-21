<?php

class Mail {
    
    public $to;
    public $subject;
    public $message;
    public $headers;

    public function __construct($to, $subject, $message, $headers = null) {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public function send_email() {
        mail($this->to, $this->subject, $this->message, $this->headers);
    }
}