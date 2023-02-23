<?php
namespace GOIPInfo;

/**
 * @package GO IP Info
 * Set the admin page
 */
class Dashboard extends Base {

    public $settings = [];
    public $admin_page = [];
    public $callbacks = null;
    public $sections = [];
    public $fields = [];

    public function register(){

        $this->callbacks = new Callbacks();

        $this->setAdminPage()
            ->setSettings()
            ->setSections()
            ->setFields();

        add_action('admin_menu', function(){
            add_menu_page(
                $this->admin_page['page_title'], 
                $this->admin_page['menu_title'], 
                $this->admin_page['capability'], 
                $this->admin_page['menu_slug'], 
                $this->admin_page['callback'], 
                $this->admin_page['icon_url'], 
                $this->admin_page['position']
            );
        });
                
        
        add_action('admin_init', [$this, 'registerCustomFields']);
   
    }

    public function setSettings(){
        $args = [
            [
                'option_group' => 'go_ip_info_group',
                'option_name' => 'ip2location_url',
                'callback' => [$this->callbacks, 'optionsGroup']
            ],
            [
                'option_group' => 'go_ip_info_group',
                'option_name' => 'ip2location_key',
            ],
            [
                'option_group' => 'go_ip_info_group',
                'option_name' => 'google_maps_api_key',
            ],
            [
                'option_group' => 'go_ip_info_group',
                'option_name' => 'ip2location_package',
            ],
            [
                'option_group' => 'go_ip_info_group',
                'option_name' => 'ip2location_errors',
            ],
        ];

        $this->settings = $args;
        return $this;

    }

    public function setSections(){
        $args = [
            [
                'id' => 'goipinfo_admin_index',
                'title' => 'Settings',
                'callback' => [$this->callbacks, 'adminSection'],
                'page' => 'go_ip_info'   
            ]
        ];

        $this->sections = $args;
        return $this;

    }

    public function setFields(){
        $args = [
            [
                'id' => 'ip2location_url',
                'title' => 'IP2Location URL',
                'callback' => [$this->callbacks, 'ip2locationURL'],
                'page' => 'go_ip_info',
                'section' => 'goipinfo_admin_index',
                'args' => 
                [
                    'label_for' => 'ip2location_url',
                    'class' => 'url-class'
                ]  
                
            ],
            [
                'id' => 'ip2location_key',
                'title' => 'IP2Location Key',
                'callback' => [$this->callbacks, 'ip2locationKEY'],
                'page' => 'go_ip_info',
                'section' => 'goipinfo_admin_index',
                'args' => 
                [
                    'label_for' => 'ip2location_key',
                    'class' => 'key-class'
                ]  
                
            ],
            [
                'id' => 'google_maps_api_key',
                'title' => 'Google Maps API Key',
                'callback' => [$this->callbacks, 'googlemapsAPIKEY'],
                'page' => 'go_ip_info',
                'section' => 'goipinfo_admin_index',
                'args' => 
                [
                    'label_for' => 'google_maps_api_key',
                    'class' => 'gmapskey-class'
                ]  
                
            ],
            [
                'id' => 'ip2location_package',
                'title' => 'IP2Location Package',
                'callback' => [$this->callbacks, 'ip2locationPACKAGE'],
                'page' => 'go_ip_info',
                'section' => 'goipinfo_admin_index',
                'args' => 
                [
                    'label_for' => 'ip2location_package',
                    'class' => 'package-class'
                ]  
                
            ],
            [
                'id' => 'ip2location_errors',
                'title' => 'Last IP2Location Error',
                'callback' => [$this->callbacks, 'ip2locationERRORS'],
                'page' => 'go_ip_info',
                'section' => 'goipinfo_admin_index',
                'args' => 
                [
                    'label_for' => 'ip2location_errors',
                    'class' => 'errors-class'
                ]  
                
            ],
        ];

        $this->fields = $args;
        return $this;

    }

    public function setAdminPage(){
        $this->admin_page = [
            'page_title' => 'GO IP Info', 
            'menu_title' => 'GO IP Info',
            'capability' => 'manage_options',
            'menu_slug' => 'go_ip_info',
            'callback' => array($this->callbacks, 'adminPage'),
            'icon_url' => 'dashicons-location',
            'position' => 70,
        ];
        
        //dashicons-migrate
        
        return $this;
    }

    public function registerCustomFields(){

        //register setting
        foreach($this->settings as $setting ){
            register_setting(
                $setting["option_group"], 
                $setting["option_name"], 
            );
        }

        // add settings section
        foreach($this->sections as $section){
            add_settings_section(
                $section["id"], 
                $section["title"], 
                (isset($section["callback"]) ? $section["callback"] : ''), 
                $section["page"]
            );
        }

        // add settings field
        foreach($this->fields as $field){
            add_settings_field(
                $field["id"], 
                $field["title"], 
                (isset($field["callback"]) ? $field["callback"] : ''), 
                $field["page"], 
                $field["section"], 
                (isset($field["args"]) ? $field["args"] : '')
            );
        }
        
    }

}