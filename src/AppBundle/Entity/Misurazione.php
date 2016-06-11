<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MisurazioneRepository")
 * @ORM\Table(name="misurazioni")
 * @ExclusionPolicy("all")
 */
class Misurazione
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Expose
     * @Type("DateTime<'Y-m-d\TH:i:sO'>")
     */
    private $data;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    private $inquinante;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    private $um;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    private $tipologiaMisurazione;

    /**
     * @ORM\Column(type="float")
     * @Expose
     */
    private $valore;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stazione", inversedBy="misurazioni")
     * @ORM\JoinColumn(name="id_stazione", referencedColumnName="id", nullable=false)
     **/
    private $stazione;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
     * @param mixed $inquinante
     */
    public function setInquinante($inquinante)
    {
        $this->inquinante = $inquinante;
    }

    /**
     * @return mixed
     */
    public function getInquinante()
    {
        return $this->inquinante;
    }

    /**
     * @param mixed $stazione
     */
    public function setStazione($stazione)
    {
        $this->stazione = $stazione;
    }

    /**
     * @return mixed
     */
    public function getStazione()
    {
        return $this->stazione;
    }

    /**
     * @param mixed $tipologiaMisurazione
     */
    public function setTipologiaMisurazione($tipologiaMisurazione)
    {
        $this->tipologiaMisurazione = $tipologiaMisurazione;
    }

    /**
     * @return mixed
     */
    public function getTipologiaMisurazione()
    {
        return $this->tipologiaMisurazione;
    }

    /**
     * @param mixed $um
     */
    public function setUm($um)
    {
        $this->um = $um;
    }

    /**
     * @return mixed
     */
    public function getUm()
    {
        return $this->um;
    }

    /**
     * @param mixed $valore
     */
    public function setValore($valore)
    {
        $this->valore = $valore;
    }

    /**
     * @return mixed
     */
    public function getValore()
    {
        return $this->valore;
    }

}


