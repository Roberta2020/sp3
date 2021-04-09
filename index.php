<?php
require_once "./bootstrap.php";
use Models\Page;

$url = $_SERVER['REQUEST_URI'];
$prefix = '/sp3';
switch ($url) {
    case $prefix . '/' :
        require __DIR__ . '/src/views/user.php';
        break;
    case $prefix . '' :
        require __DIR__ . '/src/views/user.php';
        break;
    case $prefix . '/user' :
        require __DIR__ . '/src/views/user.php';
        break;
    case $prefix . '/?id=' . $_GET['id']:
        require __DIR__ . '/src/views/user.php';
        break;    
    case $prefix . '/user?id=1':
        require __DIR__ . '/src/views/user.php';
        break;  
    case $prefix . '/user?id=' . $_GET['id']:
        require __DIR__ . '/src/views/user.php';
        break;

    case $prefix . '/admin' :
        require __DIR__ . '/src/views/admin.php';
        break;
    case $prefix . '/admin.php?action=logout':
        require __DIR__ . '/src/views/admin.php';
        break;  
    case $prefix . '/admin?delete=' . $_GET['delete']:
        require __DIR__ . '/src/views/admin.php';
        break;
    case $prefix . '/admin?updatable=' . $_GET['updatable']:
        require __DIR__ . '/src/views/admin.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/src/views/404.php';
        break;
}

