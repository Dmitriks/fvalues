<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home (start) controller
 * 
 * @author dmitrik
 */
class Home extends CI_Controller {

    /**
     * Index Page for this controller
     */
    public function index() {
        $this->load->driver('cache');
        $this->load->helper('url');
        $this->config->load('values');
        $apiUrl = $this->config->item('api_url');
        $cacheTime = $this->config->item('cache_time');
        // Get symbols from cache
        $symbols = $this->cache->file->get('symbols');
        if (!$symbols) {
            // Get symbols from database
            $this->load->database();
            $this->load->model('symbol_model');
            $symbols = $this->symbol_model->get_symbol_names();
            $this->cache->file->save('symbols', $symbols, $cacheTime);
            chmod(APPPATH . 'cache/symbols', 0666);
        }
        // Get quotes from cache
        $data['quotes'] = $this->cache->file->get('quotes');
        if (!$data['quotes']) {
            // Get remote quotes
            $url = $apiUrl . '&q=' . urlencode(implode(',', array_keys($symbols)));
            $quotes = file_get_contents($url);
            $data['quotes'] = json_decode($quotes);
            $this->cache->file->save('quotes', $data['quotes'], $cacheTime);
            chmod(APPPATH . 'cache/quotes', 0666);
        }
        $data['symbols'] = $symbols;
        $this->load->view('header', array('title' => 'Foreign exchange and commodity values'));
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

}
