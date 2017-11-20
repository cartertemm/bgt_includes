
browser.bgt:

string select_file(string top, custom_voice@ voice);

Parameters:
 top : the top-level directory
  voice: the custom_voice to use for spoken feedback
Return value: the selected file, or an empty string on cancel.

Example:

#include "browser.bgt"

 void main() {
custom_voice voice("voice.cfg");
 string selectedFile=select_file("c:\\");
 alert("Selected file", "You selected " + selectedFile + ". ");
}

custom_pool.bgt:

--- alternate version of the sound_pool class. If custom_pool.bgt and sound_pool.bgt are both included, the compiler will flag a name conflict.
--- This version of sound_pool should be compatible with the default version, with these differences:

Properties:
double behind_volume_decrease : the amount by which the volume of a sound is decreased if it is behind the listener.

Methods:

 void update_angle(double theta)

Parameters:
 double theta: the angle of the listener, in radians.

This method will change the listener angle while leaving everything else unaffected. All sounds should immediately update according to the new angle.

void update_listener_2d(int x, int y, double theta)

Parameters:
 int x : the x coordinate of the listener
 int y : the y coordinate of the listener
 double theta : the angle of the listener

All playing sounds will be updated to reflect their new relative positions, relative to the listener angle.

example:

#include "custom_pool.bgt"

void main() {
sound_pool pool;
 pool.behind_volume_decrease=-5;
 pool.behind_pitch_decrease=2.5;
 pool.play_2d("c:\\windows\\media\\ding.wav", 0, 0, 5, 5, true);
 double theta=0;
 while(!key_pressed(KEY_ESCAPE)) {
// Rotate continuously.
 theta +=0.01;
 pool.update_angle(theta);

 // If we've made a complete rotation, adjust listener position and return angle to 0.
 if(theta>=2.0*pi) {theta=0.0; pool.update_listener_2d(random(-5, 5), random(-5, 5), theta);}
 wait(5);
}
}



Custom_voice.bgt:

 functions:
 int lastIndexOf(string to_search, string to_find)

Parameters:
 string to_search: the string that will be searched
 string to_find: the pattern to search for inside to_search

return value:
The last index in to_search where to_find occurs, or -1 on failure.

Example:

void main() {

string str="It is time that I test.";
 alert("The last I", "The last occurance of I in the string is " + lastIndexOf(str, "I") + ". ");
}



custom_voice

This class provides methods for speaking using sapi, screen readers, or a word_speaker.

Constructors:

custom_voice()

Parameters: none
creates a custom_voice with default settings.

custom_voice(string cp)

parameters:
 string cp: the filename of a configuration file (can be relative or absolute).
Creates a custom_voice and attempts to load configuration information from the specified file, if it exists.


Methods:
Most of the tts_voice methods for speech remain the same.

void options_menu()

parameters: none

This allows the user to adjust voice settings. If config_path is set, the changes will be saved to the specified file for later use.


Example:

#include "custom_voice.bgt"

// Create a custom_voice, let the user set its options, then speak a message before exiting.

void main() {
 custom_voice voice;
 show_game_window("Custom voice test.");
 voice.options_menu();
 voice.speak("Thank you. Is this what you wanted?");
 while(voice.isSpeaking()) wait(100);
 }


void set_rate(int rate)

parameters:
 int rate: the desired voice rate

This sets the rate of speech for sapi, or adjusts screen_reader_wait_factor if in screen reader mode.

 bool load_config()
return value:
 true on success, false otherwise.

Attempts to load configuration from the file specified by config_path.

example:

void main() {

custom_voice voice;
 voice.config_path="voice.cfg";
 voice.load_config();
}

bool load_config(string cp)

Parameters:
 string cp: the file to load from

return value:
 True on success, false otherwise.

This method attempts to load voice settings from the specified file.
This does not change the value of config_path, so could be used to load from different files without changing the primary file associated with this voice.

Example:

void main() {
 custom_voice voice;
 bool result=voice.load_config("voice.cfg");
 if(result==true) alert("Success!", "Voice settings were successfully loaded.");
 else alert("Error", "Voice settings could not be loaded.");
}


void save_config(int x)
Parameters:
 int x: the sapi voice to use, or -1 for screen reader.

This method will save the current settings of this voice to the file specified by config_path.

