<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class MY_Controller extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_modal', 'main');
	}

	protected function uploadImage($upload, $exts='jpg|jpeg|png', $size=[], $name=null, $thumb=[])
    {
        $this->load->library('upload');
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => $exts,
                'file_name'        => $name ? $name : time(),
                'file_ext_tolower' => TRUE,
                'overwrite'        => FALSE
            ];
            
        $config = array_merge($config, $size);
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($upload)){
            if ($thumb) {
                $this->load->library('image_lib');
                $t_config['image_library'] = 'gd2';
                $t_config['source_image'] = $this->upload->data('full_path');
                $t_config['new_image'] = $this->path."thumb/";
                $t_config['maintain_ratio'] = TRUE;
                $t_config = array_merge($t_config, $thumb);
                $this->image_lib->initialize($t_config);
                $this->image_lib->resize();
                $this->image_lib->clear();
                $img_th = $this->upload->data("file_name");
                $name_th = $this->upload->data("raw_name");
                
                if (in_array($this->upload->data('file_ext'), ['.jpg', '.jpeg']))
                    $image_th = imagecreatefromjpeg($this->path."thumb/".$img_th);
                if ($this->upload->data('file_ext') == '.png')
                    $image_th = imagecreatefrompng($this->path."thumb/".$img_th);

                if (isset($image_th)){
                    convert_webp($this->path."thumb/", $image_th, $name_th);
                    unlink($this->path."thumb/".$img_th);
                    $img_th = "$name_th.webp";
                }
            }

            $img = $this->upload->data("file_name");
            $name = $this->upload->data("raw_name");
            
            if (in_array($this->upload->data('file_ext'), ['.jpg', '.jpeg']))
                $image = imagecreatefromjpeg($this->path.$img);
            if ($this->upload->data('file_ext') == '.png')
                $image = imagecreatefrompng($this->path.$img);

            if (isset($image)){
                convert_webp($this->path, $image, $name);
                unlink($this->path.$img);
                $img = "$name.webp";
            }
            
            return ['error' => false, 'message' => $img];
        }else
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
    }

    public function mobile_check($str)
    {
        $where = ['mobile' => $str, 'id != ' => $this->session->auth];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $where = ['email' => $str, 'id != ' => $this->session->auth];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

	public function error_404()
	{
		$data['title'] = 'Error 404';
        $data['name'] = 'Error 404';

		return $this->template->load('template', 'error_404', $data);
	}
}