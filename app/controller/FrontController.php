<?php
namespace App\Controller;

class FrontController
{
    public function home()
    {
        view('home.php');
    }
    public function product()
    {
        view('product.php');
    }

    public function cart()
    {
        view('cart.php');
    }
}
