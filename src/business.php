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
    else {
        $imageData['ext'] = $fileExt;
    }

    if ($errors == 0) {
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

        // Save the original image
        if (move_uploaded_file($_FILES['file']['tmp_name'], $fileLoc)) {
            
            $wImg = watermark($fileLoc, $imageData['wmark'], $fileExt);
            if ($wImg) {
                $wFileLoc = "upload/w" . $newFileName;
                if (rename($wImg, $wFileLoc)) {
                    return true;
                } 
            } 
        } else {
            echo "Failed to save image.";
            return false;
        }
    } else {
        echo $errorMsg;
        return false;
    }
}

function watermark($imagePath, $wmark, $ext)
{
    if ($ext == "jpg" || $ext == "jpeg") {
        $img = imagecreatefromjpeg($imagePath);
    } else if ($ext == "png") {
        $img = imagecreatefrompng($imagePath);
    }

    $color = imagecolorallocatealpha($img, 255, 0, 0);
    $font = "static/fonts/arial.ttf";

    // Add the watermark text to the image
    imagettftext($img, 11, 0, 20, 30, $color, $font, $wmark);

    $wImgPath = tempnam(sys_get_temp_dir(), 'wmark_');

    if ($ext == "jpg" || $ext == "jpeg") {
        imagejpeg($img, $wImgPath);
    } else if ($ext == "png") {
        imagepng($img, $wImgPath);
    }

    imagedestroy($img);

    return $wImgPath;
}

function delete_image($id)
{
    $db = get_db();
    $image = $db->images->findOne(['_id' => new ObjectID($id)]);

    if ($image) {
        $fileExt = $image['ext'];
        $db->images->deleteOne(['_id' => new ObjectID($id)]);
        $toDelete = (string)$id;
        unlink("upload/" . $toDelete . "." . $fileExt);
    }
}
