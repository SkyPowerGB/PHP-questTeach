<?php

class Account
{
    public $conn;


    public $userId;
    public $username;
    public $userRole;

    public $avatarPath;
    public $email;
    public $password;

    public $errorCode;
    public $anyErrors;

    public $registerErrorCode;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    /* 
    registerErrorCode
    1->username validation fail
    2->email fail
    3->passwordFail
    4->image failed;
    5->uppload fail
    6->db fail;
    7->db returned null
    */
    public function registerUserDirect($username, $email, $file, $password, $passwordRpt, $fileUVobj)
    {
        if (!$this->validateUsername($username)) {
            $this->registerErrorCode = 1;
            return false;
        }
        if (!$this->validateEmail($email)) {
            $this->registerErrorCode = 2;
            return false;
        }
        if (!$this->validateNewPassword($password, $passwordRpt)) {
            $this->registerErrorCode = 3;
            return false;
        }

        $filePath = "";
        if (!$this->validateUserAvatar($fileUVobj, $file)) {
            $this->registerErrorCode = 4;
            $filePath = "";
        }

        if ($fileUVobj->uploadAvatarFile($file)) {
            $this->registerErrorCode = 5;
            $filePath = $fileUVobj->fileDestination;
        };

        $passwordHshed = password_hash($password, PASSWORD_DEFAULT);
        /*SELECT createNewUser(?usnm,?eml,?avatar,?pswrd); */
        $sql = "SELECT createNewUser(?,?,?,?) as res;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $filePath, $passwordHshed);
        if ($stmt->execute()) {

            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (is_null($result["res"])) {
                $fileUVobj->deleteFile($filePath);
                $this->registerErrorCode = 7;
                return false;
            }

            $this->userId = $result["res"];
            return true;
        }
        $stmt->close();
        $fileUVobj->deleteFile($filePath);

        $this->registerErrorCode = 6;
        return false;
    }


    /* 1->username or password*/
    public function loginDirect($username, $password)
    {

        if (!$this->readUserIdbyCrediental($username)) {
            $this->errorCode = 1;
            return false;
        }
        $this->errorCode = 2;
        if (!$this->getUserPassword($this->userId)) {
            return false;
        }


        return password_verify($password, $this->password);
    }
    // uzmi user id prek emaila ili username
    public function readUserIdbyCrediental($crediental)
    {
        $sql = "CALL getUserByCredentials(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $crediental);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $this->userId = $res["user_id"];
            if (is_null($res["user_id"])) {
                return false;
            }
            return true;
        }
        $stmt->close();
        return false;
    }

    public function readUserData($userId)
    {
        $sql = "call readUserData(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();

            $stmt->close();
            if (!is_null($res["username"])) {
                $this->userId = $res["id"];
                $this->username = $res["username"];
                $this->userRole = $res["role"];
                $this->email = $res["email"];
                $this->avatarPath = $res["avatar_path"];
                return true;
            }

            return false;
        }

        return false;
    }

    public function isAdmin($userId)
    {
        $this->readUserData($userId);
        if ($this->userRole == "admin") {
            return true;
        }
        return false;
    }

    public function deleteUser($userId)
    {
        $sql = "DELETE FROM accounts WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }


    public $updateUserErrorCode;
    /* WARNING ROVJERI SIFRU PRIJE
     
     */
    public function updateUser($userId, $username, $file, $email, $password, $role, $fileUVobj)
    {
        
        $pswrdHsh = null;
        if ($password != null || $password != "") {
            $pswrdHsh = password_hash($password, PASSWORD_DEFAULT);
        }
        $avatar_path = "";


        if (!is_null($username)) {
            if ($this->usernameExists($username)) {
                return false;
            }
        }

        if (!is_null($email)) {
            if (!$this->validateEmail($email)) {
                $email = null;
            }
        }
        if (!is_null($file)) {
            if ($fileUVobj->validateImageFile($file)) {
                if ($fileUVobj->uploadAvatarFile($file)) {
                    $avatar_path = $fileUVobj->fileDestination;
                    $this->readUserData($userId);
                    $fileUVobj->deleteFile($this->avatarPath);
                } else {
                    $fileUVobj->deleteFile($file);
                }
            }
        }

        /*SELECT updateUserAccount(id,"username", "mail","avatarPath","password","role" ); */
        $sql = "SELECT updateUserAccount(?,?,?,?,?,?) as otp;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssss", $userId, $username, $email, $avatar_path, $pswrdHsh, $role);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result["otp"];
        }
        $stmt->close();
        return false;
    }


    public function getUserPassword($userId)
    {
        $sql = "SELECT PASSWORD as pswrd FROM accounts WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $this->password = $res["pswrd"];
            return true;
        }
        $stmt->close();
        return;
    }

    public function getAllAccounts()
    {

        $sql = "CALL getAllUserAccounts();";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
        return false;
    }

    /*-------------------------------------------------------------------------------------- */
    public function usernameExists($username)
    {
        $sql = "select usernameExists(?) as outpt;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return  $result["outpt"];
        }
        $stmt->close();
        return false;
    }
    public function emailExists($email)
    {
        $sql = "select emailExists(?) as outpt;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return  $result["outpt"];
        }
        $stmt->close();
        return false;
    }
    /*-------------------------------------------------------------------------------------------------- */
    /*////VALIDATION ///////////////////////////////////////////////////////////////////////////////////////////// */
    /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */
    /*1->email exists         2->email not valid */
    public $emailValidationCode;
    public function validateEmail($email)
    {
        if ($this->emailExists($email)) {
            $this->emailValidationCode = 1;
            return false;
        }
        $filter = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
        if (preg_match($filter, $email)) {
            return true;
        }
        $this->emailValidationCode = 2;
        return false;
    }

    public $pswrdValidationCode;
    public function validatePassword($password)
    {
        $filter = "/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/";
        $this->pswrdValidationCode = 0;
      
            if (preg_match($filter, $password)) {
            return true;
        }
         $this->pswrdValidationCode=1;
        return false;
    }

    /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */
    /* 1->pasword dont match   2->password doesnt meet criteria error */
    public $newPswrdValidationCode;
    public function validateNewPassword($password, $passwordRpt)
    {
        if ($this->validatePassword($password)) {

            if ($password == $passwordRpt) {
                return true;
            } else {

                $this->newPswrdValidationCode = 1;
                return false;
            }
        }
        $this->newPswrdValidationCode = 2;
        return false;
    }

    /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */
    /*1->username exists    2->validation criteria not passed */
    public $usernameValidationCode;
    public function validateUsername($username)
    {
        if ($this->usernameExists($username)) {
            $this->usernameValidationCode = 1;
            return false;
        }

        $filter = "/^[a-z0-9_\.-]+$/i";
        if (preg_match($filter, $username)) {
            return true;
        }
        $this->usernameValidationCode = 2;
        return false;
    }

    /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */
    /*      -1 -> file too big  -2->file extension not supoorteed   1-8 file errors        */
    public $avatarValidationCode;
    public function validateUserAvatar($fileUVobj, $file)
    {
        if ($fileUVobj->validateImageFile($file)) {
            return true;
        }
        $this->avatarValidationCode = $fileUVobj->errorCode;
        return false;
    }
}
