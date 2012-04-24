<?php

	require_once '../view/document.php';
	require_once '../config.php';

	abstract class Controller
	{
		protected $action;
		protected $destination;
		protected $repost_data;
	
		public function __construct()
		{
			$this->action = "";
			$this->destination = "index.php";
			$this->repost_data = array();
		}

		public function process()
		{
			$this->action = $_GET['action'];
			$this->execute();
			$url = SITE_URL.$this->destination;
			header('Location: '.$url) ;
		}

		protected function execute()
		{
		}
	}

?>