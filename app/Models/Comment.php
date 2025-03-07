<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Comment
{
    public $id;
    public $reportId;
    public $userId;
    public $commentText;
    public $commentDate;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id          = $data['id'] ?? null;
        $this->reportId    = $data['reportId'] ?? null;
        $this->userId      = $data['userId'] ?? null;
        $this->commentText = $data['commentText'] ?? '';
        $this->commentDate = $data['commentDate'] ?? date('Y-m-d H:i:s');
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Comments ORDER BY commentDate DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No comments found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Comments WHERE id = ?");
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
        $query = "SELECT * FROM Comments WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach($conditions as $column => $value){
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY commentDate DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No comments found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Comments SET reportId = ?, userId = ?, commentText = ?, commentDate = ? WHERE id = ?");
            return $stmt->execute([
                $this->reportId,
                $this->userId,
                $this->commentText,
                date('Y-m-d H:i:s'),
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Comments (reportId, userId, commentText, commentDate) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->reportId,
                $this->userId,
                $this->commentText,
                date('Y-m-d H:i:s')
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
        $stmt = $conn->prepare("DELETE FROM Comments WHERE id = ?");
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
    public function getReport()
    {
        return Report::find($this->reportId);
    }
    
    public function getUser()
    {
        return User::find($this->userId);
    }
}
