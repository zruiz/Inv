<?php
/*
Template Name: Listing
*/
get_header();
wp_enqueue_script('imic_search_filter');
global $imic_options;
//Get Page Banner Type
if(is_home()) { $id = get_option('page_for_posts'); }
else { $id = get_the_ID(); }
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($page_header==3) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==4) {
	get_template_part( 'pages', 'nivo' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
}
elseif($page_header==1||$page_header==2) {
	get_template_part( 'pages', 'banner' );
}
else {
	//get_template_part( 'pages', 'banner' );
}
if(is_plugin_active("imithemes-listing/listing.php")) {
$listing_page_url = imic_get_template_url('template-dashboard.php');
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
$listing_type = get_post_meta($id,'imic_default_listing_type',true);
$active_listing = ($listing_type=='list')?'active':'';
$active_grid = ($listing_type=='grid')?'active':'';
$vehicle_switch = get_post_meta($id,'imic_home_vehicle_switch',true);
$parallax_switch = get_post_meta($id,'imic_home_third_parallax_section',true);
$pricing_switch = get_post_meta($id,'imic_home_pricing_switch',true);
$posts_page = get_option('posts_per_page');
$qrs = imic_queryToArray($_SERVER['QUERY_STRING']);
?>
<!-- Start Content -->
    <div class="content" role="content">
        <div id="content" class="content full padding-b0">
            <?php if(have_posts()):while(have_posts()):the_post();
                echo '<div class="container" id="container1">';
                the_content();
              endwhile; endif;
             echo '</div>'; ?>
        </div>
    </div>
<!-- Actions bar -->
    <div class="actions-bar">
     	<div class="container">
        	<div class="row">
            	<div class="col-md-5 col-sm-5 search-actions">
                	<ul class="utility-icons tools-bar">
                    	<li><a href="#"><i class="fa fa-star-o"></i></a>
                        	<div class="tool-box">
                            	<div class="tool-box-head">
                                <?php if(is_user_logged_in()) { ?>
                            		<a href="<?php echo esc_url(add_query_arg('saved',1,$listing_page_url)); ?>" class="basic-link pull-right"><?php _e('View all','framework'); ?></a><?php } ?>
                            		<h5><?php _e('Saved yachts','framework'); ?></h5>
                                </div>
                                <div class="tool-box-in">
                                	<ul class="saved-cars-box listing tool-car-listing">
                                    <?php if((!isset($_SESSION['saved_vehicle_id1']))&&(!isset($_SESSION['saved_vehicle_id2']))&&(!isset($_SESSION['saved_vehicle_id3']))) { if ( is_user_logged_in() ) {
										$user_id = get_current_user_id( );
										$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
										$saved_cars = get_post_meta($user_info_id,'imic_user_saved_cars',true);
										if(!empty($saved_cars)) {
											$total = 0;
											$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:'';
											$unique_specs = $imic_options['unique_specs'];	
											foreach($saved_cars as $car) {
												$specifications = get_post_meta($car[0],'feat_data',true);
												$unique_value = imic_vehicle_price($car[0],$unique_specs,$specifications);
												$highlight_value = imic_vehicle_title($car[0],$highlighted_specs,$specifications);
											echo '<li>
                                        	<div class="checkb"><input id="saved-'.esc_attr($car[0]).'" value="0" type="checkbox" class="compare-check"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($car[0])).'">'.get_the_post_thumbnail($car[0]).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($car[0])).'">'.$highlight_value.'</a>
                                                <span class="price">'.$unique_value.'</span>
                                           	</div>
                                            <div rel="specific-saved-ad" class="delete delete-box-saved"><div class="specific-id" style="display:none;"><span class="saved-id">'.esc_attr($car[0]).'</span></div><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
										if($total++==2) { break; } }
										}
										else { echo '<li class="blank">'.__('No Saved Yachts yet','framework').'</li>'; }
									} }
									if(!empty($_SESSION['saved_vehicle_id1'])) {
									$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['saved_vehicle_id1'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id1'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id1'],$highlighted_specs,$specifications); ?>
                                    	<li>
                                        	<div class="checkb"><input value="0" id="saved-<?php echo esc_attr($_SESSION["saved_vehicle_id1"]); ?>" class="compare-check" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id1'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id1']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id1'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="one" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['saved_vehicle_id2'])) {
											$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['saved_vehicle_id2'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id2'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id2'],$highlighted_specs,$specifications); ?>
                                        <li>
                                        	<div class="checkb"><input value="0" id="saved-<?php echo esc_attr($_SESSION["saved_vehicle_id2"]); ?>" class="compare-check" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id2'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id2']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id2'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="two" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['saved_vehicle_id3'])) {
											$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['saved_vehicle_id3'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id3'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id3'],$highlighted_specs,$specifications); ?>
                                        <li>
                                        	<div class="checkb"><input value="0" id="saved-<?php echo esc_attr($_SESSION["saved_vehicle_id3"]); ?>" class="compare-check" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id3'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id3']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id3'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="three" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['saved_vehicle_id1'])&&!empty($_SESSION['saved_vehicle_id2'])&&!empty($_SESSION['saved_vehicle_id3'])) {
											echo '<li>'.__('Please login/register to add more','framework').'</li>';
										} if(empty($_SESSION['saved_vehicle_id1'])&&empty($_SESSION['saved_vehicle_id2'])&&empty($_SESSION['saved_vehicle_id3'])&&empty($saved_cars)&&(!is_user_logged_in())) {
										echo '<li class="blank">'.__('No Saved Yachts yet','framework').'</li>'; } ?>
                                        
                                    </ul>
                                </div>
                                <div class="tool-box-foot">
                                	<?php if ( !is_user_logged_in() ) { ?><a href="#" data-target="#PaymentModal" data-toggle="modal" class="btn btn-xs btn-primary pull-right"><?php _e('Signin/Join','framework'); ?></a><?php } if((!empty($_SESSION['saved_vehicle_id1'])||!empty($_SESSION['saved_vehicle_id2'])||!empty($_SESSION['saved_vehicle_id3']))&&(is_user_logged_in())) { echo '<a href="#" rel="popup-save" class="btn btn-xs btn-primary pull-right save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id">unsaved</span></div>Save</a>'; } ?>
                                	<a href="<?php echo esc_url(imic_get_template_url("template-compare.php")); ?>" class="btn btn-xs btn-info compare-in-box" disabled><?php _e('Compare','framework'); ?>()</a>
                                </div>
                            </div>
                        </li>
                    	<li><a href="#"><i class="fa fa-folder-o"></i></a>
                        	<div class="tool-box">
                            	<div class="tool-box-head">
								<?php
									$user_id = get_current_user_id( );
										$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
										$search_cars = get_post_meta($user_info_id,'imic_user_saved_search',true);
								 if(is_user_logged_in()&&!empty($search_cars)) { ?>
                            		<a href="<?php echo esc_url(add_query_arg('search',1,$listing_page_url)); ?>" class="basic-link pull-right"><?php _e('View all','framework'); ?></a><?php } ?>
                            		<h5><?php _e('Saved searches','framework'); ?></h5>
                                </div>
                                <div class="tool-box-in">
                                	<ul id="search-saved" class="listing tool-search-listing">
                                    <?php if((!isset($_SESSION['search_page1']))&&(!isset($_SESSION['search_page2']))&&(!isset($_SESSION['search_page3']))) { if ( is_user_logged_in() ) {
										
										if(!empty($search_cars)) {
											$total = 0;
											foreach($search_cars as $search) {
												$res = preg_replace("/[^a-zA-Z]/", "", $search[0]);
											echo '<li>
                                        	<div class="link"><a href="'.esc_url($search[2]).'">'.esc_attr($search[0]).'</a></div>
                                            <div id="specific-search-ad" class="delete delete-box-search"><div class="specific-id" style="display:none;"><span class="search-id">'.esc_attr($res).'</span></div><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>'; if($total++==3) { break; } }
										}
									else {
										echo '<li id="blank-search">
                                        	<div class="link">'.__('No Saved Searches Yet','framework').'</div>
                                        </li>';
									}
									}
									}
									if(!empty($_SESSION['search_page1'])) {
										$values = $_SESSION['search_page1']; ?>
                                    	<li>
                                        	<div class="link"><a href="<?php echo esc_url($values[1]); ?>"><?php echo esc_attr($values[0]); ?></a></div>
                                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['search_page2'])) {
												$values = $_SESSION['search_page2']; ?>
                                        <li>
                                        	<div class="link"><a href="<?php echo esc_url($values[1]); ?>"><?php echo esc_attr($values[0]); ?></a></div>
                                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['search_page3'])) {
												$values = $_SESSION['search_page3']; ?>
                                        <li>
                                        	<div class="link"><a href="<?php echo esc_url($values[1]); ?>"><?php echo esc_attr($values[0]); ?></a></div>
                                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } else { '<li>'.__('No saved searches yet','framework').'</li>'; } if(!empty($_SESSION['search_page1'])&&!empty($_SESSION['search_page2'])&&!empty($_SESSION['search_page3'])) { echo '<li>'.__('Please login/register to add more','framework').'</li>'; }
										if(empty($_SESSION['search_page1'])&&empty($_SESSION['search_page2'])&&empty($_SESSION['search_page3'])&&empty($search_cars)&&(!is_user_logged_in())) {
										echo '<li id="blank-search">
                                        	<div class="link">'.__('No Saved Searches Yet','framework').'</div>
                                        </li>'; } ?>
                                    </ul>
                                </div>
                                <div class="tool-box-foot">
								<?php if ( !is_user_logged_in() ) { ?><a href="#" data-target="#PaymentModal" data-toggle="modal" class="btn btn-xs btn-primary pull-right"><?php _e('Signin/Join','framework'); ?></a><?php } if((!empty($_SESSION['search_page1']))||(!empty($_SESSION['search_page2']))||(!empty($_SESSION['search_page3']))&&(is_user_logged_in())) { echo '<a href="#" id="popup-search" class="btn btn-xs btn-primary pull-right save-search"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id">unsaved</span></div>Save</a>'; } ?>
                                </div>
                            </div>
                        </li>
                    	<li><a href="#"><i class="fa fa-clock-o"></i></a>
                        	<div class="tool-box">
                            	<div class="tool-box-head">
                            		<h5><?php _e('Recently viewed yachts','framework'); ?></h5>
                                </div>
                                <div class="tool-box-in">
                                	<ul id="viewed-cars-listbox" class="listing tool-car-listing">
                                    <li id="blank-viewed">
                                    <div class="textb">
                                            	<?php echo _e('You do not have any viewed listings yet','framework'); ?>
                                   	</div>
                                    </li>
                                    	<?php 
									if(!empty($_SESSION['viewed_vehicle_id1'])) {
									$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['viewed_vehicle_id1'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['viewed_vehicle_id1'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id1'],$highlighted_specs,$specifications); ?>
                                    
                                    	<li>
                                        	<div class="checkb"><input value="0" id="view-<?php echo esc_attr($_SESSION["viewed_vehicle_id1"]); ?>" class="compare-viewed" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id1'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id1']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id1'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="seven" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['viewed_vehicle_id2'])) {
											$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['viewed_vehicle_id2'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['viewed_vehicle_id2'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id2'],$highlighted_specs,$specifications); ?>
                                        <li>
                                        	<div class="checkb"><input value="0" id="view-<?php echo esc_attr($_SESSION["viewed_vehicle_id2"]); ?>" class="compare-viewed" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id2'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id2']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id2'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="eight" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } if(!empty($_SESSION['viewed_vehicle_id3'])) {
											$highlighted_specs = $imic_options['highlighted_specs'];
									$unique_specs = $imic_options['unique_specs'];
									$specifications = get_post_meta($_SESSION['viewed_vehicle_id3'],'feat_data',true);
									$unique_value = imic_vehicle_price($_SESSION['viewed_vehicle_id3'],$unique_specs,$specifications);
									$highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id3'],$highlighted_specs,$specifications); ?>
                                        <li>
                                        	<div class="checkb"><input value="0" id="view-<?php echo esc_attr($_SESSION["viewed_vehicle_id3"]); ?>" class="compare-viewed" type="checkbox"></div>
                                            <div class="imageb"><a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id3'])); ?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id3']); ?></a></div>
                                            <div class="textb">
                                            	<a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id3'])); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <span class="price"><?php echo esc_attr($unique_value); ?></span>
                                           	</div>
                                            <div id="nine" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li><?php } ?>
                                    </ul>
                                </div>
                                <div class="tool-box-foot">
                                	<a href="<?php echo imic_get_template_url("template-compare.php"); ?>" class="btn btn-xs btn-info compare-viewed-box" disabled><?php _e('Compare','framework'); ?>()</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a href="#" id="reset-filters-search" class="btn-default btn-sm btn"><i class="fa fa-refresh"></i> <?php _e('Reset search','framework'); ?></a>
                    <a id="saved-search" href="#" class="btn-primary btn-sm btn" data-target="#searchmodal" data-toggle="modal"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa fa-folder-o"></i> <?php _e('Save search','framework'); ?></a>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="btn-group pull-right results-sorter">
                        <button type="button" class="btn btn-default listing-sort-btn"><?php _e('Sort by','framework'); ?></button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <span class="caret"></span>
                          <span class="sr-only"><?php _e('Toggle Dropdown','framework'); ?></span>
                        </button>
                        <?php $sorting_specs = get_post_meta(get_the_ID(),'imic_sort_by_specification',false); ?>	
                        <ul class="dropdown-menu sorter">
                        <?php foreach($sorting_specs as $sort) { ?>
                          	<li class="sort-para"><div style="display:none;"><span class="price-var"><?php echo esc_attr("int_".imic_the_slug($sort)); ?></span><span class="price-val"><?php echo esc_attr(1000000000); ?></span><span class="price-order"><?php _e('DESC','framework'); ?></span></div><a href="javascript:void(0);"><?php echo get_the_title($sort); _e('(High to Low)','framework'); ?></a></li>
                          	<li class="sort-para"><div style="display:none;"><span class="price-var"><?php echo esc_attr("int_".imic_the_slug($sort)); ?></span><span class="price-val"><?php echo esc_attr(1000000000); ?></span><span class="price-order"><?php _e('ASC','framework'); ?></span></div><a href="javascript:void(0);"><?php echo get_the_title($sort); _e('(Low to Hight)','framework'); ?></a></li>
                       	<?php } ?>
                        </ul>
                  	</div>
                    
                    <div class="toggle-view view-count-choice pull-right">
                        <label><?php _e('Show','framework'); ?></label>
                        <div id="quick-paginate" class="btn-group">
                            <a href="#" class="btn btn-default">10</a>
                            <a href="#" class="btn btn-default">20</a>
                            <a href="#" class="btn btn-default">50</a>
                        </div>
                    </div>
                    
                    <div class="toggle-view view-format-choice pull-right">
                        <label><?php _e('View','framework'); ?></label>
                        <div class="btn-group">
                            <a href="#" class="btn btn-default <?php echo esc_attr($active_listing); ?>" id="results-list-view"><i class="fa fa-th-list"></i></a>
                            <a href="#" class="btn btn-default <?php echo esc_attr($active_grid); ?>" id="results-grid-view"><i class="fa fa-th"></i></a>
                        </div>
                    </div>
                    <!-- Small Screens Filters Toggle Button -->
                    <!-- <button class="btn btn-default visible-xs" id="Show-Filters"><?php _e('Search Filters','framework'); ?></button>  -->
                </div>
            </div>
      	</div>
    </div>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            <?php
			$filters_type = (isset($imic_options['filters_type']))?$imic_options['filters_type']:'';
			if(is_plugin_active("imi-classifieds/imi-classified.php")) 
			{
				
				$selected_cat = get_query_var('list-cat');
				$data_page = ($filters_type==1)?'yes':'';
				$list_termss = array();
				if($selected_cat) 
				{
					$category_ids = get_term_by('slug', $selected_cat, 'listing-category');
					$term_ids = $category_ids->term_id;
					$parent = get_ancestors( $term_ids, 'listing-category' );
					foreach($parent as $parents)
					{
						$list_term = get_term_by('id', $parents, 'listing-category');
						$list_termss[] = $list_term->slug;
					}
					$list_termss[] = $selected_cat; 
				}
				$listing_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
				if(!empty($listing_cats))
				{
					echo '<div class="row parent-category-row">';
					echo '<div class="col-md-3 col-sm-3 act-cat" id="list-1">';
					echo '<label>'.__('Select Category').'</label>';
					echo '<select data-page="'.$data_page.'" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
					echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
					$this_cat = $act = '';
					foreach($listing_cats as $cat)
					{
						$term_children = get_terms('listing-category',array('parent' => $cat->term_id));
						$disabled = (empty($term_children))?'blank':'';
						if($this_cat!="selected"&&$act!=1)
						{
							$cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:'';
							$counter = (in_array($cat->slug,$list_termss))?1:0;
						}
						$this_cat = (in_array($cat->slug,$list_termss))?'selected':'';
						if($this_cat=="selected") { $act = 1; }
						echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
					}
					echo '</select>';
					echo '</div>';
					if(get_query_var('list-cat'))
					{
						while(($counter<=count($list_termss))&&($cat_id!=''))
						{
							$meet = 0;
							$listing_cats = get_terms('listing-category',array('parent' => $cat_id));
							if(!empty($listing_cats))
							{
								echo '<div class="col-md-3 col-sm-3 act-cat" id="list-'.($counter+1).'">';
								echo '<label>'.__('Select Category').'</label>';
								echo '<select data-page="'.$data_page.'" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
								echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
								$this_cat = $act = '';
								foreach($listing_cats as $cat)
								{
									$term_children = get_term_children($cat->term_id, 'listing-category');
									$disabled = (empty($term_children))?'blank':'';
									if($this_cat!="selected"&&$act!=1)
									{
										$cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:'';
									}
									$this_cat = (in_array($cat->slug,$list_termss))?'selected':'';
									if($this_cat=="selected") { $act = 1; }
									echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
								}
								echo '</select>';
								echo '</div>'; 
							}
							$counter++;
						}
					}
					echo '<div class="col-md-3 col-sm-3 loading-fields" id="loading-field" style="display:none;"><label>'.__('Select Category','framework').'</label><input class="form-control" type="text" value="'.__('Loading...','framework').'"></div></div>';
				}
			}?>
                                        <div class="row">
            <div class="col-md-12">
            <ul class="search-tabs nav nav-pills" id="search-tab">
            <?php if(!empty($qrs)) { foreach($qrs as $key=>$value) {
				if(!get_query_var($key)&&$key!="order"&&$key!="pg"&&$key!="pagin"&&$key!="list-cat") {
				if($value!='') {
                    echo '<li id="'.urldecode($key).'"><a href="javascript:void(0);">'.urldecode($value).' <i class="fa fa-times"></i></a></li>';
				} }
			} } ?>
            </ul>
            </div></div>
            	<div class="row" id="listing-with-filter">
                    <!-- Search Filters -->
                    <?php $class_list = 12;
					$search_filters = $list_terms_ids = $list_terms_slug = array();
					$search_filter_custom = get_option('imic_classifieds');
					if((get_query_var('list-cat'))&&(!empty($search_filter_custom)))
					{
						$category_slug = get_term_by('slug', get_query_var('list-cat'), 'listing-category');
						$term_id = $category_slug->term_id;
						$parents = get_ancestors( $term_id, 'listing-category' );
						$list_terms = array();
						foreach($parents as $parent)
						{
							$list_term = get_term_by('id', $parent, 'listing-category');
							$list_terms_slug[] = $list_term->slug;
							$list_terms_ids[] = $list_term->term_id;
						}
						$search_filter_custom = get_option('imic_classifieds');
					if(!empty($search_filter_custom))
					{
					foreach($search_filter_custom as $key=>$value)
					{
						if($key==$term_id)
						{
							$filters = $value['filter'];
							if($filters!='')
							{
								$search_filters = explode(',',$filters);
							}
							break;
						}
						else
						{
							foreach($list_terms_ids as $id)
							{
								if($key==$id)
								{
									$filters = $value['filter'];
									if($filters!='')
									{
										$search_filters = explode(',',$filters);
									}
									break;
								}
							}
						}
					}
					}
					}
					else
					{ 
					$search_filters = (isset($imic_options['search_filter_listing']))?$imic_options['search_filter_listing']:array();
					}?>
                    <!-- Listing Results -->
                    <!-- <div class="col-md-<?php echo esc_attr($class_list); ?> results-container"> -->
                    <div class="col-md-12> results-container">
                        <div class="results-container-in">
                        	<div class="waiting" style="display:none;">
                            	<div class="spinner">
                                  	<div class="rect1"></div>
                                  	<div class="rect2"></div>
                                  	<div class="rect3"></div>
                                  	<div class="rect4"></div>
                                  	<div class="rect5"></div>
                                </div>
                            </div>
                        	<div id="results-holder" class="results-<?php echo esc_attr($listing_type); ?>-view">
                            	<?php $paged = (get_query_var('paged'))?get_query_var('paged'):''; $arrays = $term_array = array(); 
								$value = $pagin = $offset = $have_int = $off = ''; $count = 1; 
if(!empty($qrs)) 
{ 
	foreach($qrs as $key=>$value)
  {
  	if(!get_query_var($key)&&$key!="lang") 
	{
  	$count = count($arrays);
		if(($value=="ASC")||($value=="DESC")) 
		{
			$order = $value;
		} 
		elseif($key=="pg") 
		{
			$posts_page = $value;
			$off = $value;
		}
		elseif($key=="paged") 
		{
			$paged = $value;
			$posts_page = get_option('posts_per_page');
		}
		elseif($key=='specification-search')
		{
			$sval = explode('%20', $value);
			foreach($sval as $val)
			{
				$arrays[$count+1] = array(
					'key' => 'feat_data',
					'value' =>  urldecode($val),
					'compare' => 'LIKE'
					);
					$count++;
			}
		}
		else 
		{
			if (strpos($key,'int_') !== false||strpos($key,'range_') !== false) {
			if(strpos($key,'range_') !== false)
			{
				$new_val = explode("-", $value);
				$value = $new_val[1];
				$pm_value = $new_val[0];
				$key = explode("_", $key);
				$key = "int_".$key[1];
				$arrays[$count++] = array(
                    'key' => $key,
                    'value' =>  $pm_value,
                    'compare' => '>=',
										'type' => 'numeric'
                    );
			}
			$arrays[$count] = array(
                    'key' => $key,
                    'value' =>  $value,
                    'compare' => '<=',
										'type' => 'numeric'
                    );
					$have_int = 1;
		}
				elseif ((strpos($key,'char_') !== false)||(strpos($key,'child_') !== false)) 
				{
					$value = str_replace('%20', ' ', $value);
					$arrays[$count] = array(
                    	'key' => $key,
                    	'value' =>  $value,
                    	'compare' => '=',
             		);
				} 
				else 
				{
							$sval_arr = str_replace('%20', ' ', $value);
       				$arrays[$count] = array(
                    	'key' => 'feat_data',
                    	'value' =>  serialize(strval(urldecode($sval_arr))),
                    	'compare' => 'LIKE'
              		); 
				}
			}
   			$count++; 
		}
		elseif($key=="list-cat")
		{ 
			$term_array[0] = array(
				'taxonomy' => 'listing-category',
				'field' => 'slug',
				'terms' => $value,
				'operator' => 'IN');
		} 
   
   } 
   
   } 
	$arrays[$count++] = array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=');
	$arrays[$count++] = array('key'=>'imic_plugin_listing_end_dt','value'=>date('Y-m-d'),'compare'=>'>=');
	if($paged==1) { $offset = $off; 
	}
	elseif($paged>1) { $offs = $paged-1; $offset = $off+($posts_page*$offs);
	}	
	$logged_user_pin = '';			
	$user_id = get_current_user_id( );
										$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
										$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
										$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
										$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
										if($badges_type=="0")
										{
											$badge_ids = (isset($imic_options['badge_specs']))?$imic_options['badge_specs']:array();
										}
										else
										{
											$badge_ids = array();
										}
										$img_src = '';
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:'';
										if($specification_type==0)
										{
											$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
										}
										else
										{
											$detailed_specs = array();
										}
										$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
										$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';
										if($have_int==1)
										{	
											$args_cars = array ('post_type'=>'yachts','orderby' => 'meta_value_num','order' => $order,'tax_query'=>$term_array,'meta_query' => $arrays,'posts_per_page'=>$posts_page,'post_status'=>'publish','offset'=>$offset);
$cars_listing = new WP_Query( $args_cars ); 
										}
										else
										{
											$args_cars = array ('post_type'=>'yachts','order' => $order,'tax_query'=>$term_array,'meta_query' => $arrays,'posts_per_page'=>$posts_page,'post_status'=>'publish','offset'=>$offset);
$cars_listing = new WP_Query( $args_cars ); 
										}
									if ( $cars_listing->have_posts() ) :
										while ( $cars_listing->have_posts() ) :	
											$cars_listing->the_post();
										if(is_plugin_active("imi-classifieds/imi-classified.php")) 
										{
											$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
											$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
										}
										$saved_car_user = array();
										$post_author_id = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
										$car_pin = get_post_meta($user_info_id,'imic_user_lat_long',true);
										if(!empty($car_pin)) { $car_pin = explode(',',$car_pin); $lat = $car_pin[0]; $long = $car_pin[1]; }
										else { $lat = 0; $long = 0; }
										$author_role = get_option('blogname');
										if(!empty($user_info_id)) {
										$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
										if(!empty($term_list)) {
										$author_role = $term_list[0]; }
										else { $author_role = get_option('blogname'); }
										}
										$save1 = (isset($_SESSION['saved_vehicle_id1']))?$_SESSION['saved_vehicle_id1']:'';
										$save2 = (isset($_SESSION['saved_vehicle_id2']))?$_SESSION['saved_vehicle_id2']:'';
										$save3 = (isset($_SESSION['saved_vehicle_id3']))?$_SESSION['saved_vehicle_id3']:'';
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$highlight_value = ($highlight_value=='')?get_the_title():$highlight_value;
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
										$video = get_post_meta(get_the_ID(),'imic_plugin_video_url',true);
										$user_id = get_current_user_id( );
										$current_user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
										if($current_user_info_id!='') {
										$saved_car_user = get_post_meta($current_user_info_id,'imic_user_saved_cars',true); }
										if((empty($saved_car_user))||($current_user_info_id=='')||($saved_car_user=='')) { $saved_car_user = array($save1, $save2, $save3); }
										$save_icon = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'fa-star':'fa-star-o';
										$save_icon_disable = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'disabled':'';
										?>
                                        <!-- Result Item -->
                                        <div class="result-item format-standard">
                                            <div class="result-item-image"><?php if(has_post_thumbnail()) { ?>
                                                <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                                                <?php $start = 0; 
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													if(!empty($badges)) {
													foreach($badges as $badge):
														$badge_class = ($start==0)?'default':'success';
														echo '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start]).'">'.esc_attr($badge).'</span>';
													$start++; if($start>3) { break; }
													endforeach; } ?>
                                                <div class="result-item-view-buttons">
                                                    <?php if($video!='') { ?>
                                                    <a href="<?php echo esc_attr($video); ?>" data-rel="prettyPhoto"><i class="fa fa-play"></i> <?php _e('View video','framework'); ?></a><?php } ?>
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-plus"></i> <?php _e('View details','framework'); ?></a>
                                                </div>
                                            </div>
                                            <div class="result-item-in">
                                                <h4 class="result-item-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <?php 
												if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
												{
													echo imic_get_cats_list(get_the_ID(), "dropdown");
												}
												?></h4>
                                                
                                                <div class="result-item-cont">
                                                    <div class="result-item-block col1">
                                                        <?php echo imic_excerpt(20); ?>
                                                    </div>
                                                    <div class="result-item-block col2">
                                                        <div class="result-item-pricing">
                                                            <div class="price">$<?php echo esc_attr(number_format((str_replace('$', '', $unique_value)))); ?></div>
                                                        </div>
                                                        <div class="result-item-action-buttons">
                                                            <a <?php echo esc_attr($save_icon_disable); ?> href="#" class="btn btn-default btn-sm save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa <?php echo esc_attr($save_icon); ?>"></i> <?php _e('Save','framework'); ?></a>
                                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-default btn-sm"><?php _e('Enquire','framework'); ?></a><br>
                                                            <div class="view-distance"><div style="display:none;"><span class="car-lat"><?php echo esc_attr($lat); ?></span><span class="car-long"><?php echo esc_attr($long); ?></span></div><a id="<?php echo esc_attr(get_the_ID()); ?>" href="#" class="distance-calc"><i class="fa fa-map-marker"></i> <?php _e('Distance from me?','framework'); ?></a>
                                                            <div class="input-group">
                                                              	<input type="text" value="<?php echo esc_attr($logged_user_pin); ?>" class="get-distance form-control input-sm" style="display:none;" placeholder="Enter Zipcode">
                                                              	<span class="input-group-btn">
                                                                	<a href="#" class="btn btn-default btn-sm search-dist" style="display:none;"><?php _e('Get','framework'); ?></a>
                                                              	</span>
                                                            </div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="result-item-features">
                                                    <ul class="inline">
                                                    <?php if(!empty($details_value)) {
														foreach($details_value as $detail) {
															if(!empty($detail)) {
														echo '<li>'.$detail.'</li>'; }
													} } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; else: ?>
										<div class="text-align-center error-404">
              		<hr class="sm">
              		<p><strong><?php echo esc_attr_e('Sorry - No listing found for this criteria','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('Please search again with different filters.','framework'); ?></p>
             	</div>
                
										<?php endif; 
										echo '<div class="clearfix"></div>'; 
										$paged = ($paged==0)?1:$paged; 
										imic_listing_pagination("page-".$paged, $cars_listing->max_num_pages, $paged); 
										wp_reset_postdata(); ?>
                    </div>
               	</div>
            </div>
        </div>
   	</div>
</div>
    <!-- End Body Content -->
<?php } else { ?>
<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="text-align-center error-404">
            		<h1 class="huge"><?php echo esc_attr_e('Sorry','framework'); ?></h1>
              		<hr class="sm">
              		<p><strong><?php echo esc_attr_e('Sorry - Plugin not active','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('Please install and activate required plugins of theme.','framework'); ?></p>
             	</div>
            </div>
        </div>
   	</div>
<?php } get_footer(); ?>