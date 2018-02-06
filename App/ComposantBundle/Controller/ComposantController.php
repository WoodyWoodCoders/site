<?php

namespace App\ComposantBundle\Controller;

use Core\Controller;
use App\ComposantBundle\Entity\Composant;

class ComposantController extends Controller {
    protected $viewPath = "App/ComposantBundle/Views/";
    protected $errors = array(
        array(
            "success" => true,
            "message" => "Le composant a bien été créé",
        ),
        array(
            "success" => false,
            "message" => "Le composant n'a pas pu être créé",
        ),
        array(
            "success" => true,
            "message" => "Le composant a bien été édité",
        ),
        array(
            "success" => false,
            "message" => "Le composant n'a pas pu être édité",
        ),
        array(
            "success" => true,
            "message" => "Le composant a bien été supprimé",
        ),
        array(
            "success" => false,
            "message" => "Le composant n'a pas pu être supprimé",
        ),
        array(
            "success" => false,
            "message" => "Une erreur a eue lieu",
        ),
    );

    public function indexAction($showInLayout = true) {
        global $composant;
        // if (!empty($composant) && !empty($composant->getToken())) {
        //     $this->redirect("index.php");
        // }

        $this->includeJS[] = "public/tools/datatables/datatables.min.js";
        $this->includeCSS[] = "public/tools/datatables/datatables.min.css";

        $this->includeJS[] = $this->viewPath . "script.js";
        // $this->includeCSS[] = $this->viewPath . "style.css";

        $data = $this->rest(
            "rest/composant/get/all/dto",
            array(),
            "GET",
            true
        );

        $composants = array();

        if (!empty($data)) {
            foreach($data as $composant) {
                $composants[] = new Composant($composant);
            }
        }

        $this->variables["composants"] = $composants;

        $this->afficher("annuaire", $showInLayout);
    }

    public function getAction() {
        if(!empty($_POST) && isset($_POST["action"])) {
            $action = $_POST["action"];

            if($action === "getComposantModal" && isset($_POST["id"])) {
                $id_composant = intval($_POST["id"]);
                if($id_composant > 0 ) {

                    $data = $this->rest(
                        "rest/composant/get/$id_composant",
                        array(),
                        "GET",
                        true
                    );

                    if (!empty($data)) {
                        $composant = new Composant($data);
                    } else {
                        echo json_encode(
                            array(
                                "success" => false,
                                "error" => "Le composant n'a pas été trouvé"
                            )
                        );
                    }
                } else {
                    $composant = new Composant();
                }


                $this->variables["composant"] = $composant;
                echo json_encode(
                    array(
                        "success" => true,
                        "content" => $this->getInclude($this->viewPath . "composant.php")
                    )
                );

            } else {
                echo json_encode(
                    array(
                        "success" => false,
                        "error" => "Les paramètres sont incorrects"
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "success" => false,
                    "error" => "Les paramètres sont incorrects"
                )
            );
        }
    }


    public function crudAction() {
        if(!empty($_POST) && isset($_POST["action"])) {
            $action = $_POST["action"];

            if(($action === "addComposant" || $action === "updateComposant") && isset($_POST["id"])) {
                $id_composant = intval($_POST["id"]);

                if($action === "addComposant") {

                    $dateNow = new \DateTime("now");
                    $data = $this->rest(
                        "rest/composant/create",
                        array(
                            "nom" => $_POST["nom"],
                            "gamme" => $_POST["gamme"],
                            "dimensions" => $_POST["dimensions"],
                            "prix" => $_POST["prix"],
                        ),
                        "POST",
                        true
                    );
                } else {
                    $data = $this->rest(
                        "rest/composant/update",
                        array(
                            "id" => $_POST["id"],
                                "nom" => $_POST["nom"],
                                "gamme" => $_POST["gamme"],
                                "dimensions" => $_POST["dimensions"],
                                "prix" => $_POST["prix"],
                        ),
                        "POST",
                        true
                    );
                }

                if (!empty($data) && !isset($data["success"])) {
                    $composant = new Composant($data);

                    if(is_numeric($composant->getId())) {
                        $this->redirect("index.php?p=composant",
                            $action === "addComposant"
                            ? 0
                            : 2
                        );
                    } else {
                        $this->redirect("index.php?p=composant",
                            $action === "addComposant"
                            ? 1
                            : 3
                        );
                    }
                } else {
                    $this->redirect("index.php?p=composant",
                        $action === "addComposant"
                        ? 1
                        : 3
                    );
                }

            } elseif($action === "deleteComposant" && isset($_POST["id"])) {
                $id_composant = intval($_POST["id"]);

                $data = $this->rest(
                    "rest/composant/delete/$id_composant",
                    array(),
                    "GET",
                    true
                );
                // var_dump($data);

                if (!empty($data) && !isset($data["success"])) {
                    $this->redirect("index.php?p=composant", 4);
                } else {
                    $this->redirect("index.php?p=composant", 5);
                }
            }  else {
                $this->redirect("index.php?p=composant", 6);
            }
        } else {
            $this->redirect("index.php?p=composant", 6);
        }
    }


}
