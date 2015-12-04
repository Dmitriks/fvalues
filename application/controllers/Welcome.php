<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Welcome (start) controller
 * 
 * @author dmitrik
 */
class Welcome extends CI_Controller {

    /**
     * Index Page for this controller
     */
    public function index() {
        $this->load->helper('url');
        $this->config->load('values');
        $apiUrl = $this->config->item('api_url');
        $symbols = $this->config->item('symbols');
        $url = $apiUrl . '&q=' . urlencode(implode(',', array_keys($symbols)));
        $content = file_get_contents($url);
        $data['quotes'] = unserialize($content);
        $data['symbols'] = $symbols;
        $this->load->view('welcome', $data);
    }

}