Example:

// create a custom_voice, and have it save its settings with the active screen reader as the desired voice.

void main() {

custom_voice voice;
 voice.config_path="voice.cfg";
 voice.save_config(-1);
}



void save_config(string cp, int x)

parameters:
 string cp: the file where settings should be saved.
 int x: the index of the sapi voice, or -1 for screen reader.

This method does not alter config_path.

Example:

void main() {

 custom_voice voice("settings1.ini");
 voice.save_config("settings2.ini", -1);
}


bool isSpeaking()

Returns true if the voice is speaking, or if screen_reader_wait_factor predicts that it is speaking, false otherwise.


void update()

This method keeps the status of the screen reader predictions and word_speakers up to date.
If you want to enable word_speakers as an option, this method should be called frequently.



Properties:

 bool sapi: If this is set to false, the voice will attempt to use the active screen reader, or the window title if none can be found.
 double screen_reader_wait_factor: this value is used to predict how long a screen reader will take to speak a message, based on the length of the text. The higher this value, the longer a screen reader is expected to take to speak.
 int pitch: attempts to modify the pitch of spoken feedback using sapi XML. Screen reader output ignores this property.
string config_path: the default file where settings will be saved or loaded from. The default is an empty string (equivalent to none).


word_speaker:

This class will attempt to read words or phrases by searching for associated sound files in the specified folder.
In order for this class to behave correctly, the update method must be called frequently once speech has begun.

* Note. Many planned features have not yet been implemented.


Properties:
Notice that many of these properties do not currently take effect.
 string current_text; // The text in progress. This value should not be modified from the script.
 string[] current_words; // Words that have yet to be spoken. The speak methods should parse an incoming sentence and populate current_words before speech begins. This value should not be modified from the script.
 vector source; // Position of this sound.
 vector listener; // Position of the listener.
 float pan_step; float volume_step; float behind_pitch_decrease; float behind_volume_decrease; // Properties used for positioning sound.
 float angle; // the angle of the listener.
 float start_pan; float start_volume; float start_pitch; // Start values.
 bool auto_inflect; // Flag that determines whether the speak methods should attempt to alter pitch/volume to simulate inflection.
 string dir; // The directory where the word_speaker will look for sound files. Default is "", that is, the directory from which the script is launched.
 string extention; // ".wav" or ".ogg" are legal values. Default is ".wav"


 // The following can be used to add pauses corresponding to punctuation.
 timer pause_timer; // This timer should not be altered from outside of this class.
 // Set the following values to 0 if you do not want to automatically pause for punctuation.
 double comma_pause; // The same delay is used for parentheses, brackets, etc.
 double period_pause; // Used for misc punctuation, such as ? and !.
 double semi_pause;
 double colon_pause;


Constructors:

word_speaker()
Constructs a word_speaker with default parameters.

word_speaker(string d)
 Constructs a word_speaker and sets the directory containing the sounds to d.

void speak(string text)

Parameters:
 string text: the text to be spoken.

This attempts to speak the given text, appending it to any text waiting to be spoken.
Notice: this will attempt to start speech, but in order for it to continue, the update method must be called frequently.

void speak_interrupt(string text)

Parameters:
 string text: the text to be spoken

This method will stop all speech in progress before speaking the given text.


void stop()
 Stops any speech in progress and clears any text waiting to be spoken.


 void set_positioning_properties(sound_pool@ pool)
 This method sets the sound_positioning properties of this word_speaker to match those of the given sound_pool.

Notice: this method expects the sound_pool found in custom_pool.bgt.


void update()

Updates the word_speaker, including changes to the sound or listener positions or positioning properties, and attempts to speak the rest of the text if there is any yet unspoken.
This method should be called frequently once a word_speaker has started speaking.

Example:

// Create a word_speaker, have it speak some text, and give the user the option of entering more text or exiting.

 void main() {

 word_speaker speaker("voice/");
 show_game_window("Word speaker test.");
alert("Word Speaker test", "Press space bar to enter some text, or escape to exit.");
 speaker.speak("Hello, I will tell you everything I know, or no.");

 while(!key_pressed(KEY_ESCAPE)) {
 if(key_pressed(KEY_SPACE)) {
 string text=input_box("Enter text", "Enter some text for speaking, or press escape to stop speech.");
 if(text!="") speaker.speak(text);
 else speaker.stop();
}
 speaker.update();
 wait(5);
}
}


