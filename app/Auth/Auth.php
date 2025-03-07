<?php
namespace App\Auth;

use App\Models\User;
use App\Models\Admin;
use Exception;

class Auth
{
    /**
     * Holds the single instance.
     *
     * @var Auth
     */
    private static $instance;

    /**
     * Retrieve the single instance of Auth.
     *
     * @return Auth
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Check if any account is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
    }

    /**
     * Determine if the authenticated account is a user.
     *
     * @return bool
     */
    public function isUser()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Determine if the authenticated account is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return isset($_SESSION['admin_id']);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function user()
    {
        if ($this->isUser()) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }

    /**
     * Get the currently authenticated admin.
     *
     * @return Admin|null
     */
    public function admin()
    {
        if ($this->isAdmin()) {
            return Admin::find($_SESSION['admin_id']);
        }
        return null;
    }

    /**
     * Login either a user or an admin.
     * For admin login, pass $asAdmin = true.
     *
     * @param string $email
     * @param string $password
     * @param bool   $asAdmin
     * @return User|Admin|false
     */
    public function login($email, $password, $asAdmin )
    {
       
        $this->logout();
        if ($asAdmin ==='admin') {
            $admins = Admin::where(['email' => $email]);
            if (!empty($admins)) {
                $admin = $admins[0];
                if (password_verify($password, $admin->password)) {
                    $_SESSION['admin_id'] = $admin->id;
                    session_regenerate_id(true);
                    return $admin;
                }
            }
        } else {
            $users = User::where(['email' => $email]);
            if (!empty($users)) {
                $user = $users[0];
                if (password_verify($password, $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    session_regenerate_id(true);
                    return $user;
                }
            }
        }
        return false;
    }

    /**
     * Register a new user.
     * Registration is for users only.
     *
     * @param string      $fullName
     * @param string      $email
     * @param string      $password
     * @param string|null $phoneNumber
     * @return User
     * @throws Exception If the email is already registered or registration fails.
     */
    public function register($fullName, $email, $password, $phoneNumber = null)
    {
        $existing = User::where(['email' => $email]);
        if (!empty($existing)) {
            throw new Exception("A user with this email already exists.");
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User([
            'fullName'    => $fullName,
            'email'       => $email,
            'password'    => $hashedPassword,
            'phoneNumber' => $phoneNumber
        ]);
        if ($user->save()) {
            $_SESSION['user_id'] = $user->id;
            session_regenerate_id(true);
            return $user;
        }
        throw new Exception("Registration failed.");
    }

    /**
     * Update the profile for the authenticated account.
     *
     * @param array $data For a user, keys may include 'fullName', 'email', 'phoneNumber'. For admin, 'name' and 'email'.
     * @return bool
     */
    public function updateProfile(array $data)
    {
        if ($this->isUser()) {
            $user = $this->user();
            if (!$user) return false;
            $user->fill($data);
            return $user->save();
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            $admin->fill($data);
            return $admin->save();
        }
        return false;
    }

    /**
     * Update the password for the authenticated account.
     *
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool
     * @throws Exception If the old password is incorrect.
     */
    public function updatePassword($oldPassword, $newPassword)
    {
        if ($this->isUser()) {
            $user = $this->user();
            if (!$user) return false;
            if (password_verify($oldPassword, $user->password)) {
                $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
                return $user->save();
            }
            throw new Exception("Old password is incorrect.");
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            if (password_verify($oldPassword, $admin->password)) {
                $admin->password = password_hash($newPassword, PASSWORD_DEFAULT);
                return $admin->save();
            }
            throw new Exception("Old password is incorrect.");
        }
        return false;
    }

    /**
     * Delete the authenticated account.
     *
     * @return bool
     */
    public function deleteAccount()
    {
        if ($this->isUser()) {
            $user = $this->user();
            if (!$user) return false;
            $result = $user->delete();
            if ($result) {
                unset($_SESSION['user_id']);
            }
            return $result;
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            $result = $admin->delete();
            if ($result) {
                unset($_SESSION['admin_id']);
            }
            return $result;
        }
        return false;
    }

    /**
     * Log out the authenticated account.
     *
     * @return void
     */
    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }
        if (isset($_SESSION['admin_id'])) {
            unset($_SESSION['admin_id']);
        }
        // Optionally: session_destroy();
    }
}
