<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PackRepository")
 */
class Pack extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->date = new \DateTime();
        $this->amis = new \Doctrine\Common\Collections\ArrayCollection();

        // your own logic
    }

    /**
     * Random string
     * @ORM\Column(name="prenom", type="string", length=255)
     * @var string
     */
    protected $prenom;
    /**
     * Random string
     * @ORM\Column(name="couleur", type="string", length=255)
     * @var string
     */
    protected $couleur;
    /**
     * Random date
     * @ORM\Column(name="date", type="date")
     * @var string
     */
    protected $date;
    /**
     * Random string
     * @ORM\Column(name="famille", type="string", length=255)
     * @var string
     */
    protected $famille;
    /**
     * Random string
     * @ORM\Column(name="nourriture", type="string", length=255)
     * @var string
     */
    protected $nouriture;
    /**
     * @ORM\ManyToMany(targetEntity="Pack")
     * @ORM\JoinColumn(name="id",referencedColumnName="id",onDelete="cascade")
     */
    private $amis;

    /**
     * Set nouriture
     *
     * @param string $nouriture
     *
     * @return Pack
     */
    public function setNouriture($nouriture)
    {
        $this->nouriture = $nouriture;

        return $this;
    }

    /**
     * Get nouriture
     *
     * @return string
     */
    public function getNouriture()
    {
        return $this->nouriture;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Pack
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Pack
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }


    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Pack
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Pack
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amis
     *
     */
    public function setAmis(\App\Entity\Pack $amis = null)
    {
        $this->amis = $amis;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAmis()
    {
        return $this->amis;
    }

    /**
     * Add amis
     *
     * @param \App\Entity\Pack $amis
     *
     */
    public function addAmis(\App\Entity\Pack $amis)
    {
        $this->amis[] = $amis;

        return $this;
    }

    /**
     * Remove amis
     *
     * @param \App\Entity\Pack $amis
     */
    public function removeAmis(\App\Entity\Pack $amis)
    {
        $this->amis->removeElement($amis);
    }
}
