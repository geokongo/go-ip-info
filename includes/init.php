<?php
namespace GOIPInfo;
/**
 * @package GO IP Info
 * Entry point to the plugin classes.
 * Will mostly have methods
 */
final class Init{

    /**
     * @var array List of all plugin shortcodes
     */
    public $shortcodes = [
        'goipinfo_data',
    ];

    /**
     * @var Object Dashboard object
     * It handles setting up admin dashboard and callbacks
     */
    public $dashboard;

    /**
     * Return GO IP Info content
     * @param null
     * @return strong HTML for displaying IP address
     */
    public function goipinfo_data(){

        $data = $this->dashboard->callbacks;
        $data = $data->goipinfo_data();

        return $data;

    }

    /**
     * Enqueue the plugin CSS and JS files
     * @param nul
     * @return void
     */
    public function enqueueScripts(){

        //get google maps api key
        $gmaps_api_key = get_option('google_maps_api_key');
        $gmaps_api_url = "https://maps.googleapis.com/maps/api/js?key=$gmaps_api_key&callback=initMap&v=weekly";

        //enqueue all our scripts
        wp_enqueue_style('goipinfostyle', $this->dashboard->plugin_url . 'assets/style.css');
        wp_enqueue_script('goipinfoscript', $this->dashboard->plugin_url . 'assets/script.js');
        wp_enqueue_script('goipinfomapscript', $gmaps_api_url, [], false, true );
        
    }

    /**
     * Register all shortcodes
     * @param null
     * @return void
     */
    public function setShortcodes(){

        foreach($this->shortcodes as $shortcode){
            add_shortcode($shortcode, [$this, $shortcode]);
        }

        return $this;
    }

    /**
     * Launche the plugin
     * @param null
     * @return void
     */
    public function start(){

        $this->dashboard = new Dashboard();
       
        // enqueue the plugin css and javascript files
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

        //set shortcodes
        $this->setShortcodes();
        

        // add settings link in the plugins list page
        add_filter("plugin_action_links_" . $this->dashboard->plugin, function($links){
            $link = '<a href="admin.php?page=go_ip_info">Settings</a>';
            $links[] = $link;
            return $links;
        });

        $this->dashboard->register();
        
    }

}        