math.bgt

Contains additional math-related functions and variables.

Constants:
double MAX_VALUE: the maximum non-infinite value for a double.
double MIN_VALUE: the minimum non-infinite value for a double.
double pi: pi, accurate to 8 decimal places.
double PI: (all caps) pi, accurate to 32 decimal places.


Functions:

int32 vectorhash(vector v, uint depth=10)

Parameters:
 vector v: the vector to be hashed
 uint depth: the bit-depth of each part of the vector, must be greater than 0 but no greater than 10.

Return value:
 A 32-bit integer representing the given vector.

This function is intended to provide a unique integer to reference an arbitrary vector. This would be useful if you needed to organize a collection of 2d or 3d values in a 1d array.

There are situations in which this function could return the same value for two different vectors, but this is rare with all but the lowest values for depth.
If you can safely predict a maximum range for the components of your vectors, you could predict the smallest depth that would be likely to guarantee a unique hash for each vector. This would be the nearest power of 2 above the maximum component range, though in practical terms the closest power of 2 should be sufficient regardless of whether it is greater or less than the maximum component range.

Example:

#include "math.bgt"

//Create an array of vectors sorted into hash order.
// This example isn't particularly useful; a better use would be to speed up collision detection in an object-based world by simulating a tile-based world using hashes for indeces.

void main() {

int depth=4; // This is likely too small for any realistic use of hashed vectors.
 vector[] vectors(8192); // The depth refers to each component of a vector. With three components, this means the hash will utilize the bottom 12 bits, meaning the highest possible value would be 2^13-1.

for(uint i=0; i<100; i++) {
 vector v(random(0, 16), random(0, 16), random(0, 16));
 int hash=vectorhash(v, depth);
 if((hash<0)||(hash>=vectors.length())) alert("Hash out of bounds", "The hash for " + v.x + ", " + v.y + ", " + v.z + " is out of range: " + hash + " is not between 0 and " + vectors.length() + ". ");
 else vectors[hash]=v;
}
alert("Done", "100 vectors were organized. In an array with nearly 82 times the capacity.");
}



void init_trig()

This populates arrays with precalculated trigonometric values to speed up trig function calls.
This function should only be called once, however if one of the functions dependent on this one is called first, it will be called automatically.


void trigcheck()
This function checks the arrays of trig values, and if any are not the appropriate length, calls init_trig.
This function is called by the trig functions to avoid potential index out of bounds errors.


double sin(double theta)
double asin(double theta)
double cos(double theta)
double acos(double theta)
double tan(double theta)
double atan(double theta)

Parameters:
 double theta: the angle to calculate, in radians.

Returns the trig values associated with each function.
The values are calculated and stored with the first call to init_trig. The purpose of these functions is to save processing time that recalculating trigonometric functions whenever needed would incur. If a script requires a large number of trig functions often, this might help to reduce possible lag by a small amount.


Example:

#include "math.bgt"

// Perform several calculations and return which is faster.
void main() {

init_trig();
timer t;
 for(uint i=0; i<10000; i++) {
 double a=sin(0.5);
 double b=cos(3);
 double c=atan(0.707);
 a=b*c;
}
 double result=t.elapsed;
 t.restart(); t.resume();
 for(uint i=0; i<10000; i++) {
 double a=sine(0.5);
 double b=cosine(3);
 double c=arc_tangent(0.707);
 a=b*c;
}
double res2=t.elapsed;
alert("Results", "30000 trig operations took " + res2 + " milliseconds when recalculated, and " + result + " when stored values were used.");
}


 vector rotate(vector p, vector o, double theta)

Parameters:
 vector p: the point to be rotated
 vector o: the point around which p will be rotated.
 double theta: the angle of rotation, in radians.

return value:
 A vector representing p after being rotated around o by theta radians.


vector cross(vector a, vector b)
 return value:
 The cross product of a and b.


double dot(vector a, vector b)
Return value:
 The dot product of a and b.




sound_positioning.bgt:

--- Exactly the same as the default sound_positioning.bgt in bgt/includes, except that position_sound_2d and related functions take an additional parameter to represent behind_volume_decrease.

