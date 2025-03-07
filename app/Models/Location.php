<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Location
{
    public $id;
    public $name;
    public $coordinates;
    public $description;
    public $status;
    public $authorityId;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id          = $data['id'] ?? null;
        $this->name        = $data['name'] ?? '';
        $this->coordinates = $data['coordinates'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->status      = $data['status'] ?? 'active';
        $this->authorityId = $data['authorityId'] ?? null;
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Locations ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No locations found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Locations WHERE id = ?");
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
        $query = "SELECT * FROM Locations WHERE ";
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
            error_log("No locations found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Locations SET name = ?, coordinates = ?, description = ?, status = ?, authorityId = ? WHERE id = ?");
            return $stmt->execute([
                $this->name,
                $this->coordinates,
                $this->description,
                $this->status,
                $this->authorityId,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Locations (name, coordinates, description, status, authorityId) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->name,
                $this->coordinates,
                $this->description,
                $this->status,
                $this->authorityId
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
        $stmt = $conn->prepare("DELETE FROM Locations WHERE id = ?");
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
    
    // Relationships
    public function getAuthority()
    {
        return Authority::find($this->authorityId);
    }
    
    public function getReports()
    {
        return Report::where(['locationId' => $this->id]);
    }
    
    public function getStatistics()
    {
        return Statistic::where(['locationId' => $this->id]);
    }
}
