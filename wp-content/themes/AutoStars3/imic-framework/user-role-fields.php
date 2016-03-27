<?php
add_action('user-role_edit_form_fields','user_role_edit_form_fields');
add_action('user-role_add_form_fields','user_role_edit_form_fields');
add_action('edited_user-role', 'user_role_save_form_fields', 10, 2);
add_action('created_user-role', 'user_role_save_form_fields', 10, 2);

function user_role_save_form_fields($term_id) {
    $meta_name = 'order';
    if ( isset( $_POST[$meta_name] ) ) {
        $meta_value = $_POST[$meta_name];
        // This is an associative array with keys and values:
        // $term_metas = Array($meta_name => $meta_value, ...)
        $term_metas = get_option("taxonomy_{$term_id}_metas");
        if (!is_array($term_metas)) {
            $term_metas = Array();
        }
        // Save the meta value
        $term_metas[$meta_name] = $meta_value;
        update_option( "taxonomy_{$term_id}_metas", $term_metas );
    }
}

function user_role_edit_form_fields ($term_obj) {
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("taxonomy_{$term_id}_metas");
    if ( isset($term_metas['order']) ) {
        $order = $term_metas['order'];
    } else {
        $order = '';
    }
?>
<tr class="form-field form-required term-order-wrap">
<th scope="row">
<label for="order"><?php _e('Ad Listing','framework'); ?></label>
</th>
<td>
<select name="order" id="order">
<option <?php echo ($order=="1")?'selected':''; ?> value="1"><?php _e('Yes','framework'); ?></option>
<option <?php echo ($order=="0")?'selected':''; ?> value="0"><?php _e('No','framework'); ?></option>
</select>
</td>
</tr>
<?php 
}
//Field for Listing Tags Terms
add_action('cars-tag_edit_form_fields','cars_tag_edit_form_fields');
add_action('cars-tag_add_form_fields','cars_tag_edit_form_fields');
add_action('edited_cars-tag', 'cars_tag_save_form_fields', 10, 2);
add_action('created_cars-tag', 'cars_tag_save_form_fields', 10, 2);

function cars_tag_save_form_fields($term_id) {
    $meta_name = 'cats';
    if ( isset( $_POST[$meta_name] ) ) {
        $meta_value = $_POST[$meta_name];
        // This is an associative array with keys and values:
        // $term_metas = Array($meta_name => $meta_value, ...)
        $term_metas = get_option("taxonomy_{$term_id}_metas");
        if (!is_array($term_metas)) {
            $term_metas = Array();
        }
        // Save the meta value
        $term_metas[$meta_name] = $meta_value;
        update_option( "taxonomy_{$term_id}_metas", $term_metas );
    }
}

function cars_tag_edit_form_fields ($term_obj) {
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("taxonomy_{$term_id}_metas");
    if ( isset($term_metas['cats']) ) {
        $order = $term_metas['cats'];
    } else {
        $order = '';
    }
?>
<tr class="form-field form-required term-cats-wrap">
<th scope="row">
<label for="order"><?php _e('Categories','framework'); ?></label>
</th>
<td>
<input type="text" name="cats" id="cats" value="<?php echo $order; ?>">
<p>Insert categories slug "," comma separated.</p>
</td>
</tr>
<?php 
}