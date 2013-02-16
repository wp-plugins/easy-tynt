<?PHP
/*
Plugin Name: Easy Tynt
Plugin URI: http://www.ScottSwezey.com/wp-plugins/easy-tynt
Description: Easily install and configure Tynt Insight for your WordPress Blog. Leverage the benefit of copy/paste, learn what is being copied off your blog, and learn how to leverage this behavior into more traffic, higher search rank and more. See <a href="http://www.tynt.com" target="_blank">www.tynt.com</a> for information on Tynt Insight.
Version: 0.2.5.1
Author: Scott Swezey
Author URI: http://www.ScottSwezey.com/
License: GPL2

  	Copyright 2010  Scott Swezey  (email : plugins@scottswezey.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function ss_easy_tynt_get_script() {
	return stripslashes(get_option('easy_tynt_script'));
}

function ss_easy_tynt_activate() {
	if (false === ss_easy_tynt_get_script()) {
		add_option('easy_tynt_script', '', null, 'yes');
	}
}

function ss_easy_tynt_print_js_tag() {
	$ss_easy_tynt_script = ss_easy_tynt_get_script();
	if (!empty($ss_easy_tynt_script)) {
		echo '<!-- Start Easy Tynt -->';
		echo "\n";
		echo $ss_easy_tynt_script;
		echo '<!-- End Easy Tynt -->';
		echo "\n";
	}
}

function ss_easy_tynt_admin_menu() {
	add_options_page('Settings for Easy Tynt', 'Easy Tynt', 'administrator', 'ss_easy_tynt', 'ss_easy_tynt_settings_page');
}

function ss_easy_tynt_settings_page() {
// variables for the field and option names 
    $opt_name = 'easy_tynt_script';
    $hidden_field_name = 'ss_easy_tynt_submit_hidden';
    $data_field_name = 'easy_tynt_script';

    // Read in existing option value from database
    $opt_val = ss_easy_tynt_get_script();

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, stripslashes($opt_val) );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'ss_easy_tynt_trans_domain' ); ?></strong></p></div>
<?php
			//Strip slashes for propper display
			$opt_val = stripslashes($opt_val);
    }

    // Now display the options editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>" . __( 'Settings for Easy Tynt', 'ss_easy_tynt_trans_domain' ) . "</h2>";

    // options form
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><strong><?php _e("Your Tynt Script:", 'ss_easy_tynt_trans_domain' ); ?></strong><br />
<textarea name="<?php echo $data_field_name; ?>" rows="5" cols="100"><?php echo $opt_val; ?></textarea>
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'ss_easy_tynt_trans_domain' ) ?>" />
</p>

<p><strong>New to Tynt Insight?</strong><br />
	<ol>
		<li>You will need to visit <a href="http://www.tynt.com/" target="_blank">http://www.tynt.com/</a> and sign up for a free account.</li>
		<li>Once you are registered you can chose various options for use on your site. Chose the options you would like.</li>
		<li>Paste the resulting "YOUR SCRIPT" code in the text area at the top of this page.</li>
		<li>If you ever want to change how Tynt works on your site, just visit the Tynt site, change anything you want to, and paste the new code they give you into the text area at the top of this page.</li>
	</ol>
</p>

</form>
</div>

<?php
 
} // end function ss_easy_tynt_settings_page

function ss_easy_tynt_uninstall() {
	delete_option('easy_tynt_script');
}

//register actions and hooks
register_activation_hook(__FILE__, 'ss_easy_tynt_activate');

add_action('wp_head', 'ss_easy_tynt_print_js_tag', 1, 0);

add_action('admin_menu', 'ss_easy_tynt_admin_menu');

register_uninstall_hook(__FILE__, 'ss_easy_tynt_uninstall');
?>