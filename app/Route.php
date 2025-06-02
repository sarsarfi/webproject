<?php
namespace App;

class Route
{
    private $routes = [];

    // افزودن مسیر جدید به لیست مسیرها
    public function addRoute($method = "GET", $path = "/", $handle = null)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path'   => rtrim($path, "/"), // حذف اسلش انتهایی برای هماهنگی
            'handle' => $handle
        ];
    }

    // اجرای مسیر مناسب بر اساس درخواست
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $handle = $route['handle'];

                if (is_callable($handle)) {
                    call_user_func($handle);
                } elseif (is_array($handle)) {
                    $controller = new $handle[0];
                    $methodName = $handle[1];

                    if (method_exists($controller, $methodName)) {
                        $controller->$methodName();
                    } else {
                        die("Method {$methodName} not found in " . get_class($controller));
                    }
                }

                return;
            }
        }

        // مسیر پیدا نشد، نمایش صفحه 404
        http_response_code(404);
        require_once __DIR__ . '/../views/404.php';
    }
}

