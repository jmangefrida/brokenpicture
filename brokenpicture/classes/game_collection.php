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
    protected $games = array();
    
    function __construct($arg)
    {
        $conn = dbconn::getInstance();
        $sql = "select id from turns where datediff(now(), time) > 3 AND status = 0 order by id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while (($row = $stmt->fetch()) !== false) {
            $this->games[] = new game($row['id']);
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
    
    public function getGame($num) {
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

?>