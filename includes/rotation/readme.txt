rotational pack readme
description: This is a small pack that I created that allows a person to easily create an fps in bgt! This provides you with not only a moving function, but distance calculations, theta calculate, a bunch of pi, quite litterily, snap functions, turn functions, and more! I also atempted a bit of 3d rotation with 90 degrees streight up, but it's not that good and doesn't have to be used. It is more ment for aiming, as actual 3d sound positioning isn't implomented. The moving code, at least does work though. 
files included: 
pi.txt: This was just something fun I put in here, enjoy 100000 digits of pi, hey, were talking about circles and stuff here, right? :D
readme.txt: This document
rotation.bgt: Contains a nice arsinal of functions used in most fps games! including snap turning, move coad, distance calculations, etc!
sound_pool.bgt: Modified sound_pool class, not much different, but allows functions to be passed to...
sound_positioning.bgt: Allows for the changing in a sound with rotation. I actually put it in sound_positioning it's self, so if for some reason you didn't want to use sound_pool, the actual sound modifying is done in sound_positioning.bgt anyway, yay!
functions and use:
rotation.bgt
constants: 
pi: contains 32 digits of pi, you shouldn't really have to use this much
north, northeast, east, southeast, south, southwest, west, northwest, half_up, streight_up, half_down, streight_down: Contains the degrees of the normal cumpis directions, sutch as east being 90 and so on. 
functions:
vector move(double x, double y, double z, double deg, double zdeg, double dir, double zdir)
peramitors: 
x, y, z: the current x, y, and z coordinates of the object that is to be moved. 
deg, zdeg: this is the angle the player would be facing in degrees, deg for the normal angle, and zdeg for the angle facing up and down(could be used for 3d bullet travel)
dir, zdir: This is ment for side stepping or walking in a different direction then what the player is actually facing. For walking forward, just use the north constant, for left, use the west constant, etc. For zdir, just usually keep it at 0 so it will go in the original direction, but if for example, you were ducking, you could use streight down, and that would make the bullet not go anywhare. Like I said 3d rotation is something you can use at your own risk and figure out at your own risk, even i'm not really using it. 
This function can be called in these other methods, same peramotirs apply. 
vector move(double x, double y, double deg, double dir=0.0)
vector move(double x, double y, double z, double deg, double dir) note that this is so if your using a 3d map but not a 3d rotation, and your x and y and z were in a vector, this would make the z value not be effected. 

return value: 
A vector with the new coordinates after the move is complete. 
remarks:
This is how you can move a player, or for that madder any other object in what ever direction you wanted to. For example, if was going east and the original x and y were 5, 5, the end result would be 6, 5. Note I havn't found a way to move in actual squares rather than triangle like things using sine and cosine, but it's not really notisable, I just wanted to throw it in there incase anyone was very picky about that. 
double calculate_theta(double deg)
peramitors: 
deg: the angle the player is facing, in degrees. 
return value:
the theta of the degrees you entered, calculated by taking deg*pi/180
double getdir(double facing)
peramitors: 
facing: The angle the player is facing, in degrees
return value: The nearest direction the player is facing.
remarks:
This returns the current direction the player is facing, changing every 45 degrees you can just use the constants. If you were facing anywhare between 45 and 90 degrees, it would return northeast, for example. 
double snapleft(double deg, int direction, double inc=45) and double snapright(double deg, int direction, double inc=45)
peramitors: 
deg: the angle the player is facing, in degrees
direction: the direction the player is facing, you can use getdir() for this
inc: the increment to snap in, default is 45 degrees. 
return value:
The new degree value
remarks:
This is usefull for if you want the user to perform a turn in a cirtain angle. It is not turning gradually, but it snapps you to exactly north, east, etc. If you set the inc value to 180, for example, it means hitting that command would turn a 180, either left or right depending on the function. Call like player_angle=snapleft(player_angle, getdir(player_angle), 180); This would cause the player to turn left at 180 degrees. 
double turnleft(double deg, double inc) and double turnright(double deg, double inc)
peramitors:
deg: The angle the player is facing, in degrees
inc: The value used to teturmin how slight the turn would be
return value: The changed degrees
remarks: This is actually what you use if you want a player to turn in a circle by holding in an arrow key. For example: player_angle=turnleft(player_angle, 1); This would turn the player one degree to the left. 
string dir_to_string(int direction)
peramitors: direction: Use the getdir function, and pass the direction the player is currently facing, or any other direction constant. 
return value: A string containing the direction you are facing such as "north", "south", etc on success, or the number in degrees you passed to the function on failure. 

