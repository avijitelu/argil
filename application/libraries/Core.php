<?php
    /*
    * App core class
    * Create URL & loads Core controller
    * URL FORMAT - /controller/method/params
    */

    class Core {
        protected $currentController = "Posts";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct() {
            
            $url = $this->getUrl();

            if(file_exists("../application/controllers/" . ucwords($url[0]) . ".php")) {
                $this->currentController = ucwords($url[0]);
                // unset 0 index
                unset($url[0]);
            }

            // Require the controller
            require_once "../application/controllers/" . $this->currentController . ".php";

            // Instantiate controller class
            $this->currentController = new $this->currentController;

            // Check for the second part of the url
            if(isset($url[1])) {
                // Check to see if the method is exists in controller
                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            // Get params
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            if(isset($_GET["url"])) {
                $url = filter_var($_GET["url"], FILTER_SANITIZE_URL);
                $url = explode("/", $url);
                return $url;
            }
        } 
    }

