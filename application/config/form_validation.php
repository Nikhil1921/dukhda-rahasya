<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'error_prefix' => '<span class="text-danger">',
    'error_suffix' => '</span><br />',
    'profile' => [
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
    ],
    'login' => [
        [
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'required|is_natural|exact_length[10]|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
                'exact_length' => "%s is invalid",
            ],
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|max_length[100]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed"
            ],
        ]
    ]
];