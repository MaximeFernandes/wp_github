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
}

?>