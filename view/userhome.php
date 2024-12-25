<?php
    session_start();
    if(!isset($_SESSION['uname'])){
        header("location: http://localhost/onlinevoting/");
    }
    $name = $_SESSION['uname'];
?>

<!DOCTYPE html>

<head>
    <title>Online Voting System</title>
    <link rel="icon" type="image/x-icon" href="voting-box.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
    <div class="header text-center" style="background-color: #e8f0fc; padding: 20px 0px; max-width: 100%; max-height: 20%;">
        <h2 style="color: black;">Online Voting System</h2>
        <h3 style="color: black;">Welcome <?php echo $name ?></h3>
        <img src="userhomeheader-removebg-preview.png" alt="Header Image">
    </div><br>
    <div class="voting text-center">
        <form>
            <div class="form-group text-center">
                <h5>
                <label class="form-check-label">Select and vote for your preferred party</label><br><br>
                </h5>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" name="party" id="party01" value="New Alliance Party">
                    <label class="form-check-label">New Alliance Party</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" name="party" id="party02" value="Fatherland Union">
                    <label class="form-check-label">Fatherland Union</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" name="party" id="party03" value="Unionist Party">
                    <label class="form-check-label">Unionist Party</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" name="party" id="party04" value="United Workers' Party">
                    <label class="form-check-label">United Workers' Party</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" name="party" id="party05" value="Workers' League">
                    <label class="form-check-label">Workers' League</label>
                </div>
                <div id="vote_err" style="margin: 10px 0;"><br></div>
            </div>
            <button class="btn btn-primary" id="sbmtvote">Submit Vote</button>
        </form><br>
        <div class="footer">
            <button class="btn btn-warning" id="logout">Logout</button>
        </div>

        <div class="modal fade bd-example-modal-sm" id="success_vote" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: green;">Success</h5>
                            </div>
                            <div class="modal-body">
                                <div>Vote Registered</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="../js/userhome.js"></script>
</html>