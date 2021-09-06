<?php defined('BASEPATH') OR exit('No direct script access allowed');


$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.gmail.com', 
    'smtp_port' => 465,
    'smtp_user' => 'email@example', //use actual valid email address
    'smtp_pass' => 'P@ssword', // use valid password for that email
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '10', //in seconds
    //'charset' => 'iso-8859-1',
    'charset' => 'utf-8',
    "newline"  => "\r\n",
    'crlf' => "\r\n",
   'wordwrap' => TRUE
);
//$this->email->initialize($config);
?>