<?php

namespace App\ModuleBundle\Controller;

use Core\Controller;
use App\ModuleBundle\Entity\Module;

class ModuleController extends Controller {
    protected $viewPath = "App/ModuleBundle/Views/";
    protected $errors = array(
        array(
            "success" => true,
            "message" => "Le module a bien été créé",
        ),
        array(
            "success" => false,
            "message" => "Le module n'a pas pu être créé",
        ),
        array(
            "success" => true,
            "message" => "Le module a bien été édité",
        ),
        array(
            "success" => false,
            "message" => "Le module n'a pas pu être édité",
        ),
        array(
            "success" => true,
            "message" => "Le module a bien été supprimé",
        ),
        array(
            "success" => false,
            "message" => "Le module n'a pas pu être supprimé",
        ),
        array(
            "success" => false,
            "message" => "Une erreur a eue lieu",
        ),
    );

    public function indexAction($showInLayout = true) {
        global $module;
        // if (!empty($module) && !empty($module->getToken())) {
        //     $this->redirect("index.php");
        // }

        $this->includeJS[] = "public/tools/datatables/datatables.min.js";
        $this->includeCSS[] = "public/tools/datatables/datatables.min.css";

        $this->includeJS[] = $this->viewPath . "script.js";
        // $this->includeCSS[] = $this->viewPath . "style.css";

        $data = $this->rest(
            "rest/module/get/all",
            array(),
            "GET",
            true
        );

        $modules = array();

        if (!empty($data)) {
            foreach($data as $module) {
                $modules[] = new Module($module);
            }
        }

        $this->variables["modules"] = $modules;

        $this->afficher("annuaire", $showInLayout);
    }

    public function getAction() {
        if(!empty($_POST) && isset($_POST["action"])) {
            $action = $_POST["action"];

            if($action === "getModuleModal" && isset($_POST["id"])) {
                $id_module = intval($_POST["id"]);
                if($id_module > 0 ) {

                    $data = $this->rest(
                        "rest/module/get/$id_module",
                        array(),
                        "GET",
                        true
                    );

                    if (!empty($data)) {
                        $module = new Module($data);
                    } else {
                        echo json_encode(
                            array(
                                "success" => false,
                                "error" => "Le module n'a pas été trouvé"
                            )
                        );
                    }
                } else {
                    $module = new Module();
                }


                $this->variables["module"] = $module;
                echo json_encode(
                    array(
                        "success" => true,
                        "content" => $this->getInclude($this->viewPath . "module.php")
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

            if(($action === "addModule" || $action === "updateModule") && isset($_POST["id"])) {
                $id_module = intval($_POST["id"]);

                if($action === "addModule") {

                    $dateNow = new \DateTime("now");
                    $data = $this->rest(
                        "rest/module/create",
                        array(
                            "nom" => $_POST["nom"],
                            "dimensions" => $_POST["dimensions"],
                            "prix" => $_POST["prix"],
                            "dateCrea" => $dateNow->format("Y-m-d")
                        ),
                        "POST",
                        true
                    );
                } else {
                    $data = $this->rest(
                        "rest/module/update",
                        array(
                            "id" => $_POST["id"],
                                "nom" => $_POST["nom"],
                                "dimensions" => $_POST["dimensions"],
                                "prix" => $_POST["prix"],
                        ),
                        "POST",
                        true
                    );
                }

                if (!empty($data) && !isset($data["success"])) {
                    $module = new Module($data);

                    if(is_numeric($module->getId())) {
                        $this->redirect("index.php?p=module",
                            $action === "addModule"
                            ? 0
                            : 2
                        );
                    } else {
                        $this->redirect("index.php?p=module",
                            $action === "addModule"
                            ? 1
                            : 3
                        );
                    }
                } else {
                    $this->redirect("index.php?p=module",
                        $action === "addModule"
                        ? 1
                        : 3
                    );
                }

            } elseif($action === "deleteModule" && isset($_POST["id"])) {
                $id_module = intval($_POST["id"]);

                $data = $this->rest(
                    "rest/module/delete/$id_module",
                    array(),
                    "GET",
                    true
                );
                // var_dump($data);

                if (!empty($data) && !isset($data["success"])) {
                    $this->redirect("index.php?p=module", 4);
                } else {
                    $this->redirect("index.php?p=module", 5);
                }
            }  else {
                $this->redirect("index.php?p=module", 6);
            }
        } else {
            $this->redirect("index.php?p=module", 6);
        }
    }


}
