<?php
/**
 * 
 * @author Anton Menkveld
 *
 */
class placementpartner_vacancies_region_shortcodes {
	
	function vacancy_detail() {
		if(!empty($_GET['region'])) {
			$ad = self::_getVacancy(trim($_GET['region']));
			$logo_url = get_option('siteurl').'/wp-content/plugins/placementpartner/vacancies/includs/images/logo.jpg';
			//Get the branding options
            $branding_options = get_option('placementpartner_branding_options');
            //get full details template
            include('single.php');
		} else {
			return "Vacancy not found on Placement Partner Server";
		}
	}
	
	function _getVacancy($id) {
		$connectionError = false;
		$authenticationError = false;
		$functionError = false;

		// Get the user options from the WP Settings system
		$advanced_options = get_option('placementpartner_advanced_options');
		$login_options = get_option('placementpartner_logindetails_options');
		
		// Connect to the Placement Partner Web Service
		$client = new nusoap_client($advanced_options['wsdl_url'], true);
		$err = $client->getError();
		if ($err) {
			$connectionError = true;
		} else {
			// Create a proxy object
			$pp = $client->getProxy();
			$err = $pp->getError();
			if ($err) {
				$connectionError = true;
			} else {
				// Login to the web service with the given username and password
				$session_id = $pp->login($login_options['username'], $login_options['password']);
				$err = $pp->getError();
				if ($err) {
					$authenticationError = true;
				} else {
					// Get the vacanies from the Placement Partner server
					// Remove any / from vacancy ref and replace with %
					$id_arr = explode('/', $id);
					$id_val = $id_arr[0].'%';

					// Retrieve list of regions
					$regions_response = $pp->getAdvertRegions($session_id);

					// Create an array representing the key-value pairs
					$regions = array();
					foreach($regions_response as $region) {
						$regions[$region["id"]] = $region["label"];
						if ($region["label"] == $_GET['region']) {
							$region_id = $region["id"];
						}
					}

					// Get the vacanies from the Placement Partner server
					// TODO: Give user the option for sorting.
					$filter = array(
								array(
									'Gauteng' => array(
										'field' => 'region',
										'operator' => '=',
										'value' => $region_id,
									)
								)								
							);

					$vacancy = $pp->getAdverts($session_id, array($filter[0]["Gauteng"]));
					$err = $pp->getError();
					if ($err) {
						$functionError = true;
					}
					// Logout
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

		return $vacancy;
	}
}