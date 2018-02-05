<?php

class Autoloader{

    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }


    /**
     * Inclue le fichier correspondant Ã  notre classe
     * @param $class string Le nom de la classe Ã  charger
     */
    static function autoload($class){
        if (file_exists(str_replace('\\', DS, $class) . ".php")) {
            include(str_replace('\\', DS, $class) . ".php");
            return true;
        }
        return false;
    }


    /**
     * Inclue le fichier correspondant Ã  notre classe
     * @param $class string Le nom de la classe Ã  charger
     */
//    static function autoload($class){
//
//        $filename = explode(DS, $class);
//        $className = end($filename);
//        $paths = array("app/Controller/","app/Entity/", "app/Manager/","core/Controller/","core/Manager/");
//        var_dump(file_exists($paths[0] . $className . ".php"));
//        var_dump($class);
//        foreach($paths as $path) {
//            if(file_exists($path . $className . ".php")) {
//                var_dump($path . $className . ".php");
//                include_once($path . $className . ".php");
//                return true;
//            }
//        }
//        return false;
//        if(file_exists($class . ".php")) {
//            var_dump($class . ".php");
//            var_dump(file_exists($class . ".php"));
//            require_once($class . ".php");
//        } else {
//            $filename = explode(DS, $class);
//            $className = end($filename);
//            var_dump($className);
//
//            if(preg_match("/Controller/i", $className)) {
//                $class = "app" . DS . "Controller" . DS . $className .".php";
//
//                var_dump($class);
//
//                var_dump("app" . DS . "Controller" . DS . $className .".php : " . require_once($class));
//            } elseif(preg_match("/Manager/i", $className)) {
//                $class = "app" . DS . "Manager" . DS . $className .".php";
//
//                var_dump($class);
//
//                var_dump("app" . DS . "Manager" . DS . $className .".php : " . require_once($class));
//            } elseif(preg_match("/Entity/i", $className)) {
//                $class = "app" . DS . "Entity" . DS . $className .".php";
//
//                var_dump($class);
//                var_dump("app" . DS . "Entity" . DS . $className .".php : " . require_once($class));
//
//            } else
//                return false;
//        }
//        return true;
//    }

}
