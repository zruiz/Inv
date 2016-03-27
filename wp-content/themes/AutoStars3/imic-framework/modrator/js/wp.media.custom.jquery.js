( function( $ ) {
    'use strict';
jQuery(document).ready(function($){
	if(typeof wp !== 'undefined'){
		 var custom_media = wp.media( {
				multiple: true,
				library: {
					type: 'image'
				}
		 });
		$('#cbafu_button').click(function(e) {
			var button = $(this);
			custom_media.on( 'ready', function() {
				$( '.media-modal' ).addClass( 'no-sidebar' );
			} );
			custom_media.state( 'library' ).on( 'select', function() {
				  var files = this.get('selection').toArray();
				  $.each(files,function(i,v)
				  {
					   ManageThumbnail(v.toJSON(),button);
				  });
				/* reset selection */  
				this.get('selection').reset();
			} );
			if(custom_media)
			{
				custom_media.open();
				return;
			}
		   return false;
		});
	}
   /* manage preview and delete button */
   function ManageThumbnail(attachment,button)
   {
		/* generate unique id */
		var unique_id = Math.floor(Math.random() * 10000) + 1;
		var input = '<input id ="input_'+unique_id+'" type="hidden" name="listing_photos[]" value="'+attachment.id+'" />';
		var html = '<div class="col-md-2 col-sm-2" id ="div_'+unique_id+'">';
			html+='<img class="thumbnail" width="127" height="95" src="'+attachment.url+'">';
			html+='<span id = "'+unique_id+'" style="cursor:pointer" class = "wp_media_remove_file">X</span>';
		    html+= '</div>';
		$(button).closest('form').append(input); 
		$('#'+$(button).data('container')).append(html);
   }
   /* remove thumbnail and input data */
	$('body').on( "click", ".wp_media_remove_file", function(e) {
		var _id = $(this).attr('id');
		$('#div_'+_id).remove();
		$('#input_'+_id).remove();
	});

});

} )( jQuery || {} );