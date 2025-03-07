<?php
namespace App\Models;

use App\Database\DB;
use PDO;

class User
{
    public $id;
    public $fullName;
    public $email;
    public $password;
    public $phoneNumber;
    public $points;
    public $avatar; // New avatar property

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id         = $data['id'] ?? null;
        $this->fullName   = $data['fullName'] ?? '';
        $this->email      = $data['email'] ?? '';
        $this->password   = $data['password'] ?? '';
        $this->phoneNumber= $data['phoneNumber'] ?? '';
        $this->points     = $data['points'] ?? 0;
        $this->avatar     = $data['avatar'] ?? 'default-avatar.png'; // Default avatar
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM Users ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            error_log("No users found in database.");
        }
        return array_map(fn($row) => new self($row), $results);
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM Users WHERE id = ?");
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
        $query = "SELECT * FROM Users WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach ($conditions as $column => $value) {
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            error_log("No users found for conditions: " . print_r($conditions, true));
        }
        return array_map(fn($row) => new self($row), $results);
    }

    public function save()
    {
        $conn = DB::getConnection();
        if ($this->id) {
            $stmt = $conn->prepare("UPDATE Users SET fullName = ?, email = ?, password = ?, phoneNumber = ?, points = ?, avatar = ? WHERE id = ?");
            return $stmt->execute([
                $this->fullName,
                $this->email,
                $this->password,
                $this->phoneNumber,
                $this->points,
                $this->avatar,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO Users (fullName, email, password, phoneNumber, points, avatar) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->fullName,
                $this->email,
                $this->password,
                $this->phoneNumber,
                $this->points,
                $this->avatar
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
        $stmt = $conn->prepare("DELETE FROM Users WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }

    // Relationship Methods
    public function getReports()
    {
        return Report::where(['userId' => $this->id]);
    }

    public function getComments()
    {
        return Comment::where(['userId' => $this->id]);
    }

    public function getUserChallengeTasks()
    {
        return UserChallengeTask::where(['userId' => $this->id]);
    }

    public function getPoints()
    {
        return Point::where(['userId' => $this->id]);
    }

    public function getRequestPoints()
    {
        return RequestPoint::where(['userId' => $this->id]);
    }

    // Get full avatar URL
    public function getAvatarUrl()
    {
        return asset('assets/uploads/avatars/' . ($this->avatar ?: 'default-avatar.png'));
    }
}
