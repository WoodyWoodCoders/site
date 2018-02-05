<?php

namespace App\UserBundle\Controller;

use Core\Controller;
use App\UserBundle\Entity\User;

class UserController extends Controller {
    protected $viewPath = "App/UserBundle/Views/";
    protected $errors = array(
        array(
            "success" => false,
            "message" => "L'identifiant ou le mot de passe est incorrect",
        ),
        array(
            "success" => true,
            "message" => "Vous avez bien été déconnecté",
        ),
        array(
            "success" => false,
            "message" => "Les mots de passes ne sont pas identiques",
        ),
        array(
            "success" => false,
            "message" => "Une erreur a eu lieu lors de l'inscription, merci de réessayer ultérieurement.",
        ),
        array(
            "success" => true,
            "message" => "Votre compte a bien été enregistré. Vous pouvez dès à présent vous connecter.",
        ),
    );

    public function loginAction($showInLayout = true, $visitorsLayout = true) {
        global $user;
        // if (!empty($user) && !empty($user->getToken())) {
        //     $this->redirect("index.php");
        // }
        $this->page['title'] = "Connexion";
        if(!empty($_POST)) {
            $login = $_POST["login"];
            $password = $_POST["password"];

            $password = hash("sha256", $password);

            $reponse = $this->rest(
                "user/jwt/login",
                array(
                    "login" => $login,
                    "password" => $password
                )
            );
            // var_dump($reponse);
            if(isset($reponse['token'])) {
                // var_dump("Connexion réussie");
                $user = new User();
                $user->setLogin($login);
                $user->setToken($reponse['token']);
                $_SESSION['user'] = $user;

                $data = $this->rest(
                    "rest/user/profile",
                    array(),
                    "GET",
                    true
                );
                // var_dump($data["data"]);

                $user = new User($data["data"]);
                // var_dump($user);
                //
                // var_dump($data->data);
                // var_dump(new User($data->data[0]));

                $user->setToken($reponse['token']);

                $_SESSION['user'] = $user;

                $this->redirect("index.php");
            } else {
                $this->redirect("index.php?p=user&a=login&e");
            }
        }
        // $this->viewPath .= 'login/';
                    // 'Authorization': 'Bearer ' + token

        $this->afficher("login", $showInLayout, true);
        // include($this->viewPath . "login.php");
    }


    public function registerAction($showInLayout = true, $visitorsLayout = true) {
        global $user;
        // if (!empty($user) && !empty($user->getToken())) {
        //     $this->redirect("index.php");
        // }

        $this->page['title'] = "Inscription";
        // $this->includeJS[] = $this->viewPath . "register.js";

        if(!empty($_POST)) {
            $login = $_POST["login"];
            $nom = $_POST["firstName"] . " " . $_POST["lastName"];
            $type = 1;
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            if($password !== $password2) {
                $this->redirect("index.php?p=user&a=register&e=2");
                return false;
            }

            $password = hash("sha256", $password);
            // $hexPassword = bin2hex($password);

            $reponse = $this->rest(
                "user/jwt/register",
                array(
                    "login" => $login,
                    "nom" => $nom,
                    "type" => $type,
                    "password" => $password,
                )
            );
            // var_dump($reponse);
            if(isset($reponse['id'])) {
                // var_dump("Connexion réussie");

                $this->redirect("index.php?p=user&a=login&e=4");
            } else {
                $this->redirect("index.php?p=user&a=register&e=3");
            }
        }
        // $this->viewPath .= 'login/';
                    // 'Authorization': 'Bearer ' + token

        $this->afficher("register", $showInLayout, true);
        // include($this->viewPath . "login.php");
    }


    public function logoutAction() {
        if(!empty($_SESSION)) {
            unset($_SESSION['user']);
            session_destroy();
        }

        if (isset($_COOKIE['i'])) {
            unset($_COOKIE['i']);
            setcookie('i', '', time() - 3600, GLOBAL_PATH, GLOBAL_DOMAIN); // empty value and old timestamp
        }
        if (isset($_COOKIE['t'])) {
            unset($_COOKIE['t']);
            setcookie('t', '', time() - 3600, GLOBAL_PATH, GLOBAL_DOMAIN); // empty value and old timestamp
        }
        if (isset($_COOKIE['stayConnected'])) {
            unset($_COOKIE['stayConnected']);
            setcookie('stayConnected', '', time() - 3600,  GLOBAL_PATH, GLOBAL_DOMAIN); // empty value and old timestamp
        }

        $this->redirect("index.php");
    }


}
