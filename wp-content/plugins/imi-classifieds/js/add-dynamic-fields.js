function remove_field(obj) {
        var parent=jQuery(obj).parent().parent();
        //console.log(parent)
        parent.remove();
}
function add_field_row() {
		//alert("saibaba");
        var row = jQuery('#master-row').html();
        jQuery('#field_wrap').append(row);
}
jQuery(document).ready(function($){
	/*$(function() {
     $( ".connectedSortable" ).sortable({
         connectWith: $(this).parent()
     }).disableSelection();
 	});*/
	$all_ids = [];
	$( ".connectedSortable" ).sortable(
      { //handle: "li",
	  connectWith: $(this).parent(),
        stop: function(event, ui){
          $all_ids = [];
		$(this).parent().find(".del-spec").each(function(index, element) {
        var $id = $(this).parent().attr("id");
		$all_ids.push($id);
    });
	$(this).parent().find(".save_ids").val("");
	$(this).parent().find(".save_ids").val($all_ids);
     }
	}).disableSelection();
	$all_ids = [];
	$(".add-speci").live('change',function(){
		var $spec_id = $("option:selected", this);
		var data = "<li id="+$spec_id.val()+">"+$spec_id.text()+" <span class=\"del-spec\">X</span></li>";
		$(this).parent().find(".selected-specs").append(data);
		$(this).find('option[value='+$spec_id.val()+']').hide();
		$all_ids = [];
		$(this).parent().find(".del-spec").each(function(index, element) {
        var $id = $(this).parent().attr("id");
		$all_ids.push($id);
    });
	$(this).parent().find(".save_ids").val("");
	$(this).parent().find(".save_ids").val($all_ids);
	});
	$(".del-spec").live("click",function(){
		var $spec_item = $(this).parent().attr("id");
		var $text = $(this).parent().parent().parent().find(".save_ids");
		$all_ids = [];
		$(this).parent().parent().parent().find(".del-spec").each(function(index, element) {
        var $id = $(this).parent().attr("id");
		$all_ids.push($id);
    	});
		$(this).parent().parent().parent().find("select option[value^=" + $spec_item + "]").show();
		$(this).parent().remove();
		$all_ids = $.grep($all_ids, function(value) {
		  return value != $spec_item;
		});
	$text.val("");
	$text.val($all_ids);
	});
});