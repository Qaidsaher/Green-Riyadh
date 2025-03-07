<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Authority
{
    public $id;
    public $name;
    public $contactEmail;
    public $contactPhone;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id           = $data['id'] ?? null;
        $this->name         = $data['name'] ?? '';
        $this->contactEmail = $data['contactEmail'] ?? '';
        $this->contactPhone = $data['contactPhone'] ?? '';
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Authorities ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No authorities found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Authorities WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }
    
    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if(empty($conditions)){
            return [];
        }
        $query = "SELECT * FROM Authorities WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach($conditions as $column => $value){
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No authorities found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Authorities SET name = ?, contactEmail = ?, contactPhone = ? WHERE id = ?");
            return $stmt->execute([
                $this->name,
                $this->contactEmail,
                $this->contactPhone,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Authorities (name, contactEmail, contactPhone) VALUES (?, ?, ?)");
            $result = $stmt->execute([
                $this->name,
                $this->contactEmail,
                $this->contactPhone
            ]);
            if($result){
                $this->id = $conn->lastInsertId();
            }
            return $result;
        }
    }
    
    public function delete()
    {
        if(!$this->id){
            return false;
        }
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM Authorities WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
    
    public function fill(array $data)
    {
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }
    
    // Relationship: Authority has many Locations.
    public function getLocations()
    {
        return Location::where(['authorityId' => $this->id]);
    }
}
