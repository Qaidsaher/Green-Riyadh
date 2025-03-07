<?php
namespace App\Controllers;

use App\Models\Comment;

class AdminCommentsController
{
    // List all comments
    public function index()
    {
        view('admin/comments/index');
    }

    // Optionally, if you want to allow editing comments:
    public function edit()
    {
        view('admin/comments/edit');
    }

    // Process comment update (if editing is allowed)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $comment = Comment::find($id);
            if (!$comment) {
                $_SESSION['error'] = "التعليق غير موجود";
                header("Location: " . route('admin.comments'));
                exit;
            }
            $comment->fill([
                'commentText' => trim($_POST['commentText'])
            ]);
            if ($comment->save()) {
                $_SESSION['success'] = "تم تحديث التعليق بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث التعليق";
            }
            header("Location: " . route('admin.comments'));
            exit;
        }
    }

    // Delete a comment
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $comment = Comment::find($id);
        if ($comment && $comment->delete()) {
            $_SESSION['success'] = "تم حذف التعليق بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف التعليق";
        }
        header("Location: " . route('admin.comments'));
        exit;
    }
}
