<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$this->layout->set('title', 'Accueil');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript',array());
		$this->layout->load('default', 'contents' , 'index/index');
	}
}
