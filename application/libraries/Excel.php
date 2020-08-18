<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ========================================== 
 *  Library Excel extend from PHP Excel 1.8.0
 *  ========================================== 
 */  
require_once APPPATH."/third_party/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}