<?php

/*
 * Plugin Name: wp_github
 * Description: WP_Github est un plugin qui sert à afficher les derniers commits d'un dépôt Github.
 * Author: Maxime Fernandes 
 */


include_once plugin_dir_path( __FILE__ ).'/commits_widget.php';

class Plugin 
{
    public function __construct()
    {
        add_action('widgets_init', function(){register_widget('Commits_Widget');});
    }
}

new Plugin();
?>