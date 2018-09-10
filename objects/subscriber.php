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
    
    public function getById($id)
    {           
        $query = "SELECT " .
                 "  id, " .
                 "  email_address, " .
                 "  name, " .
                 "  state " .
                 "FROM subscriber " .
                 "WHERE id = " . $id;

        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }
    
    public function deleteById($id)
    {
        $query = "DELETE FROM subscriber " .
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
    
    public function getStateText($state)
    {
        switch ($state) {
            case 0: return "unconfirmed";
            case 1: return "active";
            case 2: return "unsubscribed";
            case 3: return "junk";
            case 4: return "bounced";
        }
    } 

    public function doesEmailDomainExist($email_address)
    {
        list($user, $domain) = explode("@", $email_address);
        return checkdnsrr($domain, "MX");
    }
    
    private function createOrUpdate($isForCreate, $idToUpdate)
    {
        $command = "";
        if ($isForCreate) {
            $command = "INSERT INTO";
        } else {
            $command = "UPDATE";
        }
        $query = $command . " subscriber " .
                 "SET " .
                 "  email_address = :email_address, ";
        if ($this->name != null) {
           $query = $query . "  name = :name, ";
        }
        $query = $query . "  state = :state";
        if ($isForCreate) {
            $query = $query . ";";
        } else {
            $query = $query . "    WHERE id = " . $idToUpdate . ";";
        }
        $statement = $this->conn->prepare($query);
        
        //Sanitise name and email_address
        $this->email_address = 
            htmlspecialchars(strip_tags($this->email_address));
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        $statement->bindParam(":email_address", $this->email_address);
        if ($this->name != null) {
            $statement->bindParam(":name", $this->name);
        }
        $statement->bindParam(":state", $this->state);
        
        return $statement->execute();
    }
}
