<?php

/**
 * Description of Import
 *
 * @author dmitrik
 */
class Import extends CI_Controller {

    /**
     * Get quotes
     */
    public function get_quotes() {
        $this->load->database();
        $this->load->model('symbol_model');
        $this->load->model('value_model');
        $this->config->load('values');
        $apiUrl = $this->config->item('api_url');
        $symbols = $this->symbol_model->get_symbol_codes();
        $url = $apiUrl . '&q=' . urlencode(implode(',', array_keys($symbols)));
        $content = file_get_contents($url);
        $quotes = unserialize($content);
        foreach ($quotes as $key => $value) {
            $data = array();
            $data['symbol_id'] = $symbols[$key];
            $data['bid'] = $value['bid'];
            $data['ask'] = $value['ask'];
            $data['time'] = strtotime('-2 hours', $value['lasttime']);
            // Get last minute value
            $lastMinuteValue = $this->value_model->get_last_minute_value($data['symbol_id']);
            // Save minute value
            if (!$lastMinuteValue || date('Y-m-d H:i', $lastMinuteValue['time']) != date('Y-m-d H:i', $data['time'])) {
                $this->value_model->insert_minute_value($data);
                $this->value_model->delete_old_minute_values($data['symbol_id'], strtotime('-1 hour'));
            }
            // Get last hour value
            $lastHourValue = $this->value_model->get_last_hour_value($data['symbol_id']);
            // Save hour value
            if (!$lastHourValue || date('Y-m-d H', $lastHourValue['time']) != date('Y-m-d H', $data['time'])) {
                $this->value_model->insert_hour_value($data);
                $this->value_model->delete_old_hour_values($data['symbol_id'], strtotime('-1 day'));
            }
            // Get last day value
            $lastDayValue = $this->value_model->get_last_day_value($data['symbol_id']);
            // Save day value
            if (!$lastDayValue || date('Y-m-d', $lastDayValue['time']) != date('Y-m-d', $data['time'])) {
                $this->value_model->insert_day_value($data);
            }
            // Get last month value
            $lastMonthValue = $this->value_model->get_last_month_value($data['symbol_id']);
            // Save hour value
            if (!$lastMonthValue || date('Y-m', $lastMonthValue['time']) != date('Y-m', $data['time'])) {
                $this->value_model->insert_month_value($data);
            }
        }
    }

}
