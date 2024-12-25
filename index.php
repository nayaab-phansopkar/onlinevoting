<?php
  session_start();
  if(isset($_SESSION['name'])){
    header("location: http://localhost/onlinevoting/view/admindash.php");
  }
  if(isset($_SESSION['uname'])){
    header("location: http://localhost/onlinevoting/view/userhome.php");
  }
?>
<html>
    <head>
        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="/onlinevoting/view/voting-box.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
    <body>
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                  <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-5">
                      <h2 class="text-uppercase text-center mb-5">Login</h2>
                      <div id="resp" style="text-align: center;"></div>
                      <form id="logform">
        
                        <div class="form-outline mb-4">
                          <label class="form-label" for="mail">Your Email</label>
                          <input type="email" id="mail" class="form-control form-control-lg" />
                          <span id="email_err"><br></span>
                        </div>
        
                        <div class="form-outline mb-4">
                          <label class="form-label" for="pass">Password</label>
                          <input type="password" id="pass" class="form-control form-control-lg" />
                          <span id="pass_err"><br><br></span>
                        </div>

                        <input type="hidden" id="action" value="login">
        
                        <div class="d-flex justify-content-center">
                          <button type="button"
                            class="btn btn-dark btn-block btn-lg gradient-custom-4 text-body" id="logbtn">Login</button>
                        </div>
        
                        <p class="text-center text-muted mt-5 mb-0">Don't have an account? <a id="reg" href="../view/register.html"
                            class="fw-bold text-body"><u>Register here</u></a></p>
        
                      </form>
        
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </body>
    <script src="./js/logscript.js"></script>
</html>