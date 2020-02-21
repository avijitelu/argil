<?php
    /**
     * Set the mode of your application either production or development
     * Switch between two MODE according to your Development Environment 
     */
    // define("MODE", "PRODUCTION");
    define("MODE", "TEST");

    if(strcasecmp(MODE, "production") === 0) {
        // DB Params for Production 
        define("DB_HOST", "");
        define("DB_USER", "");
        define("DB_PASS", "");
        define("DB_NAME", "");

        // URL root
        define("URLROOT", "http://your-domain.in");

    } else {
        // DB Params for Development
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASS", "");
        define("DB_NAME", "argil");

        // URL root
        define("URLROOT", "http://localhost/argil");
    }

    // Site Name
    define("SITENAME", "Argil");
    
    // App root
    define("APPROOT", dirname(dirname(__FILE__)));
    // App Path
    define("APP_PATH", dirname(dirname(dirname(__FILE__))));

    // View path
    define("VIEW_PATH", APPROOT . "/views");

    //CSS Path
    define("CSS_PATH", URLROOT . "/public/assets/build/css");
    // JS Path
    define("JS_PATH", URLROOT . "/public/assets/build/js");
    // Image Path
    define("IMAGE_PATH", APP_PATH . "/public/images");