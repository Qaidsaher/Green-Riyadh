<?php

// Middleware helper function
function middleware($middleware, $callback)
{
    return function () use ($middleware, $callback) {
        // 'auth' middleware: Check if the user is logged in.
        if ($middleware === 'auth') {
            if (!auth()->isUser()) {
                header("Location: " . route('login'));
                exit;
            }
        }
        // 'admin' middleware: Check if the user is logged in and has an admin role.
        if ($middleware === 'admin') {
            if (!auth()->isAdmin()) {
                header("Location: " . route('home'));
                exit;
            }
        }
        // Additional middleware types can be added here.
        // echo auth()->isAdmin();
        // exit;
        // If all checks pass, call the route callback.
        $callback();
    };
}

// Routes definition
use App\Controllers\AdminChallengeController;
use App\Controllers\AdminLocationController;
use App\Controllers\AdminRequestsController;
use App\Controllers\AdminStatisticsController;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\AdminFAQController;
use App\Controllers\AdminUserController;
use App\Controllers\AdminAdminController;
use App\Controllers\AdminAuthorityController;
use App\Controllers\AdminReportsController;
use App\Controllers\UserChallengesController;
use App\Controllers\UserReportsController;
use App\Controllers\UserRequestsController;

// Public routes (no middleware needed)
$routes = [
    'home'     => function () {
        view('home');
    },
    'login'    => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            view('auth/login');
        }
    },
    'register' => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            view('auth/register');
        }
    },
    'logout'   => function () {
        session_destroy();
        header("Location: " . route('home'));
        exit;
    },
    'about'      => function () {
        view('about');
    },
    'terms'      => function () {
        view('terms');
    },
    'privacy'    => function () {
        view('privacy');
    },
    'contact'    => function () {
        view('contact');
    },
    'faq'    => function () {
        view('faq');
    },

    // User panel routes (require authentication)
    'user.update_profile'  => middleware('auth', function () {
        $controller = new ProfileController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateProfile();
        } else {
            view('user/edit_profile');
        }
    }),
    
    'user.update_password' => middleware('auth', function () {
        $controller = new ProfileController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updatePassword();
        } else {
            view('user/profile/update_password');
        }
    }),
    'delete_account'  => middleware('auth', function () {
        $controller = new ProfileController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->deleteAccount();
        } else {
            // For deletion, you might want a confirmation page.
            echo "<form action='" . route('delete_account') . "' method='POST' class='text-center mt-10'>
                <p class='mb-4'>هل أنت متأكد من حذف الحساب؟</p>
                <button type='submit' class='bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded transition'>حذف الحساب</button>
              </form>";
        }
    }),
    'user.dashboard'  => middleware('auth', function () {
        view('user/dashboard');
    }),
    // New Challenges routes:
    'user.challenges'         => function () {
        $controller = new UserChallengesController();
        $controller->index();
    },
    'user.challenges.show'    => function () {
        $controller = new UserChallengesController();
        $controller->show();
    },
    'user.profile'    => middleware('auth', function () {
        view('user/profile/profile');
    }),
    'user.edit_profile' => middleware('auth', function () {
        view('user/profile/edit_profile');
    }),
    'user.reports'        => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->index();
    }),
    'user.reports.myreports'        => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->myreport();
    }),
    'user.reports.create' => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->create();
    }),
    'user.reports.store'  => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->store();
    }),
    'user.reports.show'   => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->show();
    }),
    'user.reports.add_comment' => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->addComment();
    }),
    'user.reports.delete_comment' => middleware('auth', function () {
        $controller = new UserReportsController();
        $controller->deleteComment();
    }),
    'user.requests'       => middleware('auth', function () {
        $controller = new UserRequestsController();
        $controller->index();
    }),
    'user.requests.create' => middleware('auth', function () {
        $controller = new UserRequestsController();
        $controller->create();
    }),
    
    'user.requests.store' => middleware('auth', function () {
        $controller = new UserRequestsController();
        $controller->store();
    }),

    // Admin routes (require admin privileges)
    'admin.home'         => middleware('admin', function () {
        view('admin/dashboard');
    }),
    'admin.users'        => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->index();
    }),
    'admin.users.create' => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->create();
    }),
    'admin.users.store'  => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->store();
    }),
    'admin.users.edit'   => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->edit();
    }),
    'admin.users.update' => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->update();
    }),
    'admin.users.delete' => middleware('admin', function () {
        $controller = new AdminUserController();
        $controller->delete();
    }),
    'admin.admins'        => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->index();
    }),
    'admin.admins.create' => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->create();
    }),
    'admin.admins.store'  => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->store();
    }),
    'admin.admins.edit'   => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->edit();
    }),
    'admin.admins.update' => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->update();
    }),
    'admin.admins.delete' => middleware('admin', function () {
        $controller = new AdminAdminController();
        $controller->delete();
    }),
    'admin.faqs'         => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->index();
    }),
    'admin.faqs.create'  => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->create();
    }),
    'admin.faqs.store'   => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->store();
    }),
    'admin.faqs.edit'    => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->edit();
    }),
    'admin.faqs.update'  => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->update();
    }),
    'admin.faqs.delete'  => middleware('admin', function () {
        $controller = new AdminFAQController();
        $controller->delete();
    }),
    'admin.requests'     => middleware('admin', function () {
        $controller = new AdminRequestsController();
        $controller->index();
    }),
    'admin.requests.update_status' => middleware('admin', function () {
        $controller = new AdminRequestsController();
        $controller->updateStatus();
    }),
    'admin.requests.delete' => middleware('admin', function () {
        $controller = new AdminRequestsController();
        $controller->delete();
    }),
    'admin.challenges'         => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->index();
    }),
    'admin.challenges.create'  => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->create();
    }),
    'admin.challenges.store'   => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->store();
    }),
    'admin.challenges.edit'    => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->edit();
    }),
    'admin.challenges.update'  => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->update();
    }),
    'admin.challenges.delete'  => middleware('admin', function () {
        $controller = new AdminChallengeController();
        $controller->delete();
    }),
    'admin.statistics'   => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->index();
    }),
    'admin.statistics.create'  => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->create();
    }),
    'admin.statistics.store'   => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->store();
    }),
    'admin.statistics.edit'    => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->edit();
    }),
    'admin.statistics.update'  => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->update();
    }),
    'admin.statistics.delete'  => middleware('admin', function () {
        $controller = new AdminStatisticsController();
        $controller->delete();
    }),
    'admin.comments'         => middleware('admin', function () {
        $controller = new \App\Controllers\AdminCommentsController();
        $controller->index();
    }),
    'admin.comments.edit'    => middleware('admin', function () {
        $controller = new \App\Controllers\AdminCommentsController();
        $controller->edit();
    }),
    'admin.comments.update'  => middleware('admin', function () {
        $controller = new \App\Controllers\AdminCommentsController();
        $controller->update();
    }),
    'admin.comments.delete'  => middleware('admin', function () {
        $controller = new \App\Controllers\AdminCommentsController();
        $controller->delete();
    }),
    'admin.authorities'         => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->index();
    }),
    'admin.authorities.create'  => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->create();
    }),
    'admin.authorities.store'   => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->store();
    }),
    'admin.authorities.edit'    => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->edit();
    }),
    'admin.authorities.update'  => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->update();
    }),
    'admin.authorities.delete'  => middleware('admin', function () {
        $controller = new AdminAuthorityController();
        $controller->delete();
    }),
    // Admin Reports Routes
    'admin.reports'               => middleware('admin', function () {
        $controller = new AdminReportsController();
        $controller->index();
    }),
    'admin.reports.update_status' => middleware('admin', function () {
        $controller = new AdminReportsController();
        $controller->updateStatus();
    }),
    'admin.reports.delete'        => middleware('admin', function () {
        $controller = new AdminReportsController();
        $controller->delete();
    }),
    'admin.locations'  => middleware('admin', function () {
        $controller = new AdminLocationController();
        $controller->index();
    }),
    'admin.locations.create' => middleware('s', callback: function () {
        $controller = new AdminLocationController();
        $controller->create();
    }),
    'admin.locations.store'  => middleware('admin', function () {
        $controller = new AdminLocationController();
        $controller->store();
    }),
    'admin.locations.edit'   => middleware('admin', function () {
        $controller = new AdminLocationController();
        $controller->edit();
    }),
    'admin.locations.update' => middleware('admin', function () {
        $controller = new AdminLocationController();
        $controller->update();
    }),
    'admin.locations.delete' => middleware('admin', function () {
        $controller = new AdminLocationController();
        $controller->delete();
    }),



];

$route = isset($_GET['route']) ? $_GET['route'] : 'home';
if (isset($routes[$route]) && is_callable($routes[$route])) {
    $routes[$route]();
} else {
    echo "المسار '{$route}' غير موجود.";
}
