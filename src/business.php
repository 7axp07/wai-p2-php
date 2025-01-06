<?php

use MongoDB\BSON\ObjectID;


function get_db(){
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function get_images(){
    $db = get_db();
    return $db->images->find()->toArray();
}

function get_images_by_category($cat){
    $db = get_db();
    $images = $db->images->find(['cat' => $cat]);
    return $images;
}

function get_image($id){
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
        $str = "File is too big, max 1MB. ";
        $errorMsg .= $str;
        $errors++;
    }

    $allowed = array('jpg', 'jpeg', 'png', 'PNG', 'JPG', 'JPEG');
    if (!in_array($fileExt, $allowed)){
        $str = "File type not allowed. ";
        $errorMsg .= $str;
        $errors++;}
       
    else {
        $imageData['ext'] = $fileExt;
    }

    if ($errors > 0){
        echo $errorMsg;
        return false;
    }
    else if ($errors == 0) {
        $db = get_db();

        if ($id == null) {
            $insert = $db->images->insertOne($imageData);
            $imgID = (string)$insert->getInsertedId();
        } else {
            $db->images->replaceOne(['_id' => new ObjectID($id)], $imageData);
            $imgID = $id;
        }

        $newFileName = $imgID . "." . $fileExt;
        $fileLoc = "upload/" . $newFileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $fileLoc)) {
            thumbnail($fileLoc, $fileExt, $imgID);
            watermark($fileLoc, $imageData['wmark'], $fileExt, $imgID);
            return true;
        }
        else {
            echo "Failed to save image.";
            return false;
        }
    }
    else {
        return false;
    }
}

function watermark($imagePath, $wmark, $ext, $id){
    if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG") { $img = imagecreatefromjpeg($imagePath);}
    else if ($ext == "png" || $ext == "PNG") { $img = imagecreatefrompng($imagePath);}

    $color = imagecolorallocatealpha($img, 255, 0, 0, 80);
    $font = "static/fonts/arial.ttf";
    $xVal = imagesx($img)/4;
    $yVal = imagesy($img)/2;
    $size = $yVal/5;
    
    imagettftext($img, $size, 0, $xVal, $yVal, $color, $font, $wmark);

    if ($ext == "jpg" || $ext == "JPG") { imagejpeg($img, "upload/wmarked/w".$id.".jpg");}
    else if ($ext == "jpeg" || $ext == "JPEG") { imagejpeg($img, "upload/wmarked/w".$id.".jpeg");}
    else if ($ext == "png" || $ext == "PNG") { imagepng($img, "upload/wmarked/w".$id.".png");}

    imagedestroy($img);
}

function thumbnail($imagePath, $ext, $id){
    if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG") { $img = imagecreatefromjpeg($imagePath);}
    else if ($ext == "png" || $ext == "PNG") { $img = imagecreatefrompng($imagePath);}

    $width = imagesx($img);
    $height = imagesy($img);

    $newWidth = 200;
    $newHeight = 125;

    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    imagecopyresized($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if ($ext == "jpg" ||  $ext == "JPG") { imagejpeg($thumb, "upload/thumb/t".$id.".jpg");}
    else if ($ext == "jpeg" || $ext == "JPEG") { imagejpeg($thumb, "upload/thumb/t".$id.".jpeg");}
    else if ($ext == "png" || $ext == "PNG") { imagepng($thumb, "upload/thumb/t".$id.".png");}

    imagedestroy($img);
    imagedestroy($thumb);
}

function delete_image($id){
    $db = get_db();
    $image = $db->images->findOne(['_id' => new ObjectID($id)]);

    if ($image) {
        $fileExt = $image['ext'];
        $db->images->deleteOne(['_id' => new ObjectID($id)]);
        $toDelete = (string)$id;
        unlink("upload/" . $toDelete . "." . $fileExt);
        unlink("upload/wmarked/w" . $toDelete . "." . $fileExt);
        unlink("upload/thumb/t" . $toDelete . "." . $fileExt);
    }
}


function get_user($user){
    $db = get_db();
    return $db->users->findOne(['user' => $user]);
}

function create_user($user){
    $db = get_db();
    $db->users->insertOne($user);
    return true;
}