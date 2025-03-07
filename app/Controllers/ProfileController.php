<?php

namespace App\Controllers;

use App\Models\User;

class ProfileController
{
    // Display profile page
    public function showProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . route('login'));
            exit;
        }
        view('user/profile');
    }

    // Process profile update form submission
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = auth()->user();
            $data = [
                'fullName'    => trim($_POST['fullName']),
                'email'       => trim($_POST['email']),
                'phoneNumber' => trim($_POST['phoneNumber']),
            ];

            // Process avatar upload
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/avatars/';

                // Ensure the directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generate a unique filename
                $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = 'user_' . $user->id . '_' . time() . '.' . $fileExtension;
                $targetFile = $uploadDir . $filename;

                // Move the uploaded file
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    // Delete old avatar if it exists and is not the default one
                    if (!empty($user->avatar) && $user->avatar !== 'default-avatar.png') {
                        $oldAvatarPath = $uploadDir . $user->avatar;
                        if (file_exists($oldAvatarPath)) {
                            unlink($oldAvatarPath);
                        }
                    }

                    // Set the new avatar path
                    $data['avatar'] = $filename;
                } else {
                    $_SESSION['error'] = "فشل رفع صورة الملف الشخصي.";
                    header("Location: " . route('user.profile'));
                    exit;
                }
            }

            $user->fill($data);

            if ($user->save()) {
                $_SESSION['success'] = "تم تحديث الملف الشخصي بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث الملف الشخصي";
            }

            header("Location: " . route('user.profile'));
            exit;
        }
    }


    // Process password update form submission
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = auth()->user();
            $currentPassword = $_POST['current_password'];
            $newPassword     = $_POST['new_password'];

            if (!password_verify($currentPassword, $user->password)) {
                $_SESSION['error'] = "كلمة المرور الحالية غير صحيحة";
                header("Location: " . route('update_password'));
                exit;
            }

            $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($user->save()) {
                $_SESSION['success'] = "تم تحديث كلمة المرور بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث كلمة المرور";
            }
            header("Location: " . route('user.profile'));
            exit;
        }
    }

    // Process account deletion (for example)
    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = auth()->user();
            if ($user->delete()) {
                session_destroy();
                header("Location: " . route('home'));
                exit;
            } else {
                $_SESSION['error'] = "فشل حذف الحساب";
                header("Location: " . route('user.profile'));
                exit;
            }
        }
    }
}
