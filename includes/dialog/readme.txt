DIALOG CLASS
Created by Burak Yüksek
This class allows you to create timed or untimed dialog boxes.
Properties:
string closes:
Adjusts the sound that plays when the dialog closes.
string opens:
Adjusts the sound when the dialog box opens
If those strings are left blank, no sound will be played.
int time(enter in  milliseconds):
Adjusts the time of the dialog box.
bool copyable:
This sets whether the text in the dialog can be copied with the c key or not.
void set_speech_mode(int reader):
Reader is the same as screen reader functions in bgt.
void create(string text):
Sets the text of the dialog.
An example is included in the example.bgt file.
lisence:
You can motify the script as you like, but please give credit where it is needed.
Enjoy, I hope you can get some use out of it.