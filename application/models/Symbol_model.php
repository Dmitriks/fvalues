<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Symbol model
 * 
 * @author dmitrik
 */
class Symbol_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Get symbol codes (code => id)
     * 
     * @return array
     */
    public function get_symbol_codes() {
        $result = array();
        $this->db->select('id,code');
        $query = $this->db->get('symbol');
        $symbols = $query->result_array();
        foreach ($symbols as $symbol) {
            $result[$symbol['code']] = $symbol['id'];
        }
        return $result;
    }

    /**
     * Get symbol names (id => name)
     * 
     * @return array
     */
    public function get_symbol_names() {
        $result = array();
        $this->db->select('id,name');
        $query = $this->db->get('symbol');
        $symbols = $query->result_array();
        foreach ($symbols as $symbol) {
            $result[$symbol['id']] = $symbol['name'];
        }
        return $result;
    }

}
