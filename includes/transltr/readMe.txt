transltr API wrapper
written by amir ramezani
thanks DJT alpha (on skype) for hosting the php script because my host didnt allow it

introduction
you know, must of the time, translation is needed, and it is quite good to have a free translation API
i was looking on stackoverflow, and i saw this transltr.org website
although the website itself allows you to translate text, but it has free and grate API to use
but a problem existed and that problem was, bgt can't work with json or xml, and here php script comes to the place

faq
can i modify this script for my own needs?
the answer is yup, but please note that i'm the copyright ownner and you can't claim that you've wrote it
why should i use this script?
it depends on you, i don't know, you would better know, if you want to translate chats on your game, if you want to translate messages for your game, etc!
if i've found a bug?
please tell it to me and i will fix it

functions:
these are functions for transltr class: you should make instance of it at first after including transltr.bgt
transltr translator;

functions:
bool set_php_script_url(string phpscript)

parameters:
the url to the php script

return value:
true if url can be set, false otherwise

remarks:
this function set's the url where the php script was stored

bool set_from_language(string lang)

parameters:
lang
the language that you want to translate from

return value:
true on success, false if failed

remarks:
if you want to translate from english, you must pass "en", if you want to translate from persian, you must pass "fa", etc

bool set_language_to(string lang)

parameters:
the language that you want to translate the text into

return value:
true on success, false if failed

remarks:
this function should be called to set the language that you want to translate into it
for example, if you want to translate into persian, you need to pass "fa"

string[] get_available_languages()

parameters:
none

return value:
retrieve's the available languages from transltr.org, then return's them

remarks:
this function return's an array of strings that has the language codes

string translate(string text)

parameters:

text
the text that you want to be translated

return value:
the translated text

remarks:
if you want to translate a text, just call this function

files:
phpserver.bat
this is a batch file that run's php as a webserver
i've used that to test the php script
readme.txt
this file
transltr.bgt
the bgt wrapper to transltr.org website
transltr.php
this is the php script which should be placed somewhere
transltr_example.bgt
this is a very very simple example of usage

notes:
i'm not responsible for any usage of this script, use it is completely is at your own risk

contact:
email: amir.ramezani1370@gmail.com
skype: amir.ramezani1370
audiogames.net forum username: visualstudio