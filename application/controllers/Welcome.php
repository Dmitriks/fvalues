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
        // Get quotes from cache
        $data['quotes'] = $this->cache->file->get('quotes');
        if (!$data['quotes']) {
            // Get remote quotes
            $url = $apiUrl . '&q=' . urlencode(implode(',', array_keys($symbols)));
            $quotes = file_get_contents($url);
            $data['quotes'] = unserialize($quotes);
            $this->cache->file->save('quotes', $data['quotes'], $cacheTime);
            chmod(BASEPATH . '../application/cache/quotes', 0666);
        }
        $data['symbols'] = $symbols;
        $this->load->view('welcome', $data);
    }

}
