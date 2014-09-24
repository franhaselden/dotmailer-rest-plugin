<?php
/**
 * Plugin Name: Dotmailer Plugin
 * Description: Dotmailer add to address book
 */

// Define variables
$apiemail = filter_var(get_option('apiemail'), FILTER_SANITIZE_EMAIL);
$apipassword = get_option('apipassword');
$listID = get_option('listID');
$successful_slug = str_replace('/', '', get_option('slugSuccess'));
$unsuccessful_slug = str_replace('/', '', get_option('slugUnsuccess'));

// Add menu item to the admin panel
add_action( 'admin_menu', 'dotmailer_menu' );

// Add an options page
function dotmailer_menu() {
	add_options_page( 'Dotmailer Options', 'Dotmailer Details', 'manage_options', 'dotmailer', 'dotmailer_options' );
}

// Form for the options including three fields
function dotmailer_options() {
?>

<div class="wrap">
	<h2>Dotmailer API information</h2><br />
	<form method="post" action="options.php">
		<?php settings_fields( 'settings-group' );
		do_settings_sections( 'settings-group' );
		?>
			<label>API key</label><br />
			<input type="email" name="apiemail" value="<?php echo get_option('apiemail'); ?>"><br /><br />
			<label>Password</label><br />
			<input type="password" name="apipassword" value="<?php echo get_option('apipassword'); ?>"><br /><br />
			<label>Address Book List ID</label><br />
			<small>This is the ID for the list you want to save contacts too. Find this by navigating to the list in Dotmailer and taking the 7 digit ID from the end of the URL</small><br /><br />
			<input type="number" name="listID" value="<?php echo get_option('listID') ?>"/><br /><br />
			<label>Redirect after result</label><br />
			<small>Include the page slug of where you would like to redirect the user after <strong>successful</strong> submission</small><br />
			<input type="text" name="slugSuccess" value="<?php echo get_option('slugSuccess'); ?>"/><br /><br />
			<small>Include the page slug of where you would like to redirect the user after <strong>un</strong>successful submission</small><br />
			<input type="text" name="slugUnsuccess" value="<?php echo get_option('slugUnsuccess'); ?>"/><br />

			<p><input type="submit" value="Save" class="button-primary" /></p>

	</form>
</div>
<?php 
}

// Registers the options
function register_settings() {  
	    register_setting('settings-group','apiemail');
	    register_setting('settings-group','apipassword');
	    register_setting('settings-group','listID');
	    register_setting('settings-group','slugUnsuccess');
	    register_setting('settings-group','slugSuccess');
	}

// Initialises the options registered
add_action( 'admin_init', 'register_settings' );


// Tidy vars
$listID = get_option('listID');
$apiemail = filter_var(get_option('apiemail'), FILTER_SANITIZE_EMAIL);
$apipassword = get_option('apipassword');
$successful_slug = str_replace('/', '', get_option('slugSuccess'));
$unsuccessful_slug = str_replace('/', '', get_option('slugUnsuccess'));



// Add a widget for the newsletter form which can be added to the footer/widget areas
class wp_dotmailer extends WP_Widget {

	// constructor
	function wp_dotmailer() {
		 parent::WP_Widget(false, $name = __('Dotmailer Newsletter Signup', 'wp_widget_dotmailer') );
	}

	// widget form creation
	function form($instance) {	
	// Check values
		if( $instance) {
		     $title = esc_attr($instance['title']);
		} else {
		     $title = '';
		     $text = '';
		}
		?>
			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_dotmailer'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<?php

		}

		// widget update
		function update($new_instance, $old_instance) {
		      $instance = $old_instance;
		      // Fields
		      $instance['title'] = strip_tags($new_instance['title']);
		     return $instance;
		}

		// display widget
		function widget($args, $instance) {
		   extract( $args );
		   // these are the widget options
		   $title = apply_filters('widget_title', $instance['title']);
		   echo $before_widget;
		   // Display the widget
		   echo '<div class="widget-text wp_widget_dotmailer_box">';

		   // Check if title is set
		   if ( $title ) {
		      echo $before_title . $title . $after_title;
		   }
		   echo '<form class="newsletter" action="' . site_url() . '/wp-content/plugins/dotmailer/dotmailer-add.php" method="POST">';
		   echo '<label>Your email:</label>';
		   echo '<input type="email" placeholder="your@email.com" name="useremail"/>';
		   echo '<input type="submit" class="btn" value="Sign up" />';
		   echo '</form>';
		   echo '</div>';
		   echo $after_widget;
		}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_dotmailer");'));

?>
