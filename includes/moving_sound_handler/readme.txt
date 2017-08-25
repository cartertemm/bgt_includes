Moving Sound Handler Pack.
Written by Colton Hill

This is a set of scripts designed with the purpose of having server controlled sounds that can be created, destroyed, and position updated.
This can be used for more than just sounds you want to move. I used it to create and destroy stationary sounds I wanted looped, the applications are nearly limitless.
current limitations:
the range feature of the sound pool is not supported, thus meaning the potential application of a spreading fire, for instance, could not be created via this handler.
the 2d and 3d versions were built for different games, having different needs. The 2d, the original, does not support the newer excluded player/owner and pitch features that the 3d one has, and the 3d version does not adapt the automover wrapper system built in to the 2d version.
Any moving sounds created cannot change maps once created serverside. However, there is experimental support in the handlers to support switching maps client side, and updating sounds accordingly. This is only checked, however, in their update calls.
Obviously these were not designed originally as open source includes, so there are a few features that use some variables/classes that were included in these games that they were built for. The 2d version was designed for btb, and the 3d version was designed for tk. If you have a player class, which I know you definitely should, handling should be easy, just change a few names around if they don't just work.
usage:
This section is put here so you know how to use these handlers, as usage could be misinterpreted by simply examining the code without too much carefulness, and there are no comments in the classes because they were not originally intended to be open source.
The classes are simply there for data storage. Please do not attempt to interact with them directly, because a lot of the functionality you would have to code has already been provided in the global wrapper functions.
The serverside handlers include a function called randomstring at the bottom, which simply generates a randomized string of arbitrary length, default 10. This function is used by the handlers for the ID system, so that's why it's there.
Note that the 2d handlers use channel 13 and the 3d handlers use channel 4. Sending is wrapped, but not reception.
It is part of the server code of each game, that when a player logs on, to loop through the moving sound objects and send them creation packets. This is the only time you should interact with the objects, and only to get properties.
quick examples will be provided for the global functions.
2d set:
server handler:
string spawn_moving_sound(string loop, int x, int y,string map)
creates a moving sound and tells all clients about it. The returned string is the ID of this sound, hopefully you've got a variable to hold this.
void update_moving_sound(string id, int x, int y)
updates this moving sound's position and notifies all clients about the update. Sends unreliablely to prevent net lag.
void destroy_moving_sound(string id)
kills this moving sound and notifies clients of it's death so they can kill their sounds.
To destroy all, loop through all msounds and call destroy on the server.
A wrapper is also provided called automover, though documentation will not be given here. Just look at it.
client handler. These functions should be called once a packet is received with specified information:
void createmsound(string id, string loop, int x, int y,string map)
creates a local copy of a sound, handling sound pool stuff.
void updatemsound(string id, int x, int y)
updates it's position and recalculates map checks.
void destroymsound(string id)
deletes this sound and frees it from the pool.
void destroy_all_msounds()
removes all moving sounds. Nice for reset.
3d set:
server handler:
string spawn_moving_sound(string loop, int x, int y,int z,string map,string owner="",double pitch=100)
creates and notifies.
the owner parameter is a player who will not receive these packets, good if you want to add a system where they just get stationary so it doesn't kinda jump when they move.
Pitch is self explanitory.
void update_moving_sound(string id, int x, int y,int z,double pitch=-1)
same as above for updating. -1 for pitch means no change.
void destroy_moving_sound(string id)
same as above.
the automover wrapper is not adapted to this version, however the code is there in a block comment. Adapt it if you wish.
client handler:
void createmsound(string id, string loop, int x, int y,int z,string map,double pitch)
same as above. Does not process owner parameter because the server did that for us.
void updatemsound(string id, int x, int y,int z,double pitch)
same as above. -1 for pitch does not work here, the server already took care of that one.
void destroymsound(string id)
void destroy_all_msounds()
same as above.
Enjoy these handlers! They really can come in handy if you know what you're doing.
extra notes:
The 3d system's owner/pitch attributes were designed for a vehicle system, where the player would simply receive a packet that would cause the client to stationary loop the engine sound, while everybody else would hear the external engine. The pitch part was designed for the speed of the vehicle.
The 2d system's automover is fun, because it has the ability to hurt players. You'll wanna edit that spot though, as that style of hurting was pretty much specific to up and clones. Also note that since 2d automovers have no owner, they will hurt anybody! If you want to have bullets with a loop, just attach the core to your bullet class.
I do hope that this code will come very useful to somebody someday so I can know it wasn't all a waste of coding skills designing it for it's original purpose, shitty clone games by ivan.