<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function chat()
	{
		get();
		
		if($this->input->is_ajax_request()){
			$options = [
				'cluster' => 'ap2',
				'encrypted' => true
			];

			$pusher = new Pusher\Pusher('1bcc03ffc88b92ba0906', '8bf81f16e0fd1337000f', '1407436', $options);
			
			$data = ['message' => $this->input->post('message'), 'sender' => "ME", 'dt' => date('h:i a')];

			$pusher->trigger($this->api.'_channel', 'my-event', $data);
			//   echo 'error';
			  echo 'success';
		}else{
			$data['id'] = $this->api;
			return $this->load->view('chat', $data);
		}
	}

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();
    }

    protected $table = 'users';
}