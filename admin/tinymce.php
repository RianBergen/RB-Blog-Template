<?php echo '<script src="'.TINYMCE.'"></script>';?>
<script>
    // Initialize TinyMCE Using Dark Theme
    function InitTinyMCE_Dark() {
		tinymce.init({
            // ID Selector
            selector: "#tinyMCE",
            // Plugins
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table paste"
            ],
            // Skins For Dark Mode
            skin: "oxide-dark",
            content_css: "dark",
            // Toolbar Information Including List Of Images When Adding Images
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            image_list: [
                <?php
                    // Retrieve List Of Images
                    $stmt2 = $connection->query('
                        SELECT
                            imageID,
                            imageTitle,
                            imagePath
                        FROM
                            blog_images
                        ORDER BY
                            imageTitle
                    ');
                    while($row2 = $stmt2->fetch()) {
                        // Input Images Into List
                        echo "{title: '".$row2['imageTitle']."', value: '../".$row2['imagePath']."'},";
                    }
                ?>
                // Input Placeholder Image Into List
                {title: 'Placeholder Image', value: '../_res/images/missing/Placeholder-Image-1920x1080.png'}
            ],
            // Restrict Height Of Editor
            height : "500px"
        });

        return 0;
    }



    // Initialize TinyMCE Using Dark Theme
    function InitTinyMCE_Light() {
		tinymce.init({
            // ID Selector
            selector: "#tinyMCE",
            // Plugins
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table paste"
            ],
            // Toolbar Information Including List Of Images When Adding Images
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            image_list: [
                <?php
                    // Retrieve List Of Images
                    $stmt2 = $connection->query('
                        SELECT
                            imageID,
                            imageTitle,
                            imagePath
                        FROM
                            blog_images
                        ORDER BY
                            imageTitle
                    ');
                    while($row2 = $stmt2->fetch()) {
                        // Input Images Into List
                        echo "{title: '".$row2['imageTitle']."', value: '../".$row2['imagePath']."'},";
                    }
                ?>
                // Input Placeholder Image Into List
                {title: 'Placeholder Image', value: '../_res/images/missing/Placeholder-Image-1920x1080.png'}
            ],
            // Restrict Height Of Editor
            height : "500px"
        });

        return 0;
    }



    // Light/Dark Theme Setting
    <?php if(ISDARKMODE == 'dark') {
        echo 'InitTinyMCE_Dark();'; // Dark Mode Is True: Call Tiny MCE Dark Mode Initializer
    } else {
        echo 'InitTinyMCE_Light();'; // Dark Mode Is True: Call Tiny MCE Dark Mode Initializer
    }
    ?>
</script>