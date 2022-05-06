<?php defined('BASEPATH') OR exit('No direct script access allowed');

function my_crypt($string, $action = 'e' )
{
    $secret_key = md5(APP_NAME).'_key';
    $secret_iv = md5(APP_NAME).'_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}

function re($array='')
{
    $CI =& get_instance();
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    exit;
}

function flashMsg($success,$succmsg,$failmsg,$redirect)
{
    $CI =& get_instance();
    if ( $success ){
        $CI->session->set_flashdata('success',$succmsg);
    }else{
        $CI->session->set_flashdata('error', $failmsg);
    }
    return redirect($redirect);
}

function e_id($id)
{
    return 41254 * $id;
}

function d_id($id)
{
    return $id / 41254;
}

function admin($uri='')
{
    return ADMIN.'/'.$uri;
}

if ( ! function_exists('convert_webp'))
{
    function convert_webp($path, $image, $name) {
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagewebp($image, "$path$name.webp", 100);
        imagedestroy($image);
    }
}

if ( ! function_exists('check_ajax'))
{
    function check_ajax()
    {
        $CI =& get_instance();
        if (!$CI->input->is_ajax_request())
            die;
    }
}

if ( ! function_exists('script'))
{
    function script($url='', $type='application/javascript')
    {
        return "\n<script src=\"".base_url($url)."\" type=\"$type\"></script>\n";
    }
}