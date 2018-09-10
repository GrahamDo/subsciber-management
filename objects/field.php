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
    
    public function listBySubscriberId($subscriber_id)
    {
        $query = "SELECT " .
                 "  id, " .
                 "  title, " .
                 "  type " .
                 "FROM field " .
                 "WHERE subscriber_id = " . $subscriber_id . ";";
                 
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }
    
    public function getById($id)
    {           
        $query = "SELECT " .
                 "  id, " .
                 "  subscriber_id, " .
                 "  title, " .
                 "  type " .
                 "FROM field " .
                 "WHERE id = " . $id;

        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }    
    
    public function getTypeText($type)
    {
        switch ($type) {
            case 0: return "date";
            case 1: return "number";
            case 2: return "string";
            case 3: return "boolean";
        }
    }
}
