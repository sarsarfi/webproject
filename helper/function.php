<?php
function view($viewName) {
    require_once __DIR__ . '/../views/' . $viewName;
}
function redirect($path) {
    header("Location: $path");
    exit;
}

function isloggedin() {
    return isset($_SESSION['user_id']);
}
?>