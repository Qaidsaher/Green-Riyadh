<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class Report
{
    public $id;
    public $userId;
    public $locationId;
    public $title;  // ✅ Added title field
    public $description;
    public $image;
    public $status;
    public $submit;
    public $multipleChoiceSelection;
    
    protected static $pdo;
    
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    public function __construct(array $data = [])
    {
        $this->id                     = $data['id'] ?? null;
        $this->userId                 = $data['userId'] ?? null;
        $this->locationId             = $data['locationId'] ?? null;
        $this->title                  = $data['title'] ?? '';  // ✅ Initialize title
        $this->description            = $data['description'] ?? '';
        $this->image                  = $data['image'] ?? '';
        $this->status                 = $data['status'] ?? 'pending';
        $this->submit                 = $data['submit'] ?? date('Y-m-d H:i:s');
        $this->multipleChoiceSelection= $data['multipleChoiceSelection'] ?? null;
    }
    
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Reports ORDER BY submit DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($results)){
            error_log("No reports found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Reports WHERE id = ?");
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
        $query = "SELECT * FROM Reports WHERE ";
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
            error_log("No reports found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }
    
    public function save()
    {
        $conn = DB::getConnection();
        if($this->id){
            $stmt = $conn->prepare("UPDATE Reports SET userId = ?, locationId = ?, title = ?, description = ?, image = ?, status = ?, submit = ?, multipleChoiceSelection = ? WHERE id = ?");
            return $stmt->execute([
                $this->userId,
                $this->locationId,
                $this->title,  // ✅ Added title
                $this->description,
                $this->image,
                $this->status,
                date('Y-m-d H:i:s'),
                $this->multipleChoiceSelection,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Reports (userId, locationId, title, description, image, status, submit, multipleChoiceSelection) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->userId,
                $this->locationId,
                $this->title,  // ✅ Added title
                $this->description,
                $this->image,
                $this->status,
                date('Y-m-d H:i:s'),
                $this->multipleChoiceSelection
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
        $stmt = $conn->prepare("DELETE FROM Reports WHERE id = ?");
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
    
    public function getLocation()
    {
        return Location::find($this->locationId);
    }
    
    public function getComments()
    {
        return Comment::where(['reportId' => $this->id]);
    }
}
