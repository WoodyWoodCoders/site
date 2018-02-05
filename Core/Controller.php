<?php
namespace Core;

use Core\Rest\Timer;
use Core\Rest\Http_Multiple_Error;
use Core\Rest\Http;
use Core\Rest\Http_Exception;

use \stdClass;

Abstract class Controller {

    protected $viewPath;
    protected $layoutPath = "Core/Views/";
    protected $page = array(
                            "title" => "WOOD | ",
                            "script" => "",
                            "showButtonHeader" => "",
                            "breadcrumb" => array(
                            ),
                        );
    protected $includeCSS = array();
    protected $includeJS = array();
    protected $includeModal = array();
    protected $modalClasses = array();
    protected $variables = array();
    protected $variablesToPass = array();
    protected $expiration_token = 604800; //1 semaine en secondes
    protected $expiration_formToken = 3600; //1 h en secondes
    protected $errors = array(
        array(
            "success" => false,
            "message" => "L'identifiant ou le mot de passe est incorrect",
        ),
    );

    public function __construct($needUserLogged = true) {
        global $userLogged;
        // var_dump($needUserLogged, $userLogged);
        if($needUserLogged && !$userLogged) {
            $this->redirect("index.php?p=user&a=login");
        } elseif(!$needUserLogged && $userLogged) {
            $this->redirect("index.php");
        }
    }


    public function rest($url, $params = array(), $method = "POST", $json = true) {
        Timer::start();

        // if(substr($url, 0, 1) !== "/") $url = "/" . $url;

        try {
            switch ($method){
                case "POST":
                    $req = Http::connect('localhost', 80)
                        ->doPost($url, $params, $json);
                    break;
                case "GET":
                    $req = Http::connect('localhost', 80)
                        ->doGet($url, $params, $json);
                    break;
            }

            $time = Timer::end();

            $reponse = json_decode($req, true);

        } catch (Http_Exception $e) {
            // switch ($e) {
            //     case Http_Exception::INTERNAL_ERROR:
            //         echo "Internal Error";
            //         break;
            // }
            $reponse = array();
            $reponse["success"] = false;
            $reponse["error"] = $e->getCode();
        }

        return $reponse;
    }


    public function redirect($url, $errorId = null) {
        if(is_numeric($errorId) && isset($this->getErrors()[$errorId])) {
            $url .= "&e=" . $errorId;
        }
        return header("Location: " . $url);
    }

    public function afficher($view, $showInLayout = true, $visitorsLayout = false) {
        extract($this->variables); //Extrait les variables et les déclares

        if($view !== null) {
            ob_start();

            require($this->viewPath . $view . ".php");

            $content = ob_get_clean();
        } else $content = null;

        if($showInLayout) {
            require(!$visitorsLayout
                    ? $this->layoutPath . "layout.php"
                    : $this->layoutPath . "visitors/layout.php");
            return true;
        } else {
            return array("content" => $content,
                        "script" => !empty($this->page["script"])
                                    ? $this->page["script"]
                                    : null,
                        "breadcrumb" => !empty($this->page["breadcrumb"])
                                    ? $this->page["breadcrumb"]
                                    : null,
                        "includeModal" => $this->includeModal,
                        "modalClasses" => $this->modalClasses,
                        "includeCSS" => $this->includeCSS,
                        "includeJS" => $this->includeJS,
                        "variablesToPass" => $this->variablesToPass
            );
        }
    }

    public function getInclude($include) {
        extract($this->variables);

        ob_start();

        require($include);

        return ob_get_clean();
    }

    public function getModule($array) {
        if(!empty($array)) {
            if(!empty($array['includeModal'])) {
                foreach($array['includeModal'] as $modal) {
                    if(!in_array($modal, $this->includeModal))
                        $this->includeModal[] = $modal;
                }
            }
            if(!empty($array['script'])) {
                if(empty($this->page["script"]))
                    $this->page["script"] = "";
                $this->page["script"] .= $array['script'];
            }
            if(!empty($array['breadcrumb'])) {
                $this->page["breadcrumb"] = empty($this->page["breadcrumb"])
                                          ? $array['breadcrumb']
                                          : array_merge($this->page["breadcrumb"], $array['breadcrumb']);
            }
            if(!empty($array['modalClasses'])) {
                foreach($array['modalClasses'] as $class) {
                    if(!in_array($class, $this->modalClasses))
                        $this->modalClasses[] = $class;
                }
            }
            if(!empty($array['includeCSS'])) {
                foreach($array['includeCSS'] as $css) {
                    if(!in_array($css, $this->includeCSS))
                        $this->includeCSS[] = $css;
                }
            }
            if(!empty($array['includeJS'])) {
                foreach($array['includeJS'] as $js) {
                    if(!in_array($js, $this->includeJS))
                        $this->includeJS[] = $js;
                }
            }
            if(!empty($array['variablesToPass'])) {
                foreach($array['variablesToPass'] as $nom => $variable) {
                    if(!isset($this->variables[$nom]))
                        $this->variables[$nom] = $variable;
                }
            }

            if(!empty($array['content']))
                return $array["content"];
            else
                return false;

        } else {
            return false;
        }
    }

    public function isAjax() {
        return isset($_GET["ajax"])
               && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
               && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
                    ? true
                    : false;
    }

    public function getIncludes() {
        return array("includeCSS" => $this->includeCSS,
                     "includeJS" => $this->includeJS,
                     "includeModal" => $this->includeModal
                 );
    }

    public function getErrors()
    {
       return $this->errors;
    }

    public function getError($index = 0)
    {
       return isset($this->errors[$index])
            ? $this->errors[$index]
            : null;
    }

    public function getErrorSuccess($index = 0)
    {
       return isset($this->errors[$index])
            ? $this->errors[$index]['success']
            : null;
    }

    public function getErrorMessage($index = 0)
    {
       return isset($this->errors[$index])
            ? $this->errors[$index]['message']
            : null;
    }
}
