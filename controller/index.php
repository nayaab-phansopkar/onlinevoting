<?php
    include_once('../model/index.php');

    $action = $_POST['action'];

    if($action === 'login'){
        
        $email = htmlspecialchars(trim($_POST['email']));
        $pass = htmlspecialchars(trim($_POST['pass']));

        $login = new Login();
        $login->checkUser($email, $pass);
        exit();
    
    }

    else if($action === 'getCount'){

        $getc = new Elector();
        $getc->getCount();
        exit();

    }

    else if($action === 'showdata'){

        $currpage = $_POST['pageNo'];
        $recperpage = $_POST['rpp'];
        $showdata = new Elector();
        $showdata->showData($currpage, $recperpage);
        exit();

    }

    else if($action === 'addElector'){

        $name = htmlspecialchars(trim($_POST['name']));
        $user = htmlspecialchars(trim($_POST['user']));
        $mail = htmlspecialchars(trim($_POST['mail']));
        $pass = htmlspecialchars(trim($_POST['pass']));
        $dob = htmlspecialchars(trim($_POST['dob']));
        $gender = htmlspecialchars(trim($_POST['gender']));
        $address = htmlspecialchars(trim($_POST['address']));
        $booth = htmlspecialchars(trim($_POST['booth']));

        $addelector = new Elector();
        $addelector->addElector($name, $user, $mail, $pass, $dob, $gender, $address, $booth);
        exit();

    }

    else if($action === 'search'){

        $searchVal = htmlspecialchars(trim($_POST['searchVal']));
        $s = new Elector();
        $s->getSearch($searchVal);

    }

    else if($action === 'vote'){

        $party = $_POST['party'];
        $vote = new User();
        $vote->submitVote($party);
        exit();

    }

    else if($action === 'partytotal'){

        $party = $_POST['party'];
        $totalvc = new User();
        $totalvc->fetchPartyResult($party);

    }

    else if($action === 'getBoothwisePartyVoteCounts'){

        $party = $_POST['party'];
        $booth = $_POST['booth'];
        $voteCount = new User();
        $voteCount->getBoothPartyCounts($party, $booth);
        exit();

    }

    else if($action === 'ResetVotes'){

        $reset = new Elector();
        $reset->resetSystem();
        exit();

    }

    else if($action === 'userlogout'){

        $lg = new LogOut();
        $lg->userLogOut();
        exit();

    }

    else if($action === 'adminlogout'){

        $lg = new LogOut();
        $lg->adminLogOut();
        exit();

    }

?>