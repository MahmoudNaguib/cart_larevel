<?php

function insertDefaultPages() {
    $rows = [
        [
            'id' => 1,
            'title' => 'About',
            'slug' => 'About',
            'content' => 'About content',
            'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png'),
            'meta_description' => 'About content',
            'meta_keywords' => 'About',
            'is_active' => 1,
            'is_default' => 1,
            'created_by' => 1,
        ],
        [
            'id' => 2,
            'title' => 'Terms',
            'slug' => 'Terms',
            'content' => 'Terms content',
            'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png'),
            'meta_description' => 'Terms content',
            'meta_keywords' => 'Terms',
            'is_active' => 1,
            'is_default' => 1,
            'created_by' => 1,
        ],
        [
            'id' => 3,
            'title' => 'Privacy',
            'slug' => 'Privacy',
            'content' => 'Privacy content',
            'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png'),
            'meta_description' => 'Privacy content',
            'meta_keywords' => 'Privacy',
            'is_active' => 1,
            'is_default' => 1,
            'created_by' => 1,
        ]
    ];
    if ($rows) {
        foreach ($rows as $row) {
            foreach (langs() as $lang) {
                $title[$lang] = $row['title'];
                $slug[$lang] = $row['slug'];
                $content[$lang] = $row['content'];
                $meta_description[$lang] = $row['meta_description'];
                $meta_keywords[$lang] = $row['meta_keywords'];
            }
            $row['title'] =$title;
            $row['slug'] = $slug;
            $row['content'] = $content;
            $row['meta_description'] = $meta_description;
            $row['meta_keywords'] = $meta_keywords;
            \App\Models\Page::create($row);
        }
    }
}

function insertDefaultCurrencies() {
    $rows = [
        [
            'id' => 1,
            'title' => 'EGP',
            'iso' => 'EGP',
            'rate' => '1',
            'created_by' => 1,
        ],
        [
            'id' => 2,
            'title' => 'USD',
            'iso' => 'USD',
            'rate' => '15.81',
            'created_by' => 1,
        ],
        [
            'id' => 3,
            'title' => 'EUR',
            'iso' => 'EUR',
            'rate' => '17.25',
            'created_by' => 1,
        ],
        [
            'id' => 4,
            'title' => 'AED',
            'iso' => 'AED',
            'rate' => '4.30',
            'created_by' => 1,
        ],
        [
            'id' => 5,
            'title' => 'SAR',
            'iso' => 'SAR',
            'rate' => '4.20',
            'created_by' => 1,
        ],
    ];
    if ($rows) {
        foreach ($rows as &$row) {
            foreach (langs() as $lang) {
                $title[$lang] = $row['title'];
            }
            $row['title'] = json_encode($title);
        }
    }
    DB::table('currencies')->insert($rows);
    \Cache::forget('currencies_' . appVersion());
}

function configureUploads() {
    $uploads = public_path() . '/uploads';
    if (!File::isDirectory($uploads)) {
        File::makeDirectory($uploads, 0777, true, true);
    }

    $uploads = public_path() . '/uploads';
    if (!File::isDirectory($uploads)) {
        File::makeDirectory($uploads, 0777, true, true);
    }
    $small = $uploads . '/small';
    if (app()->environment() != 'production') {
        File::deleteDirectory($small);
    }
    if (!File::isDirectory($small)) {
        File::makeDirectory($small, 0777, true, true);
    }
    $large = $uploads . '/large';
    if (app()->environment() != 'production') {
        File::deleteDirectory($large);
    }
    if (!File::isDirectory($large)) {
        File::makeDirectory($large, 0777, true, true);
    }
}

