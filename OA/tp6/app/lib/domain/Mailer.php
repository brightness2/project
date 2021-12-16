<?php
namespace app\lib\domain;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class Mailer{
    
   
    public $host;                // SMTP服务器
    public $from;                // SMTP 用户名  即邮箱的用户名
    public $password;             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    public $fromName;            //发件人名称
    protected $settings=[
        'CharSet'=>'UTF-8', //设定邮件编码
        'SMTPDebug'=>0,     //调试模式输出
        'isSMTP'=>true,     //使用SMTP
        'SMTPAuth'=>true,   //允许 SMTP 认证
        'SMTPSecure'=>'ssl',//允许 TLS 或者ssl协议
        'Port'=>465,        //服务器端口 25 或者465 具体要看邮箱服务器支持
    ];
    protected $mail;

    public function __construct($host,$from,$fromName,$password,$settings=array())
    {
        if(is_array($settings) and !empty($settings)){
           $this->settings = array_merge($this->settings,$settings);
        }
        $this->host = $host;
        $this->from = $from;
        $this->password = $password;
        $this->fromName = $fromName;
        $this->init();
    }

    protected function init()
    {
        try {
            $this->mail = new PHPMailer(true); 
            //服务器配置
            $this->mail->CharSet =$this->settings['CharSet'];       //设定邮件编码
            $this->mail->SMTPDebug = $this->settings['SMTPDebug'];  // 调试模式输出
            if($this->settings['isSMTP']){
                $this->mail->isSMTP();                              // 使用SMTP
            }
            $this->mail->Host = $this->host;                        // SMTP服务器
            $this->mail->SMTPAuth = $this->settings['SMTPAuth'];                      // 允许 SMTP 认证
            $this->mail->Username = $this->from;                    // SMTP 用户名  即邮箱的用户名
            $this->mail->Password = $this->password;                // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $this->mail->SMTPSecure = $this->settings['SMTPSecure'];// 允许 TLS 或者ssl协议
            $this->mail->Port =  $this->settings['Port'];           // 服务器端口 25 或者465 具体要看邮箱服务器支持
            $this->mail->setFrom($this->from, $this->fromName);           //发件人
            $this->mail->addReplyTo($this->from, $this->fromName); //回复的时候回复给哪个邮箱 建议和发件人一致
            $this->mail->isHTML(true);                              //是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
        } catch (MailerException $e) {
            throw new \Exception($this->mail->ErrorInfo);
        }
        
    }

    /**
     * 添加收件人
     * 可以添加多个
     * @param string $toEmail
     * @param string $toName
     * @return void
     */
    public function addAddress($toEmail,$toName)
    {
        $this->mail->addAddress($toEmail, $toName);  // 收件人
    }

    /**
     * 抄送
     *
     * @param string $toEmail
     * @return void
     */
    public function addCC($toEmail)
    {
        $this->mail->addCC($toEmail);                    
    }

    /**
     * 密送
     *
     * @param string $toEmail
     * @return void
     */
    public function addBCC($toEmail)
    {
        $this->mail->addBCC($toEmail);                     
    }

    /**
     * 添加附件
     *
     * @param string $attachmentPath 附件路径
     * @param string $rename 附件别名
     * @return void
     */
    public function addAttachment($attachmentPath,$rename=null)
    {
        if($rename){
            $this->mail->addAttachment($attachmentPath,$rename);
        }else{
            $this->mail->addAttachment($attachmentPath);
        }
    }

    /**
     * 设置内容
     *
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function setContent($subject,$content)
    {
        $this->mail->Subject = $subject;
        $this->mail->Body = $content;
        $this->mail->AltBody = strip_tags($content);
    }
    /**
     * 发送
     *
     * @return void
     */
    public function send()
    {
        try {
            $this->mail->send();
        } catch (MailerException $e) {
            throw new \Exception($this->mail->ErrorInfo);
        }
    }
}