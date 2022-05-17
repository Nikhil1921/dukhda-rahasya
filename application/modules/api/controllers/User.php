<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function chat()
	{	
		if($this->input->is_ajax_request()){
			$options = [
				'cluster' => 'ap2',
				'encrypted' => true
			];

			$pusher = new Pusher\Pusher('1bcc03ffc88b92ba0906', '8bf81f16e0fd1337000f', '1407436', $options);
			
			$data = ['message' => $this->input->post('message'), 'sender' => "ME", 'dt' => date('d-m-Y h:i a')];

			$pusher->trigger(e_id($this->api).'_channel', 'my-event', $data);
			
			$post = [
                'message'      => $data['message'],
                'created_at'   => time(),
                'created_by'   => $this->api,
                'u_id'         => $this->api,
                'message_type' => 'User'
            ];

			echo ($this->main->add($post, 'chats')) ? 'success' : 'error';
		}else{
			$data['id'] = $this->api;
			$data['chats'] = $this->main->getAll('chats', 'message, created_at, message_type', ['u_id' => $this->api], '', 100);
			return $this->load->view('chat', $data);
		}
	}

    public function purchase_plan()
    {
		post();

		$this->form_validation->set_rules('price', 'Price', 'required|is_natural|max_length[4]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 4 chars allowed."]);
		$this->form_validation->set_rules('validity', 'Validity', 'required|is_natural|max_length[2]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 2 chars allowed."]);
		$this->form_validation->set_rules('payment_id', 'Payment ID', 'required|max_length[100]', ['required' => "%s is required", 'max_length' => "Max 100 chars allowed."]);

		verifyRequiredParams();

		$post = [
			'u_id' => $this->api,
			'created_at' => time(),
			'price' => $this->input->post('price'),
			'validity' => $this->input->post('validity'),
			'payment_id' => $this->input->post('payment_id')
		];

		$purchase = $this->main->add($post, 'purchased_plans');

		$response['row'] = $purchase ? $purchase : 0;
		$response['error'] = $purchase ? false : true;
		$response['message'] = $purchase ? "Plan purchase success." : "Plan purchase not success.";

		echoRespnse(200, $response);
    }

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();
    }

    protected $table = 'users';
}