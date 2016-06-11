<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class IQARepository extends EntityRepository
{
    public function findIQAByStazioneAndData($stazione, \Datetime $dataInizio = null, \Datetime $dataFine = null)
    {

        if ($dataInizio == null) {
            $dataInizio = (new \Datetime())->sub(new \DateInterval('P5Y'));
        }

        if ($dataFine == null) {
            $dataFine = new \DateTime();
        }

        $qb = $this->_em->createQueryBuilder();
        $qb = $qb->select('iqa')
            ->from('\AppBundle\Entity\IQA', 'iqa')
            ->where('iqa.stazione = :stazione')
            ->andWhere('iqa.data >= :dataInizio')
            ->andWhere('iqa.data <= :dataFine')
            ->setParameter('stazione', $stazione)
            ->setParameter('dataInizio', $dataInizio)
            ->setParameter('dataFine', $dataFine)
            ->orderBy('iqa.data','asc')
            ->getQuery();

        return $qb->getResult();
    }

}