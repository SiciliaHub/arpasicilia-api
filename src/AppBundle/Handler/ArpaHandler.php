<?php


namespace AppBundle\Handler;

use Doctrine\ORM\EntityManager;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class ArpaHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function getStazioni()
    {
        $payload = [];
        $payload = $this->getTitle();
        $payload['risultati'] = [];

        $stazioni = $this->em->getRepository('AppBundle:Stazione')->findAll();

        if ($stazioni != null) {
            $payload['risultati']['stazioni'] = $stazioni;

            return $payload;
        }


        $payload['risultati'] = 'Nessun dato caricato';

        return $payload;
    }

    public function getMisurazioni($params)
    {
        $numParams = count($params);

        $payload = [];
        $payload = $this->getTitle();
        $payload['risultati'] = [];

        $misurazioni = [];
        $misurazioni = $this->retrieveMisurazioni($params);

        if ($misurazioni != null) {
            $stazione = $misurazioni[0]->getStazione();
            $payload['risultati']['stazione'] = $this->getHeaderStazione($stazione);
            $payload['risultati']['stazione']['misurazioni'] = $misurazioni;

            return $payload;

        }

        $payload['risultati'] = 'Nessun dato caricato';

        return $payload;
    }


    public function getIQA($params)
    {
        $numParams = count($params);

        $payload = [];
        $payload = $this->getTitle();
        $payload['risultati'] = [];

        $iqa = $this->retrieveIQA($params);

        if ($iqa != null) {
            $stazione = $this->em->getRepository('AppBundle:Stazione')->findOneById($params['id_stazione']);
            $payload['risultati']['stazione'] = $this->getHeaderStazione($stazione);
            $payload['risultati']['stazione']['iqa'] = $iqa;

            return $payload;
        }

        $payload['risultati'] = 'Nessun dato caricato';

        return $payload;
    }


    private function retrieveMisurazioni($params)
    {
        if (count(array_diff_key($params, array_flip(['id_stazione'])))==0) {
            return $this->em->getRepository('AppBundle:Misurazione')->findBy(array('stazione'=>$params['id_stazione']), array('data' => 'DESC'));
        }
        elseif (count(array_diff_key($params, array_flip(['id_stazione', 'inquinante'])))==0) {
            return $this->em->getRepository('AppBundle:Misurazione')->findBy(array('stazione'=>$params['id_stazione'], 'inquinante'=>$params['inquinante']), array('data' => 'DESC'));
        }
        else {

            $dataInizio = $this->buildData($params['data_inizio'], true);

            if (count(array_diff_key($params, array_flip(['id_stazione', 'data_inizio'])))==0) {
                return $this->em->getRepository('AppBundle:Misurazione')->findMisurazioniByStazioneAndData($params['id_stazione'], $dataInizio);
            }

            elseif (count(array_diff_key($params, array_flip(['id_stazione', 'data_inizio', 'data_fine'])))==0) {
                $dataFine = $this->buildData($params['data_fine']);
                return $this->em->getRepository('AppBundle:Misurazione')->findMisurazioniByStazioneAndData($params['id_stazione'], $dataInizio, $dataFine);
            }

            elseif (count(array_diff_key($params, array_flip(['id_stazione', 'inquinante', 'data_inizio'])))==0) {
                return $this->em->getRepository('AppBundle:Misurazione')->findMisurazioniByStazioneAndInquinanteAndData($params['id_stazione'], $params['inquinante'], $dataInizio);
            }

            elseif (count(array_diff_key($params, array_flip(['id_stazione', 'inquinante', 'data_inizio', 'data_fine'])))==0) {
                $dataFine = $this->buildData($params['data_fine']);
                return $this->em->getRepository('AppBundle:Misurazione')->findMisurazioniByStazioneAndInquinanteAndData($params['id_stazione'], $params['inquinante'], $dataInizio, $dataFine);
            }

            return null;
        }
    }

    private function retrieveIQA($params)
    {
        if (count(array_diff_key($params, array_flip(['id_stazione'])))==0) {
            return $this->em->getRepository('AppBundle:IQA')->findBy(array('stazione'=>$params['id_stazione']), array('data' => 'DESC'));
        }
        if (count(array_diff_key($params, array_flip(['id_stazione', 'data_inizio'])))==0) {
            $dataInizio = $this->buildData($params['data_inizio'], true);
            return $this->em->getRepository('AppBundle:IQA')->findIQAByStazioneAndData($params['id_stazione'], $dataInizio);
        }
        if (count(array_diff_key($params, array_flip(['id_stazione', 'data_inizio', 'data_fine'])))==0) {
            $dataInizio = $this->buildData($params['data_inizio'], true);
            $dataFine = $this->buildData($params['data_fine']);
            return $this->em->getRepository('AppBundle:IQA')->findIQAByStazioneAndData($params['id_stazione'], $dataInizio, $dataFine);
        }

        return null;
    }

    private function getTitle()
    {
        return [
            'project' => 'OpenDataSicilia ARPA',
            'fonte_dati' => 'http://www.arpa.sicilia.it/',
            'licenza' => 'Opendata IODL 2.0',
            'licenza_link' => 'http://www.dati.gov.it/iodl/2.0/'
        ];
    }

    private function getHeaderStazione($stazione)
    {
        return [
            'id'     => $stazione->getId(),
            'nome'   => $stazione->getNome(),
            'comune' => $stazione->getComune()
        ];
    }


    private function buildData($dataString, $isDataInizio = false)
    {
        $data = \DateTime::createFromFormat("Y-m-d", $dataString);
        if ($this->dataIsValid($data)) {
            if ($isDataInizio) {
                $data->sub(new \DateInterval('P1D'));
            }

            return $data;
        }

        return null;
    }

    private function dataIsValid(\DateTime $date)
    {
        $errors = $date->getLastErrors();
        if (($errors['warning_count'] == 0) && ($errors['error_count'] == 0))
        {
            return true;
        }

        return false;
    }
}




