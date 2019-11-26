<?php

return [
    'admin' => [
        'create_agent' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12|unique:agents',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits','unique' => 'This username already exists']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['required' => 'The Password field is required.','min' => 'Password is at least 6 digits', 'max' => 'Password up to 12 digits','confirmed' => 'Two password entries are inconsistent']
            ],
        ],
        'edit_agent' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'confirmed',
                'message' => ['confirmed' => 'Two password confirmation does not match.']
            ],
        ],
        'create_user' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12|unique:users',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits','unique' => 'This username already exists']
            ],            
            'phone_number' => [
                'name' => 'Phone Number',
                'rules' => 'required|min:10|max:15|unique:users',
                'message' => ['required' => 'Phone number field is required.','min' => 'Phone number is at least 10 digits', 'max' => 'phone number is up to 15 digits']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['required' => 'Password field is required.','min' => 'Password is at least 6 digits', 'max' => 'Password up to 12 digits','confirmed' => 'The password confirmation does not match.']
            ],
        ],
        'edit_user' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits']
            ],            
            'phone_number' => [
                'name' => 'Phone Number',
                'rules' => 'required|min:10|max:15',
                'message' => ['required' => 'Phone number field is required.','min' => 'phone number is at least 10 digits', 'max' => 'phone number is up to 15 digits']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'confirmed',
                'message' => ['confirmed' => 'Password confirmation does not match.']
            ],
        ],
    ],
    'agent' => [
        'create_agent' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12|unique:agents',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits','unique' => 'This username already exists']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['required' => 'The Password field is required.','min' => 'Password is at least 6 digits', 'max' => 'Password up to 12 digits','confirmed' => 'Two password entries are inconsistent']
            ],
            'score' => [
                'name' => 'Score',
                'rules' => 'required|numeric|min:0',
                'message' => ['required' => 'Score field is required.', 'numeric' => 'Score field should be number.', 'min' => 'Score should be greater than 0.'],
            ]
        ],
        'edit_agent' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'confirmed',
                'message' => ['confirmed' => 'Two password confirmation does not match.']
            ],
        ],
        'create_user' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12|unique:users',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits','unique' => 'This username already exists']
            ],            
            'phone_number' => [
                'name' => 'Phone Number',
                'rules' => 'required|min:10|max:15|unique:users',
                'message' => ['required' => 'Phone number field is required.','min' => 'Phone number is at least 10 digits', 'max' => 'phone number is up to 15 digits']
            ],
            'score' => [
                'name' => 'Score',
                'rules' => 'required|numeric|min:0',
                'message' => ['required' => 'Score field is required.', 'numeric' => 'Score field should be number.', 'min' => 'Score should be greater than 0.'],
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['required' => 'Password field is required.','min' => 'Password is at least 6 digits', 'max' => 'Password up to 12 digits','confirmed' => 'The password confirmation does not match.']
            ],
        ],
        'edit_user' => [
            'username' => [
                'name' => 'Username',
                'rules' => 'required|min:6|max:12',
                'message' => ['required' => 'The Username field is required.','min' => 'Username is at least 6 digits', 'max' => 'Username is up to 12 digits']
            ],            
            'phone_number' => [
                'name' => 'Phone Number',
                'rules' => 'required|min:10|max:15',
                'message' => ['required' => 'Phone number field is required.','min' => 'phone number is at least 10 digits', 'max' => 'phone number is up to 15 digits']
            ],
            'password' => [
                'name' => 'Password',
                'rules' => 'confirmed',
                'message' => ['confirmed' => 'Password confirmation does not match.']
            ],
        ],
    ],    
    'wap' => [
        'change_password' => [
            // 'old_password' => [
            //     'name' => 'Old Password',
            //     'rules' => 'required',
            //     'message' => ['required' => 'The Old Password field is required.']
            // ],
            'password' => [
                'name' => 'Password',
                'rules' => 'required|min:6|max:12|confirmed',
                'message' => ['required' => 'The password field is required.','min' => 'Password is at least 6 digits', 'max' => 'Password up to 12 digits','confirmed' => 'Passwrod confirmation does not match']
            ],
        ],
        'change_name' => [
            'name' => [
                'name' => 'Name',
                'rules' => 'required',
                'message' => ['required' => 'The name field is required.']
            ],
        ],
        'change_passcode' => [
            'passcode' => [
                'name' => 'PassCode',
                'rules' => 'required|digits:4',
                'message' => ['required' => 'The name field is required.', 'digits' => 'PassCode should be 4 digits.']
            ],
        ],
    ],
];