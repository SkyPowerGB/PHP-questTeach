<?php 

include_once("../parts/classes/pagesAndCoursesV3/course.php");
include_once("../parts/classes/fileUpload.php");
include_once("../parts/mainParts/database.php");
include_once("../parts/classes/pagesAndCoursesV3/page.php");
include_once("../parts/mainParts/usrChck.php");
$conn;
if(isset($_POST["delete"])){
$courseId=$_POST["courseId"];
$course=new Course($conn);
$pageO=new Page($courseId,$conn);
$course->courseId=$courseId;
$res=$course->getCousePages();



$fileO=new FileUV();
$course->deleteCourseFile($fileO,$courseId);
$course->deleteCourseWC($courseId);
header("Location: myCoursePage.php?b1=created");

}else{
  header("Location: myCoursePage.php");
}





