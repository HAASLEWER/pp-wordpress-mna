<?php
class PlacementPartner_Admin {

	function addOptionsPage() {
		add_options_page('Placement Partner Plugin Administration',				// Page Name
				'Placement Partner',											// Menu item
				'manage_options',												// capability required
				'placementpartner_admin_page',									// link page name. Will be the URL of the page
				array('PlacementPartner_Admin', 'showAdminOptionsPage'));		// Callback function to output the page
	}
	
	function registerOptions() {
		// Login Details Section
		// Create the placementpartner_logindetails_options field in the placementpartner_admin_group
		register_setting('placementpartner_admin_group', 						// Group name
						'placementpartner_logindetails_options',				// Field or setting name
						array('PlacementPartner_Admin', 'loginOptionsValidate')		// Validation function
				);

		// Create the placementpartner_logindetails_section on the placementpartner_admin_page
		add_settings_section('placementpartner_logindetails_section', 					// Section name
							'Web Service Login Details', 				// Section heading
							array('PlacementPartner_Admin', 'showLoginDetailsText'),	// Callback function for section text
							'placementpartner_admin_page');								// Page name
		
		// Create the field placementpartner_logindetails_username to the placementpartner_admin_page in the placementpartner_logindetails_section
		add_settings_field('placementpartner_logindetails_username',					// Field name
							'Username',		 											// Field label
							array('PlacementPartner_Admin', 'showLoginDetailsUsername'),// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name 
							'placementpartner_logindetails_section');					// Section name

		// Create the field placementpartner_logindetails_password to the placementpartner_admin_page in the placementpartner_logindetails_section
		add_settings_field('placementpartner_logindetails_password',					// Field name
							'Password',		 											// Field label
							array('PlacementPartner_Admin', 'showLoginDetailsPassword'),// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name
							'placementpartner_logindetails_section');					// Section name

		// Advanced Options Section
		// Create the placementpartner_logindetails_options field in the placementpartner_admin_group
		register_setting('placementpartner_admin_group', 						// Group name
						'placementpartner_advanced_options',					// Field or setting name
						array('PlacementPartner_Admin', 'advancedOptionsValidate')		// Validation function
				);
		
		// Create the placementpartner_advanced_section on the placementpartner_admin_page
		add_settings_section('placementpartner_advanced_section', 					// Section name
							'Advanced Options', 									// Section heading
							array('PlacementPartner_Admin', 'showAdvancedOptionsText'),// Callback function for section text
							'placementpartner_admin_page');							// Page name
		
		// Create the field placementpartner_logindetails_username to the placementpartner_admin_page in the placementpartner_logindetails_section
		add_settings_field('placementpartner_advanced_wsdl_url',						// Field name
							'WSDL URL',		 											// Field label
							array('PlacementPartner_Admin', 'showAdvancedWsdlUrl'),		// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name
							'placementpartner_advanced_section');						// Section name
		
                                
                                // Branding Options Section
		// Create the placementpartner_logindetails_options field in the placementpartner_admin_group
		register_setting('placementpartner_admin_group', 						// Group name
						'placementpartner_branding_options',					// Field or setting name
						array('PlacementPartner_Admin', 'brandingOptionsValidate')		// Validation function
				);
		
		// Create the placementpartner_advanced_section on the placementpartner_admin_page
		add_settings_section('placementpartner_branding_section', 					// Section name
							'Branding Options', 									// Section heading
							array('PlacementPartner_Admin', 'showBrandingOptionsText'),// Callback function for section text
							'placementpartner_admin_page');							// Page name
		
		// Create the field placementpartner_logindetails_username to the placementpartner_admin_page in the placementpartner_logindetails_section
		add_settings_field('placementpartner_branding_text_colour',						// Field name
							'Text Colour (hex value only)',		 											// Field label
							array('PlacementPartner_Admin', 'showTextColour'),		// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name
							'placementpartner_branding_section');	
                
                                add_settings_field('placementpartner_branding_button_colour',						// Field name
							'Button Colour (hex value only)',		 											// Field label
							array('PlacementPartner_Admin', 'showButtonColour'),		// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name
							'placementpartner_branding_section');
                                
                                add_settings_field('placementpartner_branding_heading_bck_colour',						// Field name
							'Headings Background Colour (hex value only)',		 											// Field label
							array('PlacementPartner_Admin', 'showHeadingColour'),		// Callback function to create the field HTML
							'placementpartner_admin_page',								// Page name
							'placementpartner_branding_section');
	}

