<?php
/*
 * 	Copyright IMIC 2014 
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('admin_init', 'permalink_setting_at_start');
add_action('admin_init', 'permalink_settings_save');
/**
 * Start  permalink settings
 */
function permalink_setting_at_start() {
    // Add a section to the permalinks page
    add_settings_section('imic-property-permalink', __('Listings permalink base', 'imic-framework-admin'), 'permalink_settings', 'permalink');
//Type section
add_settings_field(
'properties_type_slug',     // id
__( 'Listings Features base', 'imic-framework-admin' ), // setting title
'properties_type_slug_input',  // display callback
'permalink',           // settings page
'imic-property-permalink'   // settings section
);
add_settings_field(
'properties_contract_type_slug',     // id
__( 'Listings Categories base', 'imic-framework-admin' ), // setting title
'properties_contract_type_slug_input',  // display callback
'permalink',           // settings page
'imic-property-permalink'   // settings section
);  
}
/**
* Show a Type slug input box.
*/
function properties_type_slug_input() {
$permalinks = get_option('imic_property_permalinks');
?>
<input name="properties_type_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['type_base'] ) ) echo esc_attr( $permalinks['type_base'] ); ?>" placeholder="<?php echo _x('cars-tag', 'slug', 'imic-framework-admin') ?>" />
<?php
}
function properties_contract_type_slug_input() {
$permalinks = get_option('imic_property_permalinks');
?>
<input name="properties_contract_type_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['contract_types'] ) ) echo esc_attr( $permalinks['contract_types'] ); ?>" placeholder="<?php echo _x('property-contract-type', 'slug', 'imic-framework-admin') ?>" />
<?php
}
/**
 * Show the permalink settings
 */
function permalink_settings() {
    echo wpautop(__('These settings control the permalinks used for property items. These settings only apply when <strong>not using "default" permalinks above</strong>.', 'imic-framework-admin'));
    $permalinks = get_option('imic_property_permalinks');
    $property_permalink = $permalinks['property_structure'];
    $base_slug = _x('cars', 'default-slug', 'imic-framework-admin');
    $property_structure = _x('cars', 'default-slug', 'imic-framework-admin');
    $structures = array(
        0 => '',
        1 => '/' . trailingslashit($property_structure),
        2 => '/' . trailingslashit($base_slug),
    );
    ?>
    <table class="imic_form form-table">
        <tbody>
            <tr>
                <th><label><input name="property_permalink" type="radio" value="<?php echo $structures[0]; ?>" class="imic_p" <?php checked($structures[0], $property_permalink); ?> /> <?php _e('Default', 'imic-framework-admin'); ?></label></th>
                <td><code><?php echo home_url(); ?>/?property=sample-property-item</code></td>
            </tr>
            <tr>
                <th><label><input name="property_permalink" type="radio" value="<?php echo $structures[1]; ?>" class="imic_p" <?php checked($structures[1], $property_permalink); ?> /> <?php _e('Post name', 'imic-framework-admin'); ?></label></th>
                <td><code><?php echo home_url(); ?>/<?php echo $property_structure; ?>/sample-property-item/</code></td>
            </tr>
            <tr>
                <th><label><input name="property_permalink" id="imic_custom_selection" type="radio" value="custom" class="tog" <?php checked(in_array($property_permalink, $structures), false); ?> />
                        <?php _e('Custom Structure', 'imic-framework-admin'); ?></label></th>
                <td>
                    <input name="property_permalink_structure" id="imic_permalink_structure" type="text" value="<?php echo esc_attr($property_permalink); ?>" class="regular-text code"> <span class="description"><?php _e('Enter a custom structure to use. A structure <strong>must</strong> be set or WordPress will use default instead.', 'imic-framework-admin'); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Save the settings
 */
function permalink_settings_save() {
    if (!is_admin())
        return;

    // We need to save the options ourselves; settings api does not trigger save for the permalinks page
    if (isset($_POST['permalink_structure']) && isset($_POST['property_permalink'])) {
        $permalinks = get_option('property_permalinks');
        if (!$permalinks)
            $permalinks = array();
        $properties_type_slug = sanitize_text_field( $_POST['properties_type_slug'] );
        $permalinks['type_base'] = untrailingslashit( $properties_type_slug );
		$properties_contract_type_slug = sanitize_text_field( $_POST['properties_contract_type_slug'] );
		$permalinks['contract_types'] = untrailingslashit( $properties_contract_type_slug ); 
     // Property structure
        $property_permalink = sanitize_text_field($_POST['property_permalink']);
        if ($property_permalink == 'custom') {
            $property_permalink = sanitize_text_field($_POST['property_permalink_structure']);
        } elseif (empty($property_permalink)) {
            $property_permalink = false;
        }
        $permalinks['property_structure'] = untrailingslashit($property_permalink);
        update_option('imic_property_permalinks', $permalinks);
    }
}
?>