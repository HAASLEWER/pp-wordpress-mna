<?php
/**
 * 
 * @author Anton Menkveld
 *
 */
class placementpartner_vacancies_search_shortcodes {
	
	function search_detail() {
                    //launch main search method
                    self::getSearch();
	}  
	
	function getSearch() {
                    //Check if we need to reset the form
                    if(isset($_POST['reset']) && $_POST['reset']=='1'){
                        unset($_POST);
                    }
                    // Get the user options from the WP Settings system
                    $advanced_options = get_option('placementpartner_advanced_options');
                    //Get the branding options
                    $branding_options = get_option('placementpartner_branding_options');
                    //Get the login options
                    $login_options = get_option('placementpartner_logindetails_options');
                    $logo_url = get_option('siteurl').'/wp-content/plugins/placementpartner/vacancies/includs/images/logo.jpg';
                    //Get the details page url set in the placement partner widget
                    $full_details_url = self::get_widget_details_page_link();
                    //Set connection processing values
                    $connectionError = false;
                    $authenticationError = false;
                    $functionError = false;
                    // Connect to the Placement Partner Web Service
                    $client = new nusoap_client($advanced_options['wsdl_url'], true);
                    $err = $client->getError();
                    //check if there was an error connection
                    if ($err) {
                        $connectionError = true;
                    } else {
                        // Create a proxy object
                        $pp = $client->getProxy();
                        $err = $pp->getError();
                        //Check if we have a proxy error
                        if ($err) {
                            $connectionError = true;
                        } else {
                            // Login to the web service with the given username and password
                            $session_id = $pp->login($login_options['username'], $login_options['password']);
                            $err = $pp->getError();
                            //check that we have authentication
                            if ($err) {
                                $authenticationError = true;
                            } else {
                                //get the advert regions
                                $region_list = $pp->getAdvertRegions($session_id);
                                $err = $pp->getError();
                                //check if the functions is working
                                if($err){
                                    $functionError = true;
                                }else{
                                    //work on regions lists
                                    //self::printer($_GET);
                                    //NOTE! This is a straight port over from the Iframe script
                                    // If this page is requested via the URL the username is given as id in the get
                                    if (isset($_GET['debug'])) {
                                            $debug = true;
                                    }
                                    $list_group = false;
                                    if (isset($_GET["group"])) {
                                            $list_group = true;   // list group flag indicates that more than one companies adverts will be listed and thus that the region and sectors must not be shown
                                    }
                                    //Allow for remote pages to pass through a vacancy_ref varialbe and only display that advert
                                    if ((isset($_GET['vacancy_ref']) || isset($_GET['VacRef'])) && empty($_POST['vacancy_ref'])) {
                                            $_POST["keywords"] = (empty($_GET['vacancy_ref'])) ? $_GET['VacRef'] : $_GET['vacancy_ref'];
                                            $_POST['vacancy_ref'] = (empty($_GET['vacancy_ref'])) ? $_GET['VacRef'] : $_GET['vacancy_ref'];
                                            $_POST["searchwhat"] = "vacancy_ref";
                                    }
                                    
                                    $region_list = $pp->getAdvertRegions($session_id);
                                    $err = $pp->getError();
                                    if ($err) {
                                            if ($debug) {
                                                    echo "<b>Error:</b> $err<br><b>Debug:</b> $pp->response<br><br>";
                                            }
                                            die(str_replace("__ERR_NO", "003", $err_msg));
                                    }

                                    $region_options = "";
				    //Set the "All option"
                                    if (@in_array('', $_POST["region"])) {
                                        $region_options .= '<option selected="selected" value="">ALL</option>';
                                    }else{
                                        $region_options .= '<option value="">ALL</option>';
                                    }
                                    foreach ($region_list as $region) {
                                            $checked = "";
                                            if (@in_array($region["id"], $_POST["region"])) {
                                                    $checked = "selected";
                                            }
                                            $region_options .= "<option value=\"{$region["id"]}\" $checked>{$region["label"]}</option>\n";
                                    }
                                    
                                    

                                    if (! $list_group) {
                                            // Get a list of the available industry sectors and regions from the web site.
                                            // These will probably not change all the time, so it is possible to cache
                                            // these and only update from time to time - we recommend once daily
                                            $sector_list = $pp->getAdvertSectors($session_id);
                                            $err = $pp->getError();
                                            if ($err) {
                                                    if ($debug) {
                                                            echo "<b>Error:</b> $err<br><b>Debug:</b> $pp->response<br><br>";
                                                    }
                                                    die(str_replace("__ERR_NO", "004", $err_msg));
                                            }

                                            // Create the options for the select boxes
                                            $sector_options = "";
					    //Set the ALL options used to search across all sectors
                                            if (@in_array('', $_POST["sector"])) {
                                                $sector_options .= "<option selected='selected' value=''>ALL</option>";
                                            }else{
                                                $sector_options .= "<option value=''>ALL</option>";
                                            }
                                            foreach ($sector_list as $sector) {
                                                    $checked = "";
                                                    if (@in_array($sector["id"], $_POST["sector"])) {
                                                            $checked = "selected";
                                                    }
                                                    $sector_options .= "<option value=\"{$sector["id"]}\" $checked>{$sector["label"]}</option>\n";
                                            }
                                    } // $list_group

                                    $no_cache_hash = strtotime("now");
                                    $url_params = array();
                                    if(isset($_GET["id"]) && isset($_GET["f"])){
                                      $url_params = array(
                                                'id' => $_GET["id"],
                                                'f' => $_GET["f"],
                                                $no_cache_hash => ''
                                        );  
                                    }

                                    if (isset($_GET['group'])) {
                                            $url_params['group'] = '';
                                    }

                                    if (isset($_GET['debug'])) {
                                            $url_params['debug'] = '';
                                    }

                                    if (isset($_GET['source'])) {
                                            $url_params['source'] = $_GET['source'];
                                    }

                                    if (isset($_GET['popup_split_screen']) && $_GET['popup_split_screen'] == '0') {
                                            $url_params['popup_split_screen'] = "0";
                                    }
                                    
                                    if(!empty($url_params)){
                                        $return_page = $_SERVER["REQUEST_URI"] . "?" . http_build_query($url_params);
                                    }else{
                                        $return_page = $_SERVER["REQUEST_URI"];
                                    }
                                    //pull in vancancy search page template
                                    //include('vacancies_search.php');
                                    include('list.php');
                                }
                                // Logout the session
                                $pp->logout($session_id);
                            }
                        }
                    }
                    // Show nice error to the end user.
                    if($connectionError) {
                        echo "Could not connect to the Placement Partner server. Please contact the Placement Partner team.";
                        return false;
                    }
                    if($authenticationError) {
                        echo "Incorrect username and/or password returned by the Placement Partner server. Please check Placement Partner plugin settings.";
                        return false;
                    }
                    if($functionError) {
                        echo "Error communicating with the Placement Partner server. Please contact the Placement Partner technical team.";
                        return false;
                    }
	}
                /**
                 * Get the full details page from the widget options
                 * @return type
                 */
                function get_widget_details_page_link(){
                    //Ask wordpress to get the worpress placement partner registered widget options
                    $widget_options = get_option('widget_placementpartner_vacancies_widget');
                    //set details page holder
                    $details_page_url = false;
                    //serach for the url
                    $search_key = 'detail_page';
                    foreach($widget_options as $key => $opt){
                        if(is_array($opt)){
                            foreach($opt as $k => $o){
                                if($k == $search_key){
                                    $details_page_url = $o;
                                }
                            }
                        }elseif($key == $search_key ){
                            $details_page_url = $opt;
                        }
                    }
                    //return the value
                    return $details_page_url;
                }
                /**
                 * Pretty print array values
                 * @param type $array
                 */
                function printer($array){
                    //pretty print array values
                    echo '<pre>';
                    print_r($array);
                    echo '</pre>';
                }
}