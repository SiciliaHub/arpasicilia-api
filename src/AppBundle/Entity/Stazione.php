<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

use AppBundle\Entity\Misurazione;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\StazioneRepository")
 * @ORM\Table(name="stazioni")
 * @ExclusionPolicy("all")
 */
class Stazione
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true )
     * @Expose
     */
    private $nome;

    /**
     * @ORM\Column(type="string", nullable=true )
     * @Expose
     */
    private $regione;


    /**
     * @ORM\Column(type="string", nullable=true )
     * @Expose
     */
    private $provincia;


    /**
     * @ORM\Column(type="string", nullable=true )
     * @Expose
     */
    private $comune;


    /**
     * @ORM\Column(type="float", nullable=true )
     * @Expose
     */
    private $latitudine;

    /**
     * @ORM\Column(type="float", nullable=true )
     * @Expose
     */
    private $longitudine;

    /**
     * @ORM\Column(type="string", nullable=true )
     * @Expose
     */
    private $inquinanti;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Misurazione", mappedBy="stazione")
     * @ORM\OrderBy({"data" = "DESC"})
     **/
    private $misurazioni;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IQA", mappedBy="stazione")
     * @ORM\OrderBy({"data" = "DESC"})
     **/
    private $iqa;



    public function __construct()
    {
        $this->misurazioni = new ArrayCollection();
        $this->iqa = new ArrayCollection();
    }


    /**
     * @param mixed $comune
     */
    public function setComune($comune)
    {
        $this->comune = $comune;
    }

    /**
     * @return mixed
     */
    public function getComune()
    {
        return $this->comune;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $latitudine
     */
    public function setLatitudine($latitudine)
    {
        $this->latitudine = $latitudine;
    }

    /**
     * @return mixed
     */
    public function getLatitudine()
    {
        return $this->latitudine;
    }

    /**
     * @param mixed $longitudine
     */
    public function setLongitudine($longitudine)
    {
        $this->longitudine = $longitudine;
    }

    /**
     * @return mixed
     */
    public function getLongitudine()
    {
        return $this->longitudine;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }





    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param mixed $regione
     */
    public function setRegione($regione)
    {
        $this->regione = $regione;
    }

    /**
     * @return mixed
     */
    public function getRegione()
    {
        return $this->regione;
    }

    /**
     * @param mixed $misurazioni
     */
    public function setMisurazioni($misurazioni)
    {
        $this->misurazioni = $misurazioni;
    }

    /**
     * @return mixed
     */
    public function getMisurazioni()
    {
        return $this->misurazioni;
    }

    /**
     * @param mixed $inquinanti
     */
    public function setInquinanti($inquinanti)
    {
        $this->inquinanti = $inquinanti;
    }

    /**
     * @return mixed
     */
    public function getInquinanti()
    {
        return $this->inquinanti;
    }

    /**
     * @param mixed $iqa
     */
    public function setIqa($iqa)
    {
        $this->iqa = $iqa;
    }

    /**
     * @return mixed
     */
    public function getIqa()
    {
        return $this->iqa;
    }

    public function getIQAValues()
    {
        $values = [];
        foreach($this->iqa as $singleIQA) {
            $values[$singleIQA->getData()->format('d-m-Y')] = $singleIQA->getValore();
        }

        return $values;
    }

}
