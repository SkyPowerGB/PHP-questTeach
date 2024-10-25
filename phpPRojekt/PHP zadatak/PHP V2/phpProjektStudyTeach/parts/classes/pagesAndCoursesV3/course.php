<?php

class Course
{

    public $conn;

    public $courseId = 0;
    public $courseType = "";
    public $courseImgPth = "";
    public $courseTitle = "";
    public $courseTxt = "";
    public $authorId = 0;



    public $readDone = false;
    public $errorVar = " ";
    public $errorcode = 0;
    public $newCourseId = 0;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function readCourseData($courseId)
    {
        $this->readDone = true;
        $sql = "CALL getCourse(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $courseId);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            if ($result != null) {

                $this->courseImgPth = $result["courseImg"];
                $this->courseTitle = $result["courseTitle"];
                $this->courseTxt = $result["courseDesc"];
                $this->courseType = $result["courseTypeId"];
                $this->authorId = $result["authorId"];
                $this->courseId = $courseId;
            }
            $stmt->close();
            $this->errorVar = "issue reading data";
            $this->errorcode = -1;
            return $this->courseId;
        }
        $this->errorVar = "unable to connect to db";
        $this->errorcode = -1;

        $stmt->close();
    }

    public function readCourseDataAS()
    {
        $this->readCourseData($this->courseId);
    }

    /* courseId bude spremljen v courseId */
    /*------------------UPDATE/CREATE--------------------------------------------------------------------------------------*/
    
    public $createCourseError = 0;/** 1 title , 2 txt , 3 db error */
    public function createCourse($authorId, $courseType, $courseImgPth, $courseTitle, $courseTxt)
    {

        if (!$this->validateCourseTitle($courseTitle)) {
            $this->createCourseError=1;
            return false;
        }
        if (!$this->validateCourseText($courseTxt)) {
            $this->createCourseError=2;
            return false;
        }


        $sql = "SELECT createNewCourseTX(?,?,?,?,?) as outp";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", $authorId, $courseType, $courseImgPth, $courseTitle, $courseTxt);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $this->courseId = $res['outp'];
            return true;
        }
        $stmt->close();
     
        $this->createCourseError=3;
        return false;
    }


    public $updateCourseDataErr = 0; /* 1-db error */
    public function updateCourseData($courseId, $courseImagePath, $courseTitle, $courseTxt)
    {

        $sql = "SELECT updateCourse(?,?,?,?) AS output;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $courseId, $courseImagePath, $courseTitle, $courseTxt);
        if ($stmt->execute()) {
            $stmt->close();

            return true;
        } else {
            $stmt->close();
            $this->updateCourseDataErr = 1;
            return false;
        }
    }



    /*----------------------*/
    public $createCouresWFerror = 0;  /* 1 title , 2 txt , 3 file ,4 upload ,5 create (1 title, 2 txt , 3,db error) */
    public $cCouresWFileFerror=0;
    public function createCourseWFile($fileUVobj, $authorId, $courseType, $file, $courseTitle, $courseTxt)
    {
        $filePath ="";

        if (!$this->validateCourseTitle($courseTitle)) {
            $this->createCouresWFerror=1;
            return false;
        }
        if (!$this->validateCourseText($courseTxt)) {
            $this->createCouresWFerror=2;
            return false;
        }

        if (!$fileUVobj->validateImageFile($file)) {
            $this->createCouresWFerror=3;
           $this-> cCouresWFileFerror=$fileUVobj->errorCode;
            return false;
        }
        if (!$fileUVobj->uploadImageFile($file)) {
            $this->createCouresWFerror=4;

            return false;
        };

        $filePath = $fileUVobj->fileDestination;


        if (!$this->createCourse($authorId, $courseType, $filePath, $courseTitle, $courseTxt)) {
            $fileUVobj->deleteFile($filePath);
            $this->createCouresWFerror=5;
            return false;
        }


        return true;
    }


    /*---------------------------*/
    /* errors : 1->title   2->txt  3->updatecourse (1db)*/
    public  $updateCourseWFerrCode = 0;
    public function updateCourseWF($courseId, $file,$oldFilePth ,$courseTitle, $courseTxt, $fileUVobj)
    {
        $fileOK = true;
        $newFilePath = $oldFilePth;
        if (!is_null($file)) {

            if (!$this->validateCourseFile($file, $fileUVobj)) {
                $fileOK = false;
            }

            if ($fileOK) {
                $this->readCourseData($courseId);
                if ($fileUVobj->uploadImageFile($file)) {
                    $newFilePath = $fileUVobj->fileDestination;
                    $this->deleteCourseFile($fileUVobj, $courseId);
                }
            }
        }
        if (!$this->validateCourseTitle($courseTitle)) {
            $this->updateCourseWFerrCode = 1;
            return false;
        }
        if (!$this->validateCourseText($courseTxt)) {
            $this->updateCourseWFerrCode = 2;
            return false;
        }

        if ($this->updateCourseData($courseId, $newFilePath, $courseTitle, $courseTxt)) {
            return true;
        }
        $this->updateCourseWFerrCode = 3;
        return false;
    }




    /*--------------------------------------------------------------------------------------------------------*/
    //brise sve fielove od coursea
    public function deleteCourseFile($fileVCobj, $courseId)
    {
        $sql = "SELECT courseImg FROM course WHERE courseId=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $courseId);
        if ($stmt->execute()) {

            $res = $stmt->get_result()->fetch_assoc();
            if (isset($res["courseImg"])) {
                $fileVCobj->deleteFile($res["courseImg"]);
            }
            $result = $this->getAllCoursePagesFilepaths($courseId);
            while ($row = $result->fetch_assoc()) {


                $fileVCobj->deleteFile($row["filePaths"]);
            }

            $stmt->close();
            return;
        }
        return;
    }

    public function deleteCourse()
    {

        $this->deleteCourseWC($this->courseId);
    }


    public function deleteCourseWC($courseId)
    {
        
        $sql = "SELECT deleteCourse(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $courseId);
        if ($stmt->execute()) {
            $stmt->close();
            return 1;
        }
        $stmt->close();
        return -1;
    }

    /*koristi courseId v objektu */
    public function isAuthor($userId)
    {
        return $this->isAuthorWR($userId, $this->courseId);
    }

    public function isAuthorWR($userId, $courseId)
    {
        $result =  $this->getAuthorId($courseId);
        if ($result == $userId) {
            return true;
        }
        return false;
    }


    public function isUserEnroled($userId, $courseId)
    {
        $sql = "SELECT isUserEnroled(?,?) AS outp;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $courseId, $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($result["outp"] == 0) {
                return false;
            } else {
                return true;
            }
        }

        $stmt->close();
        return false;
    }
    public function getAuthorId($courseId)
    {
        $sql = "SELECT getCourseAuthor(?) as id";
        $stmt = $this->conn->prepare();
        $stmt->bind_param($this->courseId);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $res['id'];
        }
        $stmt->close();
        $this->errorVar = 'failed to connect to db';
        return -1;
    }


    public function getCousePages()
    {
        $sql = "CALL getCoursePages(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->courseId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
    }

    public function getCoursesFromTo($from, $to, $shrch, $pageType)
    {
        $sql = "CALL getCoursesFromTo(?,?,?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiss", $from, $to, $shrch, $pageType);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $stmt->close();
            return $result;
        }


        $stmt->close();
        return null;
    }

    public function getAllMyCourses($userId)
    {
        $sql = "SELECT * FROM course WHERE authorId = (?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $stmt->close();
            return $result;
        }
        $stmt->close();
        return null;
    }


    public function getMaxCourseNumUnfiltered()
    {

        $sql = "SELECT COUNT(courseId ) AS maxCourseNum FROM course";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result["maxCourseNum"];
        }
        $stmt->close();
        return 0;
    }


    public function enrollCourse($userId, $courseId)
    {
        $sql = "SELECT enroll(?,?) as otp ;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $courseId);
        if ($stmt->execute()) {

            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result["otp"];
        }
        $stmt->close();
        return false;
    }

    public function withdrawEnroll($userId, $courseId)
    {
        $sql = "SELECT withdrawEnrollment(?,?) as otp ;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $courseId);
        if ($stmt->execute()) {

            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result["otp"];
        }
        $stmt->close();
        return false;
    }


    public function getEnrolledCourses($userId)
    {
        $sql = "CALL getEnrolledCourses(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $stmt->close();
            return $result;
        }
        $stmt->close();
        return false;
    }

    public function getAllCoursePagesFilepaths($courseId)
    {
        $sql = "call getPageFilePaths(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $courseId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
        return false;
    }


    public function deleteAllMyData($userId, $fileUVobj)
    {
        $enrolledC = $this->getEnrolledCourses($userId);
        while ($row1 = $enrolledC->fetch_assoc()) {
            $this->withdrawEnroll($userId, $row1["courseId"]);
        }
        $mycourses = $this->getAllMyCourses($userId);
        while ($row = $mycourses->fetch_assoc()) {
            $this->deleteCourseWC($row["courseId"]);
            $this->deleteCourseFile($fileUVobj, $row["courseId"]);
        }
    }



    /*---------------------------------------------------------------------------------------------*/
    /*---------------   VALIDACIJA------------------------------------------------------------------------------------------*/
    /*---------text ,title 1-validation /  2-null  ------------------------------------------------*/
    public  $validationCourseTileErrCode = 0;
    public function validateCourseTitle($text)
    {


        if ($text == null || $text == "") {
            $this->validationCourseTileErrCode = 2;
            return false;
        }

         

        $filter = "/^.{1,4999}$/s";

        if (preg_match($filter, $text)) {
            return true;
        }
        $this->validationCourseTileErrCode = 1;
        return false;
    }


    /*---------------------------------------------------------*/
    public  $validationCourseTextErrCode = 0;
    public function validateCourseText($text)
    {

        if ($text == null || $text == "") {
            $this->validationCourseTextErrCode = 2;
            return false;
        }

        return true;
        /*
        $filter = "/[^\w\s]/";

        if (preg_match($filter, $text)) {
            return true;
        }
        $this->validationCourseTextErrCode = 1;
        return false;*/
    }

    /*---------------------------------------------------------*/

    public $validationCourseImgErrCode = 0;
    public function validateCourseFile($file, $fileUVobj)
    {
        if (!$fileUVobj->validatePagefile("img", $file)) {
            $this->validationCourseImgErrCode = $fileUVobj->errorCode;
            return false;
        }
        return true;
    }
}
