<?php

include_once("../parts/classes/options.php");

include_once("../parts/mainParts/database.php");

include_once("../parts/classes/pagesAndCoursesV3/course.php");
include_once("../parts/classes/fileUpload.php");

$conn;

$course = new Course($conn);
$options = new options($conn);
$fileUV = new FileUV();


$new = true;

$newId = 0;
$editor;

$showFile = false;
$reslut = 0;



//create new
if (isset($_POST['newCourseForm'])) {

    $courseTitle = htmlentities($_POST['title']);
    $courseText = htmlentities($_POST['txt']);
    $courseType = $_POST["ctype"];
    $file = $_FILES["img"];

    function fileUploadErrorMsg($code)
    {
        switch ($code) {
            case -1:
                return "file too big";
            case -2:
                return "file format not supported (jpg,png,jpeg)";
            case 1:
                return " uploaded file exceeds the upload_max_filesize";
            case 2:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive ";
            case 3:
                return "The uploaded file was only partially uploaded";
            case 4:
                return "No file was uploaded";
            case 6:
                return "Missing a temporary folder";
            case 7:
                return "Failed to write file to disk";
            case 8:
                return " A PHP extension stopped the file upload";
        }
    }


    if ($course->createCourseWFile($fileUV, $_SESSION["user_id"], $courseType, $file, $courseTitle, $courseText)) {

        $newId = $course->courseId;
        $course->readCourseData($newId);
        $new = false;
        $showMessage = true;
        $message = "crated course succes!";
    } else {

        $errC = $course->createCouresWFerror;
        $showWarning = true;

        switch ($errC) {
            case 1:
                $message = "Title validation error: must be less than 5000 chars and not empty";
                break;
            case 2:
                $message = "Text validation error: must not be empty";
                break;
            case 3:
                $message = fileUploadErrorMsg($course->cCouresWFileFerror);
                break;
            case 4:
                $message = "File upload error";
                break;
            case 5:
                $message = "db error";
                break;
        }
    }
}


//save edit
if (isset($_POST["saveEdit"])) {

    $courseTitle = htmlentities($_POST["title"]);
    $courseText = htmlentities($_POST["txt"]);
    $courseId = $_POST["courseId"];
    $imagePth = $_POST["oldImage"];
    $oldImage = $imagePth;
    $file = $_FILES["img"];
    $formValid = true;

    if ($course->updateCourseWF($courseId, $file, $imagePth, $courseTitle, $courseText, $fileUV)) {
        $newId = $courseId;
        $showMessage = true;
        $messageCourse = true;
        $message = "update course succesful";
    };
}


//read
if (isset($_POST["editCourse"]) || $newId > 0 || isset($_POST["courseId"])) {


    if ($newId < 0) {

        return;
    }
    if (isset($_POST["courseId"])) {
        $newId = $_POST["courseId"];
    }
    $new = false;
    $showFile = true;
    $course->readCourseData($newId);
}



?>
<?php  ?>

<?php  ?>


<div class="content-panel">


    <?php if ($new) { ?>
        <div class="div-form-accounts">

            <form class="form-accounts" method="post" action="courseEditor.php" enctype="multipart/form-data">
                <div class="form-label-div-accounts"><label>Course Image:</label></div>
                <input type="file" name="img"></input>
                <div class="form-label-div-accounts"><label>Select type of course:</label></div>
                <select type="text" name="ctype"> <?php $options->genCourseTypesOP(); ?> </select>
                <div class="form-label-div-accounts "><label>Course title: *</label></div>
                <input type="text" name="title"></input>
                <div class="form-label-div-accounts"><label>Course description:</label></div>
                <textarea name="txt"></textarea>
                <button type="submit" name="newCourseForm">Create New</button>
            </form>


        </div>
    <?php } else { ?>


        <div class="div-form-accounts">


            <form class="form-accounts" method="post" action="courseEditor.php" enctype="multipart/form-data">
                <img class="course-form-old-image" src="<?= $course->courseImgPth ?>">
                <input type="hidden" name="courseId" value="<?= htmlspecialchars($course->courseId) ?>">
                <input type="hidden" name="oldImage" value="<?= $course->courseImgPth ?>">
                <div class="form-label-div-accounts"><label>Course Image:</label></div>
                <input type="file" name="img">
                <div class="form-label-div-accounts "><label>Course title: *</label></div>
                <input type="text" name="title" value="<?= htmlspecialchars($course->courseTitle) ?>">
                <div class="form-label-div-accounts"><label>Course description:</label></div>
                <textarea name="txt"><?= htmlspecialchars($course->courseTxt) ?></textarea>
                <button type="submit" name="saveEdit">Edit</button>
            </form>

        </div>

    <?php } ?>
</div>

