<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>


<?php




include_once("../parts/classes/userClass.php");
include_once("../parts/mainParts/usrChck.php");
include_once("../parts/classes/pagesAndCoursesV3/course.php");
include_once("../parts/classes/pagesAndCoursesV3/page.php");

include_once("../parts/mainParts/database.php");
$conn;
$courseId = null;
if (isset($_POST['courseId'])) {
  $courseId = $_POST['courseId'];
}

$courseId;
$isFrontPageEditor = true;

$frontPage = true;

if (isset($_POST['frontPage'])) {

  $frontPage = $_POST['frontPage'];
}


$course = new Course($conn);
$course->courseId = $courseId;
$pages = $course->getCousePages();


$showWarning = false;
$warning = "";


$showMessage = false;
$message = "";




?>

<?php include("..//parts/mainParts/accountPage.php"); ?>

<div class="content main-content">
  <div class="sidebar">

    <div class="classes-btns">

      <form class="classes-btns-form" action="myCoursePage.php?" method="get">

        <button type="submit" name="b1" value="created">Back</button>
      </form>


    </div>
    <?php if (!is_null($courseId)) { ?>
      <div class="classes-btns">
        <form class="classes-btns-form" action="courseEditor.php" method="post">
          <input type="hidden" name="courseId" value="<?= $course->courseId ?>"></input>
          <input type="hidden" name="frontPage" value="<?= true ?>"></input>
          <button id="FPbtn" name="editCourse" type="submit" value="created">Fornt-Page</button>
        </form>
      </div>


      <div class="classes-btns">
        <form class="classes-btns-form" action="courseEditor.php" method="post">
          <input type="hidden" name="courseId" value=<?= $courseId ?>>
          <input type="hidden" name="frontPage" value="<?= false ?>"></input>
          <button id="PLbtn" type="submit" name="b1" value="created">Pages</button>
        </form>
      </div>
    <?php } ?>


  </div>

  <div class="content-panel">
    <?php

    if ($frontPage) {
      include_once("../parts/courseEditor/frontPageEditorPart.php");
    } else {
      include_once("../parts/courseEditor/pagesListPart.php");
    }
    ?>

  </div>

</div>

<?php

if (isset($_GET["ceditorForm"])) {
  echo ("fak");
}

?>
<?php include_once("../parts/mainParts/warningWindow.php") ?>


<?php include("../parts/mainParts/footer.php"); ?>


<?php include_once("../parts/mainParts/warningWindowP2.php");

if ($showWarning) {

  showWarning($message);
} else if ($showMessage) {



  showMessage($message);
}


if ($frontPage) {
  echo ('<script>
  $("#FPbtn").addClass("spg-active");
  $("#PLbtn").removeClass("spg-active");
</script>');
} else {
  echo ('<script>
  $("#PLbtn").addClass("spg-active");
  $("#FPbtn").removeClass("spg-active");
</script>');
}

?>