<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index()
    {
        if ($this->migration->latest()) {
            echo 'Migrations ran successfully.';
        } else {
            echo $this->migration->error_string();
        }
    }
}
