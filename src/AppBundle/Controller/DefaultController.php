<?php


namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Ob\HighchartsBundle\Highcharts\Highchart;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        return $this->render('AppBundle:Default:homepage.html.twig');
    }

    public function chartAction()
    {
        $oneMonthAgo = (new \DateTime())->sub(new \DateInterval('P1M'));

        $categories = $this->buildCategories();

        $stazioni = $this->getDoctrine()->getRepository('AppBundle:Stazione')->findStazioniByIQAData($oneMonthAgo);

        $values = $this->buildValues($stazioni);

        $chart = $this->buildChart($categories, $values);

        return $this->render('AppBundle:Default:chart.html.twig', array(
            'chart' => $chart
        ));
    }


    private function buildCategories()
    {
        $oneMonthAgo = (new \DateTime())->sub(new \DateInterval('P1M'));

        $categories = [];

        for($i=0; $i<30; $i++) {
            $categories[] =  $oneMonthAgo->format('d-m-Y');
            $oneMonthAgo->add(new \DateInterval('P1D'));
        }

        return $categories;
    }

    private function buildValues($stazioni)
    {
        $finalValues = [];
        foreach($stazioni as $stazione) {
            $dataSeries = [];
            $existentValues = $stazione->getIQAValues();

            $start = (new \DateTime())->sub(new \DateInterval('P30D'));

            for($i=0; $i<30; $i++) {
                $currentData = $start->format('d-m-Y');
                $value = 0;

                if (array_key_exists($currentData,$existentValues)) {
                    $value = $existentValues[$currentData];
                }
                $dataSeries[] = $value;
                $start->add(new \DateInterval('P1D'));
            }
            $finalValues[] = array('name'=>$stazione->getNome(), 'data' => $dataSeries);
        }

        return $finalValues;
    }

    private function buildChart($categories, $values)
    {
        $ob = new Highchart();

        $ob->chart->renderTo('linechart');
        $ob->chart->type('spline');
        $ob->title->text('IQA - Arpa Sicilia');
        $ob->xAxis->title(array('text'  => "Ultimo mese"));
        $ob->xAxis->categories($categories);
        $ob->yAxis->title(array('text'  => "IQA"));
        $ob->yAxis->min(0);
        $ob->yAxis->plotBands([array('from'=>0, 'to'=>50, 'color'=>'#7ec0ee', 'label'=>['text'=>'Ottima', 'style'=>['color'=>'#606060']]),
            array('from'=>51,'to'=>70,'color'=>'#00ff00', 'label'=>['text'=>'Buona', 'style'=>['color'=>'#606060']]),
            array('from'=>71,'to'=>100,'color'=>'#ffff00', 'label'=>['text'=>'Accettabile', 'style'=>['color'=>'#606060']]),
            array('from'=>101,'to'=>150,'color'=>'#ffa500', 'label'=>['text'=>'Mediocre', 'style'=>['color'=>'#606060']]),
            array('from'=>151,'to'=>200,'color'=>'#ff0000', 'label'=>['text'=>'Scadente', 'style'=>['color'=>'#606060']]),
            array('from'=>201,'to'=>400,'color'=>'#a020f0', 'label'=>['text'=>'Pessima', 'style'=>['color'=>'#606060']])]);

        $ob->series($values);

        return $ob;
    }
}

