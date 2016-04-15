(function($) {
  "use strict";
$(document).ready(function(){
	$(".parent-spec").live("change", function(){
		var $parent_val = jQuery(this).val();
		var $spec_id = $(this).attr("data-specid");
		var $list_id = $(this).attr("data-listid");
		var $area = $(this);
		jQuery.ajax({
            type: 'POST',
            url: listadm.ajaxurl,
            data: {
                action: 'imic_list_child_specs',
								'parent': $parent_val,
								'specid': $spec_id,
								'listid': $list_id
            },
            success: function(data) {
							$($area).parents().find('.child-spec').empty();
							$($area).parents().find('.child-spec').append(data);
            },
            error: function(errorThrown) {
            }
        });
	});
});
})(jQuery);