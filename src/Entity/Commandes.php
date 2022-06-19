<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandesRepository::class)
 */
class Commandes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=articles::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $garantie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Cadeau;

    /**
     * @ORM\Column(type="boolean")
     */
    private $envoierapide;

/**
     * @ORM\Column(type="boolean")
     */
    private $envoie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?articles
    {
        return $this->article;
    }

    public function setArticle(?articles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isGarantie(): ?bool
    {
        return $this->garantie;
    }

    public function setGarantie(bool $garantie): self
    {
        $this->garantie = $garantie;

        return $this;
    }

    public function isCadeau(): ?bool
    {
        return $this->Cadeau;
    }

    public function setCadeau(bool $Cadeau): self
    {
        $this->Cadeau = $Cadeau;

        return $this;
    }

    public function isEnvoierapide(): ?bool
    {
        return $this->envoierapide;
    }

    public function setEnvoierapide(bool $envoierapide): self
    {
        $this->envoierapide = $envoierapide;

        return $this;
    }
 public function isEnvoie(): ?bool
    {
        return $this->envoie;
    }

    public function setEnvoie(bool $envoie): self
    {
        $this->envoie = $envoie;

        return $this;
    }
}
