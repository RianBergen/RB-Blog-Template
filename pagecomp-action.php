<?php
// Get Post Data
if ($id != NULL) {
	$statement = $connection->prepare('
        SELECT
            pageID,
            pageTitle,
            pageContent,
            pageSlug
        FROM 
            blog_pages
        WHERE
            pageSlug = :pageSlug
    ');
	$statement->execute(array(
        ':pageSlug' => $id
    ));
	$row = $statement->fetch();
}
?>

	<!-- Back To Posts Button -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="\" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important; margin-top: 2rem;"><b>Home</b></a>
		</div>
		<div>
		</div>
	</div>

	<!-- Blog Post -->
	<?php
        // Process Submitted Form
		if(isset($_POST['submitcontact'])) {
            // Collect Form Data
			extract($_POST);
            
            // Honeypot
            if (testInput($_POST['id1']) == "") {
                $firstname = testInput($_POST['id2']);
                $lastname = testInput($_POST['id3']);
                $email = testInput($_POST['id4']);
                $subject = testInput($_POST['id5']);
                
                // Very Basic Validation
                if($firstname =='') {
                    $error[] = 'Please Enter A First Name';
                }
                
                if($lastname =='') {
                    $error[] = 'Please Enter A Last Name';
                }
                
                if(($email == '') || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
                    $error[] = 'Please Enter A Valid Email';
                }
                
                if($subject == '') {
                    $error[] = 'Please Enter A Subject';
                }
                
                // No Errors
                if(!isset($error)){
                    // Retrieve Email Template
                    $statementemail = $connection->prepare('
                        SELECT
                            pageTitle,
                            pageContent,
                            pageExtra
                        FROM
                            blog_pages
                        WHERE
                            pageTitle = :pageTitle
                    ');
                    $statementemail->execute(array(
                        ':pageTitle' => "Contact-Email Notification"
                    ));
                    $rowemail = $statementemail->fetch();
                    
                    // Format Template And Replace Tags With Information
                    $msg = '
                        <html>
                        <head>
                            <title>Contact Request</title>
                        </head>
                        <body>
                    '.$rowemail['pageContent'].'
                        </body>
                        </html>
                    ';
                    
                    $msg = str_replace('[First]', $firstname, $msg);
                    $msg = str_replace('[Last]', $lastname, $msg);
                    $msg = str_replace('[Email]', $email, $msg);
                    $msg = str_replace('[Subject]', $subject, $msg);
                    
                    // Add Headers
                    $headers = "MIME-Version: 1.0"."\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1"."\r\n";
                    $headers .= "From: ".$firstname." ".$lastname."<".$email.">"."\r\n";
                    
                    // Send Message
                    mail(ADMINEMAIL, $rowemail['pageExtra'], $msg, $headers);
                    
                    $success[] = 'Thank you for contacting us. We will get back with you shortly.';
                }
            }  else {
                // Submission Failed Failed
                $error[] = 'Please Fill Out All Fields';
            }
		} else if (isset($_POST['submitsubscribe'])) {
            // Collect Form Data
			extract($_POST);
            
            // Honeypot
            if (testInput($_POST['id1']) == "") {
                $email = testInput($_POST['id4']);
                
                // Very Basic Validation
                if(($email == '') || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
                    $error[] = 'Please Enter A Valid Email';
                }
                
                // No Errors
                if(!isset($error)){
                    // Retrieve Database
                    $statement1 = $connection->prepare('
                        SELECT COUNT(1)
                            subscriberID,
                            subscriberEmail
                        FROM
                            blog_subscribers
                        WHERE
                            subscriberEmail = :subscriberEmail
                    ');
                    $statement1->execute(array(
                        ':subscriberEmail' => $email
                    ));
                    $row1 = $statement1->fetch();
                    
                    // Check If Row Exists
                    if ($row1[0] >= 1) {
                        // Unsubscribe
                        $statement2 = $connection->prepare('
                            DELETE FROM
                                blog_subscribers
                            WHERE
                                subscriberEmail = :subscriberEmail
                        ');
                        $statement2->execute(array(
                            ':subscriberEmail' => $email
                        ));
                        
                        // Retrieve Email Template
                        $statementemail = $connection->prepare('
                            SELECT
                                pageTitle,
                                pageContent,
                                pageExtra
                            FROM
                                blog_pages
                            WHERE
                                pageTitle = :pageTitle
                        ');
                        $statementemail->execute(array(
                            ':pageTitle' => "Unsubscribe-Email Notification"
                        ));
                        $rowemail = $statementemail->fetch();
                        
                        // Format Template And Replace Tags With Information
                        $msg = '
                            <html>
                            <head>
                                <title>Contact Request</title>
                            </head>
                            <body>
                        '.$rowemail['pageContent'].'
                            </body>
                            </html>
                        ';
                        
                        $msg = str_replace('[Email]', $email, $msg);
                        
                        // Add Headers
                        $headers = "MIME-Version: 1.0"."\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1"."\r\n";
                        $headers .= "From: ".ADMINNAME."<".ADMINEMAIL.">"."\r\n";
                    
                        // Send Message
                        mail($email, $rowemail['pageExtra'], $msg, $headers);
                        
                        $success[] = 'We are sorry to see you go... :( You will recieve a confirmation email shortly.';
                    } else {
                        // Subscribe
                        $statement2 = $connection->prepare('
                            INSERT INTO
                                blog_subscribers (subscriberEmail)
                            VALUES
                                (:subscriberEmail)
                        ');
                        $statement2->execute(array(
                            ':subscriberEmail' => $email
                        ));
                        
                        // Retrieve Email Template
                        $statementemail = $connection->prepare('
                            SELECT
                                pageTitle,
                                pageContent,
                                pageExtra
                            FROM
                                blog_pages
                            WHERE
                                pageTitle = :pageTitle
                        ');
                        $statementemail->execute(array(
                            ':pageTitle' => "Subscribe-Email Notification"
                        ));
                        $rowemail = $statementemail->fetch();
                        
                        // Format Template And Replace Tags With Information
                        $msg = '
                            <html>
                            <head>
                                <title>Contact Request</title>
                            </head>
                            <body>
                        '.$rowemail['pageContent'].'
                            </body>
                            </html>
                        ';
                        
                        $msg = str_replace('[Email]', $email, $msg);
                        
                        // Add Headers
                        $headers = "MIME-Version: 1.0"."\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1"."\r\n";
                        $headers .= "From: ".ADMINNAME."<".ADMINEMAIL.">"."\r\n";
                    
                        // Send Message
                        mail($email, $rowemail['pageExtra'], $msg, $headers);
                        
                        $success[] = 'Thank you for Subscribing! You will recieve a confirmation email shortly.';
                    }
                }
            }  else {
                // Submission Failed
                $error[] = 'Please Fill Out All Fields';
            }
        }
        
		
        
        // Form
		if($row['pageTitle'] == "") {
			// Card
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Page Was Not Found, Or Is Empty!</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<p>Please type in a different URL, or select a different Page.</p>';
				echo '</div>';
			echo '</div>';
		} else if ($row['pageTitle'] == "Contact"){
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Contact Us</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<div style="padding: 1rem;">';
                    
                    // Check For Any Errors/Success
                    if(isset($error)) {
                        foreach($error as $error) {
                            echo '<p class="rb-error" style="margin: 0rem; margin-bottom: 1rem;">'.$error.'</p>';
                        }
                    }
                    
                    echo '<form action="" method="post">
                            <input class="rb-login-input rb-id1" style="width: 100%;" type="text" id="id1" name="id1" placeholder="id1">
                            
                            <label for="id2">First Name</label>
                            <input class="rb-login-input" style="width: 100%;" type="text" id="id2" name="id2" placeholder="Your Name...">

                            <label for="id3">Last Name</label>
                            <input class="rb-login-input" style="width: 100%;" type="text" id="id3" name="id3" placeholder="Your Last Name...">
                            
                            <label for="id4">Email</label>
                            <input class="rb-login-input" style="width: 100%;" type="text" id="id4" name="id4" placeholder="Your Email...">
                            
                            <label for="id5">Subject</label>
                            <textarea class="rb-login-input" style="width: 100%; height: 12.5rem;" id="id5" name="id5" placeholder="Write something..."></textarea>

                            <input class="rb-login-button rb-button rb-button-border rb-padding-1rem-2rem" style="margin: 0rem;" type="submit" name="submitcontact" value="Contact">
                    ';
                    
                    // Check For Success
                    if(isset($success)) {
                        foreach($success as $success) {
                            echo '<p class="rb-success" style="margin: 0rem; margin-top: 1rem; margin-bottom: 1rem;">'.$success.'</p>';
                        }
                    }
                    
                        echo '</form>';
                    echo '</div>';
				echo '</div>';
			echo '</div>';
		} else if ($row['pageTitle'] == "Subscribe"){
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Subscribe/Unsubscribe</b></h3>';
                    echo '<p>Please enter your email below to subscribe to our post updates. We wont spam you and will only notify you of new posts. Entering your email if you are already subscribed will unsubscribe you.</p>';
				echo '</div>';
				echo '<div>';
					echo '<div style="padding: 1rem;">';
                    
                    // Check For Any Errors/Success
                    if(isset($error)) {
                        foreach($error as $error) {
                            echo '<p class="rb-error" style="margin: 0rem; margin-bottom: 1rem;">'.$error.'</p>';
                        }
                    }
                    
                    echo '<form action="" method="post">
                        <input class="rb-login-input rb-id1" style="width: 100%;" type="text" id="id1" name="id1" placeholder="id1">
                        
                        <label for="id4">Email</label>
                        <input class="rb-login-input" style="width: 100%;" type="text" id="id4" name="id4" placeholder="Your Email...">
                        
                        <input class="rb-login-button rb-button rb-button-border rb-padding-1rem-2rem" style="margin: 0rem;" type="submit" name="submitsubscribe" value="Submit">
                    ';
                    
                    // Check For Success
                    if(isset($success)) {
                        foreach($success as $success) {
                            echo '<p class="rb-success" style="margin: 0rem; margin-top: 1rem; margin-bottom: 1rem;">'.$success.'</p>';
                        }
                    }
                    
                        echo '</form>';
                    echo '</div>';
				echo '</div>';
			echo '</div>';
        }
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->