<?php
    
    class Twig {
        public static $twig = null;

        public static function getInstance() {
            $loader = new Twig_Loader_Filesystem(VIEW_PATH);
            $twig = new Twig_Environment($loader, array(
                'auto_reload' => true,
                'debug' => true,
                'cache' => APPROOT . "/cache"
            ));
            $twig->addExtension(new Twig_Extension_Debug());
            $twig->addGlobal('session', $_SESSION);
            return $twig;
        }
    }
    