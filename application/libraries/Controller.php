<?php
    /*
    * Base controller
    * Loads the Model & Views
    */
    class Controller {
        // Load model
        public function model($model) {
            // Require model file
            require_once '../application/models/' . $model . '.php';

            // Instantiate model
            return new $model();
        }

        // Load view
        // public function view($view, $data = []) {
        //     // Check for view file
        //     if(file_exists("../application/views/" . $view . ".php")) {
        //         require_once "../application/views/" . $view . ".php";
        //     } else {
        //         die("View does not exsist");
        //     }
        // }
    }