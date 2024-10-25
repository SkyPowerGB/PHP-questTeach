<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>
<?php include("..//parts/mainParts/accountPage.php"); ?>



<?php
include_once("../parts/mainParts/database.php");

include_once("../parts/classes/pagesAndCoursesV3/page.php");
include_once("../parts/classes/pagesAndCoursesV3/course.php");
include_once("../parts/classes/pagination/pagination.php");
include_once("../parts/mainParts/usrChck.php");



$conn;
$current = 1;
$courseId = 0;

$courseO = new Course($conn);

if (isset($_POST["paginationSPage"])) {

    $current = $_POST["paginationSPage"];
}


if (isset($_POST["enrolConfirmId"])) {
    $courseId = $_POST["enrolConfirmId"];
    $courseO->enrollCourse($_SESSION["user_id"], $courseId);
}

if (isset($_POST["paginationData"])) {
    $data = unserialize($_POST["paginationData"]);
    $courseId = $data["courseId"];
}

if (isset($_POST["courseId"])) {
    $courseId = $_POST["courseId"];
}

if ($courseId == 0) {
    header("Location: mainpage.php");
}


$hasNoPages = false;
$pageO = new Page($courseId, $conn);

$maxPageNum = $pageO->readMaxPgNum();
if ($maxPageNum == 0) {
    $current = 1;
    $hasNoPages = true;
}

$data = array("courseId" => $courseId);
$data = serialize($data);
$PageO;

$paginationO = new Pagination("coursePageDisplay.php", 1, $current, $maxPageNum, 5);


if (!$hasNoPages) {
    $pageO->readPageP($paginationO->current);

    $ifleEmpty = false;

    if ($pageO->pageFPVI == "") {
        $ifleEmpty = true;
    }




    $isVideo = false;
    $isImg = false;
    $isYTvideo = false;


    switch ($pageO->pageFileType) {
        case "img":
            $isImg = true;
            break;
        case "youtubevideo":
            $isYTvideo = true;
            break;
        case "video":
            $isVideo = true;
            break;
        default:
            $ifleEmpty = true;
    }



    $paginationO->data = $data;


    if (isset($_POST["paginationCurrPg"])) {

        $current = $_POST["paginationCurrPg"];
    }



    $paginationO->generatePaginationLogic($paginationO);
}

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

        <?php if (!$hasNoPages) { ?>
            <?php $paginationO->generatePagination(); ?>

            <div class="content-column-display-course">
                <div class="courseDisplayPage">

                    <?php
                    if (!$ifleEmpty) {
                        if ($isImg) {
                            echo "<img src='$pageO->pageFPVI'>";
                        } elseif ($isYTvideo) {
                    ?>
                            <iframe src='<?= $pageO->pageFPVI ?>'></iframe>;
                    <?php
                        } elseif ($isVideo) {
                            echo "<video controls><source src='$pageO->pageFPVI' type='video/mp4'></video>";
                        }
                    }

                    ?>





                    <h1>
                        <?= $pageO->pageTitle ?>
                    </h1>
                    <div class="courseDisplayPage-text-div">
                        <p>
                            <?= $pageO->pageTxt ?>
                        </p>
                    </div>
                </div>

            <?php } else {
        } ?>
            </div>


    </div>
</div>














<?php include("../parts/mainParts/footer.php"); ?>