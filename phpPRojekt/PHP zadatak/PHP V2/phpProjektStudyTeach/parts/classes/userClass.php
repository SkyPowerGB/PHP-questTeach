<?php


class User{


public $userId;
public $username;
public $role;
public $conn;

 function __construct($uid ,$conn)
 {
    $sql="SELECT username,role FROM accounts JOIN userroles ON userroles.roleId=accounts.role_id WHERE id=?";
    $this->userId=$uid;
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$uid);
if($stmt->execute()){
$result=$stmt->get_result()->fetch_assoc();

$this->username=$result["username"];
$this->role=$result["role"];
$stmt->close();
return;
}
$stmt->close();

exit();
}

}