function insertDefaultConfigs() {
    \Cache::forget('configs');
    $rows = [];
    //////////// appName
    $txt = env('APP_NAME');
    foreach (langs() as $lang) {
        $rows[] = [
            'field_type' => 'text',
            'field_class' => '',
            'type' => 'Basic Information',
            'field' => 'application_name',
            'label' => 'Application Name',
            'value' => $txt.' - '.$lang,
            'lang' => $lang,
            'created_by' => NULL
        ];
    }
    $image = resizeImage(resource_path() . '/imgs/logo.png', ['large' => 'resize,300x150','small' => 'resize,200x100']);

    ///////////////// Logo
    $rows[] = [
        'field_type' => 'file',
        'field_class' => 'custom-file-input',
        'type' => 'Basic Information',
        'field' => 'logo',
        'label' => 'Logo',
        'value' => $image,
        'lang' => NULL,
        'created_by' => NULL,
    ];
    //////////// Social links
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Social links',
        'field' => 'facebook_link',
        'label' => 'Facebook link',
        'value' => 'https://www.facebook.com/'.env('APP_NAME'),
        'lang' => NULL,
        'created_by' => NULL,
    ];
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Social links',
        'field' => 'twitter_link',
        'label' => 'Twitter link',
        'value' => 'https://twitter.com/'.env('APP_NAME'),
        'lang' => NULL,
        'created_by' => NULL,
    ];
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Social links',
        'field' => 'linkedin_link',
        'label' => 'Linkedin link',
        'value' => 'https://www.linkedin.com/'.env('APP_NAME'),
        'lang' => NULL,
        'created_by' => NULL,
    ];
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Social links',
        'field' => 'instagram_link',
        'label' => 'Instagram link',
        'value' => 'https://www.instagram.com/'.env('APP_NAME'),
        'lang' => NULL,
        'created_by' => NULL,
    ];
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Social links',
        'field' => 'youtube_link',
        'label' => 'Youtube link',
        'value' => 'https://www.youtube.com/'.env('APP_NAME'),
        'lang' => NULL,
        'created_by' => NULL,
    ];
    /////////// Contact info
    $txt = "Address will be here";
    foreach (langs() as $lang) {
        $rows[] = [
            'field_type' => 'textarea',
            'field_class' => '',
            'type' => 'Contact information',
            'field' => 'address',
            'label' => 'Address',
            'value' => $txt.' - '.$lang,
            'lang' => $lang,
            'created_by' => NULL,
        ];
    }

    $txt = '01234567890';
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Contact information',
        'field' => 'phone',
        'label' => 'Phone',
        'value' => $txt,
        'lang' => NULL,
        'created_by' => NULL,
    ];


    $txt = env('CONTACT_EMAIL');
    $rows[] = [
        'field_type' => 'text',
        'field_class' => '',
        'type' => 'Contact information',
        'field' => 'email',
        'label' => 'Email',
        'value' => $txt,
        'lang' => NULL,
        'created_by' => NULL,
    ];
    ///////////////// SEO
    //////////// $metaDescription
    unset($txt);
    $txt = env('APP_NAME');
    foreach (langs() as $lang) {
        $rows[] = [
            'field_type' => 'textarea',
            'field_class' => '',
            'type' => 'SEO',
            'field' => 'meta_description',
            'label' => 'Meta description',
            'value' => $txt,
            'lang' => $lang,
            'created_by' => NULL,
        ];
    }
    $metaKeywords = env('APP_NAME');
    foreach (langs() as $lang) {
        $rows[] = [
            'field_type' => 'textarea',
            'field_class' => '',
            'type' => 'SEO',
            'field' => 'meta_keywords',
            'label' => 'Meta keywords',
            'value' => $txt,
            'lang' => $lang,
            'created_by' => NULL,
        ];
    }
    \DB::table('configs')->insert($rows);
}

function insertDefaultRoles() {
    $rows = [
        [
            'id' => 1,
            'title' => 'Super Administrator',
            'permissions' => json_encode(permissions()),
            'created_by' => NULL,
            'is_default' => 1,
        ],
        [
            'id' => 2,
            'title' => 'Administrator',
            'permissions' => json_encode(permissions()),
            'created_by' => NULL,
            'is_default' => 1,
        ]
    ];
    \DB::table('roles')->insert($rows);
}

