<?php
    //set the custom branding options
    //Heading backgrounds
    if($branding_options['heading_bck_colour'] && !empty($branding_options['heading_bck_colour'])){
        //test
        $hex = strpos($branding_options['heading_bck_colour'], '#');
        $length = strlen($branding_options['heading_bck_colour']);
        if($length == 7 && $hex == 0){
            ?>
            <style>
                .search-box {
                    background:<?=$branding_options['heading_bck_colour']?> !important;
                }
                .listing-head {
                    background:<?=$branding_options['heading_bck_colour']?> !important;
                }
            </style>
            <?php
        }
    }
    //Text colour
    if($branding_options['text_colour'] && !empty($branding_options['text_colour'])){
        //test
        $hex = strpos($branding_options['text_colour'], '#');
        $length = strlen($branding_options['text_colour']);
        if($length == 7 && $hex == 0){
            ?>
            <style>
                .search-box label{
                    color:<?=$branding_options['text_colour']?> !important;
                }
                .listing-head h1 {
                    color:<?=$branding_options['text_colour']?> !important;
                }
                .listing-contens-left p span {
                    color:<?=$branding_options['text_colour']?> !important;
                }
                .listing-contens-right h2 {
                    color:<?=$branding_options['text_colour']?> !important;
                }
                .page-serch label {
                    color:<?=$branding_options['text_colour']?> !important;
                }
		.listing-contens-left a{
                    color:<?=$branding_options['text_colour']?> !important;
                }
		.listing-contens-left a:hover{
                    color:<?=$branding_options['text_colour']?> !important;
                }
            </style>
            <?php
        }
    }
    //Button background color
    if($branding_options['button_colour'] && !empty($branding_options['button_colour'])){
        //test
        $hex = strpos($branding_options['button_colour'], '#');
        $length = strlen($branding_options['button_colour']);
        if($length == 7 && $hex == 0){
            ?>
            <style>
                .search-buttom{
			background-color:<?=$branding_options['button_colour']?> !important;
                }
                .listing-head a {
			background-color:<?=$branding_options['button_colour']?> !important;
                }
                .listing-contens-right a {
			color:<?=$branding_options['button_colour']?> !important;
                }
		.listing-container .page-serch a{
			color:<?=$branding_options['button_colour']?> !important;
		}
		.listing-container .page-serch a:hover{
			color:<?=$branding_options['button_colour']?> !important;
		}
            </style>
            <?php
        }
    }
?>

