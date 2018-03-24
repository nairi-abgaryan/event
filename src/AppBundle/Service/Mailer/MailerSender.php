<?php

namespace AppBundle\Service\Mailer;

class MailerSender
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $password;

    /**
     * Mailer constructor.
     */
    public function __construct($host,$username,$port,$password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
        $this->host=$host;
    }

    public function send($body,$sendEmail)
    {
        try{
            $mail = new \PHPMailer();
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = 'tsl';
            $mail->Port = 25;
            $mail->setFrom($this->username, 'UnoBuy Administration');
            $mail->addAddress($sendEmail, 'UnoBuy Administration');
            $mail->isHTML(true);
            $mail->CharSet = "utf8";
            $mail->Subject = 'UnoBuy Administration';
            $mail->Body = $body;
            $mail->send();
            echo "Message  sent.";
        }catch (\Exception $exception) {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
            exit;
        }
    }
}

