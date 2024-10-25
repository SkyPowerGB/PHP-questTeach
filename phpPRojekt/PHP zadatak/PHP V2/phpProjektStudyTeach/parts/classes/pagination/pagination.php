<?php




/*
obavezno prije

if (isset($_POST["paginationCurrPg"])) {

  $current=$_POST["paginationCurrPg"];
}

*/


class Pagination
{

    public $data;
    public $action;
    public $maxPage;

    public $first;
    public $nOptions;

    public $current = 1;

    public $CssForm = "pagination-form";
    public $CssDiv = "pagination-panel";

    public $CssFormCurr = "pagination-form-curr";

    public $CssFormFirst = "pagination-form";
    public $CssFormLast = "pagination-form";


    public $CssClass = "class=";


    private $nPside = 0;
    private $nNside = 0;


    public function __construct($action, $first, $current, $maxPage, $nOptions)
    {
        $this->action = $action;
        $this->maxPage = $maxPage;
        $this->nOptions = $nOptions;
        $this->first = $first;
        $this->current = $current;

        if ($nOptions % 2 == 0) {
            $nOptions = $nOptions - 1;
            $this->nPside = (int) $nOptions / 2;
            $this->nNside = (int) $nOptions / 2;

            $this->current = $current;
        } else {

            $this->nNside = (int) ($nOptions / 2);
            $this->nPside = (int)$nOptions / 2;
        }
        
    }


    private function recalcPos()
    {
    }
    public function next()
    {
        $this->current++;
        if ($this->current > $this->maxPage) {
            $this->current = $this->maxPage;
            $this->recalcPos();
        }
    }

    public function back()
    {
        $this->current--;
        if ($this->current < $this->first) {
            $this->current = $this->first;
            $this->recalcPos();
        }
    }

    public function first()
    {
        $this->current = $this->first;
        $this->recalcPos();
    }

    public function last()
    {
        $this->current = $this->maxPage;
        $this->recalcPos();
    }

    public function goto($pgNum)
    {
        if ($pgNum > $this->maxPage) {
            $this->current = $this->maxPage;
        }
        if ($pgNum < $this->first) {
            $this->current = $this->first;
        }
        $this->recalcPos();
    }


//pagination logic koristi se poslije kreiranja objekta
    public function generatePaginationLogic($obj)
    {
        $paginationO = $obj;
        if (isset($_POST["paginationOp"])) {

            $op = $_POST["paginationOp"];

            switch ($op) {
                case "First":
                    $paginationO->first();
                    break;

                case "Last":
                    $paginationO->last();
                    break;
                default:
                case "move":
                    if (isset($_POST["paginationCurrPg"])) {

                        $current = $_POST["paginationCurrPg"];

                        $paginationO->current = $current;
                    }
                    break;
                    if (is_int($op)) {
                        $paginationO->goto($op);
                    }
                    break;
            }
        }
    }

//generiraj traku s paginacijom
    public function generatePagination()
    {
        
        echo ("<div class='$this->CssDiv'>");

        // Display First button
        if ($this->current != $this->first) {
            echo ("<form action='$this->action' method='POST' class='$this->CssFormFirst'>");
            echo ("<input type='hidden' name='paginationCurrPg' value=$this->current>");
            echo ("<input type='hidden' name='paginationData' value='$this->data'>");
            echo ("<input type='hidden' name='paginationSPage' value='$this->first'>");
            echo ("<button type='submit' name='paginationOp' value='First'>First</button>");
            echo ("</form>");
        }

        // Display page buttons before
        for ($i = ($this->current - $this->nNside); $i < $this->current; $i++) {

            if ($i >= $this->first && $i < $this->current) {
                echo ("<form action='$this->action' method='POST' class='$this->CssForm'>");
                echo ("<input type='hidden' name='paginationCurrPg' value='$i'>");
                echo ("<input type='hidden' name='paginationData' value='$this->data'>");
                echo ("<input type='hidden' name='paginationSPage' value='$i'>");
                echo ("<button type='submit' name='paginationOp' value='move'>$i</button>");
                echo ("</form>");
            }
        }
        // Display current page num
        echo ("<form action='$this->action' method='POST' class='  $this->CssFormCurr'>");
        echo ("<input type='hidden' name='paginationCurrPg' value='$this->current'>");
        echo ("<input type='hidden' name='paginationData' value='$this->data'>");
        echo ("<input type='hidden' name='paginationSPage' value='$this->current'>");
        echo ("<button type='submit' name='paginationOp' value='$this->current'>$this->current</button>");
        echo ("</form>");

        // Display page buttons after
        for ($i = $this->current; $i < $this->current + $this->nPside; $i++) {
            if ($i > $this->current && $i <= $this->maxPage) {
                echo ("<form action='$this->action' method='POST' class='$this->CssForm'>");
                echo ("<input type='hidden' name='paginationCurrPg' value='$i'>");
                echo ("<input type='hidden' name='paginationData' value='$this->data'>");

                echo ("<input type='hidden' name='paginationSPage' value='$i'>");
                echo ("<button type='submit' name='paginationOp' value='move'>$i</button>");
                echo ("</form>");
            }
        }


        // Display Last button
        if ($this->current != $this->maxPage) {
            echo ("<form action='$this->action' method='POST' class='$this->CssFormLast'>");
            echo ("<input type='hidden' name='paginationCurrPg' value='$this->current'>");
            echo ("<input type='hidden' name='paginationData' value='$this->data'>");
            echo ("<input type='hidden' name='paginationSPage' value='$this->maxPage'>");
            echo ("<button type='submit' name='paginationOp' value='Last'>Last</button>");
            echo ("</form>");
        }

        echo ("</div>");
    }
    

//generiraj traku s paginacijom AJAX



}

