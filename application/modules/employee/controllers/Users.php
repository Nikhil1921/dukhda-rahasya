<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('users');
	}

	private $table = 'users';
	protected $redirect = 'users';
	protected $title = 'User';
	protected $name = 'users';
	
	public function index()
	{
        $data['title'] = $this->title;
        $data['name'] = $this->name;
        $data['url'] = $this->redirect;
        $data['operation'] = "List";
        
		
		return $this->template->load('template', "$this->redirect/home", $data);
	}
}