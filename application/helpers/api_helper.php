<?php 
if ( ! function_exists('post'))
{
    function post()
    {
        $CI =& get_instance();
        if ($CI->input->server('REQUEST_METHOD') == "POST") {
            return TRUE;
        }else{
            $response['error'] = true;
            $response['message'] = "The page you are attempting to reach is currently not available.";
            
            echoRespnse(404, $response);
        }
    }
}

if ( ! function_exists('get'))
{
    function get()
    {
        $CI =& get_instance();
        if ($CI->input->server('REQUEST_METHOD') == "GET") {
            return TRUE;
        }else{
            $response['error'] = true;
            $response['message'] = "The page you are attempting to reach is currently not available.";
            
            echoRespnse(404, $response);
        }
    }
}

if ( ! function_exists('echoRespnse'))
{
    function echoRespnse($status_code, $response)
    {
        http_response_code ($status_code); 
        header('Content-Type: application/json');

        die(json_encode($response));
    }
}

if ( ! function_exists('verifyRequiredParams'))
{
    function verifyRequiredParams($required_fields=[])
    {
        $error = false;
        $error_fields = [];
        $request_params = array();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $CI =& get_instance();
            
            $CI->form_validation->set_error_delimiters('', '');
            
            if ($CI->form_validation->run() === FALSE)
            {
                $response['error'] = true;
                $response['message'] = $CI->form_validation->error_array();

                echoRespnse(200, $response);
            }
        }else{
            $request_params = $_REQUEST;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'PUT') 
        {
            parse_str($_SERVER['QUERY_STRING'], $request_params);
        }
        
        foreach ($required_fields as $field) 
        {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) 
            {
                $error = true;
                $error_fields[$field] = ucfirst($field).' is required';
            }
        }

        if ($error) 
        {
            $response["error"] = true;
            $response["message"] = $error_fields;
            
            echoRespnse(200, $response);
        }
    }
}