<?php


class options
{

    public $conn;
    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getCourseTypesList()
    {
        $sql = "SELECT description FROM coursetypes";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            $stmt->close();
            return $res;
        }
        $stmt->close();
        exit();
    }
    function getPageTypesList()
    {
        $sql = "CALL getPageTypeNames";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
        exit();
    }

    function getUserRoles()
    {
        $sql="SELECT role as outpt FROM userroles";

        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute()) {

            $result = $stmt->get_result();
            $stmt->close();

            return $result;
        }
        $stmt->close();
        return false;
    }

    //generate options

    function genCourseTypesOP()
    {
        $options = $this->getCourseTypesList();

        while ($row = $options->fetch_assoc()) {
            echo "<option>" . htmlspecialchars($row['description']) . "</option>";
        }
    }

    function genPageTypeOp()
    {
        $result=$this->getPageTypesList();

        while($row=$result->fetch_assoc()){
            echo "<option>".htmlspecialchars($row['NAME'])."</option>";
        }


    }

    function genUserRoleTypeOptions(){

        $result=$this->getUserRoles();
      
        while($row=$result->fetch_assoc()){
            echo "<option>".htmlspecialchars($row['outpt'])."</option>";
        }

    }
    
}