void position_sound_2d(sound@ handle, int listener_x, int listener_y, int source_x, int source_y, float pan_step, float volume_step, float behind_pitch_decrease, float behind_volume_decrease=0)
void position_sound_custom_2d(sound@ handle, int listener_x, int listener_y, int source_x, int source_y, float pan_step, float volume_step, float behind_pitch_decrease, float behind_volume_decrease, float start_pan, float start_volume, float start_pitch)


Geom.bgt

Contains classes, functions and variables for working with geometry. Mostly euclidian.

// Documenting this will take days. Let's wait until it's actually complete.

interface Shape: Most 2d Shapes implement this interface, and thus include the following:
 Rectangle@ getBounds()
 - Returns a Rectangle in which the shape is contained.

bool contains(double x, double y)
- Returns true if the point (x, y) is contained in the shape, false otherwise.
 bool contains(vector p)
- Returns true if the given vector is within the shape, false otherwise.
 bool intersects(double x, double y, double w, double h)
 - Returns true if the given shape intersects the rectangle defined by (x, y, w, h), false otherwise.
 @param x : the x coordinate of the top-left corner of the rectangle
 @param y : the y coordinate of the top left corner of the rectangle
 @param w : the width of the rectangle
 @param h : the height of the rectangle

 bool intersects(Rectangle@ r)
 - Returns true if the given rectangle intersects this shape, false otherwise.

 bool contains(Rectangle@ r)
 - Returns true if the given Rectangle is completely within this shape, false otherwise.

 bool contains(double x, double y, double w, double h)
 - Returns true if the rectangle specified by (x, y, w, h) is contained within this shape, false otherwise.

 PathIterator@ getPathIterator(AffineTransform@ at)
 - Returns a PathIterator describing this shape, transformed according to the given AffineTransform.

 PathIterator@ getPathIterator(AffineTransform@ at, double flatness)
 - Returns a PathIterator describing this shape, transformed by the given AffineTransform, using the specified flatness value for evaluating curves.


 functions:
 vector lineIntersects(vector p1, vector p2, vector p3, vector p4)
 Parameters:
 p1 : the first end point of the first line segment
 p2 : the second end point of the first line segment
 p3 : the first endpoint of the second line segment
 p4 : the second endpoint of the second line segment

 Return value:
 A vector representing the point where the given segments intersect, or nullpoint if they do not intersect.

Note: nullpoint is a vector constant. Use isNull(vector v) to compare a returned vector to nullpoint.

bool isNull(vector v)
 - Returns true if the given vector matches nullpoint, false otherwise.

Example:

#include "geom.bgt"

