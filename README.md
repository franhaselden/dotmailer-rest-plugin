=== Dotmailer REST Newsletter Sign-up ===

Contributors: F.Haselden for SomethingBig.co.uk

Version: 1.1

Date: 12/09/2014

Updated: 24/09/2014


This plugin creates a widget which can be placed in widget areas. The widget contains an input field for an email address. The widget does not require use of SOAP.

Points of note:

1. This will work with any dotmailer account that has API access and API access to API v2

2. This only provides addition of an email address. It does not currently support first names, last names, or any other details.


=== Set up ===

1. Install and activate plugin
2. On Dotmailer, set up a new API user and make note of the API key (an email) and pword
3. On Dotmailer, make note of the ID of the address book you wish to add to (usually last 7 digits of the address book URL)
4. In Wordpress, navigate to Settings > Dotmailer Plugin and input the API key, password and Address Book ID.
5. In Wordpress, create a new page with a “success” message. This is where your users will go once their email has been successfully added
6. Repeat 5. for an “unsuccessful” page
7. Input slugs for both pages on the Dotmailer API Information page


=== Widget ===

1. Go to Appearance > Widgets
2. Drag the Dotmailer widget into the relevant widget area
3. The widget will now appear in the widget area. The user can now submit their email address to the specified list
4. When the user is successful they will be forwarded to the previously created success page


=== Success Page Advice ===

There are two ways of going about the success and unsuccessful pages. The simple way is to have two different pages, with some generic details about what has happened. The user will be sent to either one depending on the result of their submission to the address book. All you need to do for this is use the plugin settings to choose the slug (end of the URL) for your pages.

The more complicated (but better) way is to input the same slug for the page into both option boxes and instead use PHP to deliver a useful message. To do this, create one page and input the slug into the plugin settings. Then refer to the file example-success-page.php. The plugin already has the capability to pass an error code along with the redirection at the end of the script, so you can harness these error codes and give your user some useful information to carry on with. All you need to do is place this example code in your success/unsuccessful page and change the text to be more relevant to your company.


=== Error codes ===

For your reference, below are the error codes that are applied in the plugin. Also the error codes from dot mailer, and the description of what they mean.

Error 1		ERRORCONTACTSUPPRESSED		The user has already been removed from the account once before

Error 2		ERRORCONTACTINVALID		The information is invalid. This shouldn’t occur, but it might

Error 3		ERRORCONTACTTOOMANY		You have used too many requests. Dotmailer API only allows 20,000 p/d

Error 4		ERRORCONTACTSUPPRESSEDFORADDRESSBOOK	The user has already been removed from the address book but not the account

Error 5 	Generic for everything else 	This is the code you will see if the error couldn’t be determined



=== Limitations ===

1. There are three responses messages that can be received from Dotmailer. 
	• 200 = this response indicates successful addition to the mailing list. A 200 response will forward to the “successful” slug provided
	• 400 = this response indicates permission denied. The API has not authenticated the user properly. Check your details. This will forward the user to the “unsuccessful” slug provided
	• Any other response. This will trigger an unstyled page outputting the response received and requesting contact to the site administrator. This response should not occur so is included as fallback only.
2. The plugin currently only allows input of an email address. ID will be auto-generated by Dotmailer. The email type will be assumed as HTML and the subscription listing will be assumed as Subscribed. These are hardcoded values.
3. This plugin only allows submission to ONE address book.
4. The plugin will not forward to slugs which have multiple levels (e.g multiple slashes). It will only forward to a top-level page e.g yoursite.co.uk/submission-successful. Not yoursite.co.uk/anotherpage/submission-successful.
