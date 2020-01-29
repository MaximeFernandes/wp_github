<?php

include_once plugin_dir_path( __FILE__ ).'/commits_widget.php';

class Commits 
{
    public function __construct()
    {
        add_action('widgets_init', function(){register_widget('Commits_Widget');});
    }
}
?>