<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class FAQ
{
    public $id;
    public $question;
    public $answer;
    public $contactInfo;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id          = $data['id'] ?? null;
        $this->question    = $data['question'] ?? '';
        $this->answer      = $data['answer'] ?? '';
        $this->contactInfo = $data['contactInfo'] ?? '';
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM FAQs ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No FAQs found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM FAQs WHERE id = ?");
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
        $query = "SELECT * FROM FAQs WHERE ";
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
            error_log("No FAQs found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE FAQs SET question = ?, answer = ?, contactInfo = ? WHERE id = ?");
            return $stmt->execute([
                $this->question,
                $this->answer,
                $this->contactInfo,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO FAQs (question, answer, contactInfo) VALUES (?, ?, ?)");
            $result = $stmt->execute([
                $this->question,
                $this->answer,
                $this->contactInfo
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
        $stmt = $conn->prepare("DELETE FROM FAQs WHERE id = ?");
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
}
