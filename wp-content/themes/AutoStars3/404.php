<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
get_header();
$event_image = $imic_options['header_image']['url'];
?>
<div class="page-header parallax" style="background-image:url(<?php echo esc_url($event_image); ?>);">
    	<div class="container">
        	<h1 class="page-title"><?php echo esc_attr_e('404 Error','framework'); ?></h1>
       	</div>
    </div>
    <?php if(function_exists('bcn_display'))
    { ?>
    <!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <l<?php bcn_display(); ?>
                    </ol>
            	</div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                </div>
            </div>
      	</div>
    </div>
    <?php } ?>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="text-align-center error-404">
            		<h1 class="huge"><?php echo esc_attr_e('404','framework'); ?></h1>
              		<hr class="sm">
              		<p><strong><?php echo esc_attr_e('Sorry - Page Not Found!','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('The page you are looking for was moved, removed, renamed<br>or might never existed. You stumbled upon a broken link','framework'); ?></p>
             	</div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>