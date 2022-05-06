<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        if ($this->session->auth) return redirect(admin('dashboard'));
	}

    protected $table = 'admins';

	public function index()
	{
        if ($this->form_validation->run('login') == FALSE)
        {
            $data['title'] = 'login';
            $data['name'] = 'login';
            
            return $this->template->load('auth/template', 'auth/login', $data);
        }
        else
        {
            $post = [
    			'mobile'   	 => $this->input->post('mobile'),
    			'password'   => my_crypt($this->input->post('password'))
    		];
            
    		$user = $this->main->get($this->table, 'id auth', $post);
    		
            if ($user) {
    			$this->session->set_userdata($user);
    			return redirect(admin('dashboard'));
    		}else{
    			$this->session->set_flashdata('error', 'Invalid credentials or account blocked.');
    			return redirect(admin('login'));
    		}
        }
	}

    public function forgot_password()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]',
                        ['required' => "%s is required", 'numeric' => "%s is invalid", 'exact_length' => "%s is invalid",
            ]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'forgot password';
            $data['name'] = 'forgot_password';
            
            return $this->template->load('auth/template', 'auth/forgot_password', $data);
        }
        else
        {
            $post = [
    			'mobile'   	 => $this->input->post('mobile')
    		];
            
    		if ($user = $this->main->get($this->table, 'id', $post)) {
                $this->load->helper('string');
                $update = [
                    'otp'   	 => random_string('numeric', 6),
                    'otp'   	 => 999999,
                    'update_at'  => date('Y-m-d H:i:s', strtotime('+5 minutes')),
                ];

                if ($this->main->update(['id' => $user['id']], $update, $this->table) === true) {
                    $this->session->set_flashdata('check_id', $user['id']);
                    // send_sms(); // pendig because sms panel not available.
                    return redirect(admin('check-otp'));
                }else{
                    $this->session->set_flashdata('error', 'Some error occurs. Try again.');
    			    return redirect(admin('forgot-password'));
                }
    		}else{
    			$this->session->set_flashdata('error', 'Mobile not registered or account blocked.');
    			return redirect(admin('forgot-password'));
    		}
        }
    }

    public function check_otp()
    {
        if (! $this->session->check_id) return redirect(admin('forgot-password'));
        $this->session->set_flashdata('check_id', $this->session->check_id);
        $this->form_validation->set_rules('otp', 'OTP', 'required|numeric|exact_length[6]',
                        ['required' => "%s is required", 'numeric' => "%s is invalid", 'exact_length' => "%s is invalid",
            ]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'check OTP';
            $data['name'] = 'check_otp';
            
            return $this->template->load('auth/template', 'auth/check_otp', $data);
        }
        else
        {
            $post = [
    			'id'   	        => $this->session->check_id,
    			'otp'   	    => $this->input->post('otp'),
    			'update_at >= ' => date('Y-m-d H:i:s')
    		];

    		if ($user = $this->main->get($this->table, 'id', $post)) {
                
                $update = ['otp' => 0];

                if ($this->main->update(['id' => $user['id']], $update, $this->table) === true) {
                    
                    return redirect(admin('change-password'));
                }else{
                    $this->session->set_flashdata('error', 'Some error occurs. Try again.');
    			    return redirect(admin('check-otp'));
                }
    		}else{
    			$this->session->set_flashdata('error', 'OTP expired or Invalid OTP.');
    			return redirect(admin('check-otp'));
    		}
        }
    }

    public function change_password()
    {
        if (! $this->session->check_id) return redirect(admin('forgot-password'));
        $this->session->set_flashdata('check_id', $this->session->check_id);
        
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[255]',
                        ['required' => "%s is required", 'max_length' => "%s is invalid"]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'change password';
            $data['name'] = 'change_password';
            
            return $this->template->load('auth/template', 'auth/change_password', $data);
        }
        else
        {
            $update = [
    			'password'   => my_crypt($this->input->post('password'))
    		];

            if ($this->main->update(['id' => $this->session->check_id], $update, $this->table) === true) {
                $this->session->set_flashdata('success', 'Password changed. Login with new password.');
                return redirect(admin('login'));
            }else{
                $this->session->set_flashdata('error', 'Password not changed. Try again.');
                return redirect(admin('change-password'));
            }
        }
    }
}