<?php global $column_class, $home_page, $title_content, $imic_options; 
$post_format_temp =get_post_format(get_the_ID());
$post_format =!empty($post_format_temp)?$post_format_temp:'image';
				$term_slug = get_the_terms(get_the_ID(), 'gallery-category');
				$size = '600x400';
				echo '<li class=" col-md-'.esc_attr($column_class).' col-sm-'.esc_attr($column_class).' grid-item format-'.esc_attr($post_format).' ';
						if (!empty($term_slug)) {
						foreach ($term_slug as $term) {
						  echo esc_attr($term->slug).' ';
						} } ?>">
						<div class="grid-item-inner">
                        <div class="media-box">
                    <?php $image_data=  get_post_meta(get_the_ID(),'imic_gallery_images',false);
						echo imic_gallery_flexslider(get_the_ID());     
						if (count($image_data) > 0) {
						echo '<ul class="slides">';
						foreach ($image_data as $custom_gallery_images) {
						$large_src = wp_get_attachment_image_src($custom_gallery_images, '1000x800');
						if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){
							$Lightbox_init = '<li class="item"><a href="' . esc_url($large_src[0]) . '" data-rel="prettyPhoto[' . esc_attr(get_the_title()) . ']">';
						}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){
							$Lightbox_init = '<li class="item"><a href="' . esc_url($large_src[0]) . '" class="magnific-gallery-image">';
						}
						echo $Lightbox_init;
						echo wp_get_attachment_image($custom_gallery_images, $size);
						echo'</a></li>';
						}
						echo '</ul>'; } ?>
               	</div>
                </div>
                <?php if($title_content!=0) { ?>
                <div class="grid-content">
                <?php if($title_content==1||$title_content==3) { ?>
                                    <h3 class="post-title"><?php echo get_the_title(); ?></h3><?php } if($title_content==2||$title_content==3) { ?>
                                    <?php the_content(); } ?>
                                </div><?php } ?>
         	</div>
          	</li>