	function showAdminOptionsPage() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include "options_form.html";
	}
	
	function showLoginDetailsText() {
		echo "Please enter your Placement Partner Web Module username and password. If you do not have your login details, please contact the <a target=\"_blank\" href=\"http://www.placementpartner.co.za/\">Placement Partner</a> team.";
	}
	
	function showLoginDetailsUsername() {
		$loginDetails = get_option('placementpartner_logindetails_options');
		echo "<input id='username' name='placementpartner_logindetails_options[username]' size='20' type='text' value='{$loginDetails['username']}' />";
	}
	
	function showLoginDetailsPassword() {
		$loginDetails = get_option('placementpartner_logindetails_options');
		echo "<input id='password' name='placementpartner_logindetails_options[password]' size='20' type='text' value='{$loginDetails['password']}' />";
	}
	
	function loginOptionsValidate($input) {
		// Validate input fields
		$newInput['username'] = $input['username'];
		$newInput['password'] = $input['password'];
		
		return $newInput;
	}
	
	function showAdvancedOptionsText() {
		echo "You should not have to adjust these settings unless told to do so by the Placement Partner Team.";
	}
        
                function showBrandingOptionsText() {
		echo "Here you can ajust the text, heading and button background colours to your liking.";
	}
	
	function brandingOptionsValidate($input) {
		// Validate input fields
		$newInput['text_colour'] = $input['text_colour'];
                                $newInput['button_colour'] = $input['button_colour'];
                                $newInput['heading_bck_colour'] = $input['heading_bck_colour'];
	
		return $newInput;
	}
        
                function showHeadingColour() {
		$advanced = get_option('placementpartner_branding_options');
                 echo "<input id='heading_bck_colour' name='placementpartner_branding_options[heading_bck_colour]' size='60' type='text' value='".@$advanced['heading_bck_colour']."' />
			    <div id='ilctabscolorpicker_3'></div>";
	
		echo '<script type="text/javascript">

				jQuery(document).ready(function() {
				  jQuery(\'#ilctabscolorpicker_3\').hide();
				  jQuery(\'#ilctabscolorpicker_3\').farbtastic("#heading_bck_colour");
				  jQuery("#heading_bck_colour").click(function(){jQuery(\'#ilctabscolorpicker_3\').slideToggle()});
				});

			  </script>';
	}
        
                function showButtonColour() {
		$advanced = get_option('placementpartner_branding_options');
                echo "<input id='button_colour' name='placementpartner_branding_options[button_colour]' size='60' type='text' value='".@$advanced['button_colour']."' />
			  <div id='ilctabscolorpicker_2'></div>";
		echo '<script type="text/javascript">

				jQuery(document).ready(function() {
				  jQuery(\'#ilctabscolorpicker_2\').hide();
				  jQuery(\'#ilctabscolorpicker_2\').farbtastic("#button_colour");
				  jQuery("#button_colour").click(function(){jQuery(\'#ilctabscolorpicker_2\').slideToggle()});
				});

			  </script>';
	}
        
                function showTextColour() {
		$advanced = get_option('placementpartner_branding_options');
		echo "<input id='text_colour' name='placementpartner_branding_options[text_colour]' size='60' type='text' value='".@$advanced['text_colour']."' />
				<div id='ilctabscolorpicker'></div>";
		echo '<script type="text/javascript">

				jQuery(document).ready(function() {
				  jQuery(\'#ilctabscolorpicker\').hide();
				  jQuery(\'#ilctabscolorpicker\').farbtastic("#text_colour");
				  jQuery("#text_colour").click(function(){jQuery(\'#ilctabscolorpicker\').slideToggle()});
				});

			  </script>';
	}
        
                function advancedOptionsValidate($input) {
		// Validate input fields
		$newInput['wsdl_url'] = $input['wsdl_url'];
	
		return $newInput;
	}

	function showAdvancedWsdlUrl() {
		$advanced = get_option('placementpartner_advanced_options');
		echo "<input id='wsdl_url' name='placementpartner_advanced_options[wsdl_url]' size='60' type='text' value='{$advanced['wsdl_url']}' />";
	}
	
}

