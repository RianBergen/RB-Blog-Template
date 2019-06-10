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

<!-- START - Left Column: Blog Post Column -->
<div class="rb-main-flex-grid-left-column">
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
                    // Create Message
                    $msg = "First Name: ".$firstname."\r\nLast Name: ".$lastname."\r\nEmail: ".$email."\r\n\r\nSubject: \r\n".$subject;
                    $msg = str_replace("\n.", "\n..", $msg);
                    $msg = wordwrap($msg, 70, "\r\n");
                    
                    // Send Message
                    mail("rianb98@gmail.com", "RB Blog Contact Request", $msg);
                    
                    $error[] = 'Thank you for contacting us. We will get back with you shortly.';
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
                    
                    $error[] = 'Thank you for subscribing/unsubscribing';
                }
            }  else {
                // Submission Failed Failed
                $error[] = 'Please Fill Out All Fields';
            }
        }
        
		// Check For Any Errors
		if(isset($error)) {
			foreach($error as $error) {
				echo '<p class="rb-error" style="margin: 2rem; margin-top: 1rem; margin-bottom: -1rem;">'.$error.'</p>';
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
					echo '
<div style="padding: 1rem;">
    <form action="" method="post">
        <label for="id1" class="rb-id1">Honeypot: Do Not Fill Out!</label>
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
    </form>
</div>
                    ';
				echo '</div>';
			echo '</div>';
		} else if ($row['pageTitle'] == "Subscribe"){
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Subscribe/Unsubscribe</b></h3>';
                    echo '<p>Please enter your email below to subscribe to our post updates. We wont spam you and will only notify you of new posts. Entering your email if you are already subscribed will unsubscribe you.</p>';
				echo '</div>';
				echo '<div>';
					echo '
<div style="padding: 1rem;">
    <form action="" method="post">
        <label for="id1" class="rb-id1">Honeypot: Do Not Fill Out!</label>
        <input class="rb-login-input rb-id1" style="width: 100%;" type="text" id="id1" name="id1" placeholder="id1">
        
        <label for="id4">Email</label>
        <input class="rb-login-input" style="width: 100%;" type="text" id="id4" name="id4" placeholder="Your Email...">
        
        <input class="rb-login-button rb-button rb-button-border rb-padding-1rem-2rem" style="margin: 0rem;" type="submit" name="submitsubscribe" value="Contact">
    </form>
</div>
                    ';
				echo '</div>';
			echo '</div>';
        }
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->