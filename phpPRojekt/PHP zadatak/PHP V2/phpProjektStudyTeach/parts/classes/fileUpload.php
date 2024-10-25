<?php

class FileUV
{

    public  $errorMessage;
    public $errorCode = 0;
    public $fileDestination = "";

    public function __construct()
    {
    }


    function uploadAvatarFile($file)
    {
        if (!$this->validateImageFile($file)) {
            return false;
        }

        $uFileName = $file["name"];
        $uFileFullName = $file["full_path"];
        $uFileTempPath = $file["tmp_name"];
        $uFileExtensionTemp = explode(".", $uFileFullName);

        $uFileExtension = strtolower(end($uFileExtensionTemp));

        $fileNameNew = uniqid('', true) . '.' . $uFileExtension . $uFileName;

        $fileDestination = "../fielovi/avatars/.$fileNameNew";


        $this->fileDestination = $fileDestination;
        move_uploaded_file($uFileTempPath, $fileDestination);
        return true;


    }


    function uploadPageFile($file, $pageType)
    {

        if (is_null($file)) {
            return false;
        }

        if ($this->isFile($pageType)) {

            $uFileName = $file["name"];
            $uFileFullName = $file["full_path"];
            $uFileTempPath = $file["tmp_name"];
            $uFileExtensionTemp = explode(".", $uFileFullName);

            $uFileExtension = strtolower(end($uFileExtensionTemp));

            $fileNameNew = uniqid('', true) . '.' . $uFileExtension ;

            $fileDestination = "../fielovi/courseFiles/.$fileNameNew";


            $this->fileDestination = $fileDestination;


            return  move_uploaded_file($uFileTempPath, $fileDestination);
        }else{
        $this->fileDestination = $file;
        return false;
    
    }
        
    }

    //returns bool 
    function deleteFile($filePath)
    {
        if (!file_exists($filePath)) {
            return true;
        }
        return unlink($filePath);
    }

    function uploadImageFile($file)
    {
        return  $this->uploadPageFile($file, "img");
    }

    public function isFile($pageType)
    {
        if ($pageType == "youtubevideo") {
            return false;
        }
        return true;
    }


    function validateImageFile($file)
    {
        if (is_null($file)) {
            return false;
        }
        return $this->validatePagefile("img", $file);
    }


    //error-code:   -1 -> file too big  -2->file extension not supoorteed  -3 file null  1-8 file errors
    function validatePagefile($pageType, $file)
    {

        // -1 -> file too big  -2->file extension not supoorteed
        if (!$this->isFile($pageType)) {
            return $this->linkValid($file);
        }

        $fileErrors = $file['error'];

        if ($fileErrors != 0) {
            $this->errorMessage = "file error";
            $this->errorCode = $fileErrors;
            return false;
        }

        $uFileFullName = $file["full_path"];

        $size = $file["size"];

        $uFileExtensionTemp = explode(".", $uFileFullName);
        $extenstion = strtolower(end($uFileExtensionTemp));


        $allowedImg = array("jpg", "jpeg", "png");
        $allowdVideo = array("mp4");

        if ($size > 30000000) {
            $this->errorMessage = "size too big";
            $this->errorCode = -1;
            return false;
        }

        if ($pageType == "img") {

            if (in_array($extenstion, $allowedImg)) {
                $this->errorCode = -2;
                return true;
            }
            $this->errorMessage = "file extension unsuported";
            return false;
        } else {
            if (in_array($extenstion, $allowdVideo)) {
                return true;
            }
            $this->errorCode = -2;
            $this->errorMessage = "file extension unsuported";
            return false;
        }
    }



    function linkValid($link)
    {
        return true;
    }
}
