$(document).ready(function () {

    var rpp = 5;
    var input = 0;

    //Function to get total number of records in the table
    function getCount(){
        numofrec = 0;
        count = {
            action: "getCount",
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: count,
            async:false,
            success: function (response) {
                // console.log(response);
                resp = JSON.parse(response);
                if(resp.length > 0){
                    numofrec = resp.length;
                    // console.log(numofrec);
                }
                else{
                    console.log("Count Error");
                }
            }
        });
        return numofrec;
    }


    //Function to print total page buttons(pagination)
    function printPageBrowse(recs){
        numberbuttons="";
        if(recs<rpp){
            numberbuttons = "";
            $("#rec_pages").html(numberbuttons);
        }
        else{
            total = Math.ceil(recs/rpp);
            // console.log(total);
            for(i = 1 ; i <= total ; i++){
                numberbuttons += "<li class='page-item' id='getpagevalue' value=" + i + " id='page-item' style='display: table-cell;''><a class='page-link'>"+ i +"</a></li>";
            }
            $("#rec_pages").html(numberbuttons);
        }
    }

    var bid = 1;

    function showData(recspp) { 
        count = getCount();
        output="";
        let getact='showdata'
        whichpage={
            pageNo: bid,
            rpp: recspp,
            action: getact
        }
        console.log(whichpage);
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: whichpage,
            success: function (respons) {
                // console.log(respons);
                resp = JSON.parse(respons);
                if(resp.length == 0){
                    console.log("No Data Found");
                    $("#msg").html("<div class='alert alert-info'>No Electors Found. Add Electors by clicking 'Add Elector' Button</div>");
                    $("#tbody").html('');
                }
                else{
                    printPageBrowse(count);
                    for(i = 0 ; i < resp.length ; i++){
                        output += "<tr><td>" + resp[i].name + "</td><td>" + resp[i].username + "</td><td>" + resp[i].email + "</td><td>Encrypted</td><td>" + resp[i].dob +"</td><td>" + resp[i].gender +"</td><td>" + resp[i].address +"</td><td>" + resp[i].booth + "</td></tr>";
                    }
                    $("#msg").html('');
                    $("#tbody").html(output);
                }
            }
        });
    }
    showData(rpp);            //Calling showData()


    //Sets button id to the number on which user clicks, to load that particular page
    $("#paginate").on("click", ".page-item", function(){
        bid = $(this).val();
        console.log(bid);
        showData(rpp);
    })

    $("#recperpage").on("input", function () {
        input = $(this).val();
    });

    $("#rppbtn").click(function (e) { 
        e.preventDefault();
        console.log("Go button Fired");
        
        if(input > 0){
            rpp = input;
        }
        showData(rpp);
        // console.log(rpp);
    });


    function setElectorAddBlank(){
        $("#elecname").val('');
        $("#elecuser").val('');
        $("#elecmail").val('');
        $("#elecpass").val('');
        $("#elecdob").val('');
        $("#elecgenmale").prop("checked", false);
        $("#elecgenfemale").prop("checked", false);
        $("#elecgenother").prop("checked", false);
        $("#elecaddr").val('');
        $("#elecbooth").val('');
    }


    $("#addelector").click(function (e) { 
        e.preventDefault();

        $("#addelectormodal").modal('show');

        $("#elecname").on("input", function () {
            checkElecName();
        }); 
        $("#elecuser").on("input", function () {
            checkElecUser();
        });
        $("#elecmail").on("input", function () {
            checkElecMail();
        });
        $("#elecpass").on("input", function () {
            checkElecPass();
        });
        $("#elecdob").on("input", function () {
            checkElecDOB();
        });
        $("#elecaddr").on("input", function () {
            checkElecAddr();
        });
        $("#elecbooth").on("input", function () {
            checkElecBooth();
        });
        gSet="";

    });

    function checkElecGender(){
        if($("#elecgenmale").prop("checked") == true){
            gSet = "male";
            return true;
        }
        else if($("#elecgenfemale").prop("checked") == true){
            gSet = "female";
            return true;
        }
        else if($("#elecgenother").prop("checked") == true){
            gSet = "other";
            return true;
        }
        else{
            return false;
        }
    }

    $("#registerelector").click(function (e) { 
        e.preventDefault();
        console.log("Register Fired");
        let emptyInputCount = 0;
        check = checkElecGender();

        $("#addelectorform input").each(function(){
            var input = $(this);
            if(input.val() == '' && !checkElecBooth()){
                input.css('border-color','red');
                emptyInputCount = 1;
            }                                                       //Checks if input fields are empty
            else{
                input.css('border-color','#ced4da');
            }
        });

        
        if(!check){
            $("#addelec-gen_err").html("<div class='text-danger'>Select a Gender</div>");
            emptyInputCount = 1;
        }
        else{
            $("#addelec-gen_err").html('<br><br>')
        }
        if(emptyInputCount != 0){
            $("#addelectormodalresp").html('<div class="alert alert-warning">All Fields Required</div>');
        }
        else if(!checkElecName() && !checkElecUser() && !checkElecMail() && !checkElecPass() && !checkElecDOB() && !checkElecAddr() && !checkElecBooth() && !check){
            $("#addelectormodalresp").html('<div class="alert alert-warning">Enter Valid Details</div>');
        }
        else if(!checkElecName() || !checkElecUser() || !checkElecMail() || !checkElecPass() || !checkElecDOB() || !checkElecAddr() || !checkElecBooth() || !check){
            $("#addelectormodalresp").html('<div class="alert alert-warning">Error in one or more Fields</div>');
        }
        else{
            $("#addelectormodalresp").html('<br>');

            let getElecName = $("#elecname").val();
            let getElecUser = $("#elecuser").val();
            let getElecMail = $("#elecmail").val();
            let getElecPass = $("#elecpass").val();
            let getElecDOB = $("#elecdob").val();
            let getElecGend = gSet;
            let getElecAddr = $("#elecaddr").val();
            let getElecBooth = $("#elecbooth").val();
            let getAct = "addElector";

            electorData = {
                name: getElecName,
                user: getElecUser,
                mail: getElecMail,
                pass: getElecPass,
                dob: getElecDOB,
                gender: getElecGend,
                address: getElecAddr,
                booth: getElecBooth,
                action: getAct
            }

            $.ajax({
                type: "POST",
                url: "../controller/index.php",
                data: electorData,
                success: function (response) {
                    console.log(response);
                    resp = JSON.parse(response);
                    if(resp.success){
                        $("#addelectormodal").modal('hide');
                        $("#success_elector_add").modal('show');
                        setTimeout(function(){
                            $("#success_elector_add").modal('hide');
                        }, 2000);
                        showData(rpp);
                        setElectorAddBlank();
                    }
                    else{
                        console.log(resp.error);
                    }
                }
            });
        }
    });

    $("#closeaddelector").click(function (e) { 
        e.preventDefault();
        
        setElectorAddBlank();
        $("#addelectormodal").modal('hide');
    });

    $("#votingresult").click(function (e) { 
        e.preventDefault();
        
        window.location.href="http://localhost/onlinevoting/view/result.php";
    });


    $("#resetvotes").click(function (e) { 
        e.preventDefault();
        
        $("#reset_election").modal('show');
    });

    $("#closeReset").click(function (e) { 
        e.preventDefault();
        
        $("#reset_election").modal('hide');
    });

    $("#confirmReset").click(function (e) { 
        e.preventDefault();
        
        let getAct = "ResetVotes";
        setAct = {
            action: getAct,
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: setAct,
            success: function (response) {
                console.log(response);
                showData(rpp);
            }
        });
    });


    $("#searchinput").on("input", function () {
        output="";
        if($(this).val() == ''){
            showData(rpp);
        }
    });

    //Search Button Code
    $("#searchbtn").click(function (e) { 
        console.log("Search Fired");
        e.preventDefault();
        let getSearch = $("#searchinput").val();
        searchdata = {
            searchVal: getSearch,
            action: "search",
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: searchdata,
            success: function (response) {
                console.log(response);
                res = JSON.parse(response);
                console.log(res.length);
                if(res.length > 0){
                    for(i = 0 ; i < res.length ; i++){
                        output += "<tr><td>" + res[i].name+ "</td><td>" + res[i].username + "</td><td>" + res[i].email + "</td><td>Encrypted</td><td>" + res[i].dob + "</td><td>" + res[i].gender + "</td><td>" + res[i].address + "</td><td>" + res[i].booth + "</td></tr>";
                    }
                    $("#tbody").html(output);
                }
            }
        });
    });


    $("#logout").click(function (e) { 
        e.preventDefault();
        console.log("LogOut Fired");
        let getact = "adminlogout";

        homedata = {
            action: getact,
        }

        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: homedata,
            success: function (response) {
                console.log(response);
                parseJson = JSON.parse(response);
                if(parseJson.success){
                    window.location.href="http://localhost/onlinevoting/";
                }
                else{
                    console.log("LogoutError");
                }
            }
        });
    });
});




