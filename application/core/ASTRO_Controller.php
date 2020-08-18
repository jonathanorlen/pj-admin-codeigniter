<?php

if(!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class ASTRO_Controller extends MX_Controller
{        
    function __construct()
    {
        parent::__construct();

        $basmalahsession = @$this->session->userdata('astrosession');

        if($basmalahsession == NULL ) {
            redirect('authenticate');
        }
    }
}

