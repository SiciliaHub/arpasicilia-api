<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\Annotation;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Get;
use Assert\Assertion;
use FOS\RestBundle\View\View;

use AppBundle\Handler\ArpaHandler;

class ApiController extends FOSRestController
{

    /**
     *
     * @Get("/misurazioni")
     * @QueryParam(name="id_stazione", requirements="\d+", strict=true, nullable=true, description="Id della stazione.")
     * @QueryParam(name="inquinante", description="Inquinante monitorato dalla stazione.")
     * @QueryParam(name="data_inizio", requirements="(\d{4})[\-](0?[1-9]|1[012])[\-]([12][0-9]|3[01]|0?[1-9])", strict=true, nullable=true, description="Data Inizio - es. 15-02-2015")
     * @QueryParam(name="data_fine",   requirements="(\d{4})[\-](0?[1-9]|1[012])[\-]([12][0-9]|3[01]|0?[1-9])", strict=true, nullable=true, description="Data Fine - es. 20-07-2015")
     *
     * @ApiDoc(
     *  description="Informazioni atmosferiche rilevate dalle stazioni dell'Arpa Sicilia",
     *  parameters={
     *      {"name"="id_stazione", "dataType"="integer", "required"=true, "description"="Id della stazione"},
     *      {"name"="inquinante", "dataType"="string", "required"=false, "description"="Nome dell'inquinante monitorato"},
     *      {"name"="data_inizio", "dataType"="date", "required"=false, "description"="Data inizio misurazioni - es. 15-02-2015"},
     *      {"name"="data_fine", "dataType"="date", "required"=false, "description"="Data fine misurazioni - es. 20-07-2015"}
     *  }
     * )
     */

    public function misurazioniAction(ParamFetcher $paramFetcher)
    {
        $params = array_filter($paramFetcher->all());
        $payload = $this->get('arpa.handler')->getMisurazioni($params);
        $this->view()->setFormat('json');
        $view =  $this->view($payload, 200);
        $this->initFormat($view);

        return $this->handleView($view);
    }


    /**
     * @Get("/stazioni")
     */

    public function stazioniAction()
    {

        $payload = $this->get('arpa.handler')->getStazioni();
        $this->view()->setFormat('json');
        $view =  $this->view($payload, 200);
        $this->initFormat($view);

        return $this->handleView($view);
    }


    /**
     *
     * @Get("/iqa")
     * @QueryParam(name="id_stazione", requirements="\d+", strict=true, nullable=true, description="Id della stazione.")
     * @QueryParam(name="data_inizio", requirements="(\d{4})[\-](0?[1-9]|1[012])[\-]([12][0-9]|3[01]|0?[1-9])", strict=true, nullable=true, description="Data Inizio - es. 15-02-2015")
     * @QueryParam(name="data_fine",   requirements="(\d{4})[\-](0?[1-9]|1[012])[\-]([12][0-9]|3[01]|0?[1-9])", strict=true, nullable=true, description="Data Fine - es. 20-07-2015")
     *
     * @ApiDoc(
     *  description="Informazioni indice qualità dell'aria",
     *  parameters={
     *      {"name"="id_stazione", "dataType"="integer", "required"=false, "description"="Id della stazione"},
     *      {"name"="data_inizio", "dataType"="date", "required"=false, "description"="Data inizio misurazioni - es. 15-02-2015"},
     *      {"name"="data_fine", "dataType"="date", "required"=false, "description"="Data fine misurazioni - es. 20-07-2015"}
     *  }
     * )
     */

    public function iqaAction(ParamFetcher $paramFetcher)
    {

        $params = array_filter($paramFetcher->all());
        $numParams = count($params);

        if ($numParams == 0) {
            return $this->redirectToRoute('homepage');
        }

        $payload = $this->get('arpa.handler')->getIQA($params);
        $view =  $this->view($payload, 200);
        $this->initFormat($view);

        return $this->handleView($view);
    }


    private function initFormat($view)
    {
        $format = $this->get('request')->attributes->get('_format');
        if ($format == '')
        {
            $view->setFormat('json');
        }
    }
}