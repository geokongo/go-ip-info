<?php
/**
 * @package GO IP Info
 */

namespace GOIPInfo;


class Callbacks extends Base {

    public function adminPage(){

        return require_once("$this->plugin_path/templates/admin.php");

    }

    public function goipinfo_data(){

        $req = $this->requestIPINFO();
        $dat['ip_address'] = $_SERVER['REMOTE_ADDR'];

        if(isset($req->response)){

            if($req->response == 'OK') {
                $dat['country_name'] = isset($req->country_name) ? $req->country_name : 'Not set';
                $dat['region_name'] = isset($req->region_name) ? $req->region_name : 'Not set';
                $dat['city_name'] = isset($req->city_name) ? $req->city_name : 'Not set';
                $dat['latitude'] = isset($req->latitude) ? $req->latitude : 'Not set';
                $dat['longitude'] = isset($req->longitude) ? $req->longitude : 'Not set';
                $dat['isp'] = isset($req->isp) ? $req->isp : 'Not set';
            }
            else {

                update_option('ip2location_errors', $req->response . ' @' . date("Y-m-d h:i:sa"));
                $dat['country_name'] = 'Not set';
                $dat['region_name'] = 'Not set';
                $dat['city_name'] = 'Not set';
                $dat['latitude'] = 'Not set';
                $dat['longitude'] = 'Not set';
                $dat['isp'] = 'Not set';
    
            }

        }
        else {

            update_option('ip2location_errors', 'Unknown error occured @' . date("Y-m-d h:i:sa"));
            $dat['country_name'] = 'Error';
            $dat['region_name'] = 'Error';
            $dat['city_name'] = 'Error';
            $dat['latitude'] = 'Error';
            $dat['longitude'] = 'Error';
            $dat['isp'] = 'Error';
    
        }

        $content = file_get_contents("$this->plugin_path/templates/user.php");
        $content = sprintf($content,$dat['latitude'],$dat['longitude'],$dat['ip_address'],$dat['country_name'],$dat['region_name'],$dat['city_name'],$dat['isp']);
        
        return $content;

    }

    public function requestIPINFO(){
        
        $ip2location_url = get_option('ip2location_url');
        $query_params = http_build_query([
            'ip'        => $_SERVER['REMOTE_ADDR'],
            'key'       => get_option('ip2location_key'),
            'package'   => get_option('ip2location_package')
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => "$ip2location_url?$query_params",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);

        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result);

    }

    public function adminSection(){
        //echo "Check this section";
    }

    public function ip2locationURL(){
        $value = esc_attr(get_option('ip2location_url'));
        echo '<input type="text" class="regular-text" name="ip2location_url" value="' . $value . '" placeholder="https://api.ip2location.com/v2/">';
    }

    public function ip2locationKEY(){
        $value = esc_attr(get_option('ip2location_key'));
        echo '<input type="text" class="regular-text" name="ip2location_key" value="' . $value . '" placeholder="key=H5QCZ2ATH9">';
    }

    public function googlemapsAPIKEY(){
        
        $value = esc_attr(get_option('google_maps_api_key'));
        echo '<input type="text" class="regular-text" name="google_maps_api_key" value="' . $value . '" placeholder="https://maps.googleapis.com/maps/api/js?key=...">';
    
    }

    public function ip2locationPACKAGE(){
       
        $value = esc_attr(get_option('ip2location_package'));
        echo '<input type="text" class="regular-text" name="ip2location_package" value="' . $value . '" placeholder="package=WS1">';
    
    }

    public function ip2locationERRORS(){
        
        $url = get_option('ip2location_url');
        $query_params = http_build_query([
            'key'       => get_option('ip2location_key'),
            'check'       => 1,
        ]);
        $url .= "?$query_params" ;
        
        $value = get_option('ip2location_errors');
        echo '<p class="regular-text" style="color:red">' . esc_attr($value) . ' <a href="'. $url .'" target="_blank">Check credits left here</a></p>';   
    
    }

}