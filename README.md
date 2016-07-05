ARPA Sicilia API
===========

#### Stazioni ARPA Sicilia

    /arpa/api/stazioni.[json|xml] - lista stazioni geolocalizzate ARPA in Sicilia - (default formato JSON)

<a target="blank" href="http://www.gpirrotta.tk/arpa/api/stazioni">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/stazioni.xml">XML</a>


#### Misurazioni stazioni di rilevamento ARPA in Sicilia

    /arpa/api/misurazioni.[json|xml]   - Bollettino aria -  ARPA  - (default formato JSON)

* **id_stazione** - ID della stazione ARPA - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni?id_stazione=1 ">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni.xml?id_stazione=1">XML</a>
* **inquinante**  - nome dell'inquinante (SO2, Benzene, PM10, NO2, O3, PM2.5) - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni?id_stazione=3&inquinante=PM10">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni.xml?id_stazione=3&inquinante=PM10">XML</a>
* **data_inizio** - Data di inizio rilevamento dati (es. 2014-02-25) - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni.xml?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22">XML</a>
* **data_fine** - Data di fine rilevamento dati (es. 2014-03-13) - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22&data_fine=2016-05-03">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/misurazioni.xml?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22&data_fine=2016-05-03">XML</a>


####Indice di qualità dell'aria (IQA)
<a target="blank" href="http://www.arpa.vda.it/it/612-menu-meteorologia-previsioni/previsioni-di-qualita-dellaria/975/1831">Informazioni sull'indice di qualità dell'aria</a>

    /api/iqa.[json|xml]  - indice di qualità dell'aria - (default formato JSON)

* **id_stazione** - **(obbligatorio)** ID della stazione ARPA - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/iqa?id_stazione=6 ">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/stazioni.xml?id_stazione=6">XML</a>
* **data_inizio** - Data di inizio rilevamento dati (es. 2014-02-25) - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/iqa?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/iqa.xml?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22">XML</a>
* **data_fine** - Data di fine rilevamento dati     (es. 2014-03-13) - <a target="blank" href="http://www.gpirrotta.tk/arpa/api/iqa?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22&data_fine=2016-05-03">JSON</a> | <a  target="blank" href="http://www.gpirrotta.tk/arpa/api/iqa.xml?id_stazione=3&inquinante=PM10&data_inizio=2016-04-22&data_fine=2016-05-03">XML</a>

