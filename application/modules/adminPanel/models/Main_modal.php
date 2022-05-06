<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function bulk_upload($post, $table)
    {
        return $this->db->insert_batch($table, $post);
    }
}