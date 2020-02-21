<?php
    // Load config
    require_once 'config/config.php';
    require_once '../vendor/autoload.php';
    require_once 'helpers/session.php';
    require_once 'helpers/url_redirect.php';
    
    // Load libraries
    // require_once 'libraries/Core.php';
    // require_once 'libraries/Controller.php';
    // require_once 'libraries/View.php';
    
    // Autoload Core libraries
    spl_autoload_register(function($className) {
        require_once "libraries/". $className .".php";
    });

