<?php

require_once(__DIR__ . '/vendor/autoload.php');

class Commits_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('commits', 'Commits', array('description' => 'Une liste des derniers commits d\'un dépôt.'));
    }
}

?>