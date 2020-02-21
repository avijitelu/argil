<?php
    session_start();
    
    function create_user_session($user) {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['fname'] = $user->firstname;
        $_SESSION['lname'] = $user->lastname;
        $_SESSION['email'] = $user->email;
    }
    