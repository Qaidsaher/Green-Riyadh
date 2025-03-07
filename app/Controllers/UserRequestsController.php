<?php

namespace App\Controllers;

use App\Models\RequestPoint;

class UserRequestsController
{
    // List all point requests for the authenticated user
    public function index()
    {
        $user = auth()->user();
        // Assuming the User model has a method getRequests() that returns an array of RequestPoint objects
        $requests = $user->getRequestPoints();
        view('user/requests/index', ['requests' => $requests]);
    }

    // Show the form to create a new point request
    public function create()
    {
        view('user/requests/create');
    }

    // Process the submission of a new point request
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = auth()->user();
            $pointsRequested = intval($_POST['pointsRequested']);
            $message = trim($_POST['message']);

            // Process file upload if provided
            $proof = "";
            if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/';

                // Ensure upload directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type (allow only images & PDFs)
                $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
                $fileType = mime_content_type($_FILES['proof']['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = "نوع الملف غير مدعوم! يرجى رفع PNG, JPG أو PDF فقط.";
                    header("Location: " . route('user.requests.create'));
                    exit;
                }

                // Validate file size (max 2MB)
                if ($_FILES['proof']['size'] > 2 * 1024 * 1024) { // 2MB limit
                    $_SESSION['error'] = "الملف كبير جدًا! الحد الأقصى للحجم هو 2MB.";
                    header("Location: " . route('user.requests.create'));
                    exit;
                }

                // Generate a unique filename to prevent conflicts
                $fileExtension = pathinfo($_FILES['proof']['name'], PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $fileExtension;
                $targetFile = $uploadDir . $filename;

                // Move file to uploads directory
                if (move_uploaded_file($_FILES['proof']['tmp_name'], $targetFile)) {
                    $proof = 'assets/uploads/' . $filename; // Store relative path for easy retrieval
                } else {
                    $_SESSION['error'] = "فشل رفع ملف الإثبات.";
                    header("Location: " . route('user.requests.create'));
                    exit;
                }
            }

            // Prepare request data
            $data = [
                'userId' => $user->id,
                'pointsRequested' => $pointsRequested,
                'proof' => $proof,  // Save file path in DB
                'message' => $message,
                'status' => 'pending'
            ];

            // Save request
            $requestPoint = new RequestPoint($data);
            if ($requestPoint->save()) {
                $_SESSION['success'] = "تم إرسال طلب النقاط بنجاح";
            } else {
                $_SESSION['error'] = "فشل إرسال الطلب";
            }

            // Redirect to requests page
            header("Location: " . route('user.requests'));
            exit;
        }
    }
}
