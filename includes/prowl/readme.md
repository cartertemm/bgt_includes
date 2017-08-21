# Prowl-bgt

Send notifications to your iOS device using BGT.


## Important Notes
Please note the following:


* Although its not anywhere in the documentation, this app is currently priced at $2.99. Don't complain, boxcar is no longer in the iOS app store, and the only other options use HTTPS, the major point of this was not having to link to another server running PHP, also, XML is much easier to handle than JSON, at least for parsing.
* You most likely won't need an provider key. Those are only used if you need to generate API keys using something other than the web interface.
* IP addresses are limited to sending 100 requests/hour. Again, don't complain. Unless your making an insane spamming thing, that should be fine, and even then you should be able to get off 16 notifications/minute, tops.
* There's no point of verifying the API key before you send each notification, unless you wanna pointlessly use requests. Maybe call verify at the beginning of your script, but it costs you a request, and if there's an error with the key the output will show it.
* Provider key management isn't fully supported right now. This will probably be added, but you don't need one to send notifications or verify other keys.
* The code is sorta messy, deal with it
* I recommend if you use this to put it on a server.
* You can specify more than one key to send notifications to by using a comma

## Getting started

* Download the prowl app from the iOS or mac app store
* go to [the prowl website](http:/prowlapp.com) and create an account.
* On the account page, generate an API key and/or provider key. The provider key will be unnecessary for most people.

## Usage
Include the script:

```
#include "prowl.bgt"
```

Enter your API key in the constructor

```
prowl p("enter your key here");
```

Next call post or verify, see below.

## Methods

The prowl class currently has the following methods.

```
prowl(string apikey, string providerkey="")
```

This is the constructor

* apikey: Your account API key, generated on the account page.
* providerkey (optional): Your provider key, generated on the account page

```
string verify(string apikey="", string providerkey="")
```

Verify if an API or provider key is valid

* apikey (optional): Your API key. If not given, it will use the original key specified in the constructor
* providerkey (optional): If not given, it will try to use the key specified in the constructor.

```
string post(string application, string event, string description, string url="", string providerkey="", int priority=0)
```

returns XML data specifying the query. Use the functions below for parsing.

* application: The name of the application sending the notification. Example: my cool game
* event: Think of this as a subject. Example: user was banned
* description: Think of this as the body of your notification. Example: username was banned from the game. The reason specified is cheating.
* url (optional): A URL that goes along with the notification. Example: http://mysite.com/banned/user
* providerkey (optional): Only needed if your whitelisted.
* priority (optional): Default value is 0. Possible values are:
	* -2: very low
	* -1: moderate
	* 0: normal
	* 1: high
	* 2: emergency

You can set different actions based on each priority

```
string get_response(string the_string)
```

the_string represents XML data, the content of post

returns the status of the sent notification. Possible values are:

* success: notification sent successfully
* bad request: something is wrong with the parameters you specified
* API key is not valid: hopefully this is self explanitory
* exceeded API limit: You've sent more than 1000 notifications, or validated 1000 provider keys in the span of an hour. If you get this, stop spamming!
* request not approved: the user has not approved the retrieve request
* internal server error: Somethings wrong with the prowl servers

```
string get_remaining(string the_string)
```

the_string represents XML data, the content of post

returns the number of requests remaining for your IP address that hour, or "unable to get remaining" on error.
note: this isn't an int for a reason. If string_is_digits returns false, you know there's an error.

## contacting
That's all for now, if you have any questions, feel free to contact me using either github, or

email: crtbraille@hotmail.com

twitter: cartertemm