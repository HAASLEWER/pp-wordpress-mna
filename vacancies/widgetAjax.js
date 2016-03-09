/**
 * All the js to populate the vacancy list from the JSON that was returned
 * 
 * data: JSON response object holding the data to display
 * listContainer: DIV that holds the list of items
 * itemContainer: DIV that holds the template for a single item
 * 
 * This function will create itemContainers for each object in the response.
 * It will look for objects with ID of the field name in the JSON object and 
 * populate it.
 * 
 * @param data
 * @param listContainer
 * @param itemContainer
 */
function createVacancyList(data, listContainer, itemContainer) {	
	// each item in the list
	jQuery.each(data, 
			function(i, item) {
				// Create a clone of the itemContainer object
				var list_item = itemContainer.clone();
				// Set new ID for this item
				list_item.attr('id', 'placementpartner_list_item_'+i);
				jQuery.each(item,
						function(field, value) {
							// Look for a <div> that is a child of the item container 
							// and that has the same id as the current field
							var field_div = list_item.children('#'+field);
							// If the object existed with the ID the same as the field name
							// Populate it with data
							if(field_div.length) {
								field_div.html(value);
								field_div.attr('id', field+'_'+i);
							}
							
						}
				);

				// Populate the more_link
				var more_link = list_item.children('#more_link').children('a');
				more_link.attr('href', PlacementPartner.detail_page+'?vac='+item.vacancy_ref);

				// Add list item to the list container
				listContainer.append(list_item);
			}
	);
	// Remove the list_item template entry from the list
	itemContainer.remove();
}

jQuery.post(
    PlacementPartner.ajaxurl,
    {
    	// This will fire the wp_ajax_nopriv_placementpartner-vacancies-widget-load and
    	// wp_ajax_placementpartner-vacancies-widget-load actions which will then call
    	// PlacementPartner_Vacancies_Widget::ajaxLoadVacancies
    	action 	: 'placementpartner-vacancies-widget-load',
    	num_ads : PlacementPartner.num_ads,
    },
    function(response) {    	
    	list_container = jQuery('#placementpartner_vacancies_list');
    	item_container = jQuery('#placementpartner_vacancy_item');
    	createVacancyList(response, list_container, item_container);
		jQuery('#placementpartner_vacancies_wait').fadeOut({
			complete: function() {
				list_container.slideDown(700);
			}
		});
    }
);