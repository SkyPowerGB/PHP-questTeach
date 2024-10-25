<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/database.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>


<?php include("..//parts/mainParts/accountPage.php"); ?>

<?php
include_once("../parts/mainParts/usrChck.php");
include_once("../parts/mainParts/adminChck.php");
include_once("../parts/classes/accounts/account.php");
$conn;
$accoutnMngr = new Account($conn);
$accounts = $accoutnMngr->getAllAccounts();

?>



<div class="content main-content">


    <div class="content-panel">
        <div class="content-column">
            <div class="users-table-div">
                <table class="users-table">
                    <thead>

                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Edit user</th>
                        <th>Edit user Courses</th>


                    </thead>

                    <tbody>
                        <?php while ($row = $accounts->fetch_assoc()) {
                            $accAvatar = $row["avatar_path"];
                            $accoutnMngr->readUserData($row["id"]);
                            $userRole = $accoutnMngr->userRole;
                            if ($accAvatar == null || $accAvatar == "") {
                                $accAvatar = "../fielovi/default/defUsericon.png";
                            }
                        ?>
                            <tr>
                                <td><img class="users-table-avatar-img" src="<?= $accAvatar ?>"> </td>
                                <td><?= $row["username"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $userRole ?></td>
                                <td>
                                    <form class="users-table-form" action="userSettings.php" method="post">
                                        <input type="hidden" name="Admin_editUsrID" value="<?= $row["id"] ?>">
                                        <button>Edit</button>
                                    </form>
                                </td>

                                <td>
                                    <form class="users-table-form" action="myCoursePage.php?b1=created" method="post">
                                        <button name="adminEditCourses" value="<?=$row["id"] ?>" >Edit Courses</button>
                                    </form>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>


                </table>
            </div>
        </div>


    </div>


</div>




<?php include("../parts/mainParts/footer.php"); ?>


<script>
$(document).ready(function(){
$("#usersNavLink").addClass("spg-active-nav");

});

</script>