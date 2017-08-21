tts_options class:

This is a small class that lets you quickly create a nice tts options menu, with many peramitors.

credits:
Thanks to Mason Armstrong, or soundworx, for being a terific beta tester, and helper in this project.

script use: 
the script is easy to use once it is ran. up and down arrows change the voice, left and right arrows change the rate, page up and down change volume, and home and end change pitch.
space manuely refreshes the list if refresh=true, escape or alt f4 closes, and enter saves.
peramitors:
string output_path;
string encryption_key;
string intro;
bool wrap;
bool keyhook;
bool allow_escape;
bool allow_control;
bool allow_pitch;
bool allow_rate;
bool allow_volume;

string output_path: A string that defines whare the saved voice data will be kept. If set to blank, it will default into the directory into wich the script is ran.
string encryption key: A string that defines the encryption key for the data. If set to blank, the encryption key defaults to speech.
string intro: A string that defines what text should be spoken when the menu is entered. If set to blank, the text defaults to "choose a voice."
bool wrap: A boolian simpely specifying whether the voice list should wrap or not.
bool keyhook: A boolian specifying whether it should install a keyhook if jaws is running, default is true.
bool allow_escape: A boolian specifying whether the user can press escape to exit the voice menu, default is true.
bool allow_control: A boolian specifying whether the user can press control at any time to stop the speech, default is true.
bool allow_pitch, allow_rate, allow_volume: Tells the class whether the user should be allowed to change any of the above peramitors.

Functions: 
void run(tts_voice@ handle)
void load(tts_voice@ handle)

void run(handle): Runs the options menu.
void load(handle): Load/restore the voice configuration for use with the game.

contact: 
We hope you find this script helpful. If there are any bug reports, comments, or questions, please email them to webmaster@samtupy.com. 