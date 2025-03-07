<?php
namespace App\Controllers;

use App\Models\FAQ;

class AdminFAQController
{
    // List all FAQs
    public function index()
    {
        view('admin/faqs/index');
    }

    // Show the create form
    public function create()
    {
        view('admin/faqs/create');
    }

    // Process form to store new FAQ
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question    = trim($_POST['question']);
            $answer      = trim($_POST['answer']);
            $contactInfo = trim($_POST['contactInfo']);

            $faq = new FAQ([
                'question'    => $question,
                'answer'      => $answer,
                'contactInfo' => $contactInfo
            ]);

            if ($faq->save()) {
                $_SESSION['success'] = "تمت إضافة السؤال بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء إضافة السؤال";
            }
            header("Location: " . route('admin.faqs'));
            exit;
        }
    }

    // Show the edit form
    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $faq = FAQ::find($id);
        if (!$faq) {
            $_SESSION['error'] = "السؤال غير موجود";
            header("Location: " . route('admin.faqs'));
            exit;
        }
        // Pass the FAQ to the view
        view('admin/faqs/edit', ['faq' => $faq]);
    }

    // Process form to update FAQ
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $faq = FAQ::find($id);
            if (!$faq) {
                $_SESSION['error'] = "السؤال غير موجود";
                header("Location: " . route('admin.faqs'));
                exit;
            }

            $faq->fill([
                'question'    => trim($_POST['question']),
                'answer'      => trim($_POST['answer']),
                'contactInfo' => trim($_POST['contactInfo'])
            ]);

            if ($faq->save()) {
                $_SESSION['success'] = "تم تحديث السؤال بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث السؤال";
            }
            header("Location: " . route('admin.faqs'));
            exit;
        }
    }

    // Delete FAQ
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $faq = FAQ::find($id);
        if ($faq && $faq->delete()) {
            $_SESSION['success'] = "تم حذف السؤال بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف السؤال";
        }
        header("Location: " . route('admin.faqs'));
        exit;
    }
}
