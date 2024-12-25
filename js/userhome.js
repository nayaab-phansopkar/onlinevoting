$(document).ready(function () {
    partyname="";
    function checkVote(){
        if($("#party01").prop("checked") == true){
            partyname = "New Alliance Party";
            return true;
        }
        else if($("#party02").prop("checked") == true){
            partyname = "Fatherland Union";
            return true;
        }
        else if($("#party03").prop("checked") == true){
            partyname = "Unionist Party";
            return true;
        }
        else if($("#party04").prop("checked") == true){
            partyname = "United Workers' Party";
            return true;
        }
        else if($("#party05").prop("checked") == true){
            partyname = "Workers' League";
            return true;
        }
        else{
            return false;
        }
    }

    $("#sbmtvote").click(function (e) { 
        e.preventDefault();
        console.log("submit vote Fired")
        var check = checkVote();
        if(!check){
            $("#vote_err").html("<div class='text-danger'>Select atleast one Party</div>");
        }
        else{
            $("#vote_err").html("<br><br>");
            let getAct = "vote"
            let getparty = partyname;
            setAct = {
                party:getparty,
                action: getAct,
            }
            $.ajax({
                type: "POST",
                url: "../controller/index.php",
                data: setAct,
                success: function (response) {
                    console.log(response);
                    resp = JSON.parse(response);
                    if(resp.user_has_voted === true){
                        $("#vote_err").html("<div class='text-danger'>You have already cast your vote. Multiple voting is not allowed.</div>")
                    }
                    else{
                        $("#success_vote").modal('show');
                        setTimeout(function(){
                            $("#success_vote").modal('hide');
                        }, 2000);
                    }
                }
            });
        }
    });

    $("#logout").click(function(e) {
        e.preventDefault();

        setAct={
            action: 'userlogout'
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: setAct,
            success: function (response) {
                pjson = JSON.parse(response);
                if(pjson.success){
                    console.log(pjson.success);
                    window.location.href="http://localhost/onlinevoting/";
                }
                else{
                    console.log("LogOut Error");
                }
            }
        });
    })
});