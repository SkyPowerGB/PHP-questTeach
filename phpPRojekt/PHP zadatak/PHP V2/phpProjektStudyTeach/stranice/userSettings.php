<?php include("../parts/mainParts/header.php"); ?>
<?php include("../parts/mainParts/database.php"); ?>
<?php include("../parts/mainParts/navbar.php"); ?>

<?php
include_once("../parts/classes/accounts/account.php");
include_once("../parts/classes/fileUpload.php");
include_once("../parts/classes/options.php");
include_once("../parts/mainParts/usrChck.php");

$conn;
$accountObj = new Account($conn);
$fileUv = new FileUV();
$optionObj = new options($conn);
$usrAccId;
$AdminEdit = false;
$back = "mainPage.php";

$showWarning=false;
$warning="";

$showMessage=false;
$message="";

if (isset($_SESSION["user_id"])) {
    $usrAccId = $_SESSION["user_id"];
}

if (isset($_POST["Admin_editUsrID"])) {
    $usrAccId = $_POST["Admin_editUsrID"];
    $AdminEdit = true;
    $back = "userManagment.php";
}




if (!(isset($_POST["Admin_editUsrID"]) || isset($_SESSION["user_id"]))) {
    header("Location:login.php");
}


if (isset($_POST["edit"])) {

    $username = "";
    $email = "";
    $password = "";
    $passwordRpt = "";
    $passwordFinal = null;
    $file = null;
    $userRole = null;
    if ($_POST["adminEdit"]) {

        $AdminEdit = $_POST["adminEdit"];
        $usrAccId = $_POST["userId"];
        if (isset($_POST["userRole"])) {

            $userRole = $_POST["userRole"];
        }
    }

    $id = $usrAccId;

    if (isset($_POST["editPassword"])) {

        if (isset($_POST["password"])) {
            $password = $_POST["password"];
        }
        if (isset($_POST["passwordRpt"])) {
            $passwordRpt = $_POST["passwordRpt"];
        }
        if (!is_null($password)) {
            if ($accountObj->validateNewPassword($password, $passwordRpt)) {
                $passwordFinal = $password;
            }
        }
    }

    if(isset($_POST["email"])) {
        $email=htmlentities($_POST["email"]);
        if(!$accountObj->validateEmail($email)) {
            $email="";
        }
     

    }
    if (isset($_POST["username"])) {
        $username = htmlentities($_POST["username"]);
        if (!$accountObj->validateUsername($username)) {
            $username = "";
        }
    }
    if (isset($_FILES["avatarIcon"])) {
        $file = $_FILES["avatarIcon"];
    }



    if ($accountObj->updateUser($id, $username, $file, $email, $passwordFinal, $userRole, $fileUv)) {
        $showMessage=true;
        $message="updated user succefully!";
        }
}

if (isset($_POST["delete"])) {
    $id = $_POST["userId"];
    $myId = $_SESSION["user_id"];
    $gotoLogin = false;
    if ($id == $myId) {
        $gotoLogin = true;
    }

    $isAdmin = $_POST["adminEdit"];
    include_once("../parts/classes/pagesAndCoursesV3/course.php");
    $courseO = new Course($conn);


    $courseO->deleteAllMyData($id, $fileUv);
    $accountObj->readUserData($id);
    $fileUv->deleteFile($accountObj->avatarPath);

    $accountObj->deleteUser($id);



    if ($gotoLogin) {
        header("Location: login.php");
    } else {

        if ($isAdmin) {
            header("Location: userManagment.php");
        } else {
            header("Location: login.php");
        }
    }
}

$accountObj->readUserData($usrAccId);

$emailV = $accountObj->email;
$usernameV = $accountObj->username;
$avatarPthV = $accountObj->avatarPath;
$userRoleV = $accountObj->userRole;


?>


