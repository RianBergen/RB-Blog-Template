<?php
try {
    // Get SQL Data
    $statement = $connection->query('
        SELECT
            settingsID,
            settingsValue
        FROM
            blog_settings
        WHERE
            settingsID >= 1 AND settingsID <= 5
        ORDER BY
            settingsID
    ');
    
    $rows = array();
    
    while($row = $statement->fetch()) {
        array_push($rows, $row);
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

$showAbout = $rows[0][1];
$showRecent = $rows[1][1];
$showTags = $rows[2][1];
$showArchives = $rows[3][1];

// Check If Sidebar Is Needed
if($showAbout || $showRecent || $showTags || $showArchives) {
    // Sidebar Header
    echo '<!-- START - Right Column: Navigation Column -->';
    echo '<div class="rb-main-flex-grid-right-column">';
        
        // About
        if($showAbout) {
        echo '<!-- START - About Card -->';
        echo '<div class="rb-card">';
            echo '<!-- About Image -->';
            echo '<img class="rb-card-img" src="/_res/images/about/About-1920x1080.png" alt="N/A">';
            $stmt = $connection->prepare('
                SELECT
                    pageTitle,
                    pageContent
                FROM
                    blog_pages
                WHERE
                    pageTitle = :pageTitle
            ');
            $stmt->execute(array(
                ':pageTitle' => 'About'
            ));
            $row = $stmt->fetch();
            
            $string = explode(' </p>' , $row['pageContent']); //substr($row['pageContent'], 0, strpos($row['pageContent'], '</p>'));
            
            echo '<div>';
                echo $string[0];
                echo '<a href="/action/about" class="rb-button rb-button-border rb-padding-1rem-2rem"><b>READ MORE</b></a>';
            echo '</div>';
        echo '</div>';
        echo '<!-- END   - About Card -->';
        }
        
        if($showRecent) {
        // Recent Posts
        echo '<!-- START - Recent Posts -->';
        echo '<div class="rb-card">';
            echo '<div>';
                echo '<h3><b>Recent Posts</b></h3>';
            echo '</div>';
            echo '<hr/>';
            echo '<div class="rb-list">';
                $statement = $connection->query('
                    SELECT
                        postTitle,
                        postDate,
                        postSlug
                    FROM
                        blog_posts
                    ORDER BY
                        postID DESC LIMIT 5
                ');
                
                $increment = 1;
                
                while($row = $statement->fetch()){
                    echo '<a href="/post/'.$row['postSlug'].'" class="rb-button rb-list-item">';
                        echo '<img src="/_res/images/side/'.$increment.'.png" onerror="this.src=&#39;/_res/images/192x192-Logo.png&#39;" alt="N/A">';
                        echo '<div class="rb-list-item-txt">';
                            echo '<span class="rb-text-font-large">'.$row['postTitle'].'</span><br>';
                            echo '<span>'.date('F d, Y', strtotime($row['postDate'])).'</span>';
                        echo '</div>';
                    echo '</a>';
                    
                    $increment = $increment + 1;
                }
            echo '</div>';
        echo '</div>';
        echo '<!-- END   - Recent Posts -->';
        }
        
        if($showTags) {
        // Tags
        echo '<!-- START - Tags -->';
        echo '<div class="rb-card">';
            echo '<div>';
                echo '<h3><b>Tags</b></h3>';
            echo '</div>';
            echo '<hr/>';
            echo '<div>';
                echo '<p class="rb-link-tags-container">';
                    echo '<a href="/" class="rb-text-black-tag">Back Home</a>';
                    $tagsArray = [];
                    $statement = $connection->query('
                        SELECT DISTINCT
                            LOWER(postTags) AS postTags
                        FROM
                            blog_posts
                        WHERE
                            postTags != ""
                        GROUP BY
                            postTags
                    ');
                    
                    while($row = $statement->fetch()){
                        $parts = explode(', ', $row['postTags']);
                        
                        foreach ($parts as $tag) {
                            $tagsArray[] = $tag;
                        }
                    }
                    
                    $finalTags = array_unique($tagsArray);
                    foreach ($finalTags as $tag) {
                        echo '<a href="/tag/'.$tag.'" class="rb-text-grey-tag">'.ucwords($tag).'</a>';
                    }
                echo '</p>';
            echo '</div>';
        echo '</div>';
        echo '<!-- END   - Tags -->';
        }
        
        if($showArchives) {
        // Archives
        echo '<!-- START - Archives -->';
        echo '<div class="rb-card">';
            echo '<div>';
                echo '<h3><b>Archives</b></h3>';
            echo '</div>';
            echo '<hr/>';
            echo '<div>';
                echo '<p class="rb-link-tags-container">';
                    echo '<a href="/" class="rb-text-black-tag">Back Home</a>';
                    $statement = $connection->query('
                        SELECT
                            Month(postDate) as Month,
                            Year(postDate) as Year
                        FROM
                            blog_posts
                        GROUP BY
                            Month(postDate),
                            Year(postDate)
                        ORDER BY
                            postDate DESC
                    ');
                    
                    while($row = $statement->fetch()){
                        $monthName = date("F Y", mktime(0, 0, 0, $row['Month'], 10));
                        $slug = 'archive/'.$row['Month'].'-'.$row['Year'];
                        echo '<a href="/'.$slug.'" class="rb-text-grey-tag">'.$monthName.'</a>';
                    }
                echo '</p>';
            echo '</div>';
        echo '</div>';
        echo '<!-- END   - Archives -->';
        }
        
    echo '</div>';
    echo '<!-- END   - Right Column: Navigation Column -->';
}
?>