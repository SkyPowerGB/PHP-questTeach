<div class="navbar-div">
    <?php
    include_once("../parts/mainParts/database.php");
    include_once("../parts/classes/accounts/account.php");
    $userAvatar = " ../fielovi/default/defUsericon.png";
    $usrnm="not logged in";
    $isAdminV = false;
    session_start();
    if (isset($_SESSION['user_id'])) {
        $conn;
        $acc = new Account($conn);
        $id = $_SESSION['user_id'];
        $acc->readUserData($id);
        $userAvatar = " ../fielovi/default/defUsericon.png";
        $usrnm = $acc->username;
        $avtrPth = $acc->avatarPath;
        $role = $acc->userRole;
        if (!($avtrPth == null || $avtrPth == "")) {
            $userAvatar = $avtrPth;
        }
        
        if ($role == "admin") {
            $isAdminV = true;
        }
    }



    ?>

    <ul class="navbar-left">
        <li><a href="mainpage.php"><img src="../fielovi/questTeachLogo.png" class="logo"></a></li>
        <li><a id="homeNavLink" href="mainpage.php">Home</a></li>
        <?php if ($isAdminV) { ?>
            <li><a id="usersNavLink" href="userManagment.php">Users</a></li>
        <?php }  ?>
    </ul>


    <ul class="navbar-right">

        <?php


        $sqlGetUserName = "SELECT username AS username FROM accounts WHERE id=(?)";
        $sqlGetUserAvatar = "SELECT avatar_path as avatar from accounts where id=(?)";
        $username = "warning not logged in!";
        $login = false;



       


        ?>

        <li><a id="myClassesNavLink" href="myCoursepage.php">my Classes</a></li>
        <li><?php echo ($usrnm); ?></li>
        <li><button id="userIconBtn" class="usericon-btn"><img class="usericon" src=<?php echo ($userAvatar); ?>></button></li>


    </ul>

</div>