// Check to see if two segments intersect
void main() {
 vector p1(0, 0);
 vector p2(5, 5);
 vector p3(0, 5)
 vector p4 (5, 0);
 vector val=lineIntersects(p1, p2, p3, p4);
 if(isNull(val)) alert("Results", "These segments do not intersect, which is odd, since they should represent an x.");
 else alert("Intersection found!", "These segments intersect at " + val.x + ", " + val.y + ". ");



vector newVector(double x, double y, double z=0)
 - A convenience method for creating vectors. The z parameter is optional and defaults to 0.


Classes that implement Shape:

Rectangle
QuadCurve2D
CubicCurve2D
Line2D
Arc2D
Ellipse2D
Polygon


Rectangle:
Properties:
 x, y, width, height
 constructor:
 Rectangle(float x, float y, float width, float height)
Methods:
 bool collide(Rectangle@ r)
 - Returns true if the given rectangle and this rectangle collide, false otherwise.
 bool intersectsLine(double lx, double ly, double lx2, double ly2)
 - Returns true if this rectangle intersects the line with endpoints at (lx, ly) and (lx2, ly2), false otherwise.
 void moveTo(float tx, float ty)
 - changes this rectangle's x and y properties to match the parameters.
 void moveBy(double dx, double dy)
 - Moves this rectangle by the distance described by the parameters.
vector[] getPoints()
 - Returns an array containing a vector for each corner of this rectangle, starting at (x, y) and moving clockwise (if positive y is up), counterclockwise if positive y is down.

 Rectangle@ clone()
- Returns a copy of this rectangle.
 Rectangle@ rotate()
- Returns a copy of this rectangle that has been rotated 90 degrees about (x, y).


Arc2D:
Properties:
  double x : the x coordinate of the bounding Ellipse of this arc
  double y : the y coordinate of the bounding ellipse of this arc
  double width : the width of the bounding ellipse
  double height : the height of the bounding ellipse
  double start : the start angle of the arc (in radians)
  double extent : The size of the arc (in radians).
  int type: The type of the arc, which must be one of the following constants :
     Arc2D_OPEN : indicates that this arc is not closed
    Arc2D_CHORD : this arc is closed by a line drawn between the start and end of the arc.
    Arc2D_PIE : line segments are drawn from either end of the arc to the center of the bounding ellipse. Hence, it kinda looks like a pie.


Polygon:

 Methods:
void addPoint(int x, int y)
 - adds the point (x, y) to this polygon.
 - Polygons are designed to work with int precision, though I have no idea why.


AffineTransform:
 This class represents transformations of shapes, such as translation, rotation, scaling and shearing.
 I am indeed confused on how one would go about combining these operations.
The simplest methods are:

 void rotate(double theta)
 - Sets this AffineTransform to have a rotation of theta (radians).
 void translate(double tx, double ty)
 - Sets the translation of this AffineTransform to (tx, ty). Useful though this one is, how exactly it works confuses me.
 void scale(double sx, double sy)
 - Sets the scale value of this Affine Transform. For example, at.scale(2.0, 1.0) would set this transform to double the width of any shapes that pass through it.
 Shape@ createTransformedShape(Shape@ s)
 - Returns a transformed version of the specified shape.

Example:
 #include "geom.bgt"

// Create an arrow, then rotate it until it hits a rectangle.
 // We use constants from Math.bgt, since geom.bgt includes Math.

void main() {
 show_game_window("Ticking arrow");
 Polygon p;
 p.addPoint(0, 0);
 p.addPoint(5, 0);
 p.addPoint(5, -5);
 p.addPoint(10, -2);
 p.addPoint(5, 9);
 p.addPoint(5, -4);
 p.addPoint(0, -4);
 p.addPoint(0, 0);
 Shape@ s=p;
 AffineTransform at;
 at.rotate(PI/6);
 Rectangle@ r=newRectangle(-6, -4, 4, 4);
 int ticks=0;
 while(!s.intersects(r)) {
 @s=at.createTransformedShape(s);
 ticks++;
 if(key_pressed(KEY_ESCAPE)) exit();
 wait(100);
}
 alert("Done!", "The arrow struck the box after " + ticks + " ticks.");
}



Note:

Browser.bgt includes custom_voice.bgt for feedback.
Custom_voice.bgt includes custom_pool.bgt for the sake of word_speaker.
custom_pool includes both sound_positioning.bgt (for positioning sounds) and math.bgt (for rotation).
So, would including browser.bgt provide access to custom_voice, custom_pool, sound_positioning and math, all with a single include statement?


3d.bgt:

Contains classes and functions for working with 3 dimentional shapes.

interface Shape3D:
--- All classes in 3d.bgt implement Shape3D unless otherwise specified, so you can expect them to include these methods.

Box:
--- Represents a rectangular or right triangular prism, defined by a corner and dimentions, with an optional slope property to indicate the direction of a slope.


Cylinder:
--- Represents a circular cylinder. The line segment formed by the centers of the faces is always parallel to one of the three axes.

Sphere:
--- A sphere, defined by a center and a radius.

Line3D:
--- A 3 dimentional line segment, specified by a start and end point.

CappedConic:
 * extends Line3D
--- A shape with a Line3D as a central axis. A crossection with the central axis as a normal will always be a circle, with a radius defined by the equation r=r1+k*(r2-r1), where r1 is the radius at the start point of the axis, r2 is the radius at the end point, and k is the ratio of the length of the axis at the given point.
-- Or if you'd prefer, a cone with the tip rounded off wherever you like. If r1 or r2 is 0, it is effectively a cone.


Functions:

distance3d
Returns the distance between two points, given as vectors:
double distance3d(vector p1, vector p2)
Or as coordinates:
double distance3d(double x1, double y1, double z1, double x2, double y2, double z2)

gen_collide(Shape3D@ s1, Shape3D@ s2)
A general function for checking if two arbitrary 3d shapes collide.
This is accomplished by iterating along the segment formed by the centers of the shapes, and returning false if a location is found where the segment is not touching either shape.
This function is not completely reliable; if it returns true, the shapes collide, however there are cases in which it will return false, but the shapes might still collide.
For instance, two cones standing side-by-side, that overlap slightly at the base, will be treated as not colliding by this function, since the segment from center to center never crosses the region of intersection.
Thus, it is recommended to use the collide methods of a given shape.

 vector linePointIntersection(vector p1, vector p2, vector pX)
Parameters:
 p1 : an end point of a line
 p2 : a second endpoint of the line
 pX : the point to extend.
Return value:
 A vector representing a point satisfying the following:
- The line segment passing through it and pX is perpendicular to and intersects the given line segment.


examples:

#include "3d.bgt"
#include "sound_pool.bgt"

 // Let the user move a sphere around inside a box.
 Box@ b;
 Sphere@ s;
sound_pool pool;

void main() {

 @b=newBox(-10, -10, -10, 20, 20, 20);
 @s=newSphere(0, 0, 0, 1);
 show_game_window("Sphere-in-a-box. Use the arrow keys, page up and page down to move. Press escape when done.");

 while(!key_pressed(KEY_ESCAPE)) {

 if(key_pressed(KEY_LEFT)) move(-1, 0, 0);
 else if(key_pressed(KEY_RIGHT)) move(1, 0, 0);
 else if(key_pressed(KEY_UP)) move(0, 0, 1);
 else if(key_pressed(KEY_DOWN)) move(0, 0, -1);
 else if(key_pressed(KEY_PRIOR)) move(0, 1, 0);
 else if(key_pressed(KEY_NEXT)) move(0, -1, 0);

wait(5);
}

}

bool move(double dx, double dy, double dz) {

 s.moveBy(dx, dy, dz);
 if(!s.collide(b)) {
 vector c=s.getCenter();
 s.moveBy(-dx, -dy, -dz);
 pool.play_2d("c:\\windows\\media\\ding.wav", c.x, c.z, c.x+dx+(dx*s.radius), c.z+dz+(dz*s.radius), false);
}
 return true;
}


FiniteStateMachine.bgt:

This file contains an interface and a superclass for working with FiniteStateMachines.

A finite state machine is an object that is in one particular state at any given time.

In game-development terms, a finite state machine could be something like an enemy, a player character, a moving object, a trap, etc.
Most finite state machines will contain at least two properties: the current state (represented as an int), and a counter (usually a double) that keeps track of how long the FSM is expected to remain in the current state.

The FiniteStateMachine interface contains the methods common to FiniteStateMachines.
Defining all of these whenever a FiniteStateMachine is needed would be tedious, however, so a default superclass, FSM (all caps!) is included.
FSM implements FiniteStateMachine, including both a state and counter.
The step method (see the methods specification below) handles adjusting counter and calling the appropriate methods for each case.
The defaults for these methods either do nothing, or reset state to 0. You can override these methods if you need them to do other things, but generally there will be a few methods that you won't have any reason to override, making extending the FSM class easier than writing an implementation of FiniteStateMachine.


Methods:

bool setState(int s)
 Parameter:
 s, the state to set.
 Return value:
 true if the state was set successfully, false otherwise.
If extending FSM, you will probably want to override this method, as it always returns true and does not change counter.


int getState()
 Return value:
 The state of this FiniteStateMachine

Most FiniteStateMachines will simply allow you to reference this.state, but since this is not required, the getState method is included in the interface.


void step(double dt)
 Parameter:
 dt : the amount of time that will pass. Units are arbitrary, but milliseconds may be assumed for easier working with timers.

Generally, setState and step are the only methods a game should need to use in order to use a FiniteStateMachine.
Step is expected to handle the behaviors of a FiniteStateMachine, including any changes in state that are not initiated by setState.

The FSM class contains a step method designed to update counter and call the appropriate methods for each case, so under most conditions there will be no need to override this method.

#include "FiniteStateMachine.bgt"
// Example.

 class test : FSM {
 test() {
 reset();
 }
 bool setState(int s) {
 if(counter==0.0)
 {
 state=s;
 counter=1000;
 }
 return (state==s);
 }
}

void main() {
show_game_window("Press space to jump.");
 test me;
 while(true) {
 if((key_pressed(KEY_ESCAPE))||(key_pressed(KEY_F4))) exit();

 if(key_pressed(KEY_SPACE)) me.setState(1);

 int s=me.getState();
 me.step(5);
 int new_state=me.getState();
 if(s!=new_state) alert("Landed", "You have returned from your jump.");
 wait(5);
}
}



The FSM class contains a method, reset(), which sets state and counter to 0. This is not part of the FiniteStateMachine interface and is included for the sake of subclasses of FSM.


void descending(double dt)
 Parameter
 dt : the time that passes

This method makes changes as necessary when the counter of a state is approaching zero from a positive number.
This method is useful if something happens continuously during a given state, such as walking.
For example, if your FiniteStateMachine contains a double property called x, the following method might handle movement:

 void descending(double dt) {
 if(state<0) x-=dt;
 else if(state>0) x+=dt;
}


void fromAbove()
 This method is for when counter reaches 0, having previously been positive.
This is typically the end of a state.
For example, if your machine is in a state for jumping, you might tell it to play a sound for landing in this method.

This method usually resets state, or decides how to change it if it does not return to a default value.

Example:

 void fromAbove() {
// assume that there is an int constant called jump with an arbitrary non-zero value.

if(state==jump) addSound("sounds/landing.wav");

 state=0;
 }



void ascending(double dt)

Similar to the descending method, but for the case when counter is negative.
(I would use negative counters to indicate stuns or recoveries, but this can be used however you want.)

void fromBelow()

Similar to the fromAbove method, except that counter reaches 0, having previously been negative.

void always(double dt)

This method is expected to fire every time that a call is made to step.
This would be useful if movement is not linked to state (if, say, your machine has a current_speed property), or if some property is constantly changing independent of state (for instance, a health-drain in a poisonous environment, or a depletion of oxygen under water).


void addSound(string fn)

This method adds a sound to be played.

FSM contains a string array of sounds waiting to be played.
One might iterate the sounds array whenever a call to step is made, and play the sounds accordingly. Remember to clear the array after playing, however (for example, if you have an instance of FSM called machine, by calling machine.sounds.resize(0); ).


An example of a simple game using FiniteStateMachine. (Note that custom_voice and its dependencies are included as well in this example.).


#include "FiniteStateMachine.bgt"
#include "custom_voice.bgt"


 class FSF : FSM {
 double hp;
 double x;
 FSF () {
 reset();
 hp=20;
 x=0;
}
 bool setState(int s) {
 if(counter==0.0)  {state=s; counter=0.25;}
 return state==s;
}
 void descending(double dt) {
 if(state<0) x-=dt;
 else if(state>0) x+=dt;
}
 void fromAbove() {
 addSound("step.wav");
 state=0;
 }
 void always(double dt) {
 hp-=dt;
}
}

 custom_voice voice;
 sound_pool pool;

void main() {
 voice.load_config("voice.cfg");
 voice.config_path="voice.cfg";
show_game_window("Finite State Machine test. Left and right to move, enter to grab health!");
FSF me;
 double ix=random(-100, 100)*0.1;
 int slot=pool.play_1d("beacon.wav", me.x, ix, true);
 while(me.hp>0.0) {
 if(key_pressed(KEY_F4)) exit();
 else if(key_pressed(KEY_C)) voice.speak_interrupt("X" + round(me.x, 1));
 else if(key_pressed(KEY_H)) voice.speak_interrupt("Health " + round(me.hp, 1));
 else if(key_pressed(KEY_F5)) voice.options_menu();
 else if(key_pressed(KEY_LEFT)) me.setState(-1);
 else if(key_pressed(KEY_RIGHT)) me.setState(1);
 else if((key_pressed(KEY_RETURN))&&(round(me.x, 0)==round(ix, 0))) {
me.hp+=10;
 pool.play_stationary("coin.wav", false);
 ix=0.1*random(-100, 100);
 pool.update_sound_1d(slot, ix);
}// got.

me.step(0.005);
 wait(5);
 pool.update_listener_1d(me.x);
 for(uint i=0; i<me.sounds.length(); i++) {
 pool.play_stationary(me.sounds[i], false);
}
 me.sounds.resize(0);
}
 alert("Time up!", "You have died to death!");
}
