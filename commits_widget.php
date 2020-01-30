<?php

require_once(__DIR__ . '/vendor/autoload.php');

class Commits_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('commits', 'Commits', array('description' => 'Une liste des derniers commits d\'un dépôt.'));
    }

    public function form($instance)
    {
        $owner = esc_attr($instance['owner']);
        $repo = esc_attr($instance['repo']);
        $nbr = esc_attr($instance['nbr']);

        ?>

        <p>
            <label for="<?php echo $this->get_field_id('owner'); ?>">
                <?php echo 'Auteur:'; ?>
                <input class="widefat" id="<?php echo $this->get_field_id('owner'); ?>" name="<?php echo $this->get_field_name('owner'); ?>" type="text" value="<?php echo $owner; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('repo'); ?>">
                <?php echo 'Dépôt:'; ?>
                <input class="widefat" id="<?php echo $this->get_field_id('repo'); ?>" name="<?php echo $this->get_field_name('repo'); ?>" type="text" value="<?php echo $repo; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('nbr'); ?>">
                <?php echo 'Nombre de commits à afficher:'; ?>
                <input class="widefat" id="<?php echo $this->get_field_id('nbr'); ?>" name="<?php echo $this->get_field_name('nbr'); ?>" type="text" value="<?php echo $nbr; ?>" />
            </label>
        </p>

    <?php
    }

    public function getCommits($owner, $repo, $nbr)
    {
        $client = new GitHubClient();
        $client->setPage();
        $client->setPageSize($nbr);
        $commits = $client->repos->commits->listCommitsOnRepository($owner, $repo);

        foreach($commits as $commit)
        {
            ?>
            <a href="<?php echo $commit->getUrl() ?>">
                <p>
                    <?php
                    echo " - Committer: " . $commit->getCommitter()->getLogin();
                    ?>
                </p>
                <p>
                    <?php
                    echo $commit->getCommit()->getMessage() . " - Sha: " . substr($commit->getSha(), 0, 7) . "...";
                    ?>
                </p>
            </a>
            <?php
        }
    }

    public function widget($args, $instance)
    {
        extract($args);

        echo $before_widget;

        if ($instance['nbr'] !== null) {          
            echo $before_title."Commits".$after_title;
            echo "Vérifiez que vous ayez bien rempli tous les champs du formulaire ! Il manque une ou plusieurs informations.";
        }

        else {
            echo $before_title."Commits récents du dépôt ". $instance['repo'] . $after_title;
            echo $this->getCommits($instance['owner'], $instance['repo'], $instance['nbr']);
        }
       
        echo $after_widget;
    }
}

?>