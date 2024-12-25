$(document).ready(function () {

    $('#home').click(function (e) { 
        e.preventDefault();
        
        window.location.href="http://localhost/onlinevoting/view/admindash.php";
    });

    p1 = "New Alliance Party";
    p2 = "Fatherland Union";
    p3 = "Unionist Party";
    p4 = "United Workers' Party";
    p5 = "Workers' League";

    var totalout="";
    function getpt(p){
        res="";
        let getAct="partytotal"
        setAct = {
            party: p,
            action: getAct,
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: setAct,
            async: false,
            success: function (response) {
                res = JSON.parse(response);
                console.log(res);
            }
        });
        return res;
    }

    var op1 = getpt(p1);
    if(op1.length > 0){
        totalout += "<tr><td>" + op1[0].Pary + "</td><td>" + op1.length + "</td></tr>";
    } 
    var op2 = getpt(p2);
    if(op2.length > 0){
        totalout += "<tr><td>" + op2[0].Party + "</td><td>" + op2.length + "</td></tr>";   
    } 
    var op3 = getpt(p3);
    if(op3.length > 0){
        totalout += "<tr><td>" + op3[0].Party + "</td><td>" + op3.length + "</td></tr>";   
    }
    var op4 = getpt(p4);
    if(op4.length > 0){
        totalout += "<tr><td>" + op4[0].Party + "</td><td>" + op4.length + "</td></tr>";   
    } 
    var op5 = getpt(p5);
    if(op5.length > 0){
        totalout += "<tr><td>" + op5[0].Party + "</td><td>" + op5.length + "</td></tr>";   
    } 
    $("#tbody").html(totalout);

    function getBoothwisePartyVoteCounts(pname, b){
        res = "";
        let getAct = "getBoothwisePartyVoteCounts"
        partyname = {
            party: pname,
            booth: b,
            action: getAct
        }
        $.ajax({
            type: "POST",
            url: "../controller/index.php",
            data: partyname,
            async: false,
            success: function (response) {
                // console.log(response);
                res = JSON.parse(response);
            }
        });
        return res;
    }

    i=0;
    $("#booth_btn1").click(function (e) { 
        e.preventDefault();

        header = "<div class='text-primary'>Booth 1 Results</div>"
        output = "";
        po1 = getBoothwisePartyVoteCounts(p1, 1);
        if(po1.length > 0){
            output += po1[i].Party + " :   " + po1.length;
            output += "<br>";
        }
        po2 = getBoothwisePartyVoteCounts(p2, 1);
        if(po2.length > 0){
            output += po2[i].Party + " :   " + po2.length;
            output += "<br>";
        }
        po3 = getBoothwisePartyVoteCounts(p3, 1);
        if(po3.length > 0){
            output += po3[i].Party + " :   " + po3.length;
            output += "<br>";
        }
        po4 = getBoothwisePartyVoteCounts(p4, 1);
        if(po4.length > 0){
            output += po4[i].Party + " :   " + po4.length;
            output += "<br>";
        }
        po5 = getBoothwisePartyVoteCounts(p5, 1);
        if(po5.length > 0){
            output += po5[i].Party + " :   " + po5.length;
            output += "<br>";
        }
        output = header + output;
        $("#boothresults").html(output);

    });
    $("#booth_btn2").click(function (e) { 
        e.preventDefault();

        header = "<div class='text-primary'>Booth 2 Results</div>"
        output = "";
        po1 = getBoothwisePartyVoteCounts(p1, 2);
        if(po1.length > 0){
            output += po1[i].Party + " :   " + po1.length;
            output += "<br>";
        }
        po2 = getBoothwisePartyVoteCounts(p2, 2);
        if(po2.length > 0){
            output += po2[i].Party + " :   " + po2.length;
            output += "<br>";
        }
        po3 = getBoothwisePartyVoteCounts(p3, 2);
        if(po3.length > 0){
            output += po3[i].Party + " :   " + po3.length;
            output += "<br>";
        }
        po4 = getBoothwisePartyVoteCounts(p4, 2);
        if(po4.length > 0){
            output += po4[i].Party + " :   " + po4.length;
            output += "<br>";
        }
        po5 = getBoothwisePartyVoteCounts(p5, 2);
        if(po5.length > 0){
            output += po5[i].Party + " :   " + po5.length;
            output += "<br>";
        }
        output = header + output;
        $("#boothresults").html(output);
    });
    $("#booth_btn3").click(function (e) { 
        e.preventDefault();

        header = "<div class='text-primary'>Booth 3 Results</div>"
        output = "";
        po1 = getBoothwisePartyVoteCounts(p1, 3);
        if(po1.length > 0){
            output += po1[i].Party + " :   " + po1.length;
            output += "<br>";
        }
        po2 = getBoothwisePartyVoteCounts(p2, 3);
        if(po2.length > 0){
            output += po2[i].Party + " :   " + po2.length;
            output += "<br>";
        }
        po3 = getBoothwisePartyVoteCounts(p3, 3);
        if(po3.length > 0){
            output += po3[i].Party + " :   " + po3.length;
            output += "<br>";
        }
        po4 = getBoothwisePartyVoteCounts(p4, 3);
        if(po4.length > 0){
            output += po4[i].Party + " :   " + po4.length;
            output += "<br>";
        }
        po5 = getBoothwisePartyVoteCounts(p5, 3);
        if(po5.length > 0){
            output += po5[i].Party + " :   " + po5.length;
            output += "<br>";
        }
        output = header + output;
        $("#boothresults").html(output);
    });
    $("#booth_btn4").click(function (e) { 
        e.preventDefault();

        header = "<div class='text-primary'>Booth 4 Results</div>"
        output = "";
        po1 = getBoothwisePartyVoteCounts(p1, 4);
        if(po1.length > 0){
            output += po1[i].Party + " :   " + po1.length;
            output += "<br>";
        }
        po2 = getBoothwisePartyVoteCounts(p2, 4);
        if(po2.length > 0){
            output += po2[i].Party + " :   " + po2.length;
            output += "<br>";
        }
        po3 = getBoothwisePartyVoteCounts(p3, 4);
        if(po3.length > 0){
            output += po3[i].Party + " :   " + po3.length;
            output += "<br>";
        }
        po4 = getBoothwisePartyVoteCounts(p4, 4);
        if(po4.length > 0){
            output += po4[i].Party + " :   " + po4.length;
            output += "<br>";
        }
        po5 = getBoothwisePartyVoteCounts(p5, 4);
        if(po5.length > 0){
            output += po5[i].Party + " :   " + po5.length;
            output += "<br>";
        }
        output = header + output;
        $("#boothresults").html(output);
    });


});