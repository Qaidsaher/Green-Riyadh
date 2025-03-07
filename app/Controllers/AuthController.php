<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Models\User;
use App\Models\Admin;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email      = trim($_POST['email']);
            $password   = $_POST['password'];
            $userType   = $_POST['user_type']; // "user" or "admin"

            // Basic validation could go here...
                
            // Try to login via Auth
            $auth = auth();
            $result = $auth->login($email, $password,$userType );
           
            if ($result) {
                $_SESSION['success'] = "تم تسجيل الدخول بنجاح";
                if ($auth->isAdmin()) {
                    header("Location: " . route(name: 'admin.home'));
                } else {
                    header("Location: " . route('home'));
                }
               
                exit;
            } else {
                $_SESSION['error'] = "فشل تسجيل الدخول، يرجى التحقق من البيانات";
                header("Location: " . route('login'));
                exit;
            }
        } else {
            // If GET, show login page
            view('auth/login');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName    = trim($_POST['fullName']);
            $email       = trim($_POST['email']);
            $phoneNumber = trim($_POST['phoneNumber']);
            $password    = $_POST['password'];

            // Basic validation should be done here...

            $auth = Auth::instance();
            try {
                $user = $auth->register($fullName, $email, $password, $phoneNumber);
                $_SESSION['success'] = "تم إنشاء الحساب بنجاح";
                header("Location: " . route('home'));
                exit;
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: " . route('register'));
                exit;
            }
        } else {
            // If GET, show register page
            view('auth/register');
        }
    }
}
