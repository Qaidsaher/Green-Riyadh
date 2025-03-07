<?php

namespace App\Models;

use App\Database\DB;
use PDO;

class RequestPoint
{
    public $id;
    public $userId;
    public $pointsRequested;
    public $proof;
    public $status;
    public $message;      // ✅ Added message field
    public $requestDate;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id              = $data['id'] ?? null;
        $this->userId          = $data['userId'] ?? null;
        $this->pointsRequested = $data['pointsRequested'] ?? 0;
        $this->proof           = $data['proof'] ?? '';
        $this->status          = $data['status'] ?? 'pending';
        $this->message         = $data['message'] ?? '';  // ✅ Initialize message
        $this->requestDate     = $data['requestDate'] ?? date('Y-m-d H:i:s');
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM RequestPoints ORDER BY requestDate DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            error_log("No request points found.");
        }
        return array_map(fn($row) => new self($row), $results);
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM RequestPoints WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) {
            return [];
        }
        $query = "SELECT * FROM RequestPoints WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach ($conditions as $column => $value) {
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY requestDate DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            error_log("No request points found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }

    public function save()
    {
        $conn = DB::getConnection();
        if ($this->id) {
            $stmt = $conn->prepare("
                UPDATE RequestPoints 
                SET userId = ?, pointsRequested = ?, proof = ?, status = ?, message = ?, requestDate = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $this->userId,
                $this->pointsRequested,
                $this->proof,
                $this->status,
                $this->message,  // ✅ Save message
                date('Y-m-d H:i:s'),
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("
                INSERT INTO RequestPoints (userId, pointsRequested, proof, status, message, requestDate) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([
                $this->userId,
                $this->pointsRequested,
                $this->proof,
                $this->status,
                $this->message,  // ✅ Save message
                date('Y-m-d H:i:s')
            ]);
            if ($result) {
                $this->id = $conn->lastInsertId();
            }
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) {
            return false;
        }
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM RequestPoints WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Relationship
    public function getUser()
    {
        return User::find($this->userId);
    }
}