function insertDefaultUsers() {
    $users=[];
    /////////// Admin User
    $email='admin@demo.com';
    $token =generateToken($email);
    $users[]=[
        'id' => 1,
        'role_id' => 1,
        'name' => 'Admin',
        'email' => $email,
        'mobile' => '01234567890',
        'password' => bcrypt('demo@12345'),
        'country_id' => 64,
        'language' => 'en',
        'confirmed' => 1,
        'is_active' => 1,
        'created_by' => NULL,
        'image' => resizeImage(resource_path() . '/imgs/users/'.rand(1,10).'.png', \App\Models\User::$attachFields['image']['sizes']),
        //'image' => generateImage('Admin'),
        'token'=>$token
    ];
    ///////////// User1
    $email='user1@demo.com';
    $token =generateToken($email);
    $users[]=[
        'id' => 2,
        'role_id' => NULl,
        'name' => 'User 1',
        'email' => 'user1@demo.com',
        'mobile' => '01234567890',
        'password' => bcrypt('demo@12345'),
        'country_id' => 64,
        'language' => 'en',
        'confirmed' => 1,
        'is_active' => 1,
        'created_by' => NULL,
        'image' => resizeImage(resource_path() . '/imgs/users/'.rand(1,10).'.png', \App\Models\User::$attachFields['image']['sizes']),
        //'image' => generateImage('User 1'),
        'token'=>$token
    ];

    ///////////// User2
    $email='user2@demo.com';
    $token =generateToken($email);
    $users[]=[
        'id' => 3,
        'role_id' => NULl,
        'name' => 'User 2',
        'email' => 'user2@demo.com',
        'mobile' => '01234567890',
        'password' => bcrypt('demo@12345'),
        'country_id' => 64,
        'language' => 'en',
        'confirmed' => 1,
        'is_active' => 1,
        'created_by' => NULL,
        'image' => resizeImage(resource_path() . '/imgs/users/'.rand(1,10).'.png', \App\Models\User::$attachFields['image']['sizes']),
        //'image' => generateImage('User 1'),
        'token'=>$token
    ];

    ///////////// User3
    $email='user3@demo.com';
    $token =generateToken($email);
    $users[]=[
        'id' => 4,
        'role_id' => NULl,
        'name' => 'User 3',
        'email' => 'user3@demo.com',
        'mobile' => '01234567890',
        'password' => bcrypt('demo@12345'),
        'country_id' => 64,
        'language' => 'en',
        'confirmed' => 1,
        'is_active' => 1,
        'created_by' => NULL,
        'image' => resizeImage(resource_path() . '/imgs/users/'.rand(1,10).'.png', \App\Models\User::$attachFields['image']['sizes']),
        //'image' => generateImage('User 1'),
        'token'=>$token
    ];
    \DB::table('users')->insert($users);
    ////////////////// insert default address
    $users=\App\User::get();
    if ($users) {
        foreach ($users as $user) {
            $country = \App\Models\Country::inRandomOrder()->first();
            $addresses[] = [
                'title'=>'Home address',
                'country_id' => $country->id,
                'city' => 'City ' . rand(100, 10000),
                'district' => 'District ' . rand(100, 10000),
                'zip_code' => rand(1000, 10000),
                'address' => 'Address ' . rand(100, 10000),
                'created_by' => $user->id
            ];
        }
        \DB::table('addresses')->whereIn('created_by', $users->pluck('id'))->delete();
        \DB::table('addresses')->insert($addresses);
    }
}

function insertDefaultCategories() {
    for ($i = 1; $i < 6; $i++) {
        foreach (langs() as $lang) {
            $title[$lang] = 'Main category ' . $i;
        }
        $rows[] = [
            'top_id' => NULL,
            'title' => json_encode($title),
            'image' => resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png', \App\Models\Category::$attachFields['image']['sizes']),
            'created_by' => 1,
            'meta_description'=>json_encode($title),
            'meta_keywords'=>json_encode($title),
        ];
    }
    \DB::table('categories')->insert($rows);
    $mainSections = \DB::table('categories')->where('top_id', NULL)->get();
    if ($mainSections) {
        foreach ($mainSections as $main) {
            for($i=1; $i<3; $i++){
                foreach (langs() as $lang) {
                    $title[$lang] = 'Sub category ' . $main->id.$i;
                }
                $subSections[] = [
                    'top_id' => $main->id,
                    'title' => json_encode($title),
                    'image' => resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png', \App\Models\Category::$attachFields['image']['sizes']),
                    'created_by' => 1,
                    'meta_description'=>json_encode($title),
                    'meta_keywords'=>json_encode($title),
                ];
            }
        }
    }
    \DB::table('categories')->insert($subSections);
}
function insertDefaultSections() {
    for ($i = 1; $i < 6; $i++) {
        foreach (langs() as $lang) {
            $title[$lang] = 'Section ' . $i;
        }
        $rows[] = [
            'title' => json_encode($title),
            'image' => resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png', \App\Models\Section::$attachFields['image']['sizes']),
            'created_by' => 1,
            'meta_description'=>json_encode($title),
            'meta_keywords'=>json_encode($title),
        ];
    }
    \DB::table('sections')->insert($rows);
}
