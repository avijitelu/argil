<?php

    /* 
     * URL Redirection Function 
    */
    function redirect($path) {
        header('location:' . URLROOT . $path);
    }