remarks: This is usefull for if you want a key to check what direction the player is facing. tts.speak("you are facing "+dir_to_string(getdir(player_angle))); Note, only use direction constantses for this function or it will fail. 
double get_1d_distance(double x1, double x2)
peramitors: 
x1, the first value and x2, the second value. 
return value: The distance between the too values. 
remarks: This is a function that returns the distance between 2 values, for example if value one was 3 and value 2 was 1, the distance would be 2. 
double get_2d_distance(double x1, double y1, double x2, double y2)
peramitors: x1, y1: first set of coordinates. 
x2, y2: Second set of coordinates. 
return value: The total distance between the set's of coordinates. 
remarks: This is how you can see if a bullet hits a target, as well as get the distance from the middle of what you want to hit. if the first set of coordinates was 5 5 and the second was 2 3, the distance would be 5. 
There is a double get_3d_distance(double x1, double y1, double z1, double x2, double y2, double z2) function, but it works the same as 2d distance so I won't describe it here. It just includes z coordinates. 
double calculate_x_y_angle(double x1, double y1, double x2, double y2, double deg)
Properties:
x1, y1, x2, y1: Too different set's of coordinates to calculate the angle between
deg: The angle the player is facing, in degrees
return value: The degree difference between your position, and the amount of degrees you would have to turn in order to be directly facing the object. 
string calculate_x_y_string(double deg)
peramitors: 
deg: Get this using the calculate_x_y_angle, the degrees in a circle from 0 to 360. 
return value: A string containing the nearest direction such as slightly off to the left, a little ways off to the left, slightly behind and far off to the right, etc. 
remarks:
This is just a preset function with the nearest descriptions of the direction bassed on the degrees in a circle. For example if a point in a circle, extending from a dot in the middle was pointing at 90 degrees, it would be streight off to the right, and if it was 250 degrees, it would be slightly behind and far off to the left. The point is usually gathered from calculate_x_y_angle, which returns an angle bassed on the 2 points on a grid, similar to slope but in degrees, but also subtracts the angle by the degrees the player is facing and add's 360 if result is less than 0, but the function always returns a number that works with this function. Strings just return a direction, so you must include like of or what not, like "slightly to the left", of. alert("test", "in a circle, 270 degrees is "+calculate_x_y_string(270)+" of 0 degrees"); would return 270 degrees is streight off to the left of 0 degrees. 
sound_pool.bgt
This is almost the normal sound_pool, and it is possible to call the other functions the same way. You can still use the normal play_sound_2d or what not, so don't worry about that. Extra functions include:
int play_2d(string filename, int listener_x, int listener_y, int sound_x, int sound_y, double rotation, bool looping, bool persistent=false)
rotation is theta in radions you can use calculate theta
int play_extended_2d(string filename, int listener_x, int listener_y, int sound_x, int sound_y, double rotation, int left_range, int right_range, int backward_range, int forward_range, bool looping, double offset, float start_pan, float start_volume, float start_pitch, bool persistent=false)
again rotation is theta in radions
int play_3d(string filename, int listener_x, int listener_y, int listener_z, int sound_x, int sound_y, int sound_z, bool looping, bool persistent=false)
This just has the z peramitors as expected. Note that 3d rotation never applies with these functions. Just the possibility of 3d sound
int play_3d(string filename, int listener_x, int listener_y, int listener_z, int sound_x, int sound_y, int sound_z, double rotation, bool looping, bool persistent=false)
rotation is the player angle in radions, and it is just the normal x y angle. 
sound_positioning.bgt works almost the same, but with the position_sound_2d and 3d, you have to include rotation,  same with extended. 
void position_sound_custom_2d(sound@ handle, float listener_x, float listener_y, float source_x, float source_y, double theta, float pan_step, float volume_step, float behind_pitch_decrease, float start_pan, float start_volume, float start_pitch)
void position_sound_custom_3d(sound@ handle, float listener_x, float listener_y, float listener_z, float source_x, float source_y, float source_z, double theta, float pan_step, float volume_step, float behind_pitch_decrease, float start_pan, float start_volume, float start_pitch)

I hope this helps, and please report any bugs to me via email webmaster@samtupy.com, or in some other method of contacting me. thanks. 