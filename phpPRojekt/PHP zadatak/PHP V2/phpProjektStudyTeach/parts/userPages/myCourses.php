<div class="item">

    <div class="new-course-div">
        <form class="new-course-form-add-button" action="courseEditor.php" method="POST" class="button-new-course">
            <input type="hidden" name="newCourse" value="new"></input>
            <button class="button-new-course-button"><i class="fa-regular fa-square-plus fa-5x"></i></button>
        </form>
    </div>


</div>

<?php

$editUID=$_SESSION["user_id"];
if(isset($_POST["adminEditCourses"])){
    $editUID=$_POST["adminEditCourses"];
}

include_once("../parts/mainParts/database.php");
$sql = "SELECT * FROM course WHERE authorId = (?);";
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $editUID);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
?>
        <div class="item">
            <div class="course-front-page">
                <img class="course-img" src="<?= $row["courseImg"] ?>" <?php echo $row['courseImg']; ?>>
                <h1><?php echo $row['courseTitle']; ?></h1>
                <div class="course-desc">
                    <p><?php echo $row['courseDesc']; ?></p>
                </div>

                <div class="course-front-page-form-div">
                    <form class="course-front-page-form-ctrl" action="courseEditor.php" method="POST">
                        <input type="hidden" name="courseId" value=<?php echo $row['courseId']; ?>>
                        <button type="submit">Edit </button>
                    </form>

                    <form class="course-front-page-form-ctrl" action="deleteCourse.php" method="POST">
                        <input type="hidden" name="courseId" value=<?php echo $row['courseId']; ?>>
                        <button type="submit" name="delete">delete </button>
                    </form>

                </div>


            </div>
        </div>
<?php
    }
}

$stmt->close();
?>