<?php global $imic_options; ?>
<div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6">
                <?php if(function_exists('bcn_display')) { ?>
                    <ol class="breadcrumb">
                        <?php bcn_display(); ?>
                    </ol>
              	<?php } ?>
            	</div>
                <div class="col-md-4 col-sm-6">
	<?php imic_share_buttons(); ?>
                </div>
            </div>
      	</div>
    </div>