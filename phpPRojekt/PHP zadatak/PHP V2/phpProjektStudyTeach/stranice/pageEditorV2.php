<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>
<?php


include_once("../parts/classes/pagesAndCoursesV3/page.php");
include_once("../parts/classes/fileUpload.php");
include_once("../parts/classes/options.php");
include_once("../parts/mainParts/usrChck.php");

include("../parts/mainParts/database.php");

$close = false;
$new = true;
$read = false;

/*--------------------------*/
$message = "";
$showWarning = false;
$showMessage = false;
/*--------------------------*/

$conn;

$courseId;

$pageNum = 1;

$pageType = "";
$pageOldFile = "";
$pageFile = "";
$pageTitle = "";
$pageTxt = "";




$isFile = true;

$pageO;

$options = new options($conn);
$fileUpO = new FileUV();

// ----------------take course id $pageNum and set page type + is file za odabir forme and save -----------------------------------------------------------------------------------------------
if (isset($_POST["cid"])) {
    $courseId = $_POST["cid"];
} else {
    header("Location: mainpage.php");
}

if (isset($_POST["pageNum"])) {
    $pageNum = $_POST["pageNum"];
}

if (isset($_POST["pageType"])) {
    $pageType = $_POST["pageType"];

    $isFile = $fileUpO->isFile($pageType);
}

//------------------------------------------------------------------------

// RECIEVE NEW-PAGE-----------------------------------------------------------

if (isset($_POST["newPage"])) {
    $new = true;
}

//--RECIEVE EDITING ---------------------------------------------

if (isset($_POST["editPageForm"])) {

    $new = false;

    $pageNum = $_POST["editPageForm"];

    $pageO = new Page($courseId, $conn,);
    $pageO->courseId = $courseId;
    $pageO->readPageP($pageNum);

    $pageTitle = $pageO->pageTitle;
    $pageTxt = $pageO->pageTxt;
    $pageOldFile = $pageO->pageFPVI;
    $pageFile = $pageOldFile;
}

//----- CREATE ------------------------------------------------------------------------
if (isset($_POST["pageFormNew"])) {

    $pageO = new Page($courseId, $conn,);
    $new = true;
    $fileUpO = new FileUV();

    $pageTitle = htmlentities($_POST["pageTitle"]);
    $pageTxt = htmlentities($_POST["pageTxt"]);

    $validation = true;
    $isFile = $fileUpO->isFile($pageType);
    if ($isFile) {
        $file = $_FILES["fileFV"];
        $validation = $fileUpO->validatePagefile($pageType, $file);
    } else {
        $file = $_POST["fileFV"];
    }

    if ($validation) {

        if ($pageO->createPageFile($fileUpO, $pageType,  $file, $pageTitle, $pageTxt)) {
            $new = false;
            $pageO->readPageP($pageO->readMaxPgNum());

            $pageOldFile = $pageO->pageFPVI;
            $pageFile = $pageO->pageFPVI;
            $showMessage = true;
            $message = "Page created succefully!";
        } else {
            $showWarning = true;
            $message = " Creating page failed! ";
        }
    } else {
        $showWarning = true;
        $message = " Creating page failed! " .
            "Validation error on file :" .
            " file cant be empty , img: jpeg,jpg,png / video: mp4   34MB ";
    }
}

//----- SAVE ------------------------------------------------------------------------

if (isset($_POST["pageFormSaveEdit"])) {
    $new = false;
    $file = null;

    $pageTitle = htmlentities($_POST["pageTitle"]);
    $pageTxt = htmlentities($_POST["pageTxt"]);
    $oldFilePath = "";
    $oldFilePath = $_POST["fileOldPth"];

    $pageO = new Page($courseId, $conn,);
    $fileUV  = new FileUV();

    $validate = true;

    $isFile = $fileUV->isFile($pageType);

    if ($isFile) {
        $file = $_FILES["fileFV"];
    } else {
        $file = htmlentities($_POST["fileFV"]);
    }


    if ($pageO->updatePageWupldF($fileUV, $pageType, $pageNum, $file, $oldFilePath, $pageTitle, $pageTxt)) {
        $showMessage=true;
        $message="Page updated succes!";
    }
    $pageO->readPageP($pageNum);
    $pageTitle = $pageO->pageTitle;
    $pageTxt = $pageO->pageTxt;
    $pageOldFile = $pageO->pageFPVI;
    $pageFile = $pageO->pageFPVI;
}



//-------READ PAGE DATA-----------------------------------------------

?>

<div class="content main-content">
    <div class="sidebar">

        <div class="classes-btns">

            <form class="classes-btns-form" action="courseEditor.php" method="post">
                <input type="hidden" name="frontPage" value="<?= false ?>">
                <button type="submit" name="courseId" value="<?= $courseId ?>">Back</button>
            </form>

        </div>


    </div>

    <div class="content-panel">



        <div class="div-form-accounts">

            <form class="form-accounts" action="pageEditorV2.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="cid" value=<?= $courseId ?>></input>
                <input type="hidden" name="pageType" value=<?= $pageType ?>></input>
                <input type="hidden" name="new" value=<?= $new ?>></input>
                <input type="hidden" name="pageNum" value=<?= $pageNum ?>></input>
                <input type="hidden" name="fileOldPth" value=<?= $pageOldFile ?>>
                <?php if (!$new) { ?>

                    <?php if ($pageType == "img") {  ?>
                        <img class="course-form-old-image" src="<?= $pageOldFile ?>">
                    <?php } else  if ($pageType == "video") { ?>

                        <video class="course-form-old-image" controls>
                            <source src="<?= $pageOldFile ?>" type='video/mp4'>
                        </video>

                    <?php  } else { ?>
                        <iframe class="course-form-old-image" src="<?= $pageOldFile ?>"></iframe>;
                <?php }
                } ?>
                <?php if ($isFile) { ?>
                    <div class="form-label-div-accounts"><label>Page file <?= $pageType ?> : </label></div>
                    <input type="file" name="fileFV">
                <?php } else { ?>
                    <div class="form-label-div-accounts"><label>Page youtube video (put "embed/" instead of "watch?v="):</label></div>
                    <input type="text" name="fileFV" value="<?= $pageFile ?>"></input>
                <?php } ?>
                <div class="form-label-div-accounts"><label>Page title:</label></div>
                <input type="text" name="pageTitle" value="<?= $pageTitle ?>"> </input>
                <div class="form-label-div-accounts"><label>Page text:</label></div>
                <textarea name="pageTxt"><?= $pageTxt ?></textarea>

                <?php if ($new) {   ?>

                    <input type="hidden" name="newPage">
                    <button type=submit name="pageFormNew">create new</button>


                <?php } else { ?>

                    <button type=submit name="pageFormSaveEdit">save</button>


                <?php } ?>

            </form>










        </div>

    </div>

</div>


<?php include_once("../parts/mainParts/warningWindow.php") ?>
<?php include("../parts/mainParts/footer.php"); ?>
<?php include_once("../parts/mainParts/warningWindowP2.php") ?>
<?php
if ($showWarning) {

    showWarning($message);
} else if ($showMessage) {

    showMessage($message);
}
?>