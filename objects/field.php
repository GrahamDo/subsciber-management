<?php
class Field
{
    private $conn;
    
    public $id;
    public $subscriber_id;
    public $title;
    public $type;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
}
