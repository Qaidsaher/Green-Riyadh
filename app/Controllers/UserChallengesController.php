<?php
namespace App\Controllers;

use App\Models\ChallengeTask;

class UserChallengesController
{
    // List all available challenges for the user
    public function index()
    {
        // Retrieve all active challenge tasks (adjust query as needed)
        $challenges = ChallengeTask::where(['status' => 'active']);
        view('user/challenges/index', ['challenges' => $challenges]);
    }
    
    // Optionally, a method to show challenge details
    public function show()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $challenge = ChallengeTask::find($id);
        if (!$challenge) {
            $_SESSION['error'] = "المهمة غير موجودة";
            header("Location: " . route('user.challenges'));
            exit;
        }
        view('user/challenges/show', ['challenge' => $challenge]);
    }
}
