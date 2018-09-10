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
    
    public function deleteById($id)
    {
        $query = "DELETE FROM field " .
                 "WHERE id = " . $id;

        $statement = $this->conn->prepare($query);
        $statement->execute();        
    }

    public function create()
    {
        return $this->createOrUpdate(true);
    } 

    public function update()
    {
        return $this->createOrUpdate(false, $this->id);
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
    
    private function createOrUpdate($isForCreate, $idToUpdate)
    {
        $command = "";
        if ($isForCreate) {
            $command = "INSERT INTO";
        } else {
            $command = "UPDATE";
        }
        $query = $command . " field " .
                 "SET " .
                 "  subscriber_id = :subscriber_id, " .
                 "  title = :title, " .
                 "  type = :type";
        if ($isForCreate) {
            $query = $query . ";";
        } else {
            $query = $query . "    WHERE id = " . $idToUpdate . ";";
        }
        $statement = $this->conn->prepare($query);
        
        //Sanitise title
        $this->title = 
            htmlspecialchars(strip_tags($this->title));
        
        $statement->bindParam(":subscriber_id", $this->subscriber_id);
        $statement->bindParam(":title", $this->title);
        $statement->bindParam(":type", $this->type);
        
        return $statement->execute();
    }        
}
