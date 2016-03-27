<?php
/*
Template Name: Compare
*/
get_header();
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
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
$comp1 = $comp2 = $comp3 = '';
$compare = (get_query_var('compare'))?get_query_var('compare'):'';
if($compare!='') {
	$compare = explode("-", $compare);
}
$details_value1 = $details_value2 = $details_value3 = array();
$specs1 = (isset($compare[0]))?get_post_meta($compare[0],'feat_data',true):array();
$specs2 = (isset($compare[1]))?get_post_meta($compare[1],'feat_data',true):array();
$specs3 = (isset($compare[2]))?get_post_meta($compare[2],'feat_data',true):array();
$specifications = $imic_options['compare_specification_list'];
$i = 1;
if(!empty($compare)) {
foreach($compare as $comp) {
	$spec = get_post_meta($comp,'feat_data',true);
	$completed = get_post_meta($comp,'imic_plugin_ad_payment_status',true);
	if($completed==1) { 
	${"details_value".$i} = imic_vehicle_compare_specs($comp,$specifications,$spec); }
	$i++;
} }
$count = max(count($details_value1), count($details_value2), count($details_value3));
$newarray = array();
for($i=0; $i < $count; $i++) {
	$newarray[] = "<div class=\"comp-table-row\">";
	if (isset($specifications[$i])) { $newarray[] = "<div class=\"comp-table-col\">".get_the_title($specifications[$i])."</div>"; }
	else { $newarray[] = "<div class=\"comp-table-col\"></div>"; }
	$int = get_post_meta($specifications[$i],'imic_plugin_spec_char_type',true);
	if($int==0)
	{
   if ((isset($details_value1[$i]))&&(array_search($specifications[$i], $specs1['sch_title']))) { $newarray[] = "<div class=\"comp-table-col\">".$details_value1[$i]."</div>"; }
   else { $newarray[] = "<div class=\"comp-table-col\"></div>"; }
   if ((isset($details_value2[$i]))&&(array_search($specifications[$i], $specs2['sch_title']))) { $newarray[] = "<div class=\"comp-table-col\">".$details_value2[$i]."</div>"; }
   else { $newarray[] = "<div class=\"comp-table-col\"></div>"; }
   if ((isset($details_value3[$i]))&&(array_search($specifications[$i], $specs3['sch_title']))) { $newarray[] = "<div class=\"comp-table-col\">".$details_value3[$i]."</div>"; }
   else { $newarray[] = "<div class=\"comp-table-col\"></div>"; }
	}
	elseif($int==2)
	{
		$newarray[] = "<div class=\"comp-table-col\">".$details_value1[$i]."</div>";
		$newarray[] = "<div class=\"comp-table-col\">".$details_value2[$i]."</div>";
		$newarray[] = "<div class=\"comp-table-col\">".$details_value3[$i]."</div>";
	}
   $newarray[] = "</div>";
}
$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';
$browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
$browse_listing = imic_get_template_url("template-listing.php");
if($browse_specification_switch==1) {
get_template_part('bar','one'); 
} elseif($browse_specification_switch==2) {
get_template_part('bar','two');
} elseif($browse_specification_switch==3) { 
get_template_part('bar','saved');
}
if($browse_specification_switch==4)
{
	get_template_part('bar', 'category');
}
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
			<?php if(!empty($compare)) { ?>
            	<!-- Vehicle Comparision -->
                <div class="comparision-table-resp">
                <div class="col3 comparision-table">
                	<div class="tsticky thead-sticky comp-table-row">
                    	<div class="comp-table-col">&nbsp;</div>
                        <?php foreach($compare as $comp) {
							$completed = get_post_meta($comp,'imic_plugin_ad_payment_status',true);
							$specifications = get_post_meta($comp,'feat_data',true);
							$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $comp);
							$highlighted_specs = $new_highlighted_specs;
							$highlighted_specs_val = imic_vehicle_title($comp,$highlighted_specs,$specifications);
							$unique_value = imic_vehicle_price($comp,$unique_specs,$specifications);
							if($completed==1) { ?>
                        <div class="comp-table-col">
                        	<strong><?php echo esc_attr($highlighted_specs_val); ?></strong>
                            <span class="price"><?php echo esc_attr($unique_value); ?></span>
                        </div><?php } else { ?>
						<div class="comp-table-col">
                        	<strong><?php echo esc_attr($highlighted_specs_val); ?></strong>
                            <span class="price"><?php echo __('This vehicle might be sold or not active','framework'); ?></span>
                        </div>
						<?php } } ?>
                    </div>
                	<div class="comp-image comp-table-row">
                        <div class="comp-table-col">&nbsp;</div>
                        <?php foreach($compare as $comp) {
							$completed = get_post_meta($comp,'imic_plugin_ad_payment_status',true);
							if($completed==1) {  ?>
                        <div class="comp-table-col"><div class="img-thumbnail"><?php echo get_the_post_thumbnail($comp); ?></div></div>
						<?php } else { ?>
						<div class="comp-table-col"><div class="img-thumbnail"></div></div>
						<?php } } ?>
                    </div>
                	<div class="comp-feature-head comp-table-row">
                        <div class="comp-table-col"><?php echo esc_attr_e('Vehicle details','framework'); ?></div>
                    </div>
                	<?php foreach($newarray as $ss) {
						echo ''.$ss;
					} ?>
                    
                	<div class="comp-feature-head comp-table-row">
                        <div class="comp-table-col"><?php echo esc_attr_e('Additional Options','framework'); ?></div>
                    </div>
                	<div class="comp-table-row comp-table-features">
                        <div class="comp-table-col">&nbsp;</div>
                        
                        <?php foreach($compare as $comp) {
							$completed = get_post_meta($comp,'imic_plugin_ad_payment_status',true);
							if($completed==1) {  ?>
                        <div class="comp-table-col">
                            <ul class="add-features-list">
                            <?php $fterm = wp_get_post_terms( $comp, "cars-tag", array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'names') );
							foreach($fterm as $term) {
								echo '<li>'.$term.'</li>';
							} ?> 
                            </ul>
                      	</div>
                    	<?php } else { ?>
						<div class="comp-table-col">
                        
                      	</div>
						<?php } } ?>
                    </div>
                        
                    <div class="comp-table-row comp-table-permalinks">
                        <div class="comp-table-col">&nbsp;</div>
                        <?php foreach($compare as $comp) {
							$completed = get_post_meta($comp,'imic_plugin_ad_payment_status',true);
							if($completed==1) {  ?>
                        <div class="comp-table-col"><a href="<?php echo esc_url(get_permalink($comp)); ?>" class="btn btn-primary btn-lg"><?php echo esc_attr_e('View listing','framework'); ?></a></div><?php } else { ?>
							<div class="comp-table-col"></div>
						<?php } } ?>
                    </div>
                </div>
                </div><?php } else { echo '<h2>'.__('You have not selected any listing to compare.','framework').'</h2>'; } ?>
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