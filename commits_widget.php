<?php

require_once(__DIR__ . '/vendor/autoload.php');

class Commits_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('commits', 'Commits', array('description' => 'Une liste des derniers commits d\'un dépôt.'));
    }

    public function getCommits($owner, $repo, $nbr)
    {
        $client = new GitHubClient();
        $client->setPage();
        $client->setPageSize($nbr);
        $commits = $client->repos->commits->listCommitsOnRepository($owner, $repo);

        foreach($commits as $commit)
        {
            $committer = $commit->getCommitter()->getLogin();
            $message = $commit->getCommit()->getMessage();
            $sha = substr($commit->getSha(), 0, 7);
            $url = $commit->getUrl();

            ?>
            <a href="<?php echo $url ?>">
                <p>
                    <?php
                    echo " - Committer: " . $committer;
                    ?>
                </p>
                <p>
                    <?php
                    echo $message . " - Sha: " . $sha . "... \n";
                    ?>
                <p>
                <br/>
            </a>
            <?php
        }
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


    public function widget($args, $instance)
    {
        extract($args);

        $owner = $instance['owner'];
        $repo = $instance['repo'];
        $nbr = $instance['nbr'];

        echo $before_widget;

        echo $this->getCommits($owner, $repo, $nbr);

        echo $after_widget;
    }
}

?>