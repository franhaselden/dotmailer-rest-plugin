<?php 
// Insert this code into the template file for your success/unsuccessful page

		$status = htmlspecialchars($_GET["status"]);
			if ($status == "200"){
				echo 'You have been successfully subscribed to the [YOURNAME] newsletter.';
			}else if ($status == "400"){
				echo 'Unfortunately there has been an error with your sign up. ';
			};


		$errorcode = htmlspecialchars($_GET["errorcode"]);
			if ($errorcode == '1'){
				echo 'You cannot be added to the newsletter address book as you have been previously removed. If you feel this is a mistake, please contact <a href="mailto:your@email.co.uk?Subject=Manual request to add to newsletter from [YOURNAME]">your@email.co.uk</a> to request to be added to the newsletter manually.';
			}else if ($errorcode == '2'){
				echo 'The address you provided was in an invalid format. Please contact <a href="mailto:your@email.co.uk?Subject=Manual request to add to newsletter from [YOURNAME]">your@email.co.uk</a> to request to be added to the newsletter manually.';
			}else if ($errorcode == '3'){
				echo "This address book has reached it's maximum capacity. Please contact <a href='mailto:your@email.co.uk?Subject=Manual request to add to newsletter from [YOURNAME]'>your@email.co.uk</a> to request to be added to the newsletter manually.";
			}else if ($errorcode == '4'){
				echo 'You cannot be added to the newsletter address book as you have been previously removed. If you feel this is a mistake, please contact <a href="mailto:your@email.co.uk?Subject=Manual request to add to newsletter from [YOURNAME]">your@email.co.uk</a> to request to be added to the newsletter manually.';
			}else if ($errorcode == '5'){
				echo 'We are currently unsure what the error was. Please contact <a href="mailto:your@email.co.uk?Subject=Manual request to add to newsletter from [YOURNAME]">your@email.co.uk</a> to request to be added to the newsletter manually.';
			};
		?>
		</div>
		
		<br /><br /><br /><br />
		
		<?php } ?>	
