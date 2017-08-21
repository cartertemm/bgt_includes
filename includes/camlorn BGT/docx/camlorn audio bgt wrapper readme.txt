The following document explains how to use the camlorn audio wrapper that sam tupy productions and ultrosity audio calaberated to bring to you all. I have tried to make this as easy to understand as I can. Camlorn audio is a set of scripts that tries to wrap OAL (Open AL) for easier use with other languages. Basicly, it allows the positioning of sounds through the use of hrtf (Head-related transfer function), meaning 3d sounding audio.

Introduction
Camlorn audio is something me and mason had been messing with for a long long time, ever sence mason showed it to me a long time ago. We had the python wrapper and we just made random scripts that played different sounds in different positions. Camlorn even spisificly said that he wasn't going to make a wrapper in bgt, and other people said that it simply wouldn't work and looked at the project no more. I always wanted to see what it would be like if we could make a bgt version that wrapped camlorn audio, allowing any game to take advantage of it's features. Theres python, c++, and a dll that allowed me to make this in bgt and that will allow others to make it in different languages. I would sometimes when I was board, just stair at the brief dll documentation that camlorn provided with the camlorn audio package. Back then I just thought, what if, I could get something like this to work. Everyone knows that bgt's dll support is far from production quality, but it's defenatly not useless. And finily I said to heck with this and gave it a try. This was several months from the release date. And you should know that back then, my dll skills in general, especially with use with bgt, were very offle. I just used what I knew, and this is the end result. Months of work, trying to intigrate this dll with bgt propperly. Well, I finily did it, after a long, long time. Then once I got sounds to play and position, as well as reverb, that's when mason aka ultrosity audio came in. He finished wrapping some of the classes based on the code i'd written, saving me a lot of time. He also found a formula to convert the samples into length in milliseconds. Then he made the important function of packing sounds and encrypting them, a feature that many people would want. It allows you to add files to sounds.dat for example, encrypt them, and though it's slightly laggy and puts a bit of strain on the harddrive, it works! Me being a developer, I want to help other developers, so I have given this package to anyone who would like it. 

Warnings
Camlorn Audio's Ogg support is extremely iffy, so if your sounds start clipping or distorting for any reason, change the sounds to wav.
You must use mono sounds. Stereo sounds will not load.

Important notes! 
Camlorn has said many times that camlorn audio is not ment for production use. I found a later version of the dll threw an NVDA addon that used it and it fixed a lot of previous bugs, plus the addon was out there in the general public if that provides some closure, but I figured it would be rong not to throw his warning in there, sence he made and abandoned this project. 
Everything in this project has been tested, and worked on all but 1 system that I tried it with. And again this addon whare I got the improved version of the dll was out there in the public and if you want to know what it is, it is unspoken 0.1 by Camlorn and Bryan Smart. It had a later build of camlorn audio and I havn't scene many people say that it didn't work. 

Usage
There are two ways that this wrapper can be used. You can either use the wrapper directly, or you can use the sound pool class provided in includes. That sound pool is specially modified for this wrapper.

Initializing
first, of course, you must include the wrapper into your bgt script.
#include"includes/sound3d.bgt"
or
#include"includes/sound_pool3d.bgt"
If you plan to use both, you can just include the sound_pool3d.

using sound3d directly
To declare sounds, you can just type:
sound3d soundname;
Like any other variable, you can group together sounds
sound3d ambience, floorsound,wallsound;
Next, inside your void, you need to load the sound.
soundname.load("soundname.ogg");
or
soundname.load("soundname.wav");
Then, you can call any of the following functions on this sound.
Note that most of the values returned/set to these functions are just like bgt, volume is 0/100 etc. 
Note also that if an intiger function returns 0, this usually means the operations success. 
function
description

int play()
plays the sound unlooped.

int play_wait()
plays the sound and pauses script execution until the sound is done playing.

int play_looped()
Plays the sound looped.

int pause()
pauses the sound.

int stop()
stops the sound.

int close()
closes the sound and frees it from memory.

bool looping()
checks if the sound is looping.

bool playing()
checks if the sound is playing.

int set_looping(bool looping)
sets the looping of the sound to true or false.

int set_max_distance(float distance)
sets the maximum distance the sound should be heard.

int set_rolloff_factor(float factor)
sets how much the volume decreases as you move away from a sound.

int set_pitch(float pitch)
sets the pitch of the sound.

int set_volume(float volume)
sets the volume of the sound.

int seek(float position)
seeks through the sound (in MS)

int get_length()
returns the length (in MS) of the sound.

void add_reverb_effect(int r_handle, int slot=0)
Adds a reverb handle to the sound. This will be discussed later.

void add_eax_reverb_effect(int er_handle, int slot=0)
Adds an EAX reverb handle to the sound. This will be discussed later.

void add_echo_effect(int e_handle, int slot=0)
Adds an Echo handle to the sound. This will be discussed later.

void add_filter_effect(int f_handle, int slot=0)
Adds a filter handle to the sound. This will be discussed later.

int set_position( float x, float y, float z, float listener_x, float listener_y, float listener_z, double theta=0.0, bool change_volume=true)
sets the position of the sound relative to the listener.


