<?php

namespace App\ModuleBundle\Entity;


class Module {
    private $id;
    private $nom;
    private $dimensions;
    private $prix;
    private $dateCrea;
    private $composants = array();

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


    public function getDimensions()
    {
        return $this->dimensions;
    }
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

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
    public function getPrix()
    {
        return $this->prix;
    }
    public function setPrix($prix)
    {
        $this->prix = floatval($prix);

        return $this;
    }

    public function getDateCrea()
    {
        return $this->dateCrea;
    }
    public function setDateCrea($dateCrea)
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    public function getComposants()
    {
        return $this->composants;
    }
    public function setComposants($composants)
    {
        $this->composants = $composants;

        return $this;
    }


}
