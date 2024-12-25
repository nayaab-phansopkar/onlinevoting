<?php
    class DBConnect extends PDO{
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "onlinevoting";
        private $conn;
        function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch(PDOException $e) {
                echo json_encode(['error_msg' => $e->getMessage(), 'error_count' => 1]);
                exit();
            }
        }
        public function getConn(){
            return $this->conn;
        }
    }




    class Login{
        private $con;
        function __construct()
        {   
            $dbobj = new DBConnect();
            $this->con = $dbobj->getConn();
        }


        public function checkUser($email, $pass){
            $sql = "SELECT * FROM admincreds WHERE Email=:mail";
            $prepare = $this->con->prepare($sql);
            $par = ['mail'=>$email];
            try{
                $prepare->execute($par);
                $data = $prepare->fetch();
            }
            catch(Exception $e){
                echo json_encode(['adminError' => $e->getMessage(), 'error_count' => 1]);
            }
            if($data > 0){
                $adminmail = $email;
                $adminpass = $data['password'];
                if(password_verify($pass, $adminpass)){
                    session_start();
                    $_SESSION['name'] = $data['name'];
                    $_SESSION['email'] = $adminmail;
                    $_SESSION['pass'] = $adminpass;
                    echo json_encode(['admin'=>'Login Succesful']);
                    exit();
                }
                else{
                    echo json_encode(['adminError'=>'Wrong Password']);
                    exit();
                }
            }
            else{
                $sql2 = "SELECT * FROM electorcreds WHERE email=:mail";
                $prep = $this->con->prepare($sql2);
                $param = [
                    'mail'=>$email,
                ];
                try{
                    $prep->execute($param);
                    $userdata = $prep->fetch();
                    if($userdata > 0){
                        $hash = $userdata['pass'];
                        if(password_verify($pass, $hash)){
                            session_start();
                            $_SESSION['uname'] = $userdata['name'];
                            $_SESSION['user'] = $userdata['username'];
                            $_SESSION['umail'] = $email;
                            $_SESSION['upass'] = $hash;
                            $_SESSION['dob'] = $userdata['dob'];
                            $_SESSION['gend'] = $userdata['gender'];
                            $_SESSION['addr'] = $userdata['address'];
                            $_SESSION['booth'] = $userdata['booth'];
                            echo json_encode(['user'=>'login successful']);
                            exit();
                        }
                        else{
                            echo json_encode(['userError'=>'Wrong Password']);
                            exit();
                        }
                    }
                    else{
                        echo json_encode(['userError'=>'Not Found']);
                        exit();
                    }
                }
                catch(Exception $e){
                    echo json_encode(['userError' => $e->getMessage(), 'error_count' => 1]);
                    exit();
                }
            }
        }
    }




    class Elector{
        private $con;
        function __construct()
        {   
            $dbobj = new DBConnect();
            $this->con = $dbobj->getConn();
        }

        public function addElector($name, $user, $mail, $pass, $dob, $gender, $address, $booth){
            $sql = "INSERT INTO electorcreds(name, username, email, pass, dob, gender, address, booth) VALUES(:name, :user, :mail, :pass, :dob, :gender, :address, :booth)";
            $prepare = $this->con->prepare($sql);
            $param = [
                'name' => $name,
                'user' => $user,
                'mail' => $mail,
                'pass' => password_hash($pass, PASSWORD_DEFAULT),
                'dob' => $dob,
                'gender' => $gender,
                'address' => $address,
                'booth' => $booth
            ];
            try{
                $prepare->execute($param);
                echo json_encode(['success'=>'Elector Registered Successfully!']);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(), 'error_count'=>1]);
                exit();
            }
        }


        public function getCount(){
            $sql = "SELECT * FROM electorcreds";
            $prepare = $this->con->prepare($sql);
            try{
                $prepare->execute();
                $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),'error_count'=>1]);
                exit();
            }
        }


        public function showData($currpage, $rpp){
            $start = ($currpage-1) * $rpp;
            $sql = "SELECT name, username, email, pass, dob, gender, address, booth FROM electorcreds LIMIT ".$start.", ".$rpp;
            $prepare = $this->con->prepare($sql);
            try{
                $prepare->execute();
                $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),'error_count'=>1]);
                exit();
            }
        }


        public function getSearch($val){
            $sql = "SELECT * FROM `electorcreds` WHERE name LIKE '".$val."%' OR username LIKE '".$val."%' OR email LIKE '".$val."%'";
            $prepre = $this->con->prepare($sql);
            try{
                $prepre->execute();
                $data = $prepre->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),"error_count"=>1]);
                exit();
            }
        }


        public function resetSystem(){
            $sql = "SET FOREIGN_KEY_CHECKS = 0;

                    TRUNCATE `electorcreds`;
                    TRUNCATE `votecount`;
            
                    SET FOREIGN_KEY_CHECKS = 1";
            $prepare = $this->con->prepare($sql);
            try{
                $prepare->execute();
                echo json_encode(['reset'=>'System Reset Complete']);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),"error_count"=>1]);
                exit();
            }
        }
    }




    class User{
        private $con;
        function __construct()
        {   
            $dbobj = new DBConnect();
            $this->con = $dbobj->getConn();
        }


        public function submitVote($party){
            session_start();
            $booth = $_SESSION['booth'];
            $username = $_SESSION['user'];
            $selectSql = "SELECT * FROM votecount WHERE voter=:user";
            $prepare = $this->con->prepare($selectSql);
            $param = [
                'user'=>$username,
            ];
            try{
                $prepare->execute($param);
                $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
                if($data > 0){
                    echo json_encode(['user_has_voted'=>true]);
                    exit();
                }
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),'errorcount'=>1]);
                exit();
            }
            $sql = "INSERT INTO votecount(Party, Booth, voter) VALUES(:par, :booth, :user)";
            $prepare = $this->con->prepare($sql);
            $param = [
                'par'=>$party,
                'booth'=>$booth,
                'user'=>$username,
            ];
            try{
                $prepare->execute($param);
                echo json_encode(['success'=>'Vote Registered']);
                exit();
            }
            catch(Exception $e){
                echo json_encode(['error'=>$e->getMessage(),'errorcount'=>1]);
                exit();
            }
        }


        public function fetchPartyResult($party){
            $sql = "SELECT Party, Booth FROM votecount WHERE Party=:party";
            $prepare = $this->con->prepare($sql);
            $param=[
                'party'=>$party,
            ];
            try{
                $prepare->execute($param);
                $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
                if($data > 0){
                    echo json_encode($data);
                    exit();
                }
            }
            catch(Exception $e){
                json_encode(['error'=>$e->getMessage()]);
                exit();
            }
        }


        public function getBoothPartyCounts($party, $booth){
            $sql = "SELECT Party, Booth FROM votecount WHERE Party=:party AND Booth=:booth";
            $prepare = $this->con->prepare($sql);
            $param=[
                'party'=>$party,
                'booth'=>$booth,
            ];
            try{
                $prepare->execute($param);
                $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
                exit();
            }
            catch(Exception $e){
                json_encode(['BoothPartyCountError'=>$e->getMessage()]);
                exit();
            }
        }
    }




    class LogOut{
        public function adminLogOut()
        {   
            session_start();
            if(isset($_SESSION['uname'])){
                unset($_SESSION['name']);
                unset($_SESSION['email']);
                unset($_SESSION['pass']);
                echo json_encode(['success'=>'logout successful']);
            }
            else{
                session_unset();
                session_destroy();
                echo json_encode(['success'=>'logout successful']);
            }
        }


        public function userLogOut(){
            session_start();
            if(isset($_SESSION['name'])){
                unset($_SESSION['uname']);
                unset($_SESSION['user']);
                unset($_SESSION['umail']);
                unset($_SESSION['upass']);
                unset($_SESSION['dob']);
                unset($_SESSION['gend']);
                unset($_SESSION['addr']);
                unset($_SESSION['booth']);
                echo json_encode(['success'=>'logout successful']);
            }
            else{
                session_unset();
                session_destroy();
                echo json_encode(['success'=>'logout successful']);
            }
        }
    }
?>
