<?php
namespace App\Controllers;

use App\Models\ChallengeTask;

class AdminChallengeController
{
    // List all challenge tasks
    public function index()
    {
        view('admin/challenges/index');
    }

    // Show form for creating a new challenge task
    public function create()
    {
        view('admin/challenges/create');
    }

    // Process new challenge task creation
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'challengeId'   => intval($_POST['challengeId']), // or assign a default if needed
                'taskName'      => trim($_POST['taskName']),
                'taskDescription' => trim($_POST['taskDescription']),
                'points'        => intval($_POST['points']),
                'status'        => trim($_POST['status'])
            ];
            $task = new ChallengeTask($data);
            if ($task->save()) {
                $_SESSION['success'] = "تمت إضافة المهمة بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة المهمة";
            }
            header("Location: " . route('admin.challenges'));
            exit;
        }
    }

    // Show form for editing an existing challenge task
    public function edit()
    {
        view('admin/challenges/edit');
    }

    // Process challenge task update
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $task = ChallengeTask::find($id);
            if (!$task) {
                $_SESSION['error'] = "المهمة غير موجودة";
                header("Location: " . route('admin.challenges'));
                exit;
            }
            $task->fill([
                'challengeId'   => intval($_POST['challengeId']),
                'taskName'      => trim($_POST['taskName']),
                'taskDescription' => trim($_POST['taskDescription']),
                'points'        => intval($_POST['points']),
                'status'        => trim($_POST['status'])
            ]);
            if ($task->save()) {
                $_SESSION['success'] = "تم تحديث المهمة بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث المهمة";
            }
            header("Location: " . route('admin.challenges'));
            exit;
        }
    }

    // Process challenge task deletion
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $task = ChallengeTask::find($id);
        if ($task && $task->delete()) {
            $_SESSION['success'] = "تم حذف المهمة بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف المهمة";
        }
        header("Location: " . route('admin.challenges'));
        exit;
    }
}
