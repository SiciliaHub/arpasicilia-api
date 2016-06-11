<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MisurazioneRepository extends EntityRepository
{

    public function findInquinantiByStazione($idStazione)
    {
        $qb = $this->createQueryBuilder('mis')
            ->select('DISTINCT mis.inquinante')
            ->where('mis.stazione = :stazione')
            ->setParameter('stazione', $idStazione)
            ->getQuery();

        return $qb->getResult();
    }

    public function findMisurazioniByStazioneAndData($stazione, \DateTime $dataInizio = null, \DateTime $dataFine = null)
    {
        if ($dataInizio == null) {
            $dataInizio = (new \Datetime())->sub(new \DateInterval('P5Y'));
        }

        if ($dataFine == null) {
            $dataFine = new \DateTime();
        }


        $qb = $this->_em->createQueryBuilder();
        $qb = $qb->select('mis')
            ->from('\AppBundle\Entity\Misurazione', 'mis')
            ->where('mis.stazione = :stazione')
            ->andWhere('mis.data >= :dataInizio')
            ->andWhere('mis.data <= :dataFine')
            ->setParameter('stazione', $stazione)
            ->setParameter('dataInizio', $dataInizio)
            ->setParameter('dataFine', $dataFine)
            ->orderBy('mis.data','asc')
            ->getQuery();

        return $qb->getResult();
    }

    public function findMisurazioniByStazioneAndInquinanteAndData($stazione, $inquinante, \DateTime $dataInizio = null, \DateTime $dataFine = null)
    {

        if ($dataInizio == null) {
            $dataInizio = (new \Datetime())->sub(new \DateInterval('P5Y'));
        }

        if ($dataFine == null) {
            $dataFine = new \DateTime();
        }

        $qb = $this->_em->createQueryBuilder();
        $qb = $qb->select('mis')
                 ->from('\AppBundle\Entity\Misurazione', 'mis')
                 ->where('mis.stazione = :stazione')
                 ->andWhere('mis.inquinante = :inquinante')
                 ->andWhere('mis.data >= :dataInizio')
                 ->andWhere('mis.data <= :dataFine')
                 ->setParameter('stazione', $stazione)
                 ->setParameter('inquinante', $inquinante)
                 ->setParameter('dataInizio', $dataInizio)
                 ->setParameter('dataFine', $dataFine)
                 ->orderBy('mis.data','asc')
                 ->getQuery();

        return $qb->getResult();
    }
}

