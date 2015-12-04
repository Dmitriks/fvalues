<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Value model
 * 
 * @author dmitrik
 */
class Value_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Get last value
     * 
     * @param int       $symbol_id  Contains ID of symbol
     * @param string    $table      Contains table   
     * @return array
     */
    private function _get_last_value($symbol_id, $table) {
        $this->db->where('symbol_id', $symbol_id);
        $this->db->order_by('time', 'desc');
        $query = $this->db->get($table, 1);
        return $query->row_array();
    }

    /**
     * Get last minute value
     * 
     * @param int $symbol_id    Contains ID of symbol
     * @return array
     */
    public function get_last_minute_value($symbol_id) {
        return $this->_get_last_value($symbol_id, 'minute_value');
    }

    /**
     * Get last hour value
     * 
     * @param int $symbol_id    Contains ID of symbol
     * @return array
     */
    public function get_last_hour_value($symbol_id) {
        return $this->_get_last_value($symbol_id, 'hour_value');
    }

    /**
     * Get last day value
     * 
     * @param int $symbol_id    Contains ID of symbol
     * @return array
     */
    public function get_last_day_value($symbol_id) {
        return $this->_get_last_value($symbol_id, 'day_value');
    }

    /**
     * Get last month value
     * 
     * @param int $symbol_id    Contains ID of symbol
     * @return array
     */
    public function get_last_month_value($symbol_id) {
        return $this->_get_last_value($symbol_id, 'month_value');
    }

    /**
     * Insert minute value
     * 
     * @param array $data   Contains data
     */
    public function insert_minute_value($data) {
        $this->db->insert('minute_value', $data);
    }

    /**
     * Insert hour value
     * 
     * @param array $data   Contains data
     */
    public function insert_hour_value($data) {
        $this->db->insert('hour_value', $data);
    }

    /**
     * Insert day value
     * 
     * @param array $data   Contains data
     */
    public function insert_day_value($data) {
        $this->db->insert('day_value', $data);
    }

    /**
     * Insert month value
     * 
     * @param array $data   Contains data
     */
    public function insert_month_value($data) {
        $this->db->insert('month_value', $data);
    }

}
