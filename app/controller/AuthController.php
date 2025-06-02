<?php

namespace App\Controller;

use App\Model\User;

class AuthController
{
    public static function login()
    {
        if (self::isLoggedIn()) {
            return self::redirect('/webprogrammingproject/dashboard');
        }

        return view('login.php');
    }

    public static function register()
    {
        if (self::isLoggedIn()) {
            return self::redirect('/webprogrammingproject/dashboard');
        }

        return view('register.php');
    }

    public static function storeUser()
    {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $user = User::create([
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            'password' => $password
        ]);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        return self::redirect('/webprogrammingproject/dashboard');
    }

    public static function loginUser()
    {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $user = User::where('email', $email)->first();

        if ($user && password_verify($pass, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;

            return self::redirect('/webprogrammingproject/dashboard');
        }

        return self::redirect('/webprogrammingproject/login');
    }

    // تابع کمکی: ریدایرکت
    private static function redirect($path)
    {
        header("Location: $path");
        exit;
    }

    // تابع کمکی: چک لاگین
    private static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
