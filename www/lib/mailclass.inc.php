<?php
require_once 'external/phpmailer/class.phpmailer.php';

class SMTPMailer extends PHPMailer
{
    var $priority = 3;
    var $to_name;
    var $to_email;
    var $From = null;
    var $FromName = null;
    var $Sender = null;
  
    function SMTPMailer()
    {
		global $config;

		$this->Host = $config['MAIL_SMTP_HOST'];
		$this->Port = $config['MAIL_SMTP_PORT'];

		$this->IsSMTP();
		$this->SMTPAuth  = $config['MAIL_SMTP_AUTH'];
		$this->Username  = $config['MAIL_SMTP_USERNAME'];
		$this->Password  = $config['MAIL_SMTP_PASSWORD'];

		$this->CharSet= "utf-8";

      if(!$this->From)
      {
        $this->From = $config['MAIL_FROM_EMAIL'];
      }
      if(!$this->FromName)
      {
        $this-> FromName = $config['MAIL_FROM_NAME'];
      }
      if(!$this->Sender)
      {
        $this->Sender = $config['MAIL_FROM_EMAIL'];
      }
      $this->Priority = $this->priority;
    }
}
?>