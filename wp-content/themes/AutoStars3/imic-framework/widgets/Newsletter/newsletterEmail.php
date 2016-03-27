<?php $Newsletter=get_option('NewsletterEmail');?>
<h1><?php echo esc_attr_e('Email For Newsletter','framework');?></h1>
<table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>
        <th class="check-column" scope="row"></th>
        <th class="column-columnname"><?php  echo esc_attr_e('Serial','framework'); ?></th>
        <th class="column-columnname"><?php  echo esc_attr_e('Name','framework'); ?></th>
        <th class="column-columnname"><?php  echo esc_attr_e('Email Id','framework'); ?></th>
        <th class="column-columnname"><?php  echo esc_attr_e('On Date','framework'); ?></th>
    </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($Newsletter)){
		$serial = 1;
        foreach($Newsletter as $key=>$value){
			$keys = explode("|",$key); ?>
        <tr>
            <th class="check-column" scope="row"></th>
            <td class="column-columnname"><?php echo esc_attr($serial); ?></td>
            <td class="column-columnname"><?php echo esc_attr($keys[0]); ?></td>
            <td class="column-columnname"><?php echo esc_attr($keys[1]); ?></td>
            <td class="column-columnname"><?php echo esc_attr($value); ?></td>
        </tr>
        <?php $serial++; }}else{ ?>
            <tr>
            <th class="check-column" scope="row"></th>
            <th class="column-columnname"><?php  echo esc_attr_e('There is no Emails','framework'); ?></th>
            
        </tr>
        <?php } ?>
    </tbody>
</table>