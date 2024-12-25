<?php
    session_start();
    if(!isset($_SESSION['name'])){
        header("location: http://localhost/onlinevoting/");
    }
?>

<!DOCTYPE html>
    <head>
        <title>Election Results</title>
        <link rel="icon" type="image/x-icon" href="voting-box.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
    <body>
        <div class="header text-center" style="background-color: black; padding: 40px 0px; max-width: 100%;">
            <h2 style="color: whitesmoke;">Online Voting System</h2>
            <h3 style="color: whitesmoke;" id="home">Admin Dashboard</h3>
        </div>

        <div class="header text-center text-success" style="background-color: whitesmoke; padding: 10px; border-bottom: 1px solid black;">
            <h4>Election Results</h4>
        </div>
        <br>

        <div class="container text-center" style="max-width: 80%;">
            <h5>Click on Booths below to check boothwise Results</h5>
            <div class="boothbtns">
                <button class="btn btn-dark" id="booth_btn1">1</button>
                <button class="btn btn-dark" id="booth_btn2">2</button>
                <button class="btn btn-dark" id="booth_btn3">3</button>
                <button class="btn btn-dark" id="booth_btn4">4</button>
            </div>
            <br>

            <div class="boothresults" id="boothresults" style="height: 150px;">
                <!-- display results dynamically -->
            </div>

            <br><br>
            <h6>OverAll Result</h6>
            <table class="table table-bordered" id="tasklist">
                <thead>
                    <tr>
                        <th scope="col">Party Name</th>
                        <th scope="col">Total Votes</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody><!-- This Table Body will Display Users Task List -->
            </table>
            <br><br><br>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../js/result.js"></script>
</html>