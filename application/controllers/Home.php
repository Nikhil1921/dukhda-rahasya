<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller {
	
	public function index()
	{
        return redirect(admin());
	}
}