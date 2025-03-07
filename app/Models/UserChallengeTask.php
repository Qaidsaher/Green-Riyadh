<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class UserChallengeTask
{
    public $id;
    public $challengeTaskId;
    public $userId;
    public $status;
    public $submit;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id              = $data['id'] ?? null;
        $this->challengeTaskId = $data['challengeTaskId'] ?? null;
        $this->userId          = $data['userId'] ?? null;
        $this->status          = $data['status'] ?? 'pending';
        $this->submit          = $data['submit'] ?? date('Y-m-d H:i:s');
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM UserChallengeTasks ORDER BY submit DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No user challenge tasks found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM UserChallengeTasks WHERE id = ?");
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
        $query = "SELECT * FROM UserChallengeTasks WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach($conditions as $column => $value){
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY submit DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No user challenge tasks found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE UserChallengeTasks SET challengeTaskId = ?, userId = ?, status = ?, submit = ? WHERE id = ?");
            return $stmt->execute([
                $this->challengeTaskId,
                $this->userId,
                $this->status,
                date('Y-m-d H:i:s'),
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO UserChallengeTasks (challengeTaskId, userId, status, submit) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->challengeTaskId,
                $this->userId,
                $this->status,
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
        $stmt = $conn->prepare("DELETE FROM UserChallengeTasks WHERE id = ?");
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
    public function getChallengeTask()
    {
        return ChallengeTask::find($this->challengeTaskId);
    }
    
    public function getUser()
    {
        return User::find($this->userId);
    }
}
