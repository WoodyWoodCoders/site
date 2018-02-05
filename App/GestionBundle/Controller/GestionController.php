<?php

namespace App\GestionBundle\Controller;

use Core\Controller;

class GestionController extends Controller {
    protected $viewPath = "App/GestionBundle/Views/";

    public function indexAction($showInLayout = true) {

        $this->afficher("index", $showInLayout);
    }

    public function loginAction($showInLayout = true) {

                    // 'Authorization': 'Bearer ' + token

        $this->afficher("index", $showInLayout);
    }


}
