<?php

namespace App\ComposantBundle\Entity;


class Composant {
    private $id;
    private $nom;
    private $gamme;
    private $dimensions;
    private $prix;

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

    public function getGamme()
    {
        return $this->gamme;
    }
    public function setGamme($gamme)
    {
        $this->gamme = intval($gamme);

        return $this;
    }

    public function getDimensions()
    {
        return $this->dimensions;
    }
    public function setDimensions($dimensions)
    {
        $this->dimensions = floatval($dimensions);

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

}
