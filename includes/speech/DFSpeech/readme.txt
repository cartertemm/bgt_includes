DFSpeech
A speech wrapper class for BGT.
Created by DarkFlier productions, 6/20/2016.

This class intends to make it easier for people to implement propper speech support into their games, rather it be auto select a screen reader or switch to SAPI. There are many controls here in which we can use to do so.

Variable listing
Here is a list of the variables you can change to get different outcomes.
string filename
the filename of the settings stored for your speech.
example: s.filename="voice.dat";

string buffer
the output for the speech buffer. If this is set to empty, buffer support will be disabled.


Function list

bool say(string text, int interrupt=1, bool wait=false)
Simple say function. Use this to speak some stuff.
example: s.say("This is a test.");

void bufferloop()
A loop you can call within your game loop to enable buffer navigation if you have buffer enabled.
example: s.bufferloop();

bool set_voice(int v)
Set the SAPI voice.
example: s.set_voice();

int select_voice()
Bring up a menu where the user can select their prefered SAPI voice.
example: s.select_voice();

bool save()
Save your voice settings into your previously selected voice file.
example: s.save();

bool load()
Load your voice settings from your previously selected voice file.
example: s.load();

void set_speech_params(int r, int p, int v)
Set the parameters for the tts voice. R is rate, P is pitch, V is volume.
example: s.set_speech_params(0,0,-5); would set the volume to -5.

void set_speech_mode(int m)
Set the speech mode. 0 is auto, 1 is SAPI.
example: s.set_speech_mode(0);

I hope you get some use out of this class.
If you have bug reports or suggestions, contact me.
www.darkflier.com under the contact heading.

Copyright 2016 DFProductions.