<?php
namespace App\Controllers;

use App\Models\User;

class AdminUserController
{
    public function index()
    {
        view('admin/users/index');
    }

    public function create()
    {
        view('admin/users/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fullName'    => trim($_POST['fullName']),
                'email'       => trim($_POST['email']),
                'phoneNumber' => trim($_POST['phoneNumber']),
                'points'      => intval($_POST['points']),
                'password'    => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ];
            $user = new User($data);
            if ($user->save()) {
                $_SESSION['success'] = "تمت إضافة المستخدم بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة المستخدم";
            }
            header("Location: " . route('admin.users'));
            exit;
        }
    }

    public function edit()
    {
        view('admin/users/edit');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_GET['id']);
            $user = User::find($id);
            if (!$user) {
                $_SESSION['error'] = "المستخدم غير موجود";
                header("Location: " . route('admin.users'));
                exit;
            }
            $user->fill([
                'fullName'    => trim($_POST['fullName']),
                'email'       => trim($_POST['email']),
                'phoneNumber' => trim($_POST['phoneNumber']),
                'points'      => intval($_POST['points'])
            ]);
            if ($user->save()) {
                $_SESSION['success'] = "تم تحديث بيانات المستخدم بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث بيانات المستخدم";
            }
            header("Location: " . route('admin.users'));
            exit;
        }
    }

    public function delete()
    {
        $id = intval($_GET['id']);
        $user = User::find($id);
        if ($user && $user->delete()) {
            $_SESSION['success'] = "تم حذف المستخدم بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف المستخدم";
        }
        header("Location: " . route('admin.users'));
        exit;
    }
}
