<?php

namespace App\ModuleBundle\Controller;

use Core\Controller;
use App\ModuleBundle\Entity\Module;
use App\ComposantBundle\Entity\Composant;

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

        $this->includeJS[] = "public/vendors/select2/dist/js/select2.min.js";
        $this->includeJS[] = "public/vendors/select2/dist/js/i18n/fr.js";
        $this->includeCSS[] = "public/vendors/select2/dist/css/select2.min.css";

        $this->includeJS[] = $this->viewPath . "script.js";
        // $this->includeCSS[] = $this->viewPath . "style.css";

        $data = $this->rest(
            "rest/module/get/all/dto",
            array(),
            "GET",
            true
        );

        $modules = array();

        if (!empty($data)) {
            foreach($data as $module) {
                $module = new Module($module);

                $composants = $this->rest(
                    "rest/module/get/all/composants/" . $module->getId(),
                    array(),
                    "GET",
                    true
                );
                if (!empty($composants)) {
                    $tab = array();
                    foreach($composants as $composant) {
                        if (!empty($composant)) {
                            $composant = new Composant($composant);
                            $tab[$composant->getId()] = $composant;
                        }
                    }
                    $module->setComposants($tab);
                }

                $modules[] = $module;
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
                    $module = $this->rest(
                        "rest/module/get/$id_module",
                        array(),
                        "GET",
                        true
                    );

                    if (!empty($module)) {
                        $module = new Module($module);
                        $moduleComposants = $this->rest(
                            "rest/module/get/all/composants/" . $module->getId(),
                            array(),
                            "GET",
                            true
                        );
                        if (!empty($moduleComposants)) {
                            $data = array();
                            foreach($moduleComposants as $composant) {
                                if (!empty($composant)) {
                                    $composant = new Composant($composant);
                                    $data[$composant->getId()] = $composant;
                                }
                            }
                            $module->setComposants($data);
                        }
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

                $allComposants = $this->rest(
                    "rest/composant/get/all/dto",
                    array(),
                    "GET",
                    true
                );
                $composants = array();
                // var_dump($allComposants);

                if (!empty($allComposants) && !isset($allComposants["success"])) {
                    foreach($allComposants as $composant) {
                        if (!empty($composant)) {
                            $composant = new Composant($composant);
                            $composants[] = $composant;
                        }
                    }
                }


                $this->variables["module"] = $module;
                $this->variables["composants"] = $composants;
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

                    if($action === "updateModule") {
                        $moduleComposants = $this->rest(
                            "rest/module/get/all/composants/" . $module->getId(),
                            array(),
                            "GET",
                            true
                        );
                        if (!empty($moduleComposants)) {
                            $data = array();
                            foreach($moduleComposants as $composant) {
                                if (!empty($composant)) {
                                    $composant = new Composant($composant);
                                    $data[$composant->getId()] = $composant;
                                }
                            }
                            $module->setComposants($data);
                        }
                    }

                    if(is_numeric($module->getId())) {
                        if(!empty($_POST["composants"])) {
                            foreach ($_POST["composants"] as $key => $id_composant) {
                                $id_composant = intval($id_composant);
                                if ($action === "addModule" || !isset($module->getComposants()[$id_composant])) {
                                    $data = $this->rest(
                                        "rest/module/set/composant/",
                                        array(
                                            "disposition" => $key,
                                            "composant" => array(
                                                "id" => $id_composant
                                            ),
                                            "module" => array(
                                                "id" => $module->getId()
                                            ),
                                        ),
                                        "POST",
                                        true
                                    );
                                }
                            }
                        }

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
