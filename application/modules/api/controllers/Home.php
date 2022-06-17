<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends API_controller {

	public function __construct()
    {
        parent::__construct($this->table);
		$this->load->model('api_model', 'api');
    }

    protected $table = 'users';
	
	public function login()
	{
		post();

		$this->form_validation->set_rules('mobile', 'Mobile', 'required|is_natural|exact_length[10]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'exact_length' => "%s is invalid"]);
		$this->form_validation->set_rules('password', 'Password', 'required', ['required' => "%s is required"]);
		// $this->form_validation->set_rules('token', 'Token', 'required', ['required' => "%s is required"]);
		verifyRequiredParams();
		
		$post = [
			'mobile'     => $this->input->post('mobile'),
			'password'   => my_crypt($this->input->post('password')),
		];
		
		$user = $this->api->getProfile($post);

		/* if($user)
		{
			$this->api->update(['id' => $user['id']], ['token' => $this->input->post('token')], $this->table);
		} */
		
		$response['row'] = $user ? $user : [];
		$response['error'] = $user ? false : true;
		$response['message'] = $user ? "Login success." : "Invalid credentials or mobile not registered.";

		echoRespnse(200, $response);
	}

	public function forgot_password()
	{
		post();

		$this->form_validation->set_rules('mobile', 'Mobile', 'required|is_natural|exact_length[10]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'exact_length' => "%s is invalid"]);
		
		verifyRequiredParams();
		
		$post = [
			'mobile'     => $this->input->post('mobile')
		];

		$user = $this->api->getProfile($post);
		
		$response['row'] = $user ? ['otp' => rand(1000, 9999), 'mobile' => $this->input->post('mobile')] : [];
		$response['error'] = $user ? false : true;
		$response['message'] = $user ? "OTP send success." : "Mobile not registered.";

		echoRespnse(200, $response);
	}

	public function change_password()
	{
		post();

		$this->form_validation->set_rules('mobile', 'Mobile', 'required|is_natural|exact_length[10]', ['required' => "%s is required", 'is_natural' => "%s is invalid", 'exact_length' => "%s is invalid"]);
		$this->form_validation->set_rules('password', 'Password', 'required', ['required' => "%s is required"]);
		
		verifyRequiredParams();
		
		$post = [
			'password'   => my_crypt($this->input->post('password'))
		];

		$id = $this->api->update(['mobile' => $this->input->post('mobile')], $post, $this->table);
		
		$response['error'] = $id ? false : true;
		$response['message'] = $id ? "Password change success." : "Password change not success.";

		echoRespnse(200, $response);
	}

	public function register()
	{
		post();

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[50]', ['required' => "%s is required", 'max_length' => "Max 50 chars allowed"]);
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|is_natural|exact_length[10]|is_unique[users.mobile]', ['required' => "%s is required", 'exact_length' => "%s is invalid", 'is_unique' => '%s is already in use']);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[100]|is_unique[users.email]', ['required' => "%s is required", 'max_length' => "Max 100 chars allowed", '%s is invalid', 'is_unique' => '%s is already in use']);
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[100]', ['required' => "%s is required", 'max_length' => "Max 50 chars allowed"]);
		
		verifyRequiredParams();
		
		$post = [
			'name'       => $this->input->post('name'),
			'mobile'     => $this->input->post('mobile'),
			'email'      => $this->input->post('email'),
			'password'   => my_crypt($this->input->post('password')),
			'create_at'  => time()
		];
		
		$user = $this->api->add($post, $this->table);

		$response['row'] = $user ? $user : 0;
		$response['error'] = $user ? false : true;
		$response['message'] = $user ? "Register success." : "Register not success.";

		echoRespnse(200, $response);
	}

	public function getBanners()
	{
		get();

		$banners = $this->api->getBanners();
		
		$response['row'] = $banners ? $banners : [];
		$response['error'] = $banners ? false : true;
		$response['message'] = $banners ? "Banner list success." : "Banner list not success.";

		echoRespnse(200, $response);
	}

	public function getCategoryList()
	{
		get();

		$cats = $this->api->getCategoryList();
		
		$response['row'] = $cats ? $cats : [];
		$response['error'] = $cats ? false : true;
		$response['message'] = $cats ? "Category list success." : "Category list not success.";

		echoRespnse(200, $response);
	}

	public function getAstrologers()
	{
		get();

		$asts = $this->api->getAstrologers($this->input->get('c_id'));
		
		$response['row'] = $asts ? $asts : [];
		$response['error'] = $asts ? false : true;
		$response['message'] = $asts ? "Astrologers list success." : "Astrologers list not success.";

		echoRespnse(200, $response);
	}

	public function getPackagesList()
	{
		get();

		$packs = $this->api->getPackagesList();
		
		$response['row'] = $packs ? $packs : [];
		$response['error'] = $packs ? false : true;
		$response['message'] = $packs ? "Packages list success." : "Packages list not success.";

		echoRespnse(200, $response);
	}

	public function chat_verify($id)
	{
		$plan = $this->main->get('purchased_plans', 'created_at, validity, daily_validity', ['is_approved' => 1, 'u_id' => $id]);
			
		if(!$plan)
		{
			$response['error'] = true;
			$response['message'] = "You don't have active purchased plan.";
		}else{
			if(date("d-m-Y", strtotime('+ '.$plan['validity'].' Days')) < date("d-m-Y", $plan['created_at']))
			{
				$response['error'] = true;
				$response['message'] = "Your purchased plan is expired.";
				
			}else{
				
				$this->load->model('api_model');
				$chat_timer = $this->api_model->chat_timer($plan, $id);

				if($chat_timer['t_time'] <= date('H:i:s'))
				{
					$response['error'] = true;
					$response['message'] = "Your daily time is over.";
				}else{
					$response['row'] = $chat_timer['t_time'];
					$response['error'] = false;
					$response['message'] = "Your can chat now.";
				}
			}
		}

		echoRespnse(200, $response);
	}

	public function chat($id)
	{
		if($this->input->is_ajax_request()){
			$options = [
				'cluster' => 'ap2',
				'encrypted' => true
			];

			$pusher = new Pusher\Pusher('1bcc03ffc88b92ba0906', '8bf81f16e0fd1337000f', '1407436', $options);
			
			$data = ['message' => $this->input->post('message'), 'sender' => "ME", 'dt' => date('d-m-Y h:i a')];

			$pusher->trigger(e_id($id).'_channel', 'my-event', $data);

			$post = [
                'message'      => $data['message'],
                'created_at'   => time(),
                'created_by'   => $id,
                'u_id'         => $id,
                'message_type' => 'User'
            ];

			echo ($this->main->add($post, 'chats')) ? 'success' : 'error';
		}else{

			$data['id'] = $id;
			$data['chats'] = $this->main->getAll('chats', 'message, created_at, message_type', ['u_id' => $id], '', 100);
			
			return $this->load->view('chat', $data);
		}
	}
}