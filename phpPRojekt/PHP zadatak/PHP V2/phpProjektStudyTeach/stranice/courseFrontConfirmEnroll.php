<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>
<?php include("..//parts/mainParts/accountPage.php"); ?>



<?php include_once("../parts/classes/pagesAndCoursesV3/course.php"); ?>
<?php include_once("../parts/mainParts/database.php"); ?>

<?php
include_once("../parts/mainParts/usrChck.php");


$courseO;
$conn;

if (isset($_POST["enrolCourseId"])) {
    $courseO = new Course($conn);
    $courseO->courseId = $_POST["enrolCourseId"];
    $courseO->readCourseData($courseO->courseId);
} else {
    header("Location: mainpage.php");
}
/* <?= $courseO->courseImgPth?> */

?>




<div class="content main-content">
    <div class="sidebar">

        <div class="classes-btns">

            <form class="classes-btns-form" action="mainpage.php" method="get">

                <button type="submit" name="b1" value="created">Back</button>
            </form>


        </div>

    </div>

    <div class="content-panel">

        <div class="course-front-page-enrol-group-div">
            <div class="courseDisplayFrontPage">
                <img src="<?= $courseO->courseImgPth ?> ">
                <h1> <?= $courseO->courseTitle ?> </h1>
                <div class="course-front-page-enrol-desc-div">
                    <p><?= $courseO->courseTxt ?></p>
                </div>
            </div>

            <div class="fpdisplay-enrol-form-div">
                <form action="CoursePageDisplay.php" method="Post">
                    <button name="enrolConfirmId" value="<?= $courseO->courseId ?>">Enrol</button>
                </form>

            </div>

        </div>



    </div>


</div>








<?php include("../parts/mainParts/footer.php"); ?>