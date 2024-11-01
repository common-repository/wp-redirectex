<?php
/*
Plugin Name: WP-RedirectEx
Plugin URI: http://wrex.icybear.cn/
Description: Redirect to a different domain
Version: 0.1
Author: Bearice
Author URI: http://blog.icybear.cn/
*/
add_action('init', 'wrex_init');
function wrex_init(){
	add_option('wrex_hostname', $_SERVER['HTTP_HOST']);
	$host = get_option('wrex_hostname');
	if($_SERVER['HTTP_HOST']==$host
	 ||strstr($_SERVER['REQUEST_URI'],"/wp-admin")
	 ||strstr($_SERVER['REQUEST_URI'],"/wp-login")){
		return;
	}
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://".$host.$_SERVER['REQUEST_URI']);
	exit(0);
}

add_action('admin_menu','wrex_admin_menu');
function wrex_admin_menu(){
	add_submenu_page('options-general.php','WP-RedirectEx','WP-RedirectEx',8,'wrex','wrex_admin_page');
}
function wrex_admin_page(){
	if( $_POST['wrex_submit']) {
        update_option( 'wrex_hostname' , $_POST['wrex_hostname'] );
?>
<div class="updated"><p><strong><?php echo _e('Options saved.', 'wrex' ); ?></strong></p></div>
<?php
    }
?>
    <div class="wrap">
	<h2><? _e( 'WP-RedirectEx Options', 'wrex' ); ?></h2>
	<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="wrex_submit" value="true">
		<p>
			<?php _e("Host Name:", 'wrex' ); ?> 
			<input type="text" name="wrex_hostname" value="<?php echo get_option('wrex_hostname'); ?>" size="60">
		</p>
		<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Update Options', 'wrex' ) ?>" />
		</p>
	</form>
	</div>
<?php
}
?>