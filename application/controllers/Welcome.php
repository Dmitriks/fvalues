<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $this->load->helper('url');
            $this->config->load('values');
            $apiUrl = $this->config->item('api_url');
            $symbols = $this->config->item('symbols');
            $url = $apiUrl . '&q=' . urlencode(implode(',' , array_keys($symbols)));
            $content = file_get_contents($url);
            $data['quotes'] = unserialize($content);
            $data['symbols'] = $symbols;
	    $this->load->view('welcome', $data);
	}
}
