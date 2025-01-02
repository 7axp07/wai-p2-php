<?php
require_once 'business.php';
require_once 'controller_utils.php';


function images(&$model)
{
    $images = get_images();
    $model['images'] = $images;

    return 'images_view';
}

function image(&$model)
{
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

function gallery(&$model)
{
    return 'partial/gallery_view';
}

function edit(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $file = $_FILES['file']['tmp_name'];
            $image = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'id'=> $id
                //'ext' => null;
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

function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_image($id);
            return 'redirect:images';

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

    return 'login_view';
}
