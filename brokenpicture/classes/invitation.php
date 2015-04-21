<?php

/** 
 * @author jim
 * 
 */
class invitation
{
    // TODO - Insert your code here
    //static $conn = dbconn::getInstance;
    public $id;
    public $email;
    public $time;
    public $status;
    /**
     */
    function __construct($email)
    {
        $id = self::check_exists($email);
        if ($id > 0 ) {
            $this->load($id);
        } else {
            $this->create($email);
        }
        
        // TODO - Insert your code here
    }
    
    private function load($id)
    {
        $conn = dbconn::getInstance();
        $sql = "select id, email, time, status from invitations where id = " . $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $this->id);
        $stmt->bindColumn(2, $this->email);
        $stmt->bindColumn(3, $this->time);
        $stmt->bindColumn(4, $this->status);
        $stmt->fetch(PDO::FETCH_BOUND);
        //echo $this->email;
    }
    
    private function create($email)
    {
        $conn = dbconn::getInstance();
        $sql = "insert into invitations (email, time) values (:email, now())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        //echo "EMAIL:" . $email;
        $id = self::check_exists($email);
        $this->load($id);
    }
    
    public function send($from)
    {
        $mail = new mailer();
        //echo $this->email;
        $mail->invite($this->email, "http://brokenpicture.com/signup.php", $from);
    }
    
    public static function check_exists($email)
    {
        $conn = dbconn::getInstance();
        $id = 0;
        $count = 0;
        $sql = "select count(id) from invitations where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($email));
        $stmt->bindColumn(1, $count);
        $stmt->fetch(PDO::FETCH_BOUND);
        //echo "COUNT:" . $count;
        if ($count != 0) {
            $sql = "select id from invitations where email = ?";;
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $id = (int)$stmt->fetchColumn();
            //echo "ID:" . $email . "|" . $id;
            
            return $id;
        } else {
            return 0;  
        }
          
    }
    
    
}
