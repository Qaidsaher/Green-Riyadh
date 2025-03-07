<?php
namespace App\Controllers;

use App\Models\Admin;

class AdminAdminController
{
    public function index()
    {
        view('admin/admins/index');
    }

    public function create()
    {
        view('admin/admins/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'     => trim($_POST['name']),
                'email'    => trim($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ];
            $admin = new Admin($data);
            if ($admin->save()) {
                $_SESSION['success'] = "تمت إضافة المسؤول بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة المسؤول";
            }
            header("Location: " . route('admin.admins'));
            exit;
        }
    }

    public function edit()
    {
        view('admin/admins/edit');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_GET['id']);
            $admin = Admin::find($id);
            if (!$admin) {
                $_SESSION['error'] = "المسؤول غير موجود";
                header("Location: " . route('admin.admins'));
                exit;
            }
            $admin->fill([
                'name'  => trim($_POST['name']),
                'email' => trim($_POST['email'])
            ]);
            if ($admin->save()) {
                $_SESSION['success'] = "تم تحديث بيانات المسؤول بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث بيانات المسؤول";
            }
            header("Location: " . route('admin.admins'));
            exit;
        }
    }

    public function delete()
    {
        $id = intval($_GET['id']);
        $admin = Admin::find($id);
        if ($admin && $admin->delete()) {
            $_SESSION['success'] = "تم حذف المسؤول بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف المسؤول";
        }
        header("Location: " . route('admin.admins'));
        exit;
    }
}