function checkElecName(){
    var valid = /^[a-z ,.'-]+$/i;
    var name = $("#elecname").val();
    var validname = valid.test(name);
    if(!validname){
        $("#addelec-name_err").html("<div class='text-danger'>Enter a valid Name.</div>");
        return false;
    }
    else{
        $("#addelec-name_err").html('<br>');
        return true;
    }
}
function checkElecUser(){
    var valid = /^[a-z._]+$/i;
    var name = $("#elecuser").val();
    var validname = valid.test(name);
    if(!validname){
        $("#addelec-user_err").html("<div class='text-danger'>Username should contain letters, dot and underscore</div>");
        return false;
    }
    else{
        $("#addelec-user_err").html('<br>');
        return true;
    }
}
function checkElecMail(){
    var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var mail = $("#elecmail").val();
    var validmail = valid.test(mail);
    if(!validmail){
        $("#addelec-mail_err").html("<div class='text-danger'>Enter a valid email.</div>");
        return false;
    }
    else{
        $("#addelec-mail_err").html('<br>');
        return true;
    }
}
function checkElecPass(){
    var valid = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    var pass = $("#elecpass").val();
    var validpass = valid.test(pass);
    if(!validpass){
        $("#addelec-pass_err").html("<div class='text-danger'>Password should contain letters, numbers and special characters. Length = 6-16</div>")
        return false;
    }
    else{
        $("#addelec-pass_err").html('<br>');
        return true;
    }
}
function checkElecDOB(){
    var dob = $("#elecdob").val();
    if(dob == ''){
        $("#addelec-dob_err").html("<div class='text-danger'>Enter BirthDate</div>");
        return false;
    }
    else{
        $("#addelec-dob_err").html('<br>');
        return true;
    }
}
function checkElecAddr(){
    var valid = /^[a-z0-9 ,.'-]+$/i;
    var addr = $("#elecaddr").val();
    var validaddr = valid.test(addr);
    if(!validaddr){
        $("#addelec-addr_err").html("<div class='text-danger'>Enter a valid Address.</div>");
        return false;
    }
    else{
        $("#addelec-addr_err").html('<br>');
        return true;
    }
}
function checkElecBooth(){
    var booth = $("#elecbooth").val();
    console.log(booth);
    if(booth == ''){
        $("#addelec-booth_err").html("<div class='text-danger'>Assign a Booth. Click to Select.</div>");
        return false; 
    }
    else{
        $("#addelec-booth_err").html('<br>');
        return true;
    }
}