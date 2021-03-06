<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class API_controller extends MY_Controller
{
	public function __construct($table)
	{
		parent::__construct();
		$this->load->helper('api');
        $this->table = $table;
	}

	public function verify_api_key()
	{
		$headers = apache_request_headers();
        $response = array();
        
        if (isset($headers['Authorization'])) 
        {
            $key = str_replace('"', "", $headers['Authorization']);
            
            if (! $k = $this->main->check($this->table, ['id' => $key], 'id'))
            {
                $response["error"] = true;
                $response["message"] = "Unauthorized User";
                echoRespnse(200, $response);
            } else {
                return $key;
            }
        } else {
            $response["error"] = true;
            $response["message"] = "Api key is missing";
            echoRespnse(200, $response);
        }
	}

    public function mobile_check($str)
    {
        $where = ['mobile' => $str, 'id != ' => $this->api];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $where = ['email' => $str, 'id != ' => $this->api];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

	public function error_404()
	{
		$response['error'] = true;
		$response['message'] = "The page you are attempting to reach is currently not available.";
		
		echoRespnse(404, $response);
	}
}