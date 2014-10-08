<?php
/**
 * Description: This is where the email address given will be posted once the user has filled it in on the newsletter widget
 */


// Declare the basic vars
$useremail = "default@default.co.uk";
$clean_useremail = "default@default.co.uk";
$xml = "default";
$successful_slug = "default";
$unsuccessful_slug = "default";

// Gets the email that was submitted with POST from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// stores the form data in $useremail
 	$useremail = htmlspecialchars($_POST["useremail"]);
}

// Loads in WP
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

// Creates WP options dependent vars
$clean_useremail = filter_var(($useremail), FILTER_SANITIZE_EMAIL);
$apiemail = filter_var(get_option('apiemail'), FILTER_SANITIZE_EMAIL);
$apipassword = get_option('apipassword');
$listID = get_option('listID');
$successful_slug = str_replace('/', '', get_option('slugSuccess'));
$unsuccessful_slug = str_replace('/', '', get_option('slugUnsuccess'));

// Built the auth URL using the listID
$auth_url = 'https://api.dotmailer.com/v2/address-books/' . $listID .'/contacts';

// Create the XML data to be added to the DB

$xml = array(
	'id' => 'generic',
	// uses the var that was passed to the function
	'email' => $clean_useremail,
	'optInType' => 'Unknown',
	'emailType' => 'Html',
	'dataFields' => ':null',
	'status' => 'Subscribed'
);

// Encode JSON from the array
$xml_string = json_encode($xml);

// Calls the API and adds the data to the address book
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$auth_url);
curl_setopt($ch,CURLOPT_POST, count($xml));
curl_setopt($ch,CURLOPT_POSTFIELDS, $xml_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$apiemail:$apipassword");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
   'Content-Type: application/json',                                                                                
   'Content-Length: ' . strlen($xml_string))                                                                       
); 
$result = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);

$success_url = site_url() . '/' . $successful_slug;
$unsuccess_url = site_url() . '/' . $unsuccessful_slug;

if (isset($status_code)) {
	if ($status_code == '200'){
		echo 'status = ' . $status_code;
		header('Location:' . $success_url . '?status=200');
	}
	else if ($status_code =='400'){

		// Grabs the error message
		if(preg_match_all('/[A-Z]/', $result, $matches)) {
    		$error_c = implode('', $matches[0]);
    		$error = substr($error_c, 1);
		}else{echo 'There was an error, no error message was returned from Dotmailer. Please try again.';}

		// Creates error codes for the general errors returned
		if ($error == 'ERRORCONTACTSUPPRESSED'){
			$error_code = 1;
		}else if($error == 'ERRORCONTACTINVALID'){
			$error_code = 2;
		}else if($error == 'ERRORCONTACTTOOMANY'){
			$error_code = 3;
		}else if($error == 'ERRORCONTACTSUPPRESSEDFORADDRESSBOOK'){
			$error_code = 4;
		}else {$error_code = 5;}

		header('Location:' . $unsuccess_url . '?status=400&errorcode=' . $error_code);
	}
	else{
		echo 'Submission success undetermined. HTTP response = ' . $status_code . '<br />Please contact the site administrator';
	}
};


?>
