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
			$this->api->update(['id' => $user['id']], ['token' => $this->input->post('token')], $this->table); */
		
		
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

		$asts = $this->api->getAstrologers();
		
		$response['row'] = $asts ? $asts : [];
		$response['error'] = $asts ? false : true;
		$response['message'] = $asts ? "Astrologers list success." : "Astrologers list not success.";

		echoRespnse(200, $response);
	}
}