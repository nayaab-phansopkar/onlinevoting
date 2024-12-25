$(document).ready(function() {
    $("#mail").on("input", function() {
        checkmail();
    });
                                                                //To validate inputs
    $("#pass").on("input", function() {
        checkpass();
    });

    $("#mail, #pass").on("keypress", function(e) {
        if(e.which === 13){
            $("#logbtn").click();
        }
    })

    //on clicking login following code will execute. 
    $("#logbtn").click(function(e) { 
        e.preventDefault();
        console.log("Login Button Event Fired");
        let emptyInputCount = 0;

        $("#logform input").each(function(){
            var input = $(this);
            if(input.val() == ''){
                input.css('border-color','red');
                emptyInputCount = 1;
            }                                                       //Checks if input fields are empty
            else{
                input.css('border-color','#ced4da');
            }
        });

        if(emptyInputCount !== 0){
            $('#resp').html('<div class="alert alert-warning">Email and Password Required</div>');
        }
        else if(!checkmail() && !checkpass()){
            $('#resp').html('<div class="alert alert-warning">Error! Check below for more details</div>');
        }
        else if(!checkmail() || !checkpass()){
            $('#resp').html('<div class="alert alert-warning">Error in one or more Fields</div>');
        }
        else{
                
                let getmail = $("#mail").val();
                let getpass = $("#pass").val();
                let getact = $("#action").val();
    
                credentials = {
                    email: getmail,
                    pass: getpass,
                    action: getact,
                }

                $.ajax({
                    type: "post",
                    url: "./controller/index.php",
                    data: credentials,
                    success: function (response) {
                        console.log(credentials);
                        console.log(response);
                        parseJson = JSON.parse(response);
    
                        if(parseJson.admin){
                            console.log(parseJson.admin);
                            $('#resp').html('<div class="alert alert-success">'+parseJson.admin+'</div>');
                            window.location.href="http://localhost/onlinevoting/view/admindash.php";
                        }
                        else if(parseJson.adminError){
                            $('#resp').html('<div class="alert alert-warning">'+parseJson.adminError+'</div>');
                        }
                        else if(parseJson.user){
                            console.log(parseJson.user);
                            $('#resp').html('<div class="alert alert-success">'+parseJson.user+'</div>');
                            window.location.href="http://localhost/onlinevoting/view/userhome.php";
                        }
                        else if(parseJson.userError){
                            $('#resp').html('<div class="alert alert-warning">'+parseJson.userError+'</div>');
                        }
                        else{
                            $('#resp').html('');
                        }
                    }
                });
        }   
    });
});

function checkmail(){
    var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var mail = $("#mail").val();
    var validmail = valid.test(mail);
    if(!validmail){
        $("#email_err").html("<div class='text-danger'>Enter a valid email.</div>");
        return false;
    }
    else{
        $("#email_err").html('<br>');
        return true;
    }
}

function checkpass(){
    var valid = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    var pass = $("#pass").val();
    var validpass = valid.test(pass);
    if(!validpass){
        $("#pass_err").html("<div class='text-danger'>Password should contain letters, numbers and special characters. Length = 6-16</div>")
        return false;
    }
    else{
        $("#pass_err").html('<br><br>');
        return true;
    }
}