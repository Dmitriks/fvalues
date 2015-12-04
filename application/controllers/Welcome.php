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
        $this->load->driver('cache');
        $this->load->helper('url');
        $this->config->load('values');
        $apiUrl = $this->config->item('api_url');
        $symbols = $this->config->item('symbols');
        $cacheTime = $this->config->item('cache_time');
        $quotes = $this->cache->file->get('quotes');
        if (!$quotes) {
            $url = $apiUrl . '&q=' . urlencode(implode(',', array_keys($symbols)));
            $quotes = file_get_contents($url);
            $this->cache->file->save('quotes', $quotes, $cacheTime);
        }
        $data['quotes'] = unserialize($quotes);
        $data['symbols'] = $symbols;
        $this->load->view('welcome', $data);
    }

}
