<?php

include_once("../parts/classes/pagesAndCoursesV3/page.php");

include_once("../parts/classes/pagesAndCoursesV3/course.php");
include_once("../parts/classes/options.php");
include_once("../parts/classes/fileUpload.php");

$conn;
if (!isset($_POST["courseId"])) {

    header("Location: mainpage.php");
}





$id = $_POST["courseId"];



$course = new Course($conn);
$course->courseId = $id;

$options = new options($conn);


if (isset($_POST["deletePageForm"])) {

    $page = new Page($course->courseId, $conn);
    $fileO = new FileUV();
    $toDelete = $_POST["deletePageForm"];
    $page->deletePageFile($fileO, $toDelete);
    $page->delete($toDelete);
}


if (isset($_POST["moveDwnForm"])) {
    $pgNum = $_POST["moveDwnForm"];
    $page = new Page($course->courseId, $conn);
    $page->movePageDwn($pgNum);
}

if (isset($_POST["moveUpForm"])) {
    $pgNum = $_POST["moveUpForm"];
    $page = new Page($course->courseId, $conn);
    $page->movePageUp($pgNum);
}




?>


<div class="content-colums ">


    <div class="new-page-form-div ">

        <form class="new-page-form-form" action="pageEditorV2.php" method="post">
            <div class="new-page-form-lbl-div"><label>Choose page type: *</label></div>
            <select name="pageType"> <?php $options->genPageTypeOp(); ?> </select>
            <input type="hidden" name="cid" value=<?= $id ?>>

            <button name="newPage" value="<?= $id ?>">+ New Page</button>

        </form>

    </div>


    <div class="pages-list-table-div ">
        <table class="pages-list-table">
            <thead>
                <tr>
                    <th>Page number</th>
                    <th>Page title</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php

                $result = $course->getCousePages();

                while ($red = $result->fetch_assoc()) {
                    echo ("<tr>");
                    echo ("<td>$red[pageNum]</td>");
                    echo ("<td>$red[title]</td>");


                    echo ("<td>");
                ?>
                    <form  class="page-list-ctrl-btn-form"   action="courseEditor.php" method="post">
                        <input type="hidden" name="courseId" value="<?= $id ?>">
                        <input type="hidden" name="frontPage" value="<?=false?>">
                        <button type="submit" name="moveUpForm" value="<?= $red["pageNum"] ?>"><i class="fas fa-arrow-up"></i></button>
                    </form>
                    <?php
                    echo ("</td>");



                    echo ("<td>");
                    ?>
                    <form class="page-list-ctrl-btn-form"  action="courseEditor.php" method="post">
                        <input type="hidden" name="courseId" value="<?= $id ?>">
                        <input type="hidden" name="frontPage" value="<?=false?>">
                        <button type="submit" name="moveDwnForm" value="<?=$red["pageNum"] ?>"><i class="fas fa-arrow-down"></i></button>
                    </form>
                    <?php
                    echo ("</td>");



                    echo ("<td>");
                    ?>
                    <form class="page-list-ctrl-btn-form"  action="pageEditorV2.php" method="post">
                        <input type="hidden" name="cid" value="<?= $id ?>">
                      
                        <input type="hidden" name="pageType" value="<?= $red["name"] ?>">
                        <input type="hidden" name="pageNum" value="<?= $red["pageNum"] ?>">
                        <button type="submit" name="editPageForm" value="<?= $red["pageNum"] ?>">
                            <i class="fas fa-pencil-alt"></i>
                            Edit</button>
                    </form>
                    <?php
                    echo ("</td>");





                    echo ("<td>");
                    ?>
                    <form class="page-list-ctrl-btn-form"  action="courseEditor.php" method="post">
                        <input type="hidden" name="courseId" value="<?= $id ?>">
                        <input type="hidden" name="frontPage" value="<?=false?>">
                        <input type="hidden" name="frontPage" value="<?= false ?>"></input>
                        <button type="submit" name="deletePageForm" value="<?= $red["pageNum"] ?>">delete</button>
                    </form>
                <?php
                    echo ("</td>");


                    echo ("</tr>");
                }

                ?>
            </tbody>
        </table>
    </div>

</div>