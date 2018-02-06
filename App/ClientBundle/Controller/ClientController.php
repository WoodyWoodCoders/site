<?php

namespace App\ClientBundle\Controller;

use Core\Controller;
use App\ClientBundle\Entity\Client;

class ClientController extends Controller {
    protected $viewPath = "App/ClientBundle/Views/";
    protected $errors = array(
        array(
            "success" => true,
            "message" => "Le client a bien été créé",
        ),
        array(
            "success" => false,
            "message" => "Le client n'a pas pu être créé",
        ),
        array(
            "success" => true,
            "message" => "Le client a bien été édité",
        ),
        array(
            "success" => false,
            "message" => "Le client n'a pas pu être édité",
        ),
        array(
            "success" => true,
            "message" => "Le client a bien été supprimé",
        ),
        array(
            "success" => false,
            "message" => "Le client n'a pas pu être supprimé",
        ),
        array(
            "success" => false,
            "message" => "Une erreur a eue lieu",
        ),
    );

    public function indexAction($showInLayout = true) {
        global $client;
        // if (!empty($client) && !empty($client->getToken())) {
        //     $this->redirect("index.php");
        // }

        $this->includeJS[] = "public/tools/datatables/datatables.min.js";
        $this->includeCSS[] = "public/tools/datatables/datatables.min.css";

        $this->includeJS[] = $this->viewPath . "script.js";
        // $this->includeCSS[] = $this->viewPath . "style.css";

        $data = $this->rest(
            "rest/client/get/all/dto",
            array(),
            "GET",
            true
        );

        $clients = array();

        if (!empty($data)) {
            foreach($data as $client) {
                $clients[] = new Client($client);
            }
        }

        $this->variables["clients"] = $clients;

        $this->afficher("annuaire", $showInLayout);
    }

    public function getAction() {
        if(!empty($_POST) && isset($_POST["action"])) {
            $action = $_POST["action"];

            if($action === "getClientModal" && isset($_POST["id"])) {
                $id_client = intval($_POST["id"]);
                if($id_client > 0 ) {

                    $data = $this->rest(
                        "rest/client/get/$id_client",
                        array(),
                        "GET",
                        true
                    );

                    if (!empty($data)) {
                        $client = new Client($data);
                    } else {
                        echo json_encode(
                            array(
                                "success" => false,
                                "error" => "Le client n'a pas été trouvé"
                            )
                        );
                    }
                } else {
                    $client = new Client();
                }


                $this->variables["client"] = $client;
                echo json_encode(
                    array(
                        "success" => true,
                        "content" => $this->getInclude($this->viewPath . "client.php")
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

            if(($action === "addClient" || $action === "updateClient") && isset($_POST["id"])) {
                $id_client = intval($_POST["id"]);

                if($action === "addClient") {

                    $dateNow = new \DateTime("now");
                    $data = $this->rest(
                        "rest/client/create",
                        array(
                            "nom" => $_POST["nom"],
                            "telephone" => $_POST["telephone"],
                            "adresse" => $_POST["adresse"],
                            "cp" => $_POST["cp"],
                            "ville" => $_POST["ville"],
                            "dateCrea" => $dateNow->format("Y-m-d"),
                        ),
                        "POST",
                        true
                    );
                } else {
                    $data = $this->rest(
                        "rest/client/update",
                        array(
                            "id" => $_POST["id"],
                            "nom" => $_POST["nom"],
                            "telephone" => $_POST["telephone"],
                            "adresse" => $_POST["adresse"],
                            "cp" => $_POST["cp"],
                            "ville" => $_POST["ville"],
                        ),
                        "POST",
                        true
                    );
                }

                if (!empty($data) && !isset($data["success"])) {
                    $client = new Client($data);

                    if(is_numeric($client->getId())) {
                        $this->redirect("index.php?p=client",
                            $action === "addClient"
                            ? 0
                            : 2
                        );
                    } else {
                        $this->redirect("index.php?p=client",
                            $action === "addClient"
                            ? 1
                            : 3
                        );
                    }
                } else {
                    $this->redirect("index.php?p=client",
                        $action === "addClient"
                        ? 1
                        : 3
                    );
                }

            } elseif($action === "deleteClient" && isset($_POST["id"])) {
                $id_client = intval($_POST["id"]);

                $data = $this->rest(
                    "rest/client/delete/$id_client",
                    array(),
                    "GET",
                    true
                );
                // var_dump($data);

                if (!empty($data) && !isset($data["success"])) {
                    $this->redirect("index.php?p=client", 4);
                } else {
                    $this->redirect("index.php?p=client", 5);
                }
            }  else {
                $this->redirect("index.php?p=client", 6);
            }
        } else {
            $this->redirect("index.php?p=client", 6);
        }
    }


}
