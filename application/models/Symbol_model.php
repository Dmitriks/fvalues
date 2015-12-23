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
     * Get symbol names (code => name)
     * 
     * @return array
     */
    public function get_symbol_names() {
        $result = array();
        $this->db->select('code,name');
        $this->db->where('visible', true);
        $this->db->order_by('sort', 'asc');
        $query = $this->db->get('symbol');
        $symbols = $query->result_array();
        foreach ($symbols as $symbol) {
            $result[$symbol['code']] = $symbol['name'];
        }
        return $result;
    }

    /**
     * Get symbols
     * 
     * @return array
     */
    public function get_symbols() {
        $this->db->where('visible', true);
        $this->db->order_by('sort', 'asc');
        $query = $this->db->get('symbol');
        return $query->result_array();
    }

    /**
     * Get symbol by code
     * 
     * @param string $code     Contains code of symbol
     * @return array
     */
    public function get_symbol_by_code($code) {
        $this->db->like('code', $code, 'before');
        $query = $this->db->get('symbol', 1);
        return $query->row_array();
    }

}
