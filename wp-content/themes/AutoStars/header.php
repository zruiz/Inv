<!DOCTYPE html>
<!--// OPEN HTML //-->
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <?php
        $options = get_option('imic_options');
        /** Theme layout design * */
        $bodyClass = ($options['site_layout'] == 'boxed') ? ' boxed' : '';
        $style='';
       if($options['site_layout'] == 'boxed'){
            if (!empty($options['upload-repeatable-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $options['upload-repeatable-bg-image']['url'] . '); background-repeat:repeat; background-size:auto;"';
        } else if (!empty($options['full-screen-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $options['full-screen-bg-image']['url'] . '); background-repeat: no-repeat; background-size:cover;"';
        }
           else if(!empty($options['repeatable-bg-image'])) {
            $style = ' style="background-image:url(' . get_template_directory_uri() . '/includes/ReduxCore/assets/img/patterns/' . $options['repeatable-bg-image'] . '); background-repeat:repeat; background-size:auto;"';
        }
        }
        ?>
        <!--// SITE TITLE //-->
        <title>
            <?php wp_title('|', true, 'right'); ?>
<?php bloginfo('name'); ?>
        </title>
        <!--// SITE META //-->
        <meta charset="<?php bloginfo('charset'); ?>" />
        <!-- Mobile Specific Metas
        ================================================== -->
<?php if ($options['switch-responsive'] == 1) { ?>
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
            <meta name="format-detection" content="telephone=no"><?php } ?>
        <!--// PINGBACK & FAVICON //-->
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php if (isset($options['custom_favicon']) && $options['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo esc_url($options['custom_favicon']['url']); ?>" /><?php
        }
	$header_style = $options['header_layout'];
        ?>
        <?php //  WORDPRESS HEAD HOOK 
         wp_head(); ?>
    </head>
    <!--// CLOSE HEAD //-->
    <body <?php body_class($bodyClass.' header-'.$header_style); echo $style;  ?>>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
<?php get_template_part('header',$header_style); ?>