<?php
namespace App\Controllers;

use App\Models\Report;

class AdminReportsController
{
    // List all reports
    public function index()
    {
        view('admin/reports/index');
    }
    
   

    // Update report status (example: mark as reviewed/resolved)
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $report = Report::find($id);
            if (!$report) {
                $_SESSION['error'] = "البلاغ غير موجود";
                header("Location: " . route('admin.reports'));
                exit;
            }
            // Assume a dropdown in the edit form sends new status value
            $report->status = trim($_POST['status']);
            if ($report->save()) {
                $_SESSION['success'] = "تم تحديث حالة البلاغ بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث حالة البلاغ";
            }
            header("Location: " . route('admin.reports'));
            exit;
        }
    }

    // Delete a report
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $report = Report::find($id);
        if ($report && $report->delete()) {
            $_SESSION['success'] = "تم حذف البلاغ بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف البلاغ";
        }
        header("Location: " . route('admin.reports'));
        exit;
    }
}
