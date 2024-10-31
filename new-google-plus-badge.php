<?php
/*
Plugin Name: Google Plus Badge
Plugin URI:  https://awplife.com/
Description: Google+ Badge & Profile Widget For Wordpress
Version:     1.0.8
Author:      A WP Life
Author URI:  https://awplife.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: new-google-plus-badge

My Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
My Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with My Plugin. I
*/

//Load text domain
add_action( 'plugins_loaded', 'ngpbw_load_textdomain' );
function ngpbw_load_textdomain() {
	load_plugin_textdomain( 'new-google-plus-badge', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

class Google_Plus_Badge extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		define("NGPB", "new-google-plus-badge");
	
		parent::__construct(
			'Google_Plus_Badge', // Base ID
			__( 'Google+ Badge', NGPB ), // Name
			array( 'description' => __( 'A Google+ Badge Widget', NGPB ), ) // Args
		);
	}
	
	// Front-end display of widget
	public function widget( $args, $instance ) {
		$name = ! empty( $instance['name'] ) ? $instance['name'] : 'Follow Us On Google+';
		$url = ! empty( $instance['url'] ) ? $instance['url'] :'https://plus.google.com/u/0/104649297856397988957';
		$layout = ! empty( $instance['layout'] ) ? $instance['layout'] : 'portrait';
		$width = ! empty( $instance['width'] ) ? $instance['width'] : 250;
		$theme = ! empty( $instance['theme'] ) ? $instance['theme'] : 'light';
		$cover = ! empty( $instance['cover'] ) ? $instance['cover'] : 'true';
		$tagline = ! empty( $instance['tagline'] ) ? $instance['tagline'] : 'true';
		$language = ! empty( $instance['language'] ) ? $instance['language'] : 'en_US';
		
		echo $args['before_widget'];
		if ( ! empty( $instance['name'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['name'] ) . $args['after_title'];
		}
		?>
		<script type="text/javascript">
		window.___gcfg = {lang: '<?php echo $language;?>'};
		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/platform.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
		</script>
		<div class="g-person" 
			data-width="<?php echo $width;?>" 
			data-href="<?php echo $url;?>" 
			data-theme="<?php echo $theme;?>" 
			data-layout="<?php echo $layout;?>" 
			data-showtagline="<?php echo $tagline;?>" 
			data-showcoverphoto="<?php echo $cover;?>" 
			data-rel="author">
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	// Backend widget form.
	public function form( $instance ) {
		$name = ! empty( $instance['name'] ) ? $instance['name'] : 'Follow Us On Google+';
		$url = ! empty( $instance['url'] ) ? $instance['url'] : 'https://plus.google.com/u/0/104649297856397988957';
		$layout = ! empty( $instance['layout'] ) ? $instance['layout'] : 'portrait';
		$width = ! empty( $instance['width'] ) ? $instance['width'] : 250;
		$theme = ! empty( $instance['theme'] ) ? $instance['theme'] : 'light';
		$cover = ! empty( $instance['cover'] ) ? $instance['cover'] : 'true';
		$tagline = ! empty( $instance['tagline'] ) ? $instance['tagline'] : 'true';
		$language = ! empty( $instance['language'] ) ? $instance['language'] : 'en_US';	
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e('Title', NGPB); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e('Google+ Profile Url', NGPB); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php _e( 'Badge Layout', NGPB); ?></label><br> 
			<input class="widefat layP" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" <?php if($layout == 'portrait') echo "checked=checked" ?> type="radio" value="portrait" onclick="return CheckLayout(this.value);"> <?php _e('Portrait',NGPB ); ?>  &nbsp;&nbsp;
			<input class="widefat layL" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" <?php if($layout == 'landscape') echo "checked=checked" ?> type="radio" value="landscape" onclick="return CheckLayout();"> <?php _e('Landscape',NGPB ); ?>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php _e('Badge Width', NGPB); ?></label> 
			<input class="widefat" id="width_range" name="width_range" type="range" min="180" max="450" value="<?php echo esc_attr( $width ); ?>" onchange="updateRange(this.value);">
			<input class="widefat width-range-values" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" readonly>
		</p>		
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>"><?php _e('Badge Theme', NGPB); ?></label><br> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>" <?php if($theme == 'light') echo "checked=checked" ?> type="radio" value="light"> <?php _e('Light', NGPB ); ?>  &nbsp;&nbsp;
			<input class="widefat" id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>" <?php if($theme == 'dark') echo "checked=checked" ?> type="radio" value="dark"> <?php _e('Dark', NGPB ); ?>
		</p>
		
		<div class="remove" <?php if($layout == "landscape") echo 'style="display:none;"'; ?>>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cover' ) ); ?>"><?php _e( esc_attr( 'Show Profile Cover', NGPB ) ); ?></label><br> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'cover' ); ?>" name="<?php echo $this->get_field_name( 'cover' ); ?>" <?php if($cover == 'true') echo "checked=checked" ?> type="radio" value="true"> <?php _e('Enable', NGPB ); ?>  &nbsp;&nbsp;
				<input class="widefat" id="<?php echo $this->get_field_id( 'cover' ); ?>" name="<?php echo $this->get_field_name( 'cover' ); ?>" <?php if($cover == 'false') echo "checked=checked" ?> type="radio" value="false"> <?php _e('Disable', NGPB ); ?>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tagline' ) ); ?>"><?php _e( esc_attr( 'Show Tagline', NGPB ) ); ?></label><br> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'tagline' ); ?>" name="<?php echo $this->get_field_name( 'tagline' ); ?>" <?php if($tagline == 'true') echo "checked=checked" ?> type="radio" value="true"> <?php _e('Enable', NGPB ); ?>  &nbsp;&nbsp;
				<input class="widefat" id="<?php echo $this->get_field_id( 'tagline' ); ?>" name="<?php echo $this->get_field_name( 'tagline' ); ?>" <?php if($tagline == 'false') echo "checked=checked" ?> type="radio" value="false"> <?php _e('Disable', NGPB ); ?>
			</p>
		</div>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'language' ); ?>"><?php _e( 'Language', NGPB ); ?></label><br>
			<select id="<?php echo $this->get_field_id( 'language' ); ?>" name="<?php echo $this->get_field_name( 'language' ); ?>">
				<option value="en_US" <?php if ($language == 'en_US') echo ' selected="selected"'; ?>><?php _e('English (US)', NGPB ); ?></option>
				<option value="en_GB" <?php if ($language == 'en_GB') echo ' selected="selected"'; ?>><?php _e('English (UK)', NGPB ); ?></option>
				<option value="af_ZA" <?php if ($language == 'af_ZA') echo ' selected="selected"'; ?>><?php _e('Afrikaans', NGPB ); ?></option>
				<option value="ar_AR" <?php if ($language == 'ar_AR') echo ' selected="selected"'; ?>><?php _e('Arabic', NGPB ); ?></option>
				<option value="hy_AM" <?php if ($language == 'hy_AM') echo ' selected="selected"'; ?>><?php _e('Armenian', NGPB ); ?></option>
				<option value="bg_BG" <?php if ($language == 'bg_BG') echo ' selected="selected"'; ?>><?php _e('Bulgarian', NGPB ); ?></option>
				<option value="br_FR" <?php if ($language == 'br_FR') echo ' selected="selected"'; ?>><?php _e('Breton', NGPB ); ?></option>
				<option value="cs_CZ" <?php if ($language == 'cs_CZ') echo ' selected="selected"'; ?>><?php _e('Czech', NGPB ); ?></option>
				<option value="zh_CN" <?php if ($language == 'zh_CN') echo ' selected="selected"'; ?>><?php _e('Chinese (Simplified China)', NGPB ); ?></option>
				<option value="zh_HK" <?php if ($language == 'zh_HK') echo ' selected="selected"'; ?>><?php _e('Chinese (Traditional Hong Kong)', NGPB ); ?></option>
				<option value="zh_TW" <?php if ($language == 'zh_TW') echo ' selected="selected"'; ?>><?php _e('Chinese (Traditional Taiwan)', NGPB ); ?></option>
				<option value="da_DK" <?php if ($language == 'da_DK') echo ' selected="selected"'; ?>><?php _e('Danish', NGPB ); ?></option>
				<option value="nl_NL" <?php if ($language == 'nl_NL') echo ' selected="selected"'; ?>><?php _e('Dutch', NGPB ); ?></option>
				<option value="fr_FR" <?php if ($language == 'fr_FR') echo ' selected="selected"'; ?>><?php _e('French (France)', NGPB ); ?></option>
				<option value="fr_CA" <?php if ($language == 'fr_CA') echo ' selected="selected"'; ?>><?php _e('French (Canada)', NGPB ); ?></option>
				<option value="de_DE" <?php if ($language == 'de_DE') echo ' selected="selected"'; ?>><?php _e('German', NGPB ); ?></option>
				<option value="he_IL" <?php if ($language == 'he_IL') echo ' selected="selected"'; ?>><?php _e('Hebrew', NGPB ); ?></option>
				<option value="hi_IN" <?php if ($language == 'hi_IN') echo ' selected="selected"'; ?>><?php _e('Hindi', NGPB ); ?></option>
				<option value="hu_HU" <?php if ($language == 'hu_HU') echo ' selected="selected"'; ?>><?php _e('Hungarian', NGPB ); ?></option>
				<option value="ga_IE" <?php if ($language == 'ga_IE') echo ' selected="selected"'; ?>><?php _e('Irish', NGPB ); ?></option>
				<option value="id_ID" <?php if ($language == 'id_ID') echo ' selected="selected"'; ?>><?php _e('Indonesian', NGPB ); ?></option>
				<option value="it_IT" <?php if ($language == 'it_IT') echo ' selected="selected"'; ?>><?php _e('Italian', NGPB ); ?></option>
				<option value="ja_JP" <?php if ($language == 'ja_JP') echo ' selected="selected"'; ?>><?php _e('Japanese', NGPB ); ?></option>
				<option value="kk_KZ" <?php if ($language == 'kk_KZ') echo ' selected="selected"'; ?>><?php _e('Kazakh', NGPB ); ?></option>
				<option value="ko_KR" <?php if ($language == 'ko_KR') echo ' selected="selected"'; ?>><?php _e('Korean', NGPB ); ?></option>
				<option value="la_VA" <?php if ($language == 'la_VA') echo ' selected="selected"'; ?>><?php _e('Latin', NGPB ); ?></option>
				<option value="ne_NP" <?php if ($language == 'ne_NP') echo ' selected="selected"'; ?>><?php _e('Nepali', NGPB ); ?></option>
				<option value="fa_IR" <?php if ($language == 'fa_IR') echo ' selected="selected"'; ?>><?php _e('Persian', NGPB ); ?></option>			
				<option value="pl_PL" <?php if ($language == 'pl_PL') echo ' selected="selected"'; ?>><?php _e('Polish', NGPB ); ?></option>
				<option value="pt_PT" <?php if ($language == 'pt_PT') echo ' selected="selected"'; ?>><?php _e('Portuguese', NGPB ); ?> </option>
				<option value="ro_RO" <?php if ($language == 'ro_RO') echo ' selected="selected"'; ?>><?php _e('Romanian', NGPB ); ?></option>
				<option value="ru_RU" <?php if ($language == 'ru_RU') echo ' selected="selected"'; ?>><?php _e('Russian', NGPB ); ?></option>
				<option value="es_LA" <?php if ($language == 'es_LA') echo ' selected="selected"'; ?>><?php _e('Spanish', NGPB ); ?></option>
				<option value="es_CL" <?php if ($language == 'es_CL') echo ' selected="selected"'; ?>><?php _e('Spanish (Chile)', NGPB ); ?></option>
				<option value="es_CO" <?php if ($language == 'es_CO') echo ' selected="selected"'; ?>><?php _e('Spanish (Colombia)', NGPB ); ?></option>
				<option value="es_ES" <?php if ($language == 'es_ES') echo ' selected="selected"'; ?>><?php _e('Spanish (Spain)', NGPB ); ?></option>
				<option value="es_MX" <?php if ($language == 'es_MX') echo ' selected="selected"'; ?>><?php _e('Spanish (Mexico)', NGPB ); ?></option>
				<option value="es_VE" <?php if ($language == 'es_VE') echo ' selected="selected"'; ?>><?php _e('Spanish (Venezuela)', NGPB ); ?></option>
				<option value="sr_RS" <?php if ($language == 'sr_RS') echo ' selected="selected"'; ?>><?php _e('Serbian', NGPB ); ?></option>
				<option value="sv_SE" <?php if ($language == 'sv_SE') echo ' selected="selected"'; ?>><?php _e('Swedish', NGPB ); ?></option>
				<option value="th_TH" <?php if ($language == 'th_TH') echo ' selected="selected"'; ?>><?php _e('Thai', NGPB ); ?></option>
				<option value="tr_TR" <?php if ($language == 'tr_TR') echo ' selected="selected"'; ?>><?php _e('Turkish', NGPB ); ?></option>
				<option value="ur_PK" <?php if ($language == 'ur_PK') echo ' selected="selected"'; ?>><?php _e('Urdu', NGPB ); ?></option>
			</select>
		</p>
		
		<script>
		// on change range value
		function updateRange(val) {
		  jQuery("input.width-range-values").val(val);
		  jQuery("#<?php echo $this->get_field_id( 'width' ); ?>").val(val);		  
        }
		
		// on click layout
		jQuery(".layP").click(function(){
			jQuery(".remove").show();
		});
		jQuery(".layL").click(function(){
			jQuery(".remove").hide();
		});
		</script>
		<?php 
	}

	// Sanitize widget form values as they are saved
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : 'Follow Us On Google+';
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : 'https://plus.google.com/u/0/104649297856397988957';
		$instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? strip_tags( $new_instance['layout'] ) : 'portrait';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : 250;
		$instance['theme'] = ( ! empty( $new_instance['theme'] ) ) ? strip_tags( $new_instance['theme'] ) : 'light';
		$instance['cover'] = ( ! empty( $new_instance['cover'] ) ) ? strip_tags( $new_instance['cover'] ) : 'true';
		$instance['tagline'] = ( ! empty( $new_instance['tagline'] ) ) ? strip_tags( $new_instance['tagline'] ) : 'true';
		$instance['language'] = ( ! empty( $new_instance['language'] ) ) ? strip_tags( $new_instance['language'] ) : 'en_US';
		return $instance;
	}
} // end of class function

// Register Google_Plus_Badge Widget
add_action( 'widgets_init', 'register_Google_Plus_Badge_Widget' );
function register_Google_Plus_Badge_Widget() {
    register_widget( 'Google_Plus_Badge' );
}
?>