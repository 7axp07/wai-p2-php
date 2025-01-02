<?php


use MongoDB\BSON\ObjectID;


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function get_images()
{
    $db = get_db();
    return $db->images->find()->toArray();
}

function get_images_by_category($cat)
{
    $db = get_db();
    $images = $db->images->find(['cat' => $cat]);
    return $images;
}

function get_image($id)
{
    $db = get_db();
    return $db->images->findOne(['_id' => new ObjectID($id)]);
}

function upload($id, $image, $imageData){

    $errorMsg = "";
    $errors = 0;

    if (!empty($image)){
        $fileName = pathinfo($_FILES['file']['name']);
        $fileExt = $fileName['extension'];
        $fileSize = $_FILES['file']['size'];
    }

    if ($fileSize > 1000000){
        $errorMsg = "File is too big";
        $errors++;
        echo $errorMsg;
    }

    $allowed = array('jpg', 'jpeg', 'png');
    if (!in_array($fileExt, $allowed)){
        $errorMsg = "File type not allowed";
        $errors++;
        echo $errorMsg;
    }
   /* else {
        $imageData['ext'] = (string)$fileExt;
    }*/

    if ($errors == 0){
        $db = get_db();

        if ($id == null) {
            $insert = $db->images->insertOne($imageData);
            $imgID = (string)$insert->getInsertedId();
        } else {
            $db->images->replaceOne(['_id' => new ObjectID($id)], $image);
        }
        $newFileName = $imgID.".".$fileExt;
        $fileLoc = "upload/".$newFileName;
        move_uploaded_file($image, $fileLoc);
        return true;
    }
    else {
    echo $errorMsg;
    return false;
    } 
}

function delete_image($id)
{
    $db = get_db();
    $db->images->deleteOne(['_id' => new ObjectID($id)]);

}
