<?php

/** 
 * @author jim
 * 
 */
class turn
{
    // TODO - Insert your code here
    public $id;
    public $idhash;
    public $game;
    public $turn;
    public $status;
    public $time;
    public $player;
    public $receiver;
    public $invitation;
    public $data;
    //static $conn = dbconn::getInstance;
    /**
     */
    function __construct($idhash)
    {
        //echo "1.61";
        $this->idhash = $idhash;
        $conn = dbconn::getInstance();
        //echo "1.62";
        $sql = "select id, game, turn, status, time, player, receiver, invitation from turns where idhash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($idhash));
        //echo "1.63";
        $stmt->bindColumn(1, $this->id);
        $stmt->bindColumn(2, $this->game);
        $stmt->bindColumn(3, $this->turn);
        $stmt->bindColumn(4, $this->status);
        $stmt->bindColumn(5, $this->time);
        $stmt->bindColumn(6, $this->player);
        $stmt->bindColumn(7, $this->receiver);
        $stmt->bindColumn(8, $this->invitation);
        $stmt->fetch(PDO::FETCH_BOUND);
        //echo "1.64";
        if ($this->turn % 2 == 1) {
            //echo "p";
            $sql = "select phrase from phrases where id = ?";
        } else {
            //echo "file";
            $sql = "select data from files where id = ?";
        }
        $stmt = $conn->prepare($sql);
        
        //echo $this->id;
        $stmt->execute(array($this->id));
        $stmt->bindColumn(1, $this->data);
        $stmt->fetch(PDO::FETCH_BOUND);
        //echo $this->data;
        // TODO - Insert your code here
    }
    
    public static function new_turn($game, $player, $nextplayer, $invitation, $data) 
    {
        $conn = dbconn::getInstance();
        $turn = 0;
        $id = 0;
        $idhash = 0;
        
        echo $game . "|";
        echo $player. "|";
        echo $nextplayer ."|";
        echo $invitation . "|";
        echo $data;
        
        $sql = "select count(turn) + 1 as nextturn from turns where game = " . $game;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $turn);
        $stmt->fetch(PDO::FETCH_BOUND);
        
        $sql = "insert into turns (id,idhash,game, turn, status, time, player, receiver, invitation) (select max(id) +1, md5(max(id) + 1)," . $game . ", " . $turn .", 0, now(), " . $player . "," . $nextplayer . "," . $invitation . " from turns)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $sql = "select id, idhash from turns order by id desc limit 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $id);
        $stmt->bindColumn(2, $idhash);
        $stmt->fetch(PDO::FETCH_BOUND);
        if ($turn % 2 == 1) {
            self::add_phrase($id, $data);
        } else {
            self::add_image($id, $data);
        }
        return $idhash;
    }
    
    public function get_data()
    {
        if ($this->turn % 2 == 1) {
            return $this->data;
        } else {
            return "data:image/png;base64," . base64_encode($this->data);
        }
    }
    
    public static function get_all_turns($game)
    {
        //$turns[] = array();
        $conn = dbconn::getInstance();
        $sql = "select idhash from turns where game = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($game));
        while ($row = $stmt->fetch()) {
            $turns[$row['idhash']] = new turn($row['idhash']);
        }
        return $turns;
    }
    
    public static function set_status($game, $hash, $status)
    {
        $conn = dbconn::getInstance();
        $sql = "update turns set status = ? where idhash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($status, $hash));
    }
    
    public static function get_status($game, $hash)
    {
        $conn = dbconn::getInstance();
        $sql = "select status from turns where idhash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($hash));
        $stmt->bindColumn(1, $status);
        return $status;
    }
    
   public static function get_game($hash)
   {
       $conn = dbconn::getInstance();
       $sql = "select game from turns where idhash = ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute(array($hash));
       $stmt->bindColumn(1, $game);
       $stmt->fetch(PDO::FETCH_BOUND);
       return $game;
   }
    
    private static function add_phrase($id, $phrase)
    {
        $conn = dbconn::getInstance();
        $sql = "insert into phrases (id, phrase) values (:id, :phrase)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':phrase',$phrase);
        $stmt->execute();
    }
    
    private static function add_image($id, $data)
    {
        $binary = str_replace("data:image/octet-stream;base64,", "", $data);
        $binary = base64_decode($binary);
        $blobObj = new BlobDemo();
        $blobObj->insertBlob($id,$binary,"image/png");
    }
    
    public static function get_user_games($user)
    {
        $conn = dbconn::getInstance();
        $sql = "select distinct game from turns where player = ? or receiver = ? order by game";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($user, $user));
        while ($row = $stmt->fetch()) {
            $games[] = $row['game'];
        }
        return $games;
    }
}
