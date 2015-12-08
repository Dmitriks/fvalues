<?php

if (!defined('BASEPATH'))
    exit('Not allowed');

/**
 * pChart library class
 */
class Pchart {

    public function __construct() {
        /* pChart library inclusions */
        require_once APPPATH . 'libraries/pChart/class/pData.class.php';
        require_once APPPATH . 'libraries/pChart/class/pDraw.class.php';
        require_once APPPATH . 'libraries/pChart/class/pImage.class.php';
    }

    function pData() {
        return new pData();
    }

    function pImage($xSize, $ySize, $dataSet = NULL, $transparentBackground = FALSE) {
        return new pImage($xSize, $ySize, $dataSet, $transparentBackground);
    }

}
