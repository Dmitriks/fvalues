<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Chart controller
 * 
 * @author dmitrik
 */
class Chart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('symbol_model');
        $this->load->model('value_model');
    }

    /**
     * Index Page for this controller
     */
    public function index() {
        $this->last_day();
    }

    /**
     * Charts for last hour
     */
    public function last_hour() {
        $this->_drawChartWithLastValues('hour', 'H:i', 'Last hour');
    }

    /**
     * Charts for last day
     */
    public function last_day() {
        $this->_drawChartWithLastValues('day', 'H:i', 'Last 24 hours');
    }

    /**
     * Charts for last month
     */
    public function last_month() {
        $this->_drawChartWithLastValues('month', 'd/m', 'Last month');
    }

    /**
     * Draw chart with last values
     * 
     * @param string $period    Contains period
     * @param string $title     Contains title
     */
    private function _drawChartWithLastValues($period, $dateFormat, $title) {
        $this->load->helper('url');
        $this->load->library('pchart');
        $symbols = $this->symbol_model->get_symbol_names();
        $end = time();
        $begin = strtotime("-1 $period", $end);
        $data['charts'] = array();
        foreach ($symbols as $symbolId => $symbolName) {
            $fileName = 'img/chart/' . 'last_' . $period . '_' . str_replace(' ', '_', $symbolName) . '.png';
            $data['charts'][] = $fileName;
            $fileName = BASEPATH . '../' . $fileName;
            if ($period == 'hour') { // hour
                $lastValue = $this->value_model->get_last_minute_value($symbolId);
            } elseif ($period == 'day') { // day
                $lastValue = $this->value_model->get_last_hour_value($symbolId);
            } else { // month
                $lastValue = $this->value_model->get_last_day_value($symbolId);
            }
            // Check last date of image file
            if (!file_exists($fileName) || !$lastValue || filemtime($fileName) < $lastValue['time']) {
                if ($period == 'hour') { // hour
                    $values = $this->value_model->get_minute_values($symbolId, $begin, $end);
                } elseif ($period == 'day') { // day
                    $values = $this->value_model->get_hour_values($symbolId, $begin, $end);
                } else { // month
                    $values = $this->value_model->get_day_values($symbolId, $begin, $end);
                }
                $xPoints = array();
                $yPoints = array();
                foreach ($values as $value) {
                    $xPoints[] = date($dateFormat, $value['time']);
                    $yPoints[] = floatval($value['bid']);
                }
                $this->_drawChart($xPoints, $yPoints, 900, 300, $symbolName, $fileName);
            }
        }
        $this->load->view('header', array('title' => $title));
        $this->load->view('chart', $data);
        $this->load->view('footer');
    }

    /**
     * Draw chart
     * 
     * @param array $xPoints    Contains array of X points
     * @param array $yPoints    Contains array of Y points
     * @param int $xSize        Contains width
     * @param int $ySize        Contains height
     * @param string $title     Contains title
     * @param string $fileName  Contains name of file
     */
    private function _drawChart($xPoints, $yPoints, $xSize, $ySize, $title, $fileName) {
        /* Create and populate the pData object */
        $MyData = $this->pchart->pData();
        $MyData->addPoints($yPoints, "Line 1");
        $lSettings = array("R" => 0, "G" => 0, "B" => 255, "Alpha" => 80);
        $MyData->setPalette("Line 1", $lSettings);
        //$MyData->setAxisName(0, "USD");
        $MyData->addPoints($xPoints, "Dates");
        //$MyData->setSerieDescription("Dates", "Dates");
        $MyData->setAbscissa("Dates");

        /* Create the pChart object */
        $myPicture = $this->pchart->pImage($xSize, $ySize, $MyData);

        /* Draw the background */
        $bSettings = array("R" => 170, "G" => 183, "B" => 87, "Dash" => 1, "DashR" => 190, "DashG" => 203, "DashB" => 107);
        $myPicture->drawFilledRectangle(0, 0, $xSize, $ySize, $bSettings);

        /* Overlay with a gradient */
        $gSettings = array("StartR" => 219, "StartG" => 231, "StartB" => 139, "EndR" => 1, "EndG" => 138, "EndB" => 68, "Alpha" => 50);
        $myPicture->drawGradientArea(0, 0, $xSize, $ySize, DIRECTION_VERTICAL, $gSettings);

        /* Turn of Antialiasing */
        $myPicture->Antialias = FALSE;

        /* Add a border to the picture */
        $myPicture->drawRectangle(0, 0, $xSize - 1, $ySize - 1, array("R" => 0, "G" => 0, "B" => 0));

        /* Write the chart title */
        $myPicture->setFontProperties(array("FontName" => APPPATH . "libraries/pChart/fonts/Forgotte.ttf", "FontSize" => 11));
        $myPicture->drawText(150, 35, $title, array("FontSize" => 20, "Align" => TEXT_ALIGN_BOTTOMMIDDLE));

        /* Set the default font */
        $myPicture->setFontProperties(array("FontName" => APPPATH . "libraries/pChart/fonts/verdana.ttf", "FontSize" => 7));

        /* Define the chart area */
        $myPicture->setGraphArea(50, 40, $xSize - 30, $ySize - 40);

        /* Draw the scale */
        $scaleSettings = array("Floating" => TRUE, "DrawSubTicks" => TRUE, "CycleBackground" => TRUE);
        $myPicture->drawScale($scaleSettings);

        /* Turn on Antialiasing */
        $myPicture->Antialias = TRUE;

        /* Draw the line chart */
        $myPicture->drawLineChart(array("DisplayValues" => TRUE));

        /* Render the picture (choose the best way) */
        $myPicture->render($fileName);
    }

}
