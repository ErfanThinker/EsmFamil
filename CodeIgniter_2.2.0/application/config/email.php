<?php

       /*$config['protocol']          = 'smtp';
       $config['smtp_host']       = 'in.mailjet.com';
       $config['smtp_port']       = 25;
       $config['smtp_timeout']= '7';
       $config['smtp_user']       = '';
       $config['smtp_pass']       = '';
       $config['charset']            = 'utf-8';
       $config['newline']           = "\r\n";
       $config['mailtype']          = 'html'; // or html
       $config['validation']        = TRUE;*/
       
       $config['protocol']          = 'smtp';
       $config['smtp_host']       = 'ssl://smtp.googlemail.com';
       $config['smtp_port']       = 465;
       $config['smtp_timeout']= '';
       $config['smtp_user']       = '';
       $config['smtp_pass']       = '';
       $config['charset']            = 'utf-8';
       $config['newline']           = "\r\n";
       $config['mailtype']          = 'html'; // or html
       $config['validation']        = TRUE;

?>