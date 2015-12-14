<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Borino extends MY_Controller
{

    public function index() {
        header("Location: http://merlinlead.net/ebook#_a_borino");
        die();
    }

}