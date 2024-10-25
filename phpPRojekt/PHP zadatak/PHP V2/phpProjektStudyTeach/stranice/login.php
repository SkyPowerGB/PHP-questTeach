<?php include("../parts/mainParts/header.php"); ?>

<?php
include_once("../parts/classes/accounts/account.php");
include_once("../parts/mainParts/database.php");
$username="";
$error ="";
if (isset($_POST["submit"])) {
    $conn;
    $account = new Account($conn);
    $formValid = true;
    $error = false;
    $code;

    $username = $_POST["usernameEmail"];

    $password = $_POST["password"];

    $username = htmlentities($username);

    if ($username == null) {
        $formValid = false;
        $code = -1;
    }

    if ($password == null) {
        $formValid = false;
        $code = -2;
    }

    if ($formValid) {


        if ($account->loginDirect($username, $password)) {
            session_start();
            $_SESSION['user_id'] =  $account->userId;
            header("Location: mainpage.php");
        } else {
            $code = $account->errorCode;
       
            $error = true;
        }
    } else {
        $error = true;
    }
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
        <div class="div-form-accounts">

            <form class="form-accounts" action="login.php" method="post">
                <div class="form-label-div-accounts">
                    <label id="usnmEmLbl">Username or Email: *</label>
                </div>
                <input id="usnmEmIn" type="text" name="usernameEmail" value="<?=$username ?>"></input>
                <div class="form-label-div-accounts">
                    <label id="pswrdLbl">Password: *</label>
                </div>
                <input id="pswrdIn" type="password" name="password"></input>
                <div class="form-div-btn-right">
                    <button type="submit" name="submit" vlaue="submit">Login</button>
                </div>
            </form>
            <button class="form-outer-btn-left" id="registerBtn">register</button>
        </div>
    </div>
</div>

<?php include("../parts/mainParts/footer.php"); ?>

<script>
    function pswrdEmptyJ() {
        $("#pswrdLbl").text("Password: *cant be empty");
        $("#pswrdLbl").addClass("spg-txt-error");
        $("#pswrdIn").addClass("spg-input-error");

    }

    function usnmEmptyJ() {
        $("#usnmEmLbl").text("Username or Email: *cant be empty");
        $("#usnmEmLbl").addClass("spg-txt-error");
        $("#usnmEmIn").addClass("spg-input-error");

    }

    function invalidUpJ() {
        $("#pswrdLbl").text("Password: *");
        $("#pswrdLbl").addClass("spg-txt-error");
        $("#pswrdIn").addClass("spg-input-error");

        $("#usnmEmLbl").text("Username or Email: *Invalid username or password");
        $("#usnmEmLbl").addClass("spg-txt-error");
        $("#usnmEmIn").addClass("spg-input-error");
    }

    function usNotFoundJ() {
        $("#usnmEmLbl").text("Username or Email: *User not found");
        $("#usnmEmLbl").addClass("spg-txt-error");
        $("#usnmEmIn").addClass("spg-input-error");

    }
</script>

<?php
if ($error) {
    switch ($code) {
        case -1:
            usnmEmpty();
            break;
        case -2:
            pswrdEmpty();
            break;
        case 2:
            invalidUP();
            break;
        case 1:
            usNotFound();
            break;
    }
}
function pswrdEmpty()
{
    echo ("<script> pswrdEmptyJ() </script>");
}
function usnmEmpty()
{
    echo ("<script> usnmEmptyJ() </script>");
}
function invalidUP()
{
    echo ("<script> invalidUpJ() </script>");
}
function usNotFound()
{
    echo ("<script> usNotFoundJ() </script>");
}
?>