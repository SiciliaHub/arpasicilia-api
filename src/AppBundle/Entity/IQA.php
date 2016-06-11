<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IQARepository")
 * @ORM\Table(name="iqa")
 * @ExclusionPolicy("all")
 */
class IQA
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
     * @ORM\Column(type="float")
     * @Expose
     */
    private $valore;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stazione", inversedBy="iqa")
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
}


