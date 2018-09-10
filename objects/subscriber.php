<?php
class Subscriber
{
    private $conn;
    
    public $id;
    public $email_address;
    public $name;
    public $state;
    public $state_text;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function list()
    {
        $query = "SELECT " .
                 "  id, " .
                 "  email_address, " .
                 "  name, " .
                 "  state " .
                 "FROM subscriber;";
                 
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }
    
    public function getStateText($state)
    {
        switch ($state) {
            case 0: return "active";
            case 1: return "unsubscribed";
            case 2: return "junk";
            case 3: return "bounced";
        }
    }    
}
