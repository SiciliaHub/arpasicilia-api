<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class StazioneRepository extends EntityRepository
{
    public function findStazioniByIQAData(\Datetime $dataInizio)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb = $qb->select('sta', 'q')
            ->from('\AppBundle\Entity\Stazione', 'sta')
            ->leftJoin('sta.iqa', 'q')
            ->where('q.data >= :dataInizio')
            ->setParameter('dataInizio', $dataInizio)
            ->orderBy('q.data','asc')
            ->getQuery();

        return $qb->getResult();
    }
}

