<?php
namespace App\Controllers;

use App\Models\Location;

class AdminLocationController
{
    // List all locations
    public function index()
    {
        view('admin/locations/index');
    }

    // Show the form for creating a new location
    public function create()
    {
        view('admin/locations/create');
    }

    // Process the creation of a new location
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => trim($_POST['name']),
                'coordinates' => trim($_POST['coordinates']),
                'description' => trim($_POST['description']),
                'status'      => trim($_POST['status']),
                'authorityId' => isset($_POST['authorityId']) ? intval($_POST['authorityId']) : null
            ];
            $location = new Location($data);
            if ($location->save()) {
                $_SESSION['success'] = "تمت إضافة الموقع بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة الموقع";
            }
            header("Location: " . route('admin.locations'));
            exit;
        }
    }

    // Show the form for editing an existing location
    public function edit()
    {
        view('admin/locations/edit');
    }

    // Process the update for a location
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $location = Location::find($id);
            if (!$location) {
                $_SESSION['error'] = "الموقع غير موجود";
                header("Location: " . route('admin.locations'));
                exit;
            }
            $location->fill([
                'name'        => trim($_POST['name']),
                'coordinates' => trim($_POST['coordinates']),
                'description' => trim($_POST['description']),
                'status'      => trim($_POST['status']),
                'authorityId' => isset($_POST['authorityId']) ? intval($_POST['authorityId']) : null
            ]);
            if ($location->save()) {
                $_SESSION['success'] = "تم تحديث بيانات الموقع بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث بيانات الموقع";
            }
            header("Location: " . route('admin.locations'));
            exit;
        }
    }

    // Process deletion of a location
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $location = Location::find($id);
        if ($location && $location->delete()) {
            $_SESSION['success'] = "تم حذف الموقع بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف الموقع";
        }
        header("Location: " . route('admin.locations'));
        exit;
    }
}
