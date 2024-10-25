
$(document).ready(function () {
    //********************************************************** */
    $("#loginBtnReg").click(function () {



        window.location.href = "login.php";


    });

    $("#registerBtn").click(function () {



        window.location.href = "register.php";


    });


    //********************************************************** */
    $("#userIconBtn").click(function () {
        $(".drop-down-user-menu").toggle();


    })



    //-------------------------------------------------------------------*/




    $("#warningBtnClose").click(function () {
        $(".warning-msg-window").slideToggle(100);
    });



    //**SHEARCH AJAX */
    $("#shrchForm").submit(function(event) {
        event.preventDefault();
        
        // Get the value of the input field
        var shearch = $("#shrchV").val();
        
        $.ajax({
            url: "mainpage.php",
            method: "GET",
            data: { shearch: shearch },
            success: function(response) {
                $("body").html(response);
            },
            error: function(xhr, status, error) {
                console.log(response);
            }
        });
    });

    //****** MY CLASSES AJAX */
    $("#emFormMyClss").submit(function(event){
        event.preventDefault();
    });

    

    $("#enroledBtn").click(function(){
        submitForm("enroled");
    });
    
    $("#mineBtn").click(function(){
        submitForm("created");
    });




});

function closeWrn() {
    $(".warning-msg-window").slideToggle(1);
}
function warn($msg) {

    $(".warning-msg-window").addClass("spg-warning-window-err");
    $("#warningMSG").text($msg);
    $(".warning-msg-window").slideToggle(200);
}

function ok($msg) {

    $(".warning-msg-window").addClass("spg-warning-window-ok");
    $("#warningMSG").text($msg);
    $(".warning-msg-window").slideToggle(200);
}



function submitForm(value) {
 
    var formData = $("#emFormMyClss").serialize();

    formData += "&b1=" + value;
    
    $.ajax({
        url: "myCoursePage.php",
        type: "GET",
        data: formData,
        success: function(response){
        
          
            $("body").html(response);
        },
        error: function(xhr, status, error){
          
            console.error(xhr, status, error);
        }
    });
}