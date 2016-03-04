<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Analysis controller
 * 
 * @author dmitrik
 */
class Analysis extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('symbol_model');
        $this->load->model('value_model');
        $this->load->helper('url');
    }

    /**
     * Index Page for this controller
     */
    public function index() {
        $this->config->load('values');
        $data['periods'] = $this->config->item('analysis_periods');
        $this->load->view('header', array('title' => 'Analysis'));
        $this->load->view('analysis', $data);
        $this->load->view('footer');
    }

    /**
     * Charts for symbol
     * 
     * @param string $code    Contains code of symbol
     * @param int    $periods Contains amount of periods
     * @param string $period  Contains name of period
     */
    public function symbol($code, $periods, $period) {
        $symbol = $this->symbol_model->get_symbol_by_code($code);
        if ($symbol) {
            $end = time();
            $begin = strtotime("-$periods $period", $end);
            if ($begin) {
                if ($period == 'hour') { // interval in hours
                    $values = $this->value_model->get_minute_values($symbol['id'], $begin, $end);
                } elseif ($period == 'day') { // interval in days
                    $values = $this->value_model->get_hour_values($symbol['id'], $begin, $end);
                } else { // interval in months
                    $values = $this->value_model->get_day_values($symbol['id'], $begin, $end);
                }
                $waves = $this->_getWaves($values);
                $this->_analyzeWaves($waves);
                $data = array('waves' => $waves, 'symbol' => $code, 'periods' => $periods, 'period' => $period);
                $this->load->view('header', array('title' => 'Analysis of ' . $symbol['name'] . ' (Last ' . $periods . ' ' . $period . 's)'));
                $this->load->view('table', $data);
                $this->load->view('footer');
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    /**
     * Get waves from array of values
     * 
     * @param array $values     Contains array of values
     * @return array
     */
    private function _getWaves($values) {
        $waves = array();
        if ($values) {
            $wIndex = 0;
            $startValue = $values[0]['bid'];
            $waves[$wIndex] = array('start_value' => $startValue, 'end_value' => $startValue, 'values' => array($values[0]), 'direction' => 0);
            $cnt = count($values);
            for ($i = 1; $i < $cnt; $i++) {
                $value = $values[$i]['bid'];
                if ($waves[$wIndex]['direction'] == 0) {
                    // start of first wave
                    if ($value > $waves[$wIndex]['end_value']) {
                        // wave up
                        $waves[$wIndex]['direction'] = 1;
                    } elseif ($value < $waves[$wIndex]['end_value']) {
                        // wave down
                        $waves[$wIndex]['direction'] = -1;
                    }
                    // continue first wave
                    $waves[$wIndex]['end_value'] = $value;
                    $waves[$wIndex]['values'][] = $values[$i];
                } elseif ($waves[$wIndex]['direction'] == 1) {
                    // wave up
                    if ($value >= $waves[$wIndex]['end_value']) {
                        // continue wave up
                        $waves[$wIndex]['end_value'] = $value;
                        $waves[$wIndex]['values'][] = $values[$i];
                    } else {
                        // new wave down
                        $waves[++$wIndex] = array('start_value' => $value, 'end_value' => $value, 'values' => array($values[$i]), 'direction' => -1);
                    }
                } elseif ($waves[$wIndex]['direction'] == -1) {
                    // wave down
                    if ($value <= $waves[$wIndex]['end_value']) {
                        // continue wave down
                        $waves[$wIndex]['end_value'] = $value;
                        $waves[$wIndex]['values'][] = $values[$i];
                    } else {
                        // new wave up
                        $waves[++$wIndex] = array('start_value' => $value, 'end_value' => $value, 'values' => array($values[$i]), 'direction' => 1);
                    }
                }
            }
        }
        return $waves;
    }

    /**
     * Analyze waves
     * 
     * @param array $waves
     */
    private function _analyzeWaves(&$waves) {
        $cnt = count($waves);
        $i = 0;
        while ($i < $cnt) {
            if ($waves[$i]['direction'] == 1) {
                if ($i + 1 < $cnt) {
                    if ($waves[$i]['start_value'] <= $waves[$i + 1]['end_value']) { // end of 2 is higher or equal than start of 1
                        if ($i + 3 < $cnt) {
                            if ($waves[$i]['end_value'] < $waves[$i + 3]['end_value']) { // 4 don't inersect 1
                                if ($i + 4 < $cnt) {
                                    $firstWave = $waves[$i]['end_value'] - $waves[$i]['start_value'];
                                    $thirdWave = $waves[$i + 2]['end_value'] - $waves[$i + 2]['start_value'];
                                    $fifthWave = $waves[$i + 4]['end_value'] - $waves[$i + 4]['start_value'];
                                    if ($thirdWave >= $firstWave || $thirdWave >= $fifthWave) { // 3 greater than 1 or 3 greater than 5
                                        $waves[$i]['marker'] = 1;
                                        $waves[$i + 1]['marker'] = 2;
                                        $waves[$i + 2]['marker'] = 3;
                                        $waves[$i + 3]['marker'] = 4;
                                        $waves[$i + 4]['marker'] = 5;
                                        if ($i + 9 < $cnt) {
                                            if ($waves[$i + 7]['end_value'] > $waves[$i]['start_value'] && $waves[$i + 7]['end_value'] < $waves[$i + 4]['end_value'] && $waves[$i + 9]['end_value'] > $waves[$i]['start_value']) { // end of C greater than start of 1 AND end of C less than end 5 AND end of C+2 greater than start of 1
                                                $waves[$i + 5]['marker'] = 'A';
                                                $waves[$i + 6]['marker'] = 'B';
                                                $waves[$i + 7]['marker'] = 'C';
                                                $i = $i + 8;
                                                continue;
                                            } else {
                                                $i = $i + 5;
                                                continue;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } elseif ($waves[$i]['direction'] == -1) {
                if ($i + 1 < $cnt) {
                    if ($waves[$i]['start_value'] >= $waves[$i + 1]['end_value']) { // end of 2 is less or equal than start of 1
                        if ($i + 3 < $cnt) {
                            if ($waves[$i]['end_value'] > $waves[$i + 3]['end_value']) { // 4 don't inersect 1
                                if ($i + 4 < $cnt) {
                                    $firstWave = $waves[$i]['start_value'] - $waves[$i]['end_value'];
                                    $thirdWave = $waves[$i + 2]['start_value'] - $waves[$i + 2]['end_value'];
                                    $fifthWave = $waves[$i + 4]['start_value'] - $waves[$i + 4]['end_value'];
                                    if ($thirdWave >= $firstWave || $thirdWave >= $fifthWave) { // 3 greater than 1 or 3 greater than 5
                                        $waves[$i]['marker'] = 1;
                                        $waves[$i + 1]['marker'] = 2;
                                        $waves[$i + 2]['marker'] = 3;
                                        $waves[$i + 3]['marker'] = 4;
                                        $waves[$i + 4]['marker'] = 5;
                                        if ($i + 9 < $cnt) {
                                            if ($waves[$i + 7]['end_value'] < $waves[$i]['start_value'] && $waves[$i + 7]['end_value'] > $waves[$i + 4]['end_value'] && $waves[$i + 9]['end_value'] < $waves[$i]['start_value']) { // end of C less than start of 1 AND end of C greater than end of 5 AND end of C+2 less then start of 1
                                                $waves[$i + 5]['marker'] = 'A';
                                                $waves[$i + 6]['marker'] = 'B';
                                                $waves[$i + 7]['marker'] = 'C';
                                                $i = $i + 8;
                                                continue;
                                            } else {
                                                $i = $i + 5;
                                                continue;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $i++;
        }
    }

}
