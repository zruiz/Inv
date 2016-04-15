function remove_field(obj) {
        var parent=jQuery(obj).parent();
        //console.log(parent)
        parent.remove();
}
function add_field_row() {
		//alert("saibaba");
        var row = jQuery('#master-row').html();
        jQuery('#field_wrap').append(row);
}