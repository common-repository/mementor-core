<?php

// Disable the email notifications sent after auto updates.
add_filter('auto_plugin_update_send_email', '__return_false');
add_filter('auto_theme_update_send_email', '__return_false');

// Disable new user notifications.
remove_action('register_new_user', 'wp_send_new_user_notifications');
remove_action('edit_user_created_user', 'wp_send_new_user_notifications', 10, 2);

// Disable password change notifications for users.
add_filter('send_password_change_email', '__return_false');

// Footer branding
add_filter('admin_footer_text', 'mementor_footer_branding');
function mementor_footer_branding() {
    echo __('Design and development by', 'mementor-core').' <a href="https://mementor.no" rel="nofollow" target="_blank">Mementor AS</a> @ '.date('Y').' - '.__('Need technical support, send us an email to', 'mementor-core').' <a href="mailto:'.__('help@mementor.no', 'mementor-core').'" target="_blank">'.__('help@mementor.no', 'mementor-core').'</a>';
}

// Remove the default dashboard
add_action('admin_menu', 'memento_remove_dash', 99);
function memento_remove_dash() {
    remove_menu_page('index.php');
}

// Add custom dashboard
if (!function_exists('mementor_core_dashboard')) {
    add_action('admin_menu', 'mementor_core_dashboard');
    function mementor_core_dashboard() {
        add_menu_page('Mementor Dashboard', __('Welcome', 'mementor-core'), 'read', 'mementor_dashboard', 'mementor_dashboard', 'dashicons-megaphone', 0);
    }
}

// Dashboard contents
if (!function_exists('mementor_dashboard')) {
    function mementor_dashboard() {
        ?>
        <div class="mementor-wrapper">
            <!--
            <div class="mementor-container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><?php _e('Mementor Dashboard', 'mementor-core'); ?></h1>
                        <p></p>
                    </div>
                </div>
            </div>
            -->
        </div>
        <?
    }
}

// Redirect visits to the dashboard
add_action('load-index.php','mementor_redirect_dash');
function mementor_redirect_dash(){
    wp_redirect(admin_url('admin.php?page=mementor_dashboard'));
}

// Redirect to new dashboard after login
add_filter('login_redirect', 'mementor_redirect_new_dash');
function mementor_redirect_new_dash($url) {
    global $current_user;
    if (is_array($current_user->roles)) {
        if (in_array('administrator, shop_manager, editor, author', $current_user->roles)) {
             $url = admin_url('admin.php?page=mementor_dashboard');
        }
        return $url;
    }
}
