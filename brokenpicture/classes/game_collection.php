<?php

/** 
 * @author jim
 * 
 */
class game_collection implements \Iterator
{

    /**
     */
    public $total = 0;
    protected $mapper;
    protected $pointer = 0;
    public $games = array();
    
    function __construct($arg)
    {
        $conn = dbconn::getInstance();
        $sql = "select game from turns where datediff(now(), time) > 3 AND status = 0 order by game";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while (($row = $stmt->fetch()) !== false) {
            $this->games[$this->total] = new game($row['game']);
            //echo $row['game'] . '<br>';
            //echo array_count_values($this->games);
            //echo $this->games[$this->total]->id;
            //echo '<br>';
            $this->total = $this->total + 1;
        }
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see Iterator::valid()
     *
     */
    
    public function getGame($num)
    {
        return $this->games[$num];
    }
    
    public function valid()
    {
        return ( ! is_null($this->current()));
    }

    /**
     * (non-PHPdoc)
     *
     * @see Iterator::next()
     *
     */
    public function next()
    {
        $game = $this->getGame($this->pointer);
        if ($game) {$this->pointer++;}
        return $game;
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see Iterator::current()
     *
     */
    public function current()
    {
        return $this->games[$this->pointer];
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see Iterator::rewind()
     *
     */
    public function rewind()
    {
        $this->pointer = 0;
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see Iterator::key()
     *
     */
    public function key()
    {
        return $this->pointer;
        // TODO - Insert your code here
    }
}
