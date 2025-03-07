<?php

namespace App\Controllers;

use App\Models\Report;
use App\Models\Comment;

class UserReportsController
{
    // List all reports submitted by the authenticated user
    public function index()
    {

        $reports = Report::all();
        view('user/reports/index', ['reports' => $reports]);
    }
    public function myreport()
    {
        $user = auth()->user();
        // Assuming the User model has a method getReports() returning user's reports.
        $reports = $user->getReports();
        view('user/reports/myreport', data: ['reports' => $reports]);
    }

    // Show form to create a new report
    public function create()
    {
        view('user/reports/create');
    }

    // Process new report submission
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = auth()->user();

            // Validate input fields
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $locationId = isset($_POST['locationId']) ? intval($_POST['locationId']) : null;
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $multipleChoiceSelection = isset($_POST['multipleChoiceSelection']) ? intval($_POST['multipleChoiceSelection']) : 0;
            $imagePath = '';

            // 🔥 Handle Image Upload Securely
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/reports/'; // Save in assets/uploads/reports

                // Ensure the directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generate a unique filename
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $filename = 'report_' . $user->id . '_' . time() . '.' . $fileExtension;
                $targetFile = $uploadDir . $filename;

                // Allowed file types
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileExtension, $allowedTypes)) {
                    $_SESSION['error'] = "نوع الملف غير مدعوم. يجب أن تكون الصورة بصيغة JPG, PNG, أو GIF.";
                    header("Location: " . route('user.reports.create'));
                    exit;
                }

                // Check file size (2MB max)
                if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error'] = "حجم الملف كبير جدًا. الحد الأقصى 2MB.";
                    header("Location: " . route('user.reports.create'));
                    exit;
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Delete old image if it exists
                    if (!empty($user->avatar) && $user->avatar !== 'default-avatar.png') {
                        $oldImagePath = $uploadDir . $user->avatar;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    // Save the new image path
                    $imagePath =  $filename;
                } else {
                    $_SESSION['error'] = "فشل رفع الصورة. حاول مرة أخرى.";
                    header("Location: " . route('user.reports.create'));
                    exit;
                }
            }

            // 🔥 Data to save
            $data = [
                'userId'    => $user->id,
                'title'     => $title,
                'locationId' => $locationId,
                'description' => $description,
                'image'       => $imagePath, // Save image path in database
                'status'      => 'pending',
                'multipleChoiceSelection' => $multipleChoiceSelection,
            ];

            $report = new Report($data);
            if ($report->save()) {
                $_SESSION['success'] = "تم إرسال البلاغ بنجاح";
            } else {
                $_SESSION['error'] = "فشل إرسال البلاغ";
            }

            header("Location: " . route('user.reports'));
            exit;
        }
    }




    // Show detailed report with its comments
    public function show()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $report = Report::find($id);
        if (!$report) {
            $_SESSION['error'] = "البلاغ غير موجود";
            header("Location: " . route('user.reports'));
            exit;
        }
        // Assume $report->getComments() returns an array of Comment objects
        view('user/reports/detail', ['report' => $report]);
    }

    // Process adding a new comment to a report
    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reportId = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $user = auth()->user();
            $commentText = trim($_POST['commentText']);
            if (!$reportId || empty($commentText)) {
                $_SESSION['error'] = "يجب إدخال نص التعليق";
                header("Location: " . route('user.reports.show', ['id' => $reportId]));
                exit;
            }
            $comment = new Comment([
                'reportId'    => $reportId,
                'userId'      => $user->id,
                'commentText' => $commentText
            ]);
            if ($comment->save()) {
                $_SESSION['success'] = "تم إضافة التعليق بنجاح";
            } else {
                $_SESSION['error'] = "فشل إضافة التعليق";
            }
            header("Location: " . route('user.reports.show', ['id' => $reportId]));
            exit;
        }
    }

    // Process deletion of a comment (only if the comment belongs to the user)
    public function deleteComment()
    {
        $commentId = isset($_GET['commentId']) ? intval($_GET['commentId']) : 0;
        $user = auth()->user();
        $comment = Comment::find($commentId);
        if (!$comment || $comment->userId !== $user->id) {
            $_SESSION['error'] = "لا يمكنك حذف هذا التعليق";
        } else {
            if ($comment->delete()) {
                $_SESSION['success'] = "تم حذف التعليق بنجاح";
            } else {
                $_SESSION['error'] = "فشل حذف التعليق";
            }
        }
        $reportId = $_GET['id'] ?? 0;
        header("Location: " . route('user.reports.show', ['id' => $reportId]));
        exit;
    }
}
