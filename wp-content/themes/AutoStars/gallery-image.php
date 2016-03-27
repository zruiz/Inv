<?php
global $imic_options;
 if ( '' != get_the_post_thumbnail() ) { 
global $column_class, $home_page, $title_content; 
								$image_id = get_post_thumbnail_id(get_the_ID()); 
								$image = wp_get_attachment_image_src($image_id,'1000x800','');
$post_format_temp =get_post_format(get_the_ID());
$post_format =!empty($post_format_temp)?$post_format_temp:'image';
				$term_slug = get_the_terms(get_the_ID(), 'gallery-category');$size = '600x400';
						echo '<li class=" col-md-'.esc_attr($column_class).' col-sm-'.esc_attr($column_class).' grid-item format-'.esc_attr($post_format).' ';
						if (!empty($term_slug)) {
						foreach ($term_slug as $term) {
						  echo esc_attr($term->slug).' ';
						} } ?>">
                        <div class="grid-item-inner">
                        <?php if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){
									$Lightbox_init = '<a href="'.esc_url($image[0]) .'" data-rel="prettyPhoto" class="media-box">';
								}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){
									$Lightbox_init = '<a href="'.esc_url($image[0]) .'" class="media-box magnific-image">';
								}
								echo $Lightbox_init; ?><?php the_post_thumbnail($size); ?></a>
<?php if($title_content!=0) { ?>
                <div class="grid-content">
                <?php if($title_content==1||$title_content==3) { ?>
                                    <h3 class="post-title"><?php echo get_the_title(); ?></h3><?php } if($title_content==2||$title_content==3) { ?>
                                    <?php the_content(); } ?>
                                </div><?php } ?>
         	</div>
</li>
<?php } ?>