<?php

/*
Plugin Name: CSSniffer
Description: CSSniffer checks a users browser user agent, and serves up different CSS.
Version: 0.1
Author: Brad Parbs
Author URI: http://bradparbs.com/
*/

/**
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */
add_action('wp_head','cssniffer');
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );


function cssniffer(){
	//check to see what the user agent is

	$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
	$grossitsie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
	$safari = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
	$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
	$opera = strpos($_SERVER["HTTP_USER_AGENT"], 'Opera') ? true : false;
	$iphone = strpos($_SERVER["HTTP_USER_AGENT"], 'iPhone') ? true : false;
	//this is static
	echo '<!-- cssniffer -->';
	echo '<style type="text/css">';

	$options = get_option('cssniffer_theme_options');


	if($firefox){
	echo $options['firefox'];
	}
	if($chrome||$safari){
	echo $options['webkit'];
	}
	if($opera){
	echo $options['opera'];
	}
	if($grossitsie){
	echo $options['grossitsie'];
	}
	if($iphone){
	echo $options['iphone'];
	}
	echo'</style>';
}


function theme_options_do_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'cssniffertheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'cssniffertheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'cssniffer_options' ); ?>
			<?php $options = get_option( 'cssniffer_theme_options' ); ?>

			<table class="form-table">


				<tr valign="top"><th scope="row"><?php _e( 'Firefox Specific CSS', 'cssniffertheme' ); ?></th>
					<td>
						<textarea id="cssniffer_theme_options[firefox]" class="large-text" cols="50" rows="10" name="cssniffer_theme_options[firefox]"><?php echo esc_textarea( $options['firefox'] ); ?></textarea>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Webkit Specific CSS', 'cssniffertheme' ); ?></th>
					<td>
						<textarea id="cssniffer_theme_options[webkit]" class="large-text" cols="50" rows="10" name="cssniffer_theme_options[webkit]"><?php echo esc_textarea( $options['webkit'] ); ?></textarea>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Internet Explorer Specific CSS', 'cssniffertheme' ); ?></th>
					<td>
						<textarea id="cssniffer_theme_options[grossitsie]" class="large-text" cols="50" rows="10" name="cssniffer_theme_options[grossitsie]"><?php echo esc_textarea( $options['grossitsie'] ); ?></textarea>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Opera Specific CSS', 'cssniffertheme' ); ?></th>
					<td>
						<textarea id="cssniffer_theme_options[opera]" class="large-text" cols="50" rows="10" name="cssniffer_theme_options[opera]"><?php echo esc_textarea( $options['opera'] ); ?></textarea>
					</td>
				</tr>	
				<tr valign="top"><th scope="row"><?php _e( 'iPhone Specific CSS', 'cssniffertheme' ); ?></th>
					<td>
						<textarea id="cssniffer_theme_options[iphone]" class="large-text" cols="50" rows="10" name="cssniffer_theme_options[iphone]"><?php echo esc_textarea( $options['iphone'] ); ?></textarea>
					</td>
				</tr>

			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'cssniffertheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}


function theme_options_validate( $input ) {
	$input['firefox'] = wp_filter_post_kses( $input['firefox'] );
	$input['webkit'] = wp_filter_post_kses( $input['webkit'] );
	$input['opera'] = wp_filter_post_kses( $input['opera'] );
	$input['grossitsie'] = wp_filter_post_kses( $input['grossitsie'] );
	$input['iphone'] = wp_filter_post_kses( $input['iphone'] );

	return $input;
}



function theme_options_add_page() {	add_theme_page( __( 'CSSniffer', 'cssniffertheme' ), __( 'CSSniffer', 'cssniffertheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );}
function theme_options_init(){register_setting( 'cssniffer_options', 'cssniffer_theme_options', 'theme_options_validate' );}
?>