<div class="content main-content">

    <div class="sidebar">

        <div class="sidebar-button-div">
            <a href="<?= $back ?>">Back</a>
        </div>

        <div class="sidebar-button-div">
            <button id="showUserData">Display data</button>
        </div>


        <div class="sidebar-button-div">
            <button id="changeAvatarToggle">Change Avatar</button>
        </div>

        <div class="sidebar-button-div">
            <button id="changeUsernameToggle">Change Username</button>
        </div>

        <div class="sidebar-button-div">
            <button id="changeEmailToggle">Change Email</button>
        </div>

        <div class="sidebar-button-div">
            <button id="changePasswordToggle">Change Password</button>
        </div>

        <?php if ($AdminEdit) { ?>
            <div class="sidebar-button-div">
                <button id="editUserRoleToggle">User Role</button>
            </div>
        <?php } ?>
        <div class="sidebar-button-div">
            <button class="spg-warning" id="deleteAccountToggle">Delete Account</button>
        </div>
    </div>

    <div class="content-panel">

        <div id="displayUserAccountData" class="display-user-account">
            <img src=<?= $avatarPthV ?>>
            <div class="dispaly-ua-row">
                <h2>Username:</h2>
                <p><?= $usernameV ?> </p>
            </div>
            <div class="dispaly-ua-row">
                <h2>Email:</h2>
                <p><?= $emailV ?> </p>
            </div>
                <?php if ($AdminEdit) { ?>
                    <div class="dispaly-ua-row">
                    <h2>Role:</h2>
                    <p><?= $userRoleV ?></p>
                    </div>
                <?php } ?>
            </div>

            <div id="passwordChangeForm" class="div-form-accounts ">
                <form class="form-accounts" action="userSettings.php" method="post">

                    <div class="form-label-div-accounts">
                        <label>Password:</label>
                    </div>
                    <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                    <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">
                    <input type="hidden" name="editPassword">
                    <input type="password" name="password">
                    <div class="form-label-div-accounts">
                        <label>Repeat Password:</label>
                    </div>
                    <input type="password" name="passwordRpt">
                    <button name="edit">Change Password</button>
                </form>
            </div>

            <div id="usernameChangeForm" class="div-form-accounts ">
                <form class="form-accounts" action="userSettings.php" method="post">

                    <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                    <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">
                    <div class="form-label-div-accounts">
                        <label>Change username:</label>
                    </div>
                    <input type="text" name="username">
                    <button name="edit">Change Username</button>
                </form>
            </div>


            <div id="emailChangeForm" class="div-form-accounts ">
                <form class="form-accounts" action="userSettings.php" method="post">

                    <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                    <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">
                    <div class="form-label-div-accounts">
                        <label>Email:</label>
                    </div>
                    <input type="input" name="email">
                    <button name="edit">Change Email</button>
                </form>
            </div>


            <div id="avatarChangeForm" class="div-form-accounts ">
                <form class="form-accounts" action="userSettings.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                    <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">
                    <div class="form-label-div-accounts">
                        <label>Choose File:</label>
                    </div>
                    <input type="file" name="avatarIcon">
                    <button name="edit">Change Avatar</button>
                </form>
            </div>



            <div id="deleteAccountFormConfirm" class="div-form-accounts">
                <form class="form-accounts" action="userSettings.php" method="post">

                    <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                    <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">

                    <p class="text-delete-warning">Warning! if you delete account, its pernament.
                        Courses will be deleted too!
                    </p>
                    <button class="spg-warning" name="delete">Confirm delete account</button>
                </form>
            </div>


            <?php if ($AdminEdit) { ?>

                <div id="userroleChangeForm" class="div-form-accounts ">

                    <form class="form-accounts" action="userSettings.php" method="post">
                        <input type="hidden" name="userId" value="<?= $usrAccId ?>">
                        <input type="hidden" name="adminEdit" value="<?= $AdminEdit ?>">
                        <div class="form-label-div-accounts">
                            <label>Change user role:</label>
                        </div>

                        <select name="userRole" class="form-select-accounts">
                            <?php
                            $optionObj->genUserRoleTypeOptions();
                            ?>
                        </select>

                        <button name="edit">Change User Role</button>
                    </form>
                </div>

            <?php } ?>

        </div>
    </div>



    <?php include_once("../parts/mainParts/warningWindow.php") ?>
