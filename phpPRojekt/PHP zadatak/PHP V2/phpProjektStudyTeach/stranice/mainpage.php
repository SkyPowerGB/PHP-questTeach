<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/database.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>


<?php include("..//parts/mainParts/accountPage.php"); ?>
<?php include_once("../parts/classes/pagesAndCoursesV3/course.php"); ?>

<?php include_once("../parts/classes/pagination/pagination.php"); ?>

<?php
include_once("../parts/mainParts/usrChck.php");




$current = 0;
$from = $current;
$maxPageNum = 0;
$first = 0;
$page = 0;


if (isset($_POST["paginationSPage"])) {

  $page = $_POST["paginationSPage"];
}


$nCourses = 9;

$from = $page * $nCourses;
$showTO = $from + $nCourses;


$show = true;

$conn;
$courseMngr = new Course($conn);
$maxCourseNum = $courseMngr->getMaxCourseNumUnfiltered();
$maxPageNum = (int)$maxCourseNum / (int)$nCourses;
$maxPageNum = (int)$maxPageNum;

$paginationO = new Pagination("mainpage.php", 0, $from, $maxPageNum, 5);
$paginationO->generatePaginationLogic($paginationO);
$warningMsg;

$shrch = "";
if (isset($_GET["shearch"])) {
  $shrch = htmlentities($_GET["shearch"]);
}

$courses = $courseMngr->getCoursesFromTo($from, $showTO, $shrch, "");

// Respond with JSON data

if ($courses == null) {
  $show = false;
}


?>

<div class="content main-content">
  <div class="sidebar">

    <div class="sidebar-shearch-form-div">

      <form id="shrchForm" class="sidebar-shearch-form" action="mainpage.php" method="get">
        <input id="shrchV" type="text" name="shearch"></input>
        <button id="shrchFormBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>

    </div>
  </div>

  <div class="content-panel">

    <?php $paginationO->generatePagination() ?>


    <div class="course-list">
      <?php
      if ($show) {
        while ($row = $courses->fetch_assoc()) {
      ?>
          <div class="item">
            <div class="course-front-page">
              <h1><?= $row["courseTitle"]  ?></h1>
              <img class="course-img" src="<?= $row["courseImg"] ?>">

              <div class="course-desc">
                <p><?= $row["courseDesc"]  ?></p>
              </div>

              <?php if (!$courseMngr->isUserEnroled($_SESSION["user_id"], $row["courseId"])) { ?>

                <form class="course-front-page-form" action="courseFrontConfirmEnroll.php" method="post">
                  <button name="enrolCourseId" value="<?= $row["courseId"] ?>">ENROL</button>
                </form>
            </div>
          <?php } else { ?>


            <form class="course-front-page-form" action="coursePageDisplay.php" method="post">
              <button name="courseId" value="<?= $row["courseId"] ?>">Open</button>
            </form>
          </div>

        <?php }  ?>


    </div>


<?php   }
      } ?>



  </div>

</div>


</div>




<?php include("../parts/mainParts/footer.php"); ?>


<script>
  $(document).ready(function() {
    $("#homeNavLink").addClass("spg-active-nav");


  });
</script>