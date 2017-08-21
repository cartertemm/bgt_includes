Speed stop Sound! 
Welcome to a new version of the speed stop class, this time helped by dark flier productions! 
This class atempts to rid games of the plague of speedhacking provided by things likc cheat engine, cheatomatic, etc etc. 
Use is very simple. In void main, at the beginning of your script, call: 
speed_stop_reset(true);
make sure you have the bool initial flag set to true so it loads the sound. 
Then, as constantly as you can, in every loop you will have to modify dynamic_menu.bgt etc etc, make sure you do a speed_stop check. 
bool speed_stop_is_hacking()
if(speedstop_is_hacking()==true)
{
//speedhacked! 
}
Simple as that! Warning! Make sure that silence.wav can not be tampered with! Include it in a pack file, encrypt it with bgt's flag set to true, etc etc. If someone manages to tamper with the sound and makes it really long/short, they could avoid speedhack detection entirely! You have been warned! 
With the functions speed_stop_disable and speed_stop_enable, you can pause and resume speedhack detection. speed_hack_is_hacking will always return false if is disabled. 
If you need to change the sound path: 
SPEEDSTOP_SOUND_PATH="path/to/silence.wav";

Hope this little thing helps! 