<?php include("../parts/mainParts/footer.php"); ?>

<?php include_once("../parts/mainParts/warningWindowP2.php"); ?>


<script>
    $(document).ready(function() {

        $("#avatarChangeForm").hide();
        $("#usernameChangeForm").hide();
        $("#emailChangeForm").hide();
        $("#passwordChangeForm").hide();
        $("#deleteAccountFormConfirm").hide();
        $("#userroleChangeForm").hide();
        $("#showUserData").addClass("spg-active");


        $("#changeAvatarToggle").click(function() {

            $("#avatarChangeForm").show();
            $("#usernameChangeForm").hide();
            $("#emailChangeForm").hide();
            $("#passwordChangeForm").hide();
            $("#deleteAccountFormConfirm").hide();
            $("#displayUserAccountData").hide();
            $("#userroleChangeForm").hide();

            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").addClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");

        });

        $("#changeUsernameToggle").click(function() {

            $("#usernameChangeForm").show();
            $("#avatarChangeForm").hide();
            $("#displayUserAccountData").hide();
            $("#emailChangeForm").hide();
            $("#passwordChangeForm").hide();
            $("#deleteAccountFormConfirm").hide();
            $("#userroleChangeForm").hide();


            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").addClass("spg-active");
        });

        $("#changeEmailToggle").click(function() {

            $("#emailChangeForm").show();
            $("#avatarChangeForm").hide();
            $("#usernameChangeForm").hide();
            $("#displayUserAccountData").hide();
            $("#passwordChangeForm").hide();
            $("#deleteAccountFormConfirm").hide();
            $("#userroleChangeForm").hide();


            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").addClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");
        });

        $("#changePasswordToggle").click(function() {

            $("#passwordChangeForm").show();
            $("#avatarChangeForm").hide();
            $("#usernameChangeForm").hide();
            $("#emailChangeForm").hide();
            $("#displayUserAccountData").hide();
            $("#deleteAccountFormConfirm").hide();
            $("#userroleChangeForm").hide();



            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").addClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");

        });

        $("#deleteAccountToggle").click(function() {
            $("#displayUserAccountData").hide();
            $("#deleteAccountFormConfirm").show();
            $("#avatarChangeForm").hide();
            $("#usernameChangeForm").hide();
            $("#emailChangeForm").hide();
            $("#passwordChangeForm").hide();
            $("#userroleChangeForm").hide();


            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").addClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");

        });

        $("#editUserRoleToggle").click(function() {
            $("#usernameChangeForm").hide();
            $("#userroleChangeForm").show();
            $("#avatarChangeForm").hide();
            $("#displayUserAccountData").hide();
            $("#emailChangeForm").hide();
            $("#passwordChangeForm").hide();
            $("#deleteAccountFormConfirm").hide();



            $("#showUserData").removeClass("spg-active");
            $("#editUserRoleToggle").addClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");
        });

        $("#showUserData").click(function() {
            $("#avatarChangeForm").hide();
            $("#usernameChangeForm").hide();
            $("#emailChangeForm").hide();
            $("#passwordChangeForm").hide();
            $("#deleteAccountFormConfirm").hide();
            $("#userroleChangeForm").hide();


            $("#displayUserAccountData").show();

            $("#showUserData").addClass("spg-active");
            $("#editUserRoleToggle").removeClass("spg-active");
            $("#deleteAccountToggle").removeClass("spg-active");
            $("#changePasswordToggle").removeClass("spg-active");
            $("#changeAvatarToggle").removeClass("spg-active");
            $("#changeEmailToggle").removeClass("spg-active");
            $("#changeUsernameToggle").removeClass("spg-active");

        });



    });
</script>

<?php
if($showWarning){

    showWarning($message);
  
  }else if($showMessage){
  

    showMessage($message);
  
  }
  
  
  
?>

