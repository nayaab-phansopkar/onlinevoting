<?php
    session_start();
    if(!isset($_SESSION['name'])){
        header("location: http://localhost/onlinevoting/");
    }
?>
<!DOCTYPE html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="icon" type="image/x-icon" href="voting-box.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
    <body>
        <div class="header text-center" style="background-color: black; padding: 40px 0px; max-width: 100%;">
            <h2 style="color: whitesmoke;">Online Voting System</h2>
            <h3 style="color: whitesmoke;">Admin Dashboard</h3>
        </div>

        <div class="ActionButtons" style="background-color: black; max-width: 100%; padding: 10px 0px;">
            <div class="d-grid gap-2 mx-auto text-center" style="background-color: whitesmoke; padding: 8px; border-radius: 10px;">
                <button id="addelector" style="padding: 10px 120px;" class="btn btn-dark">Add Elector</button>
                <button id="votingresult" style="padding: 10px 120px;" class="btn btn-dark">Result</button>
                <button id="resetvotes" style="padding: 10px 20px;" class="btn btn-danger">Reset</button>
                <button id="logout" style="padding: 10px 20px;" class="btn btn-secondary">LogOut</button>
            </div>
        </div>

        <div class="container" style="padding:60px ;">
            <h4 class="text-uppercase text-center mb-4"> Registered Electors Data <br></h4>
            <div class="row">
                <div class="col-12">
                    <div class="input-group" style="justify-self: right;">
                        <input type="search" class="form-control rounded" id="searchinput" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="button" id="searchbtn" class="btn btn-outline-primary">search</button>
                    </div><br>

                    <div class="text-center">
                        <input type="number" style="width: 30%; height: 36px;" name="recperpage" id="recperpage" placeholder="Enter the number of Records to Display"/>
                        <button class="btn btn-outline-dark" name="rppbtn" id="rppbtn">GO</button>
                        <span id="rppError"></span>
                    </div>

                    <br>
                    <div class="text-center" id="msg"><br><br></div>
                    <table class="table table-bordered" id="tasklist">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">DOB</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Address</th>
                                <th scope="col">Booth</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody><!-- This Table Body will Display Users Task List -->
                    </table>
                </div>
            </div>


            <nav aria-label="Page navigation example">
                <ul class="pagination" id="paginate" style="white-space: nowrap; display: table;">
                    <!-- <li class="page-item" style="display: table-cell;">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li> -->
                    <span id="rec_pages">
                        <!-- <li class="page-item"><a class="page-link" href="#">1</a></li> -->
                    </span>
                    <!-- <li class="page-item" style="display: table-cell;">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li> -->
                </ul>
            </nav>


            <div class="modal fade" id="addelectormodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addelectorlabel">Register Elector</h5>
                        </div>
                        <div class="modal-body">
                            <span id="addelectormodalresp"><br></span>
                            <form id="addelectorform">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="taskname">Name</label>
                                        <input type="text" class="form-control" id="elecname" placeholder="Full Name of Elector">
                                        <span id="addelec-name_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskname">Username</label>
                                        <input type="text" class="form-control" id="elecuser" placeholder="Assign a username to Elector">
                                        <span id="addelec-user_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskname">Email</label>
                                        <input type="text" class="form-control" id="elecmail" placeholder="Elector's Email">
                                        <span id="addelec-mail_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskname">Password</label>
                                        <input type="password" class="form-control" id="elecpass" placeholder="Assign a password to elector">
                                        <span id="addelec-pass_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskname">Date of Birth</label>
                                        <input type="date" class="form-control" id="elecdob">
                                        <span id="addelec-dob_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">Gender : </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="radio" class="form-check-input" name="elecgen" id="elecgenmale" value="male">
                                            <label class="form-check-label">Male</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="radio" class="form-check-input" name="elecgen" id="elecgenfemale" value="female">
                                            <label class="form-check-label">Female</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="radio" class="form-check-input" name="elecgen" id="elecgenother" value="other">
                                            <label class="form-check-label">Other</label>
                                        </div>
                                        <span id="addelec-gen_err"><br><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskname">Address</label>
                                        <input type="text" class="form-control" id="elecaddr" placeholder="Elector's Address">
                                        <span id="addelec-addr_err"><br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="elecbooth">Assign a Booth</label>
                                            <select id="elecbooth" name="elecbooth" class="form-control">
                                                <option value="" selected></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        <span id="addelec-booth_err"><br></span>
                                    </div>
                                </div>
                                <input type="hidden" name="add-elector" id="add-elector" value="add-elector">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="closeaddelector" class="btn btn-secondary">Close</button>
                            <button id="registerelector" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-sm" id="success_elector_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: green;">Success</h5>
                            </div>
                            <div class="modal-body">
                                <div>Elector Registered</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-sm" id="reset_election" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: red;">WARNING!</h5>
                            </div>
                            <div class="modal-body">
                                <div>This action will reset the System and DELETE every vote.<br>Please confirm Your Action:</div>
                            </div>
                            <div class="modal-footer">
                                <button id="closeReset" class="btn btn-secondary">Close</button>
                                <button id="confirmReset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../js/adminscript.js"></script>
</html>