properties
here are the properties you can check. Note, do not modify these externally, or you will have inaccurate data.
float pitch
float volume
bool active
bool paused


reverb
You can optionally add reverb to a sound or group of sounds. You first declare a reverb3d at the top of your script.
reverb3d reverb;
after this, in your main void, set the reverb up. you do this by calling the following functions. Note, prepend these functions with your reverb class, for example reverb.set_diffusion()
These functions usually have a range of 0 to 1. such as 0.5.

function
description

set_reverb_density(float value)
sets the reverb density. This is how quickly the reverb sounds play. The higher this number, the more alley-like or street like it sounds.

set_diffusion(float value)
Sets how quickly the individual reflections play. at 0, it sounds more like an echo. at 1, it sounds like reverb.

set_gain(float value)
sets how loud the reverb is.

set_gain_hf(float value)
sets the high pass of the reverb.

set_decay_time(float value)
sets how long the reverb takes to fade completely out.

set_decay_hf_ratio(float value)
sets the damping of the reverb.

set_reflections_gain(float value)
sets how loud the reflections are.

set_reflections_delay(float value)
sets the delay of the reflections.

set_late_reverb_gain(float value)
sets the secondary reverb's gain.

set_late_reverb_delay(float value)
sets the secondary reverb's delay.

set_air_absorption_gain_hf(float value)
sets how much air absorbtion the reverb has.

set_room_rolloff_factor(float value)
sets how far a sound has reverb from.

set_decay_hf_limit(int value)
sets the high pass limit of the decay.


properties
Here are the properties you can get access to. Note, do not modify these.
float current_reverb_density;
float current_diffusion;
float current_gain;
float current_gain_hf;
float current_decay_time;
float current_decay_hf_ratio;
float current_reflections_gain;
float current_reflections_delay;
float current_late_reverb_gain;
float current_late_reverb_delay;
float current_air_absorption_gain_hf;
float current_room_rolloff_factor;
float current_decay_hf_limit;
int handle Warning! Modifying this value will cause the sound to completely fail!
To add reverb to a sound, you must access the handle. This is in the handle property. You call soundname.add_reverb_effect(reverbname.handle);

eax reverb sounds the same as reverb, but it has more functions. We can't figure it out, so if you want go ahead and experiment with that on your own.


Filter works the same as reverb, but instead of adding reverb, it adds a filter to the sound.

filter3d filter;

functions

function
description

set_filter_type(float value)
sets the type of the filter.

set_gain(float value)
sets the sound's volume.

set_gain_hf(float value)
sets the filter's high pass gain.

set_gain_lf(float value)
sets the filter's low pass gain.
To add this to a sound, it is the same as in reverb, accept you get the filtername.handle, and it is add_filter_effect, not add_reverb_effect. 

echo
You can add echo, but honestly it sounds horrible and doesn't fade as you move away from a sound.
echo3d echo;

functions

function
description
set_delay(float value)
sets the delay.

set_lr_delay(float value)
sets the left/right delay.

set_damping(float value)
sets the echo's damping

set_spread(float value)
sets the spread (stereo immage) of the echo.

set_feedback(float value)
sets the feedback (echo amount).


properties
float current_delay;
float current_lr_delay;
float current_damping;
float current_spread;
float current_feedback;


using sound_pool3d
If you don't know how to use sound_pool, read the documentation on that before attempting to use this class, as it works the exact same way. There are however a few added functions.


function
description
current_reverb=reverb_handle
sets the reverb handle of the sound_pool. To get that, use reverb3d.handle

Then there is a play_3d function, works the same as 1 and 2d with the added Z coordinates, and for extended, adds the up/down range. 


Reverb handler
This is something that allows you to have the reverb change based on whare your reverb point is, such as an entire room. If the room had a door and you walked out of the door, the reverb shouldn't suddenly disappear, it should fade out every step you take. Note that this code isn't quite as clean as the rest of the code and is uncommented, simply because I ment this more for personal use, but decided to thorw it in here anyway.  You can include the script: #include "includes/reverb_handler.bgt" and it works like this
function
description
void add_reverb_handler(int rmin_x, int rmax_x, int rmin_y, int rmax_y, int rmin_z, int rmax_z, float rgain=0.5, float rdecay_time=1.0, float rmax__distance=5)
This is how you load up a reverb handler. You can either just add this or load from a map parser. Just call the function, replacing the variable names with there respective value. If need be, consult the section that deals with reverb if you don't know what some of these functions do. One note, max distance is how you set the max distance of the room. So basicly if the max distance was 5 and you were 1 square beyond the coordinate limits, the reverb would play at 80 percent volume with 80 percent defusion. So if it's set to 5, each step you take away decreases this value by 20 percent until of course they each are 0. You can experiment with this if you do not get whare i'm coming from
void reverb_handler_loop(reverb3d@ temp_reverb, int x, int y, int z)
you must call this as you would any other game loop be it enemies, items etc. Basicly you must call this as one of the main loops of your scripts for the reverb to change. X y and z are the players current coordinates. The handle is just a normal reverb3d handle

And that's litterily all there is to reverb_handler!

You can submit any bug reports to the audiogames.net forum or by emailing webmaster@samtupy.com
Enjoy this package!