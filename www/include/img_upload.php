<?php

use \Exception as Exception;
error_reporting(E_ALL);
ini_set("display_errors", 1);

function img_upload($img,$upload_dir, $ext, $imgName) {

    $tmp_dir = $_FILES[$img]['tmp_name'];
    $imgSize = $_FILES[$img]['size'];
    $imgFile = $_FILES[$img]['name'];

    if(!empty($imgFile)) {

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = $ext; // valid extensions

        // rename uploading image
        $img = $imgName.'_'.rand(1000,1000000).".".$imgExt;

        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions)){
            // Check file size '5MB'
            if($imgSize < 5632000)				{
                move_uploaded_file($tmp_dir,$upload_dir.$img);
            }
            else{
                $error = "Sorry, your file is too large.";
            }
        }
        else {
            $error = "Sorry, only ".join(", ", $ext)." are allowed.";
        }

        if(!isset($error)) {
            return $img;
        } else {
            throw new Exception($error);
        }

    } else {
        return NULL;
    }

}
?>