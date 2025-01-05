<?php
require_once 'business.php';


function images(&$model){
    $images = get_images();
    $model['images'] = $images;

    gallery($model);
    return 'images_view';
}


function image(&$model){
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($image = get_image($id)) {
            $model['image'] = $image;
            return 'image_view';
        }
    }

    http_response_code(404);
    exit;
}


function gallery(&$model){
    $images = get_images();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 8;

    $pagination = page($images, $page, $perPage);
    $model['images'] = $pagination['images'];
    $model['totalPages'] = $pagination['totalPages'];
    $model['currentPage'] = $pagination['currentPage'];
}

function table(&$model){
    $images = get_images();
    $model['images'] = $images;
    return 'table_view';
}

function page($images, $page, $perPage){
    $totalImages = count($images);
    $totalPages = ceil($totalImages / $perPage);
    $start = ($page - 1) * $perPage;
    $pagedImg = array_slice($images, $start, $perPage);

    return [
        'images' => $pagedImg,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}

function edit(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $file = $_FILES['file']['tmp_name'];
            if (empty($_POST['title'])){
                $_POST['title'] = "Untitled";
            }
            if (empty($_POST['author'])){
                $_POST['author'] = "Anonymous";
            }

            $image = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'wmark' => $_POST['wmark'],
                'id'=> $id
            ];
            if (upload($id, $file, $image)) {
                return 'redirect:images';
            }
        }
     elseif (!empty($_GET['id'])) {
        $image = get_image($_GET['id']);
    }

    $model['image'] = $image;

    return 'edit_view';
}

function delete(&$model){
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_image($id);
            return 'redirect:table';

        } else {
            if ($image = get_image($id)) {
                $model['image'] = $image;
                return 'delete_view';
            }
        }
    }

    http_response_code(404);
    exit;
}

function login(&$model){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['user']) || empty($_POST['psw'])) {
            $model['error'] = 'All fields are required';
        }
        else {
            $pass = $_POST['psw'];
            $login = $_POST['user'];
            $user = get_user($_POST['user']);

            if ($user && password_verify($pass, $user['psw'])) {
                session_regenerate_id();
                $_SESSION['user_id'] = $user['id'];
                return 'redirect:images';
            }
            else {
                echo '<em>Invalid username or password.</em>';
            }
        }
    }

    return 'login_view';
}

function create(&$model){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty($_POST['email']) || empty($_POST['user']) || empty($_POST['psw']) || empty($_POST['pswR'])) {
            echo 'All fields are required';
        }
        elseif ($_POST['psw'] !== $_POST['pswR']) {
            echo 'Passwords do not match';
        }
        else {
            $user = [
                'id' => uniqid(),
                'email' => $_POST['email'],
                'user' => $_POST['user'],
                'psw' => password_hash($_POST['psw'], PASSWORD_DEFAULT)
            ];

            if (create_user($user)) {
                return 'redirect:login';
            }
            else { echo 'Failed to create account';}
        }
    }

    return 'create_view';
}

function logincreate(&$model){
   
    return 'partial/logincreate_view';
}

function logout()
{
    session_start();
    session_unset();
    session_destroy();
    return 'redirect:images';
}
