Hi everyone. This is a small class I threw together that uses the free API from www.IPInfoDB.com to grab simple IP geolocation data and let the user do what ever he/she wishes to do with it. 
Note that I will not be held responsible for any harm that comes out of this script or the server I am using to allow access to this API. I made this with mostly experimental thoughts, also the thought that it might be cool to have a little map showing whare people on your game have been playing from, or automaticly connecting to the physicly closest server, etc. I did not write this for illegal tracking/player refused location gathering etc. If you use the script in a way that someone else does not like, I shall not be blamed in any way, shape or form. 


This class is very easy for you to use. Before using the script though, you must get an API key from http://www.ipinfodb.com. click the API link, and click whare you register it should not be to hard to find. Note that if you want to use my server which I am completely fine with for accessing the API (Good if you don't have your own), make sure that you set the server IP field to "158.69.214.237". If you want to use your own server though, just use the IP address of your server. Complete the sign up form and you should get your key. Go into ip_locale.bgt, and put the API key in the IP_LOCALE_API_KEY variable, and you should be good to start using the script! 
There is one more thing you have to do though if you are using your own server. under the key variable you should see another that is called IP_LOCALE_PHP_URL. Replace "http://www.samtupy.com/ip_locale.php" with the address to your script. ip_locale.php is included in this package as you may have scene, so just upload this onto your server whare ever you set the script url to, and there you go! 

So now that you've gotten that all out of the way, here is how you actually use the class. 
First you make an instance like normal, It's best if it's global. 
ip_locale location;

Then in whare ever you want to use it, you must point the script to the ip/hostname of your choice. Keep in mind that if you only need one location you should only have to do this and the next step once. 
location.set_ip("123.456.789.000");
Alternitivly just call set_ip to have the script just use the IP the request is sent from. 
location.set_ip();

Now we have to request the data. Do not do this durring a fast paste part of your game, it's recommended you do this on the startup of your script. 
location.request();
This will return false if there was an error, it's usually good to check. 

And there, that's all you had to do. keep in mind if you want to change IP addresses, just simply call set_ip again with the new IP or the requesters IP, and call request again, it's that easy! 

And now, simply have a field day with all the data you now have! Below is a list of string functions, call them when ever you want! 

location.get_ip_address()
location.get_country_code()
location.get_country_name();
location.get_state();
location.get_city()
location.get_zipcode
location.get_latitude()
location.get_longitude()
location.get_time_zone()

A little fun fact, if you set the IP to a domain name such as samtupy.com and then request, using the location.get_ip_address() function will give you the IP address for that domain! Kind of a clunky way to do it but hey, it's better than pinging with the command line and extracting the IP address... right? :D

Notes
As stated above I will not be held responsible for any harm that comes from any of this script. 
I am not at all providing any of the geolocation data. This is all the property of www.ipinfodb.com, meaning that I can not tell you what the accuracy is, but they claim that it's 99.5 percent accurate for country, and over 65 percent accurat for cities and usually get's the location with in 25 miles of actual location. 
I also don't mind if you use my server to access the php script that let's you access the API, but if you have your own server please use that to keep the traffic on my server lower. 
There is a little example included so you can better master the usage of this script if need be. 
Well, I hope this little script comes in handy to some of you folks out there, and if you have any questions, you can email me at webmaster@samtupy.com, skype me at sam.tupy1, or mension/follow me on twitter @samtupy1. I hope you enjoy, and have a great day! 

