<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function purchased_plans()
	{
		get();

		$plans = $this->api_model->purchased_plans();

		$response['row'] = $plans ? $plans : [];
		$response['error'] = $plans ? false : true;
		$response['message'] = $plans ? "Purchased plans success." : "Purchased plans not success.";

		echoRespnse(200, $response);
	}

	public function chat_verify()
	{
		get();
		
		$plan = $this->main->plan_purchased($this->api);
		
		if(!$plan) {
			$response['error'] = true;
			$response['message'] = "You don't have active purchased plan or purchased plan is expired.";
		}else{
			$response['row'] = $plan;
			$response['error'] = false;
			$response['message'] = "Plan success.";
		}

		echoRespnse(200, $response);
	}

    public function purchase_plan()
    {
		post(); 

		$this->form_validation->set_rules('pack_id', 'Package ID', 'required|is_natural|max_length[4]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 4 chars allowed."]);
		$this->form_validation->set_rules('a_id', 'Astrologer ID', 'required|is_natural|max_length[4]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 4 chars allowed."]);
		$this->form_validation->set_rules('price', 'Price', 'required|is_natural|max_length[4]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 4 chars allowed."]);
		$this->form_validation->set_rules('validity', 'Validity', 'required|is_natural|max_length[2]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 2 chars allowed."]);
		$this->form_validation->set_rules('daily_validity', 'Daily Validity', 'required|is_natural|max_length[2]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'max_length' => "Max 2 chars allowed."]);
		// $this->form_validation->set_rules('payment_id', 'Payment ID', 'required|max_length[100]', ['required' => "%s is required", 'max_length' => "Max 100 chars allowed."]);

		verifyRequiredParams();

		$this->path = $this->config->item('payments');

		$image = $this->uploadImage('payment_id');
		
		if($image['error']) echoRespnse(200, $image);
		
		$post = [
			'u_id' 			 => $this->api,
			'created_at' 	 => time(),
			'price' 		 => $this->input->post('price'),
			'pack_id' 		 => $this->input->post('pack_id'),
			'a_id' 		     => $this->input->post('a_id'),
			'validity' 		 => $this->input->post('validity'),
			'daily_validity' => $this->input->post('daily_validity'),
			'payment_id' 	 => $image['message']
			// 'payment_id' => $this->input->post('payment_id')
		];

		$purchase = $this->main->add($post, 'purchased_plans');

		$response['row'] = $purchase ? "$purchase" : '0';
		$response['error'] = $purchase ? false : true;
		$response['message'] = $purchase ? "Plan purchase success." : "Plan purchase not success.";

		echoRespnse(200, $response);
    }

	public function profile()
	{
		get();

		$profile = $this->api_model->get($this->table, 'name, mobile, email, create_at, CONCAT("'.($this->path).'", image) image', ['id' => $this->api]);
		$profile['create_at'] = date('d-m-Y', $profile['create_at']);
		$profile['image'] = base_url(is_file($profile['image']) ? $profile['image'] : "assets/images/profile.png");
		$response['row'] = $profile;
		$response['error'] = false;
		$response['message'] = "Profile success.";

		echoRespnse(200, $response);
	}

	public function update_profile()
	{
		post();

		$validate = [
			[
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required|max_length[50]|alpha_numeric_spaces|trim',
				'errors' => [
					'required' => "%s is required",
					'alpha_numeric_spaces' => "%s is invalid",
					'max_length' => "Max 50 chars allowed"
				],
			],
			[
				'field' => 'mobile',
				'label' => 'Mobile',
				'rules' => 'required|is_natural|exact_length[10]|callback_mobile_check|trim',
				'errors' => [
					'required' => "%s is required",
					'is_natural' => "%s is invalid",
					'exact_length' => "%s is invalid",
				],
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|max_length[100]|callback_email_check|valid_email|trim',
				'errors' => [
					'required' => "%s is required",
					'valid_email' => "%s is invalid",
					'max_length' => "Max 100 chars allowed"
				],
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'max_length[100]|trim',
				'errors' => [
					'max_length' => "Max 100 chars allowed"
				],
			]
		];

		$this->form_validation->set_rules($validate);

		verifyRequiredParams();

		$post = [
			'name'   => $this->input->post('name'),
			'mobile'   => $this->input->post('mobile'),
			'email'   => $this->input->post('email'),
		];

		if($this->input->post('password')) $post['password'] = my_crypt($this->input->post('password'));

		if(!empty($_FILES['image']['name']))
		{
			$image = $this->uploadImage('image');
        
			if ($image['error'] == TRUE)
				echoRespnse(200, $image);
			else
			{
				$unlink = $this->path.$this->api_model->check($this->table, ['id' => $this->api], 'image');

				$post['image'] = $image['message'];
			}
		}
		
		$update = $this->api_model->update(['id' => $this->api], $post, $this->table);

		if($update && isset($unlink) && is_file($unlink)) unlink($unlink);

		$response['error'] = $update ? false : true;
		$response['message'] = $update ? "Profile update success." : "Profile update not success.";

		echoRespnse(200, $response);
	}

	public function chat_timer()
	{
		get();

		$time = $this->api_model->chat_timer();

		$response['row'] = $time ? $time : [];
		$response['error'] = $time ? false : true;
		$response['message'] = $time ? "Chat timer success." : "Chat timer not success.";

		echoRespnse(200, $response);
	}

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();

		$this->path = $this->config->item('users');
    }

    protected $table = 'users';

    /* public function chat()
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
	} */
}