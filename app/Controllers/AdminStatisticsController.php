<?php
namespace App\Controllers;

use App\Models\Statistic;

class AdminStatisticsController
{
    // Display list of all statistics records
    public function index()
    {
        view('admin/statistics/index');
    }

    // Show form to create a new statistics record
    public function create()
    {
        view('admin/statistics/create');
    }

    // Process creation of a new statistics record
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'locationId'      => intval($_POST['locationId']),
                'treesPlanted'    => intval($_POST['treesPlanted']),
                'reportsSubmitted'=> intval($_POST['reportsSubmitted']),
                'pointsEarned'    => intval($_POST['pointsEarned'])
            ];
            $stat = new Statistic($data);
            if ($stat->save()) {
                $_SESSION['success'] = "تمت إضافة الإحصائيات بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة الإحصائيات";
            }
            header("Location: " . route('admin.statistics'));
            exit;
        }
    }

    // Show form to edit an existing statistics record
    public function edit()
    {
        view('admin/statistics/edit');
    }

    // Process update of a statistics record
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $stat = Statistic::find($id);
            if (!$stat) {
                $_SESSION['error'] = "الإحصائيات غير موجودة";
                header("Location: " . route('admin.statistics'));
                exit;
            }
            $stat->fill([
                'locationId'      => intval($_POST['locationId']),
                'treesPlanted'    => intval($_POST['treesPlanted']),
                'reportsSubmitted'=> intval($_POST['reportsSubmitted']),
                'pointsEarned'    => intval($_POST['pointsEarned'])
            ]);
            if ($stat->save()) {
                $_SESSION['success'] = "تم تحديث الإحصائيات بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث الإحصائيات";
            }
            header("Location: " . route('admin.statistics'));
            exit;
        }
    }

    // Delete a statistics record
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $stat = Statistic::find($id);
        if ($stat && $stat->delete()) {
            $_SESSION['success'] = "تم حذف الإحصائيات بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف الإحصائيات";
        }
        header("Location: " . route('admin.statistics'));
        exit;
    }
}
