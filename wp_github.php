<?php

/*
 * Plugin Name: wp_github
 * Description: WP_Github est un plugin qui sert à afficher les derniers commits d'un dépôt Github.
 * Author: Maxime Fernandes 
 */


class WP_Github
{
    public function __construct()
    {
        include_once plugin_dir_path( __FILE__ ).'/commits.php';
        new Commits();
    }
}

new WP_Github();
 ?>