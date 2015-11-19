<?php
//require_once 'lib/swift_required.php';
include('swift_required.php');
class SendMail{
	public $instance; //发邮件服务器
	public $smtp_port=25;//邮件服务器端口
	public $username;//发邮件的用户名
	public $user_password;//邮箱地址的密码
	public $setFrom;//发邮件的地址
	public $setTo;//接受邮件的地址,是一个数组
	public $subject;//发送邮件的主题
	public $setBody;//发送邮件的主体内容
	public $setfilepath='';//发送邮件的附件
	public $aliasname='';//附件的别名
	
	//定义构造函数
	public function __construct($instance,$smtp_port=25,$username,$user_password,$setFrom,$setTo,$subject,$setBody,$setfilepath='',$aliasname=''){
		$this->instance=$instance;
		$this->smtp_port=$smtp_port;
		$this->username=$username;
		$this->user_password=$user_password;
		$this->setFrom=$setFrom;
		$this->setTo=$setTo;
		$this->subject=$subject;
		$this->setBody=$setBody;
		$this->setfilepath=$setfilepath;
		$this->aliasname=$aliasname;
	}
	//发送邮件
	public function sendMail(){
		$transport = Swift_SmtpTransport::newInstance($this->instance,$this->smtp_port);
		$transport->setUsername($this->username);
		$transport->setPassword($this->user_password); 
		$mailer = Swift_Mailer::newInstance($transport); 
		$message = Swift_Message::newInstance();
		$message->setFrom($this->setFrom);
		$message->setTo($this->setTo);
		$message->setSubject($this->subject);
		$message->setBody($this->setBody, 'text/html', 'utf-8');
		if(!empty($this->setfilepath)){
			$message->attach(Swift_Attachment::fromPath($this->setfilepath)->setFilename($this->aliasname));
		}
		
		/*try{
		   if($mailer->send($message)){
			   return true;
		   }
		 }
		 catch (Swift_ConnectionException $e){
			//echo 'There was a problem communicating with SMTP: ' . $e->getMessage();
			return false;
		 }*/
		return ($mailer->send($message));
	}
}


?>;