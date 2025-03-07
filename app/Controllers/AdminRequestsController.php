<?php

namespace App\Controllers;

use App\Models\RequestPoint;

class AdminRequestsController
{
    // List all point requests
    public function index()
    {
        view('admin/requests/index');
    }

    // Update request status (approve or deny)
    // public function updateStatus()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    //         $request = RequestPoint::find($id);
    //         if (!$request) {
    //             $_SESSION['error'] = "طلب النقاط غير موجود";
    //             header("Location: " . route('admin.requests'));
    //             exit;
    //         }
    //         // New status from the form: pending, approved, or denied
    //         $request->status = trim($_POST['status']);
    //         if ($request->save()) {
    //             $_SESSION['success'] = "تم تحديث حالة الطلب بنجاح";
    //         } else {
    //             $_SESSION['error'] = "فشل تحديث حالة الطلب";
    //         }
    //         header("Location: " . route('admin.requests'));
    //         exit;
    //     }
    // }
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $request = RequestPoint::find($id);
            if (!$request) {
                $_SESSION['error'] = "طلب النقاط غير موجود";
                header("Location: " . route('admin.requests'));
                exit;
            }

            // Save current and new status
            $oldStatus = strtolower($request->status);
            $newStatus = strtolower(trim($_POST['status']));
            $request->status = $newStatus;

            if ($request->save()) {
                // If now approved and not already approved, then award points
                if ($newStatus === 'approved' && $oldStatus !== 'approved') {
                    $pointsToAward = $request->pointsRequested; // Adjust logic if needed
                    $userId = $request->userId;

                    // Check if a point source for "طلب نقاط" exists; if not, create it.
                    $source = null;
                    $sources = \App\Models\PointSource::where(['sourceType' => 'طلب نقاط']);
                    if (!empty($sources)) {
                        $source = $sources[0];
                    } else {
                        $source = new \App\Models\PointSource([
                            'sourceType'  => 'طلب نقاط',
                            'description' => 'النقاط المكتسبة عند الموافقة على طلب النقاط'
                        ]);
                        $source->save();
                    }

                    // Create a new Points record with the determined point source
                    $point = new \App\Models\Point([
                        'userId'       => $userId,
                        'pointsEarned' => $pointsToAward,
                        'pointSourceId' => $source->id
                    ]);
                    if ($point->save()) {
                        // Optionally update the user's total points in Users table.
                        $user = \App\Models\User::find($userId);
                        if ($user) {
                            $user->points += $pointsToAward;
                            $user->save();
                        }
                    }
                }
                $_SESSION['success'] = "تم تحديث حالة الطلب بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث حالة الطلب";
            }
            header("Location: " . route('admin.requests'));
            exit;
        }
    }


    // Delete a point request
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $request = RequestPoint::find($id);
        if ($request && $request->delete()) {
            $_SESSION['success'] = "تم حذف الطلب بنجاح";
        } else {
            $_SESSION['error'] = "فشل حذف الطلب";
        }
        header("Location: " . route('admin.requests'));
        exit;
    }
}
