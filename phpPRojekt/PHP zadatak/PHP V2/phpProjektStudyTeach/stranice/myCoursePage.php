<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>
<?php 
include_once("../parts/classes/pagesAndCoursesV3/course.php");
?>

<?php
include_once("../parts/mainParts/usrChck.php");



if (!isset($_SESSION["user_id"])) {
} else {
  header("login.php");

}
$enroled=true;
$adminEdit=false;
$editUID=$_SESSION["user_id"];
if(isset($_POST["adminEditCourses"])){
    $editUID=$_POST["adminEditCourses"];
}

?>

<div class="content main-content">

<?php include("../parts/mainParts/accountPage.php");?>


  <div class="sidebar">


    <div class="classes-btns">

      <form id="emFormMyClss" class="classes-btns-form" action="myCoursePage.php" method="get">
       
        <button id="enroledBtn" type="submit" name="b1" value="enroled">Enroled </button>
        <button id="mineBtn" type="submit" name="b1" value="created">Created </button>
      </form>
    </div>


  </div>

  <div class="content-panel">

    <div class="course-list">
      <?php
      if (isset($_GET["b1"])) {

        if ($_GET["b1"] === "created") {  $enroled=false;
          include("../parts/userPages/myCourses.php");
          
        } else {

          include("../parts/userPages/enroledCorses.php");
        }
        
      }else{
        include("../parts/userPages/enroledCorses.php");

      }

      ?>

    </div>


  </div>




</div>


<?php include("../parts/mainParts/footer.php"); ?>

<?php
if(!$enroled){
echo('<script>$("#mineBtn").addClass("spg-active");
$("#enroledBtn").removeClass("spg-active"); </script>');
}else{

echo('<script> $("#enroledBtn").addClass("spg-active");
$("#mineBtn").removeClass("spg-active");</script>');
}
?>

<script>
$(document).ready(function(){
$("#myClassesNavLink").addClass("spg-active-nav");

});

</script>