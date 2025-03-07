<?php
namespace App\Controllers;

use App\Models\Authority;

class AdminAuthorityController
{
    // List all Authorities
    public function index()
    {
        view('admin/authorities/index');
    }

    // Show create form
    public function create()
    {
        view('admin/authorities/create');
    }

    // Process new Authority creation
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'         => trim($_POST['name']),
                'contactEmail' => trim($_POST['contactEmail']),
                'contactPhone' => trim($_POST['contactPhone'])
            ];
            $authority = new Authority($data);
            if ($authority->save()) {
                $_SESSION['success'] = "تمت إضافة الجهة بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة الجهة";
            }
            header("Location: " . route('admin.authorities'));
            exit;
        }
    }

    // Show edit form
    public function edit()
    {
        view('admin/authorities/edit');
    }

    // Process Authority update
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_GET['id']);
            $authority = Authority::find($id);
            if (!$authority) {
                $_SESSION['error'] = "الجهة غير موجودة";
                header("Location: " . route('admin.authorities'));
                exit;
            }
            $authority->fill([
                'name'         => trim($_POST['name']),
                'contactEmail' => trim($_POST['contactEmail']),
                'contactPhone' => trim($_POST['contactPhone'])
            ]);
            if ($authority->save()) {
                $_SESSION['success'] = "تم تحديث بيانات الجهة بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث بيانات الجهة";
            }
            header("Location: " . route('admin.authorities'));
            exit;
        }
    }

    // Process Authority deletion
    public function delete()
    {
        $id = intval($_GET['id']);
        $authority = Authority::find($id);
        if ($authority && $authority->delete()) {
            $_SESSION['success'] = "تم حذف الجهة بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف الجهة";
        }
        header("Location: " . route('admin.authorities'));
        exit;
    }
}
