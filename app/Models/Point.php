<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Point
{
    public $id;
    public $userId;
    public $pointsEarned;
    public $dateEarned;
    public $pointSourceId;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id           = $data['id'] ?? null;
        $this->userId       = $data['userId'] ?? null;
        $this->pointsEarned = $data['pointsEarned'] ?? 0;
        $this->dateEarned   = $data['dateEarned'] ?? date('Y-m-d H:i:s');
        $this->pointSourceId= $data['pointSourceId'] ?? null;
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Points ORDER BY dateEarned DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No points found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Points WHERE id = ?");
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
        $query = "SELECT * FROM Points WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach($conditions as $column => $value){
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY dateEarned DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No points found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Points SET userId = ?, pointsEarned = ?, dateEarned = ?, pointSourceId = ? WHERE id = ?");
            return $stmt->execute([
                $this->userId,
                $this->pointsEarned,
                date('Y-m-d H:i:s'),
                $this->pointSourceId,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Points (userId, pointsEarned, dateEarned, pointSourceId) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->userId,
                $this->pointsEarned,
                date('Y-m-d H:i:s'),
                $this->pointSourceId
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
        $stmt = $conn->prepare("DELETE FROM Points WHERE id = ?");
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
    public function getUser()
    {
        return User::find($this->userId);
    }
    
    public function getPointSource()
    {
        return PointSource::find($this->pointSourceId);
    }
}
