<?php 
global $column_class, $home_page, $title_content; 
								$image_id = get_post_thumbnail_id(get_the_ID()); 
				$term_slug = get_the_terms(get_the_ID(), 'gallery-category');$size = '600x400';
						echo '<li class=" col-md-'.esc_attr($column_class).' col-sm-'.esc_attr($column_class).'">
                        <div class="grid-item-inner">'; ?>
                <div class="grid-content">
                                    <h3 class="post-title"><?php echo __('No Gallery posts to display','framework'); ?></h3>
                                </div>
         	</div>
</li>