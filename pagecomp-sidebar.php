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
            // Fetch Data
            $stmt = $connection->prepare('
                SELECT
                    pageTitle,
                    pageContent,
                    pageImage
                FROM
                    blog_pages
                WHERE
                    pageTitle = :pageTitle
            ');
            $stmt->execute(array(
                ':pageTitle' => 'About'
            ));
            $row = $stmt->fetch();

            // About Image
            echo '<!-- About Image -->';
            if($row['pageImage'] != NULL) {
                $stmt2 = $connection->query('
                    SELECT
                        imageID,
                        imageTitle,
                        imagePath
                    FROM
                        blog_images
                    WHERE
                        imageID = '.$row['pageImage']
                );

                $stmt2->execute(array());
                $row2 = $stmt2->fetch();

                echo '<a href="/action/about'.$row['postSlug'].'" class="rb-card-link"><img class="rb-card-img" title="'.$row2['imageTitle'].'" src="/'.$row2['imagePath'].'?v='.CSSVERSION.'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A"></a>';
            }

            // Page Content
            $array1 = explode('[END OF DESCRIPTION]' , $row['pageContent']);
            $array1[0] = strip_tags(html_entity_decode($array1[0]), '<p><ul><li><img><b><h1><h2><h3><h4><h5><strong>');
            
            echo '<div>';
                echo '<a href="/action/about" class="rb-card-link">'.$array1[0].'</a>';
                echo '<p><a href="/action/about" class="rb-card-link rb-text-opacity">Read More &gt;</a></p>';
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
                        postSlug,
                        postImage
                    FROM
                        blog_posts
                    ORDER BY
                        postID DESC LIMIT 5
                ');
                
                $increment = 1;
                
                while($row = $statement->fetch()){
                    echo '<a href="/post/'.$row['postSlug'].'" class="rb-button rb-list-item">';
                        echo '<div>';
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
                echo '<div class="rb-link-tags-container">';
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
                    sort($finalTags);
                    
                    echo '<ul class="rb-card-footer-tags-table rb-text-opacity">';
                        foreach ($finalTags as $tag) {
                            echo '<li style="padding-bottom: 4px;"><a href="/tag/'.$tag.'" class="rb-link-tags-container-item">#'.ucwords($tag).'</a></li>';
                        }
                    echo '</ul>';
                echo '</div>';
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
                echo '<div class="rb-link-tags-container">';
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
                    
                    echo '<ul class="rb-card-footer-tags-table rb-text-opacity">';
                        while($row = $statement->fetch()){
                            $monthName = ''.date("F", mktime(0, 0, 0, $row['Month'], 10)).' '.$row['Year'].'';
                            $slug = 'archive/'.$row['Month'].'-'.$row['Year'];
                            echo '<li style="padding-bottom: 4px;"><a href="/'.$slug.'" class="rb-link-tags-container-item">'.$monthName.'</a></li>';
                        }
                    echo '</ul>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<!-- END   - Archives -->';
        }
        
    echo '</div>';
    echo '<!-- END   - Right Column: Navigation Column -->';
}
?>
