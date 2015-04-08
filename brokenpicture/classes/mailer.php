<?php

/** 
 * @author jim
 * 
 */
class mailer
{
    private $mail;
    private $msg;
    
    /**
     */
    function __construct()
    {
        require '/var/www/brokenpicture.com/mail/PHPMailerAutoload.php';
        $this->mail = new PHPMailer();
        $this->mail->isSendmail();
        $this->mail->setFrom('gamemaster@brokenpicture.com', 'Game Master');
        $this->mail->addReplyTo('gamemaster@brokenpicture.com', 'Game Master');
        
    }
    
    function send($to, $message, $from){
        $this->mail->Subject = 'Your Turn';
        $this->msg = file_get_contents('/var/www/brokenpicture.com/mail/contents.html');
        $this->mail->addAddress($to);
        $this->msg = str_replace('#LINK#', 'http://brokenpicture.com/play.php?id=' . $message, $this->msg);
        $this->msg = str_replace('#FROM#', $from, $this->msg);
        $this->mail->msgHTML($this->msg);
        $this->mail->AltBody = $message;
        
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
    
    function invite($to, $message, $from) {
        
        $this->mail->Subject = $from . "has sent you an invitation to a game.";
        $this->mail->addAddress($to);
        $this->msg = file_get_contents('/var/www/brokenpicture.com/mail/invite.html');
        $this->msg = str_replace('#LINK#', $message, $this->msg);
        $this->msg = str_replace('#FROM#', $from, $this->msg);
        $this->mail->msgHTML($this->msg);
        $this->mail->AltBody = $message;
        
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Invitation sent!";
        }
    }
    
    function finish($to, $message) {
    
        $this->mail->Subject = "A game you were playing has finished!";
        $this->mail->addAddress($to);
        $this->msg = file_get_contents('/var/www/brokenpicture.com/mail/finish.html');
        $this->msg = str_replace('#LINK#', 'http://brokenpicture.com/play.php?id=' . $message, $this->msg);
        //$this->msg = str_replace('#FROM#', $from, $this->msg);
        $this->mail->msgHTML($this->msg);
        $this->mail->AltBody = $message;
    
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Invitation sent!";
        }
        $this->mail->clearAddresses();
    }
}

?>