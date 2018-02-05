<?php

namespace App\ClientBundle\Entity;


class Client {
    private $id;
    private $adresse;
    private $cp;
    private $date_crea;
    private $nom;
    private $telephone;
    private $ville;


    public function __construct(array $donnees = null)
    {
        if($donnees !== null)
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = intval($id);

        return $this;
    }

    public function getAdresseComplete() {
        return $this->adresse . "\r\n"
            . $this->cp . " " . $this->ville . "\r\n"
            . $this->telephone;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp()
    {
        return $this->cp;
    }
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    public function getDate_crea()
    {
        return $this->date_crea;
    }
    public function setDate_crea($date_crea)
    {
        $this->date_crea = $date_crea;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }


}
