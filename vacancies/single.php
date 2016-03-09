<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "fc8620ae-7bb4-430e-9ca6-2f41c8aa818c"}); </script>
<?php

$left_content_list = "";
$right_content = array();
foreach ($ad as $key => $value) {
    $left_content_list .= '<div class="left-item" id="left-item' . $key . '" onclick="displayContent(' . $key . ')" style="cursor: pointer; padding: 10px; padding-left: 0px; border-bottom: #ccc 1px solid"><div class="left-item-job">' . $value["job_title"] . '</div><div class="left-item-location" style="">' . $value["town"] . ', ' . $value["region"] . '</div></div>';
    $right_content[$key] = '<div class="right-content" style="margin-left: 60px; margin-top: 10px;">
                         <div class="right_heading" style="font-size: 24px; color: #649087; margin-bottom: 10px;">
                            ' . $value["job_title"] . 
                         '</div>
                          <div class="right_sub_heading">
                            ' . $value["sector"] . 
                         '</div>
                          <hr />
                         <div class="vac_details">
                            <span style="display:inline-block; width: 99px; font-weight: bold; padding-bottom: 5px;">Contract type</span>Permanent<br />
                            <span style="display:inline-block; width: 99px; font-weight: bold; padding-bottom: 5px;">Date Posted</span>' . $value["start_date"] . '<br />
                            <span style="display:inline-block; width: 99px; font-weight: bold; padding-bottom: 5px;">Salary</span>' . $value["salary_min"] . ' ' . $value["salary_max"] . '<br />
                            <span style="display:inline-block; width: 99px; font-weight: bold; padding-bottom: 5px;">Location</span>' . $value["town"] . ', ' . $value["region"] . '<br />
                         </div>
                         <div class="vac_intro_container" style="margin-top: 20px;">
                            <div class="vac_intro_heading"><h3>Job Specifications</h3></div>
                            <div class="vac_intro_content">' . $value["brief_description"] . '</div>
                            <br />
                         </div>
                         <div class="job_specification">
                            <div class="job_specification_heading"><h3>Introduction</h3></div>
                            ' . $value["detail_description"] . '
                         </div>
                         <hr />
                         <div class="vac_apply">
                            <h2>Apply now</h2>
                            <p>To apply for the above mentioned vacancy, you will need to fill in a few details and attach an up-to-date CV.</p>
                            <a href="https://www.placementpartner.co.za/wi/submit_cv_form.php?id=mna&VacRef=' . $value["vacancy_ref"] . '/LW" target="_blank" class="apply_now" style="font-size: 18px; font-weight: bold; color: #fff; background: #7da89f; padding: 5px 10px 8px 10px; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;">Apply now</a>
                         </div>
                         <br />
                         <br />
                     </div>';
}

$right_content_json = json_encode($right_content);

echo '
<div class="left-content" style="width: 30%; float: left;">
 ' . $left_content_list . '
</div>
<div class="content-view" style="width: 70%; float: right;">
    ' . $right_content[0] . '
</div>';

echo 
'
<script type="text/javascript">

(function($){ 
    $("#left-item0").css("background-color", "#ecf7f3");
    $("#left-item0").css("padding-left", "10px");
    $("#left-item0").addClass("clicked");
})(jQuery); 

var right_content = ' . $right_content_json . ';

function displayContent(key) {  
    (function($){         
        $(".left-item").css("background-color", "inherit");
        $(".left-item").css("padding-left", "0px");
        $(".left-item").removeClass("clicked");
        $("#left-item" + key).css("background-color", "#ecf7f3");
        $("#left-item" + key).css("padding-left", "10px");
        $("#left-item" + key).addClass("clicked");
        $(".content-view").fadeOut("fast");
        $(".content-view").html(right_content[key]);
        $(".content-view").fadeIn("fast");
    })(jQuery); 
}

(function($){ 
    $(".left-item").hover(function(e) {
        if ($(this).hasClass("clicked")) { return; };
        $(this).animate({ "padding-left": "10px" }, 300);
        $(this).css("background-color", "#ecf7f3");
    }, function(e) {
        if ($(this).hasClass("clicked")) { return; };        
        $(this).animate({ "padding-left": "0px" }, 300);
        $(this).css("background-color", "inherit");
    });
})(jQuery);    
</script>
';
