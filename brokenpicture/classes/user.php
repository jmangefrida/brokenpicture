<?php

/** 
 * @author jim
 * 
 */
class user
{
    // TODO - Insert your code here
    private $id;
    private $email;
    private $contact_type;
    private $contact;
    private $password;
    protected $username;
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

 /**
     * @return the $contact_type
     */
    public function getContact_type()
    {
        return $this->contact_type;
    }

 /**
     * @return the $contact
     */
    public function getContact()
    {
        return $this->contact;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }

 /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

 /**
     * @param field_type $contact_type
     */
    public function setContact_type($contact_type)
    {
        $this->contact_type = $contact_type;
    }

 /**
     * @param field_type $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

 /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

 /**
     */
    function __construct($id)
    {
        $conn = dbconn::getInstance();
        $sql = "select id, email, contact_type, contact, username from users where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));
        $stmt->bindColumn(1, $this->id);
        $stmt->bindColumn(2, $this->email);
        $stmt->bindColumn(3, $this->contact_type);
        $stmt->bindColumn(4, $this->contact);
        $stmt->bindColumn(5, $this->username);
        $stmt->fetch(PDO::FETCH_BOUND);
        // TODO - Insert your code here
    }
    
    public function add_friend($friend)
    {
        $conn = dbconn::getInstance();
        $entry = array($this->id,$friend);
        sort($entry);
        $sql = "insert into friends values (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($entry);
        
    }
    
    public function get_friends()
    {
        $conn = dbconn::getInstance();
        $sql = "select users.email as email from friends join users on friends.a = users.id where friends.b = ? UNION ";
        $sql .= "select users.email as email from friends join users on friends.b = users.id where friends.a = ?";
        //echo $sql;
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($this->id, $this->id));
        while (($row = $stmt->fetch()) != false) {
        //    echo $row['email'];
            $friends[] = $row['email'];
        }
        return $friends;
    }
    
    public static function exists($email)
    {
        $conn = dbconn::getInstance();
        $sql = "select count(id) from users where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($email));
        $count = $stmt->fetchColumn();
//         $stmt->bindColumn(1, $count);
//         $stmt->fetch(PDO::FETCH_BOUND);
        if ($count == 1) {
            $sql = "select id from users where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            return (int)$stmt->fetchColumn();
        } else {
            return 0;
        }
        
    }

    
    public static function create_user($email, $contact_type, $contact, $password)
    {
        try {
            $conn = dbconn::getInstance();
            $hash = password_hash($password, PASSWORD_BCRYPT);
            //$conn->beginTransaction();
            $sql = "select count(id) from users where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $stmt->bindColumn(1, $count);
            $stmt->fetch(PDO::FETCH_BOUND);
            if ($count == 0) {
                $sql = "insert into users (email, contact_type, contact, password, signup_date) values(?, ?, ?, ?, now())";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array($email, $contact_type, $contact, $hash));
                //echo var_dump(array($email, $contact_type, $contact, $hash));
                //echo var_dump($stmt->errorCode());
                //echo $stmt->errorInfo();
                
                //$user = new user(user::exists($email));
                $user = user::login_user($email, $password);
                return $user;
            }else {
                return false;
            }
        } catch (PDOException $e) {
            return "Internal Error.";
        }
        
        
    }
    
    public static function login_user($email, $password)
    {
        $id = user::verify_password($email, $password);
        if ($id > 0) {
            user::update_session($id);
            $user = new user($id); 
            return $user;
        } else {
            return false;
        }
        
        
    }
    
    private static function update_session($id)
    {
        $value = str_shuffle(sha1(microtime()));
        setcookie("user",$value,time() + (86400 * 30), "/");
        $conn = dbconn::getInstance();
        $sql = 'delete from user_sessions where user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));
        $sql = 'insert into user_sessions (user_id, session, expires) values (?, ?, date_add(now(), interval 30 day))';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id,$value));
    }
    
    public static function check_login()
    {
        if(isset($_COOKIE['user'])) {
            $conn = dbconn::getInstance();
            $sql = "select user_id, expires from user_sessions where session = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($_COOKIE['user']));
            $stmt->bindColumn(1, $id);
            $stmt->fetch(PDO::FETCH_BOUND);
            if ($id > 0) {
                $user = new user($id);
                return $user;
            }else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public static function verify_password($email, $password)
    {
        $conn = dbconn::getInstance();
        $sql = "select password from users where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($email));
        $stmt->bindColumn(1, $hash);
        $stmt->fetch(PDO::FETCH_BOUND);
    
        if (password_verify($password, $hash)) {
            $sql = "select id from users where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $stmt->bindColumn(1, $id);
            $stmt->fetch(PDO::FETCH_BOUND);
            return $id;
        }
        else {
            return 0;
        }
    }
    
    public static function user_logout()
    {
        unset($_COOKIE['user']);
        setcookie("user",null,-1,"/");
    }
    
    public static function lookup_email($id)
    {
        $conn = dbconn::getInstance();
        $sql = "select email from users where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));
        $stmt->bindColumn(1, $email);
        $stmt->fetch(PDO::FETCH_BOUND);
        return $email;
    }
}