<div>
    <div class="conent-container">
        <div class="search-box">
            <!-- Create the search options box -->
            <form class="jobs_filter" name="jobs_filter" method="post" action="<?php print(htmlentities($return_page)); ?>" style="display: <?php ($_GET['search'] != '0')? print('block') : print('none'); ?>;">
                <?php if (isset($_GET['facebook']) || isset($_POST['facebook'])  || (isset($_GET['source']) && $_GET['source'] == 'facebook')): ?>
                    <input type="hidden" name="facebook" value="true" />
                <?php endif; ?>
	<!-- Filter options -->
                <!-- Industry and Region options -->
                <?php if (!$list_group && !@$_GET["f"]) {?>
                    <span>
                        <label>Industry:</label>
                        <select  id="sector" name="sector[]">
                                    <?php print($sector_options); ?>
                        </select>
                    </span>
                    <span>
                        <label>Region:</label>
                        <select  id="region" name="region[]">
                                <?php print($region_options) ?>
                        </select>
                    </span>
	<?php } ?>
                <!-- List group options -->
                    <span>
                        <label>Vacancy Type:</label>
                            <select id="vacancy_type" name="vacancy_type[]">
				<option value="5" <?php print(@in_array("5", $_POST["vacancy_type"]) ? "selected" : ""); ?>>ALL</option>
                                <option value="1" <?php print(@in_array("1", $_POST["vacancy_type"]) ? "selected" : ""); ?>>Permanent</option>
				<option value="2" <?php print(@in_array("2", $_POST["vacancy_type"]) ? "selected" : ""); ?>>Temporary</option>
				<option value="4" <?php print(@in_array("4", $_POST["vacancy_type"]) ? "selected" : ""); ?>>Contract</option>
                            </select>
                    </span>
                        <?php if (@$_GET["f"] || isset($_GET["group"])) { ?>
                            <span>
                                <label>Region:</label>
                                <select id="region" name="region[]">
                                        <?php print($region_options); ?>
                                    </select>
                            </span>
                        <?php }?>
                <!-- Serach Fields -->
                    <span>
                        <label>Search:</label>
		<select name='searchwhat' id='searchwhat'>
                                    <option value="keywords" <?php print($_POST["searchwhat"] == "keywords" ? "selected" : ""); ?>>complete ads</option>
                                    <option value="jobtitle" <?php print($_POST["searchwhat"] == "jobtitle" ? "selected" : ""); ?>>job titles</option>
                                    <option value="jobdescription" <?php print($_POST["searchwhat"] == "jobdescription" ? "selected" : ""); ?>>job details</option>
                                    <option value="vacancy_ref" <?php print($_POST["searchwhat"] == "vacancy_ref" ? "selected" : ""); ?>>vacancy reference</option>
                                </select>
		<p>&nbsp;&nbsp;for&nbsp;</p>
		<input type="text" name="keywords" value="<?php print(htmlentities(stripslashes(@$_POST["keywords"]))); ?>"  id="keywords"/>
		<p>&nbsp;&nbsp;matching&nbsp;</p>
		<select id="match" name="match">
                                    <option value="any" <?php print($_POST["match"] == "any" ? "selected" : ""); ?>>any words</option>
                                    <option value="all" <?php print($_POST["match"] == "all" ? "selected" : ""); ?>>all words</option>
                                    <option value="exact" <?php print($_POST["match"] == "exact" ? "selected" : ""); ?>>exact phrase</option>
                                </select>
                    </span>
                    <span>
                        <label>list:</label>
		<select id="sort" name="sort">
                                    <option value="date_desc" <?php print($_POST["sort"] == "date_desc" ? "selected" : ""); ?>>latest positions first</option>
                                    <option value="salary_desc" <?php print($_POST["sort"] == "salary_desc" ? "selected" : ""); ?>>highest salaries first</option>
                                    <option value="region" <?php print($_POST["sort"] == "region" ? "selected" : ""); ?>>alphabetically by region</option>
                                    <option value="sector" <?php print($_POST["sort"] == "sector" ? "selected" : "");?>>alphabetically by industry</option>
                                </select>
                    </span>
                    <span>
                        <label>Results per page:</label>
                            <select id="results_per_page" name="results_per_page">
		<option value="10" <?php print($_POST["results_per_page"] == "10" ? "selected" : ""); ?>>10</option>
		<option value="20" <?php print($_POST["results_per_page"] == "20" ? "selected" : ""); ?>>20</option>
                                <option value="30" <?php print($_POST["results_per_page"] == "30" ? "selected" : ""); ?>>30</option>
                            </select>
                    </span>
                    <span>
                            <a class="search-buttom" OnClick="document.jobs_filter.page.value = ''; document.jobs_filter.submit();">SEARCH</a>
                    </span>
                    <span>
                            <input type="hidden" name="reset" id="reset" value="0">
                            <a class="search-buttom" OnClick="document.jobs_filter.reset.value = '1'; document.jobs_filter.submit();">CLEAR</a>
                   </span>
                    <input type="hidden" name="page" value="<?php print($_POST["page"]); ?>">
            </form>
    </div>
    <!-- List Jobs -->
    <div class="listing-container">
        <?php
                    // If we have nothing posted - apply the default filter
                    // Otherwise build the filter as required
                    if(empty($_POST)) {
                        // Sort by date by default
                        $filter[] = array("field" => "sort_by",
			"operator" => "desc",
			"value" => "date"
		);
                        // List 10 results per page by default
                        if(isset($_GET["showall"])) {
                            $filter[] = array("field" => "entries_per_page",
			"operator" => "",
			"value" => "0"
		);
                        } else {
                            $filter[] = array("field" => "entries_per_page",
			"operator" => "",
			"value" => "10"
		);
                        }
                    } else {
                        // Check if a sector was selected
                        if($_POST["sector"][0] !== ''){
                            if (!empty($_POST["sector"])) {
                                // Sectors was selected - add these to the filter
                                foreach ($_POST["sector"] as $sector) {
                                    $filter[] = array("field" => "sector",
                                    "operator" => "=",
                                    "value" => $sector
                                    );
                                }
                            }
                        }
                        // Set the region filter
                        if($_POST["region"][0] !== ''){
                                if (! empty($_POST["region"])) {
                                    // Regions was selected - add these to the filter
                                    foreach ($_POST["region"] as $region) {
                                        $filter[] = array("field" => "region",
                                                "operator" => "=",
                                                "value" => $region
                                        );
                                    }
                                }
                        }
                        // Set the sorting
                        if (! empty($_POST["sort"])) {
                            // The sort direction is built into the selection option separated by _
                            // Split it out here and set the values in the filter
                            $sort = explode("_", $_POST["sort"]);
                            $filter[] = array("field" => "sort_by",
			"operator" => $sort[1],
			"value" => $sort[0]
		);
                        }
                        
                            // vacancy ref searches should always use like
                            if ($_POST["searchwhat"] == 'vacancy_ref') {
                                $_POST["match"] = 'like';
                                $_POST['keywords'] = '%'.$_POST['keywords'].'%';
                            }
                            $filter[] = array("field" => $_POST["searchwhat"],
                            "operator" => $_POST["match"],
                            "value" => stripslashes($_POST["keywords"])
                            );
                        // Set paging filter
                        // List 10 results per page by default
                        $filter[] = array("field" => "entries_per_page",
			"operator" => "",
			"value" => $_POST["results_per_page"]
                        );
                        if (! empty($_POST["page"])) {
                            $filter[] = array("field" => "page",
			"operator" => "",
			"value" => $_POST["page"]
                            );
                        }
                        
                        if($_POST["vacancy_type"][0] !== '5'){
                                if (! empty($_POST["vacancy_type"])) {
                                    // Regions was selected - add these to the filter
                                    foreach ($_POST["vacancy_type"] as $vacancy_type) {
                                        $filter[] = array("field" => "vacancy_type",
                                                "operator" => "=",
                                                "value" => $vacancy_type
                                        );
                                    }
                                }
                        }
	}
                if (! empty($_GET["f"])) {
                    foreach (explode(',', $_GET["f"]) as $jobfunction) {
                        $filter[] = array("field" => "function",
			"operator" => "=",
			"value" => $jobfunction);
                        }
                }
                // Test the job_title filter field
	if ($list_group) {
                        $ads = $pp->getGroupAdverts($session_id, $filter);
	} else {
                        $ads = $pp->getAdverts($session_id, $filter);
                }
                
                $err = $pp->getError();
                if ($err) {
                    if ($debug) {
                        echo "<b>Error:</b> $err<br><b>Debug:</b> $pp->response<br><br>";
                    }
                    die(str_replace("__ERR_NO", "005", $err_msg));
                }

	$paging = $pp->getAdvertPagingData($session_id);
                if ($err) {
                    if ($debug) {
                        echo "<b>Error:</b> $err<br><b>Debug:</b> $pp->response<br><br>";
                    }
                    die(str_replace("__ERR_NO", "006", $err_msg));
                }
                if (is_int(@$_GET["page"])) {
                    $_POST["page"] = $_GET["page"];
                }

	// If no ads are found - inform the user
	if (empty($ads)) { ?>
                    <nav>
                        <p class="page-listing">No positions found matching your criteria</p>
                    </nav>
   <?php } else { ?>
                
                <!-- Job Entries -->
                <div>
                    <?php
                        $page_links = "";
                                for ($i = 1; $i <= $paging["no_of_pages"]; $i++) {
                                    if ($i != $paging["this_page"]) {
                                        $page_links .= "<option value='$i'>$i</option>";
                                        // $page_links .= "&nbsp;&nbsp;&nbsp;<a href=\"\" class=\"jobs_list_job_link\" OnClick=\"document.jobs_filter.page.value = '$i';document.jobs_filter.submit();return false;\">$i</a>";
                                    } else {
                                        $page_links .= "<option value='$i' selected style='background-color:#888'>$i</option>";
                                        // $page_links .= "&nbsp;&nbsp;&nbsp;$i";
                                    }
		}
                        ?>
                        <nav>
							<p class="page-listing">Page <?php print($paging["this_page"]); ?> of <?php print($paging["no_of_pages"]); ?> (Listing <?php print($paging["first_entry_index"]); ?> to <?php print($paging["last_entry_index"]); ?>)</p>
							<p class="text-left"><?php print($paging["entries"]); ?> positions found</p>
							<div class=" page-serch">
								<!-- <span>
									<label><?php print((! $paging["first_page"]) ? "<a href=\"\" title=\"Previous page\" OnClick=\"document.jobs_filter.page.value = '" . ($paging["this_page"]-1) . "';document.jobs_filter.submit();return false;\"><< Prev</a>" : ""); ?></label>
								</span> -->
								<span>
									<label>Page</label>
									<select OnChange="document.jobs_filter.page.value = this.value;document.jobs_filter.submit();return false;"><?php print($page_links); ?></select>
								</span>
								<!-- <span>
									<label><?php print((! $paging["last_page"]) ? "<a href=\"\" title=\"Next page\" OnClick=\"document.jobs_filter.page.value = '" . ($paging["this_page"]+1) . "';document.jobs_filter.submit();return false;\">Next >></a>" : ""); ?></label>
								</span> -->
							</div>

						</nav>
                        <?php
                        // Adverts have been found display them to the user
                        foreach ($ads as $ad) {
		$pay = "";
		$salary_min = trim($ad["salary_min"]);
		$salary_max = trim($ad["salary_max"]);
		$salary_interval = trim($ad["salary_interval"]);

		if (stripos($salary_min,'R') === false && ! empty($salary_min)) {
			if (is_numeric(preg_replace('/[^0-9]/', '', $salary_min))){
                                                    $pay .= "R ";
			}
		}

		$pay .= $salary_min;

		if ($salary_max != $salary_min && ! empty($salary_min) && ! empty($salary_max)) {
			$pay .= " - ";
		}

		if (! empty($salary_max)) {
			if (stripos($salary_max,'neg') === false && stripos($salary_max,'R') === false) {
				if(is_numeric(preg_replace('/[^0-9]/', '', $salary_max))){
                                                                    $pay .= "R ";
				}
			}
                                                $pay .= $salary_max;
		}

		if (! empty($pay) && stripos($salary_max,'neg') === false) {
			$pay .= " " . $salary_interval;
		}
                
                
                                $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                if ($_SERVER["SERVER_PORT"] != "80")
                                {
                                    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                                }
                                else
                                {
                                    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                                }
                                
                                $url_params = array(
                                    'vac' => $ad["vacancy_ref"]
		);

		if (isset($_GET['source'])) {
                                    $url_params['source'] = $_GET['source'];
                                }
                                        
                                if (isset($_GET['popup_split_screen']) && $_GET['popup_split_screen'] == '0') {
                                    $url_params['popup_split_screen'] = "0";
                                }
                        ?>
                                <div class="listing-head">
                                    <a href="https://www.placementpartner.co.za/wi/submit_cv_form.php?id=<?php print($ad["company_ref"]); ?>&VacRef=<?php print($ad["vacancy_ref"]); ?>&rtpg=<?php echo urlencode($pageURL) ?>" target="_blank" title="Click here to view the full details for this job" target="">Apply</a>
                                    <h1><?php print($ad["job_title"]); ?></h1>
                                    <p>| <?php print($ad["region"]); ?>&nbsp;-&nbsp; <?php print($ad["town"]); ?></p>		
                                </div>
                                <div class="listing-contens">
                                    <div class="listing-contens-left">
                                <p><span>Sector:</span><?php print($ad["sector"]); ?></p>
                                <?php if ($pay) { ?>
                                    <p><span>Salary/Rate:</span><?php print($pay); ?></p>
		<?php } ?>
                                    <p><span>Date Posted:</span><?php $modified_date = new DateTime($ad['last_modified_date']); echo $modified_date->format('j F Y');  ?></p>
                                <p><span>Closing Date:</span><?php $modified_date = new DateTime($ad['expiry_date']); echo $modified_date->format('j F Y');  ?></p>				
                                <a>For more information please contact | <b><?=$ad['consultant_name']?>, <?=$ad['branch_name']?></b></a>
                                <br/><br/>
                                    </div>
                                    <div class="listing-contens-right">
                                        <h2>Job Description:</h2>
                                        <p>
                                            <?php print($ad["brief_description"]); ?>
                                        </p>
                                        <a href="<?=$full_details_url?>?<?php print(http_build_query($url_params)); ?>" title="Click here to view the full details for this job" target="">+ more info</a>
                                    </div>
                                </div>
                    <?php } ?>
                     <nav>
                    <p class="page-listing">Page <?php print($paging["this_page"]); ?> of <?php print($paging["no_of_pages"]); ?> (Listing <?php print($paging["first_entry_index"]); ?> to <?php print($paging["last_entry_index"]); ?>)</p>
                    <p class="text-left"><?php print($paging["entries"]); ?> positions found</p>
					<div class=" page-serch">
						<span>
							<label><?php print((! $paging["first_page"]) ? "<a href=\"\" title=\"Previous page\" OnClick=\"document.jobs_filter.page.value = '" . ($paging["this_page"]-1) . "';document.jobs_filter.submit();return false;\"><< Prev</a>" : ""); ?></label>
						</span>
						<span>
							<label>Page</label>
							<select OnChange="document.jobs_filter.page.value = this.value;document.jobs_filter.submit();return false;"><?php print($page_links); ?></select>
						</span>
						<!-- <span>
							<label><?php print((! $paging["last_page"]) ? "<a href=\"\" title=\"Next page\" OnClick=\"document.jobs_filter.page.value = '" . ($paging["this_page"]+1) . "';document.jobs_filter.submit();return false;\">Next >></a>" : ""); ?></label>
						</span> -->
					</div>
					
                </nav>
                </div>
        <?php } ?>
    </div>
        
    <div class="page-footer">
        <img src="<?=$logo_url?>"/>
        <p>Placement Partner &COPY; 2013. All Rights Reserved.</p>
    </div>
 </div>
</div>