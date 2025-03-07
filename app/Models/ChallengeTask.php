<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class ChallengeTask
{
    public $id;
    public $challengeId;
    public $taskName;
    public $taskDescription;
    public $points;
    public $status;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id             = $data['id'] ?? null;
        $this->challengeId    = $data['challengeId'] ?? null;
        $this->taskName       = $data['taskName'] ?? '';
        $this->taskDescription= $data['taskDescription'] ?? '';
        $this->points         = $data['points'] ?? 0;
        $this->status         = $data['status'] ?? 'active';
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM ChallengeTasks ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No challenge tasks found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM ChallengeTasks WHERE id = ?");
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
        $query = "SELECT * FROM ChallengeTasks WHERE ";
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
            error_log("No challenge tasks found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE ChallengeTasks SET challengeId = ?, taskName = ?, taskDescription = ?, points = ?, status = ? WHERE id = ?");
            return $stmt->execute([
                $this->challengeId,
                $this->taskName,
                $this->taskDescription,
                $this->points,
                $this->status,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO ChallengeTasks (challengeId, taskName, taskDescription, points, status) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->challengeId,
                $this->taskName,
                $this->taskDescription,
                $this->points,
                $this->status
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
        $stmt = $conn->prepare("DELETE FROM ChallengeTasks WHERE id = ?");
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
    
    // Relationship: Get associated UserChallengeTasks
    public function getUserChallengeTasks()
    {
        return UserChallengeTask::where(['challengeTaskId' => $this->id]);
    }
}
