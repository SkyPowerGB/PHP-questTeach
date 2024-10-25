<?php include("../parts/mainParts/header.php"); ?>


<?php

include_once("../parts/classes/accounts/account.php");
include_once("../parts/classes/fileUpload.php");
include_once("../parts/mainParts/database.php");
$conn;
$accountObj = new Account($conn);
$fileUVobj = new FileUV();
$username = "";
$email = "";
$pswrd = "";
$rpswrd = "";
$file;
$filePath;
$fail = false;

if (isset($_POST["register-submit"])) {
    $formValid = true;

    $username = $_POST["userNameInput"];
    $email = $_POST["emailInput"];
    $pswrd = $_POST["pswrdInput"];
    $rpswrd = $_POST["pswrdRptInput"];
    $file = $_FILES["fileInput"];

    $username = htmlspecialchars($username);
    $email = htmlspecialchars($email);

    if ($accountObj->registerUserDirect($username, $email, $file, $pswrd, $rpswrd, $fileUVobj)) {
        echo ("succes");
        session_start();
        $_SESSION['user_id'] = $accountObj->userId;
        header("Location: mainpage.php");
    }


    $error = $accountObj->registerErrorCode;
    $emailVcode = $accountObj->emailValidationCode;
    $pswrdVcode = $accountObj->newPswrdValidationCode;
    $usnmVcode = $accountObj->usernameValidationCode;
    $avtrVcode = $accountObj->avatarValidationCode;
    $fail = true;
}

?>

<div class="content main-content">
    <div class="sidebar spg-wider-sidebar">
        <div class="sidebar-wider-background-div">
            <img src="../fielovi/questTeachLogo.png">
            <h1>Quest Teach</h1>
            <img class="sidebar-wide-background" src="../fielovi/default/bcksidebar.png">
        </div>
    </div>

    <div class="content-panel">
        <div></div>

        <div class="div-form-accounts">
            <form class="form-accounts" action="register.php" method="post" enctype="multipart/form-data">
                <div class="form-label-div-accounts">
                    <label id="usnmLbl">Username: *</label>
                </div>
                <input id="userNameInput" type="text" name="userNameInput" value="<?php echo $username; ?>"></input>
                <div class="form-label-div-accounts">
                    <label id="emailLbl">Email: *</label>
                </div>
                <input id="emailInput" type="text" name="emailInput" value="<?php echo $email; ?>"></input>
                <div class="form-label-div-accounts">
                    <label id="avatarLbl">Choose Avatar</label>
                </div>
                <input id="fileInput" type="file" name="fileInput">
                <div class="form-label-div-accounts">
                    <label id="pswrdLbl">Password: *</label>
                </div>
                <input id="pswrdInput" type="password" name="pswrdInput" value="<?php echo $pswrd; ?>"></input>
                <div class="form-label-div-accounts">
                    <label id="pswrdRptLbl">Repeat password: *</label>
                </div>
                <input id="pswrdRptInput" type="password" name="pswrdRptInput" value="<?php echo $rpswrd; ?>"></input>
                <div class="form-div-btn-right">
                    <button type="sumbit" name="register-submit" value="s">Register</button>
                </div>
            </form>
            <button class="form-outer-btn-left" id="loginBtnReg">Login</button>
        </div>
    </div>
</div>


<?php include("../parts/mainParts/footer.php"); ?>

<script>
    function usernameExists() {
    
        $("#usnmLbl").text("Username: * username exists")
        $("#usnmLbl").addClass("spg-txt-error");
        $("#userNameInput").addClass("spg-input-error");
    }

    function usernameV() {
        $("#usnmLbl").text("Username: * cant be empty ")
        $("#usnmLbl").addClass("spg-txt-error");
        $("#userNameInput").addClass("spg-input-error");
    }

    function emailExists() {
        $("#emailLbl").text("Email: * email exists");
        $("#emailLbl").addClass("spg-txt-error");
        $("#emailInput").addClass("spg-input-error");
    }

    function emailV() {
        $("#emailLbl").text("Email: *  incorrect email");
        $("#emailLbl").addClass("spg-txt-error");
        $("#emailInput").addClass("spg-input-error");
    }

    function pswrdNM() {
        $("#pswrdLbl").text("Password: * passwords dont match");
        $("#pswrdRptLbl").text("Repeat password: * passwords dont match");
        $("#pswrdLbl").addClass("spg-txt-error");
        $("#pswrdRptLbl").addClass("spg-txt-error");
        $("#pswrdRptInput").addClass("spg-input-error");
        $("#pswrdInput").addClass("spg-input-error");
    }

    function pswrdV() {
        $("#pswrdLbl").text("Password: * password must be 8 characters long and have at least 1 upper case and 1 lower case");
        $("#pswrdLbl").addClass("spg-txt-error");
        $("#pswrdRptLbl").addClass("spg-txt-error");
        $("#pswrdRptInput").addClass("spg-input-error");
        $("#pswrdInput").addClass("spg-input-error");

    }

    function fileTL() {
        $("#avatarLbl").text("Choose Avatar  file too big");
        $("#avatarLbl").addClass("spg-txt-error");
        $("#fileInput").addClass("spg-input-error");

    }

    function fileEns() {
        $("#avatarLbl").text("Choose Avatar  file extension not suppoted  : jpg ,jpeg ,png");
        $("#avatarLbl").addClass("spg-txt-error");
        $("#fileInput").addClass("spg-input-error");
    }

    function fileOth() {

    }
</script>


<?php
if ($fail) {
    switch ($error) {
        case 1:
            usernameF($usnmVcode);
            break;
            /** username */
        case 2:
            emailF($emailVcode);
            break;
            /** email */
        case 3:
            pswrdF($pswrdVcode);
            break;
            /** pswrd */
        case 4:
            avtrCode($avtrVcode);
            break;
            /** img */
        case 5:
            break;
            /** upload */
        case 6:
            break;
            /** db fail */
        case 7:
            break;
            /** dbreturned null */
    }
}
function usernameF($code)
{
    /** 1exists 2val */

    if ($code == 1) {
        echo ("<script> usernameExists() </script>");
        return;
    }

    echo ("<script> usernameV() </script>");
}
function emailF($code)
{
    /** 1exists 2val */
    if ($code == 1) {
        echo ("<script> emailExists() </script>");
        return;
    }
    echo ("<script> emailV() </script>");
}

function pswrdF($code)
{
    /** 1notMatch 2val */
    if ($code == 1) {
        echo ("<script> pswrdNM() </script>");
        return;
    }
    echo ("<script> pswrdV() </script>");
}

function avtrCode($code)
{
    /** -1too big   -2 extension */
    if ($code == -1) {
        echo ("<script> fileTL() </script>");
    } else if ($code == -2) {
        echo ("<script> fileEns() </script>");
    }
    echo ("<script> fileOth() </script>");
    return;
}


?>