<?php

/** 
 * @author jim
 * 
 */
class game implements Iterator
{
    // TODO - Insert your code here
    public $id;
    public $idhash;
    public $status;
    public $turn = array();
    //static $conn = dbconn::getInstance;
    /**
     */
    function __construct($id)
    {
        //echo $id . "|";
        $conn = dbconn::getInstance();
        $sql = "select id, idhash, status from games where id = " . $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $this->id);
        $stmt->bindColumn(2, $this->idhash);
        $stmt->bindColumn(3, $this->status);
        $stmt->fetch(PDO::FETCH_BOUND);
        //echo $this->id . "|";
        // TODO - Insert your code here
    }
    
    public static function new_game() {
        $id = self::create_game();
        $game = new game($id);
        
        return $game;
    }
    
    public function set_status($status) {
        $this->status = $status;
        $conn = dbconn::getInstance();
        $sql = "update games set status = ? where id = " . $this->id;
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($status));
    }
    
    
    public function new_turn($player, $nextplayer, $invitation, $data) {
        echo 'newturn';
        echo $this->id . '|';
        echo $player . '|';
        echo $nextplayer . '|';
        echo $invitation . '|';
        echo $data . '|';
        
        //print_r(get_declared_classes());
        $turn = turn::new_turn($this->id, $player, $nextplayer, $invitation, $data);
        return $turn;
    }
    
    public function load_turn($idhash) {
        $this->turn[$idhash] = new turn($idhash);
    }
    
    public function load_all_turns() {
        $this->turn = turn::get_all_turns($this->id);
        //usort($this->turn, array('/var/www/brokenpicture.com/classes/game.php','sort_turns'));
        //echo var_dump($this->turn);
    }
    
    public function count_turns() {
        $conn = dbconn::getInstance();
        $sql = "select count(id) from turns where game = " . $this->id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $count);
        $stmt->fetch(PDO::FETCH_BOUND);
        return $count;
        
    }
    
    public static function sort_turns($a, $b) {
        if($a->turn > $b->turn) {
            return $a;
        } else {
            return $b;
        }
    }
    
    public function get_turn_hashes() {
        foreach ($this->turn as $turn) {
            $turns[$turn->turn] = $turn->idhash;
        }
        ksort($turns);
        return $turns;
        //return (array_keys($this->turn));
    }
    
    public function get_turn_status($hash) {
        $status = turn::get_status($this->id, $hash);
        return $status;
    }
    
    public function set_turn_status($hash, $status) {
        turn::set_status($this->id, $hash, $status);
    }
    
    public function waiting($user) {
        //$this->load_all_turns();
        foreach ($this->turn as $turn) {
            if ($turn->status == 0 && $turn->receiver == $user) {
                return true;
            }
        }
        return false;
    }
    
    public function get_last_turn() {
        foreach ($this->turn as $turn) {
            if ($turn->status == 0 || $turn->status == 2) {
                return $turn->idhash;
            }
        }
        return false;
    }
    
    public function get_first_turn() {
        foreach ($this->turn as $turn) {
            if ($turn->turn == 1) {
                return $turn->idhash;
            }
        }
    }
    
    public function get_all_users() {
        //$player[] = array();
        foreach ($this->turn as $turn) {
            $player[$turn->player] = $turn->player;
            $player[$turn->receiver] = $turn->receiver;
        }
        return $player;
    }
    
    private static function create_game() {
        $conn = dbconn::getInstance();
        $conn->beginTransaction();
        $sql = "insert into games (id, idhash,status) (select max(id) + 1, md5(max(id) + 1), 0 from games)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $sql = "select id from games order by id desc limit 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn(1, $gameid);
        $stmt->fetch(PDO::FETCH_BOUND);
        $conn->commit();
        return $gameid;
    }
    
    public static function get_user_games($user) {
        $game_list = turn::get_user_games($user);
        foreach ($game_list as $game) {
            $games[] = new game($game);
        }
        rsort($games);
        return $games;
    }
    
    public function rewind()
    {
        //echo "rewinding\n";
        reset($this->turn);
    }
    
    public function current()
    {
        $var = current($this->turn);
        //echo "current: $var\n";
        return $var;
    }
    
    public function key()
    {
        $var = key($this->turn);
        //echo "key: $var\n";
        return $var;
    }
    
    public function next()
    {
        $var = next($this->turn);
        //echo "next: $var\n";
        return $var;
    }
    
    public function valid()
    {
        $key = key($this->turn);
        $var = ($key !== NULL && $key !== FALSE);
        //echo "valid: $var\n";
        return $var;
    }
    
    
    
}

?>