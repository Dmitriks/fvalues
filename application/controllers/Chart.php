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
        $this->_drawChartsForPeriod('hour');
    }

    /**
     * Charts for last day
     */
    public function last_day() {
        $this->_drawChartsForPeriod('day');
    }

    /**
     * Charts for last month
     */
    public function last_month() {
        $this->_drawChartsForPeriod('month');
    }

    /**
     * Charts for symbol
     * 
     * @param string $code    Contains code of symbol
     */
    public function symbol($code) {
        $this->load->helper('url');
        $this->load->library('pchart');
        $symbol = $this->symbol_model->get_symbol_by_code($code);
        if ($symbol) {
            $data['charts'] = array();
            $periods = array('hour', 'day', 'month');
            foreach ($periods as $period) {
                $fileName = 'img/chart/' . 'last_' . $period . '_' . str_replace('#', '', $symbol['code']) . '.png';
                $data['charts'][] = $fileName;
                $this->_drawChartForValueAndPeriod($symbol['id'], $symbol['name'], $period, $fileName);
            }
            $this->load->view('header', array('title' => $symbol['name']));
            $this->load->view('chart', $data);
            $this->load->view('footer');
        } else {
            show_404();
        }
    }

    /**
     * Charts for symbol
     * 
     * @param string $code          Contains code of symbol
     * @param string $ratioCode     Contains code of ratio symbol
     */
    public function ratio($code, $ratioCode) {
        $this->load->helper('url');
        $this->load->library('pchart');
        $symbol = $this->symbol_model->get_symbol_by_code($code);
        $ratioSymbol = $this->symbol_model->get_symbol_by_code($ratioCode);
        if ($symbol && $ratioSymbol) {
            $data['charts'] = array();
            $periods = array('hour', 'day', 'month');
            foreach ($periods as $period) {
                $fileName = 'img/chart/' . 'last_' . $period . '_' . str_replace('#', '', $symbol['code'])
                        . '_' . str_replace('#', '', $ratioSymbol['code']) . '.png';
                $data['charts'][] = $fileName;
                $valueName = $symbol['name'] . ' / ' . $ratioSymbol['name'];
                $this->_drawChartForValueAndPeriod($symbol['id'], $valueName, $period, $fileName, $ratioSymbol['id']);
            }
            $this->load->view('header', array('title' => $valueName));
            $this->load->view('chart', $data);
            $this->load->view('footer');
        } else {
            show_404();
        }
    }

    /**
     * Draw charts for period
     * 
     * @param string $period    Contains name of period
     */
    private function _drawChartsForPeriod($period) {
        $this->load->helper('url');
        $this->load->library('pchart');
        $symbols = $this->symbol_model->get_symbols();
        $data['charts'] = array();
        foreach ($symbols as $symbol) {
            $fileName = 'img/chart/' . 'last_' . $period . '_' . str_replace('#', '', $symbol['code']) . '.png';
            $data['charts'][] = $fileName;
            $this->_drawChartForValueAndPeriod($symbol['id'], $symbol['name'], $period, $fileName);
        }
        $title = 'Last ' . $period;
        $this->load->view('header', array('title' => $title));
        $this->load->view('chart', $data);
        $this->load->view('footer');
    }

    /**
     * Draw chart for value and period
     * 
     * @param int    $symbolId      Contains ID of symbol
     * @param string $valueName     Contains name of value
     * @param string $period        Contains name of period
     * @param string $fileName      Contains name of file
     * @param int    $ratioSymbolId Contains ID of ratio symbol 
     */
    private function _drawChartForValueAndPeriod($symbolId, $valueName, $period, $fileName, $ratioSymbolId = null) {
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
            $end = time();
            $begin = strtotime("-1 $period", $end);
            if ($period == 'hour') { // hour
                $values = $this->value_model->get_minute_values($symbolId, $begin, $end);
            } elseif ($period == 'day') { // day
                $values = $this->value_model->get_hour_values($symbolId, $begin, $end);
            } else { // month
                $values = $this->value_model->get_day_values($symbolId, $begin, $end);
            }
            $xPoints = array();
            $yPoints = array();
            $dateFormat = ($period == 'month') ? 'd/m' : 'H:i';
            if ($ratioSymbolId) {
                // Get ratio values
                if ($period == 'hour') { // hour
                    $ratioValues = $this->value_model->get_minute_values($ratioSymbolId, $begin, $end);
                } elseif ($period == 'day') { // day
                    $ratioValues = $this->value_model->get_hour_values($ratioSymbolId, $begin, $end);
                } else { // month
                    $ratioValues = $this->value_model->get_day_values($ratioSymbolId, $begin, $end);
                }
                // Count values
                $cnt = count($values);
                $ratioCnt = count($ratioValues);
                if ($ratioCnt < $cnt) {
                    $cnt = $ratioCnt;
                }
                // Fill X and Y arrays for ratio chart
                for ($i = 0; $i < $cnt; $i++) {
                    $value = $values[$i];
                    $ratioValue = $ratioValues[$i];
                    if ($ratioValue['bid']) {
                        $xPoints[] = date($dateFormat, $value['time']);
                        $yPoints[] = round($value['bid'] / $ratioValue['bid'], 2);
                    }
                }
            } else {
                // Fill X and Y arrays for simple chart
                foreach ($values as $value) {
                    $xPoints[] = date($dateFormat, $value['time']);
                    $yPoints[] = floatval($value['bid']);
                }
            }
            $title = $valueName . ' (Last ' . $period . ')';
            $this->_drawChart($xPoints, $yPoints, 850, 300, $title, $fileName);
        }
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
        $myPicture->setFontProperties(array("FontName" => APPPATH . "libraries/pChart/fonts/verdana.ttf", "FontSize" => 7));
        $myPicture->drawText(round($xSize / 2), 35, $title, array("FontSize" => 12, "Align" => TEXT_ALIGN_BOTTOMMIDDLE));

        /* Set the default font */
        //$myPicture->setFontProperties(array("FontName" => APPPATH . "libraries/pChart/fonts/verdana.ttf", "FontSize" => 7));

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
