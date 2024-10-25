<?php

include_once("../parts/mainParts/database.php");
$conn;
$courseO = new Course($conn);

if (isset($_POST["enrolledToRemove"])) {

    $courseO->withdrawEnroll($_SESSION["user_id"], $_POST["enrolledToRemove"]);
}
$adminEdit=false;
$editUID=$_SESSION["user_id"];
if(isset($_POST["adminEditCourses"])){
    $editUID=$_POST["adminEditCourses"];

}

$result = $courseO->getEnrolledCourses($editUID);
$show = false;
if ($result) {
    $show = true;
}



?>

<?php if ($show) {
    while ($row = $result->fetch_assoc()) { ?>

        <div class="item">
            <div class="course-front-page">
                <img class="course-img" src="<?= $row["courseImg"] ?>">
                <h1><?= $row["courseTitle"] ?> </h1>
                <div class="course-desc">
                <p><?= $row["courseDesc"] ?> </p>
                </div>

                <div class="course-front-page-form-div">
                <form class="course-front-page-form-ctrl" action="myCoursePage.php?b1=enroled" method="post"><button name="enrolledToRemove" value="<?= $row["courseId"] ?>">Remove</button></form>
                    <form class="course-front-page-form-ctrl" action="coursePageDisplay.php" method="post"><button name="courseId" value="<?= $row["courseId"] ?>">Open</button></form>
                   
                </div>

            </div>
        </div>
<?php }
} ?>