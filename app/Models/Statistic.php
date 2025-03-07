<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Statistic
{
    public $id;
    public $locationId;
    public $treesPlanted;
    public $reportsSubmitted;
    public $pointsEarned;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id              = $data['id'] ?? null;
        $this->locationId      = $data['locationId'] ?? null;
        $this->treesPlanted    = $data['treesPlanted'] ?? 0;
        $this->reportsSubmitted= $data['reportsSubmitted'] ?? 0;
        $this->pointsEarned    = $data['pointsEarned'] ?? 0;
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Statistics ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No statistics found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Statistics WHERE id = ?");
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
        $query = "SELECT * FROM Statistics WHERE ";
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
            error_log("No statistics found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Statistics SET locationId = ?, treesPlanted = ?, reportsSubmitted = ?, pointsEarned = ? WHERE id = ?");
            return $stmt->execute([
                $this->locationId,
                $this->treesPlanted,
                $this->reportsSubmitted,
                $this->pointsEarned,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Statistics (locationId, treesPlanted, reportsSubmitted, pointsEarned) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->locationId,
                $this->treesPlanted,
                $this->reportsSubmitted,
                $this->pointsEarned
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
        $stmt = $conn->prepare("DELETE FROM Statistics WHERE id = ?");
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
    
    // Relationship
    public function getLocation()
    {
        return Location::find($this->locationId);
    }
}
