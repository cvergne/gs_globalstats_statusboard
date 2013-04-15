<?php
    /**
    *
    * "3 last months Browsers stats" from Statcounter ( http://gs.statcounter.com/ )
    * Widget for Panic's Status Board
    * Developer: Christophe VERGNE
    *
    **/


    header('Content-type: application/json');

    // #Cache use (optionnal)
    if (file_exists('./cacheClass.php')) {
        require_once('./cacheClass.php');
        $oCache = new Caching();
        $fileCache = $oCache->getCache("_gs");
    }

    // #If no cache
    if (!isset($fileCache) || !$fileCache) {

        // #Date range
        $gs_dateFrom = date('Y-m', strtotime('3 months ago'));
        $gs_dateTo = date('Y-m', strtotime('1 month ago'));

        // #"API" uri
        $gs_Uri = 'http://gs.statcounter.com/chart.php?bar=1&statType_hidden=browser_version_partially_combined&region_hidden=ww&granularity=monthly&statType=Browser%20Version%20(Partially%20Combined)&region=Worldwide&fromMonthYear=' . $gs_dateFrom . '&toMonthYear=' . $gs_dateTo;

        $result = array(
            'graph' => array(
                'title' => 'Browser Versions',
                'type' => 'bar'
            )
        );

        // #Data limit
        $limit = 5;
        if (isset($_GET['limit'])) {
            $limit = intval($_GET['limit']);
        }
        $current = 1;

        // #Parse data
        $gs_xml = @simplexml_load_file($gs_Uri);

        if ($gs_xml) {
            foreach ($gs_xml->set as $set) {
                $result['graph']['datasequences'][] = array(
                    'title' => (string)$set['label'],
                    'datapoints' => array(
                        array(
                            'title' => '',
                            'value' => floatval($set['value'])
                        )
                    )
                );
                if ($current++ == $limit) {
                    break;
                }
            }
        }
        else {
            $result['graph']['error'] = array(
                'message' => 'Oops, an error has occured.',
                'detail' => 'The stats load does not work, something is wrong with the url.'
            );
        }

        echo json_encode($result);

        // #If cache set -> saveCache
        if (isset($oCache)) {
            $oCache->saveCache();
        }
    }
?>
