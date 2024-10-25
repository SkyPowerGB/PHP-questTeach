<?php
class Page
{
    public $conn;

    public $pageId;
    public $pageNum = 1;
    public $courseId = 0;
    public $pageFPVI = "";
    public $pageTitle = "";
    public $pageTxt = "";
    public $pageFileType = "";
    public $errorVar = "";
    public $maxPageNum = 1;


    public function __construct($courseId, $conn)
    {
        $this->courseId = $courseId;
        $this->conn = $conn;
    }
    public function readPageP($pageNum)
    {
        if ($pageNum == 0) {
            return false;
        }

        $sql = "CALL getCoursePage(?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->courseId, $pageNum);


        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();

            $this->pageFileType = $result['name'];
            $this->pageFPVI = $result['video'];
            $this->pageTitle = $result['title'];
            $this->pageTxt = $result['text'];

            $stmt->close();
            $this->errorVar = "Page reading succes";
            return true;
        } else {
            $stmt->close();
            $this->errorVar = "Page reading failed";
            return false;
        }
    }
    public function readPageI()
    {
        $this->readPageP($this->pageNum);
    }

    public function createPage()
    {
        $sql = "SELECT newCoursePage(?,?,?,?,?) AS outV;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", $this->courseId, $this->pageFPVI, $this->pageTitle, $this->pageTxt, $this->pageFileType);
        if ($stmt->execute()) {
            $stmt->close();
            return  $this->readMaxPgNum();
        }
        $stmt->close();
    }

    public function createPageDI($fileFPVI, $pageTitle, $pageTxt, $pageType)
    {
        $this->pageFPVI = $fileFPVI;
        $this->pageTitle = $pageTitle;
        $this->pageTxt = $pageTxt;
        $this->pageFileType = $pageType;
        return $this->createPage();
    }

    /*---------KREIRAJ S DATOTEKOM------------------------------------------------------------------------------*/
    public $createPageWFileFErrCode = 0;
    public function createPageFile($fileUploadO, $pageType, $file, $pageTitle, $pageTxt)
    {

        $validationPass = true;

        $pageFilePath = "";

        $validationPass = $fileUploadO->validatePagefile($pageType, $file);

        if ($validationPass) {

            $fileUploadO->uploadPageFile($file, $pageType);

            $pageFilePath = $fileUploadO->fileDestination;
        } else {

            $pageFilePath = $file;
        }

        if ($validationPass) {
            $sql = "SELECT newCoursePage(?,?,?,?,?) AS outV;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("issss", $this->courseId, $pageFilePath, $pageTitle, $pageTxt, $pageType);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
            $this->createPageWFileFErrCode = 1;
            return false;
        } else {
            $this->createPageWFileFErrCode = 2;
            return false;
        }
    }


    /****************EDITIRAJ S DATOTEKOM********************************************************************************* */
    public $updatePageWuplFErrCode = 0;
    public function updatePageWupldF($fileUploadO, $pageType, $pageNum, $file, $oldFilePth, $pageTitle, $pageTxt)
    {
        //fali kontrola


        $isFile = true;

        $fileValid = true;
        $useOld=false;
        $pageFilePath="";
        

        $isFile = $fileUploadO->isFile($pageType);

      
            $fileUploadO->validatePagefile($pageType,$file);
        
            if(!$isFile){
                $pageFilePath=$file;
            }

        if($isFile){
            if ($fileUploadO->uploadPageFile($file,$pageType)) {
                $fileUploadO->deleteFile($oldFilePth);
                $pageFilePath = $fileUploadO->fileDestination;
            }else{
                $pageFilePath=$oldFilePth;
            }
        }

        $sql = "SELECT updatePageData(?,?,?,?,?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iissss", $this->courseId, $pageNum, $pageFilePath, $pageTitle, $pageTxt, $pageType);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    /****************EDITIRAJ BEZ DATOTEKE*************************************************************************** */

    public $updatePageNFErrCode = 0;
    public function updatePageNF($pageType, $pageNum, $filePath, $pageTitle, $pageTxt)
    {
        $sql = "SELECT updatePageData(?,?,?,?,?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iissss", $this->courseId, $pageNum, $filePath, $pageTitle, $pageTxt, $pageType);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    /*---------------------Brisi datoteku stranice---------------------------------------------------------------------------*/
    public function deletePageFile($fileO, $pageNum)
    {

        $sql = "SELECT video AS patha FROM coursepages WHERE pageNum=? AND courseId=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $pageNum, $this->courseId);
        if ($stmt->execute()) {
            $res = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (isset($res["patha"])) {
                $fileO->deleteFile($res["patha"]);
            }
            return;
        }

        $stmt->close();
    }

    public function delete($pageNum)
    {
        $sql = "SELECT deletePage(?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->courseId, $pageNum);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    function readMaxPgNum()
    {
        $sql = "SELECT getMaxPageNum(?) as num;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->courseId);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            $result = $result["num"];
            $stmt->close();
            $this->maxPageNum = $result;
            return $result;
        } else {
            $stmt->close();
            return -1;
        }
    }


    public function getCousePages()
    {
        $sql = "CALL getCoursePages(?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->courseId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        $stmt->close();
    }

    public function movePageDwn($pageNum)
    {
        $sql = "select movePageDown(?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->courseId, $pageNum);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    public function movePageUp($pageNum)
    {
        $sql = "select movePageUp(?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->courseId, $pageNum);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }




    /*---------------   VALIDACIJA------------------------------------------------------------------------------------------*/

    /*---------------------------------------------------------*/
    public  $validationPageTileErrCode = 0;
    public function validatePageTitle($text)
    {
        $filter = "/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^\w\s]).{5000,}$/";

        if (preg_match($filter, $text)) {
            return true;
        }
        $this->validationPageTileErrCode = 1;
        return false;
    }


    /*---------------------------------------------------------*/
    public  $validationPageTextErrCode = 0;
    public function validatePageText($text)
    {

        $filter = "/[^\w\s]/";

        if (preg_match($filter, $text)) {
            return true;
        }
        $this->validationPageTextErrCode = 1;
        return false;
    }

    /*----------------------------------------------------------------------------- */
    public function validatePageYTvideo($video)
    {
        return true;


        /* $filter = "/[^\w\s]/";

        if (preg_match($filter, $text)) {
            return true;
        }
        $this->validationPageTextErrCode = 1;
        return false; */
    }


    /*-----------------------------------------------------------------------------*/
}
