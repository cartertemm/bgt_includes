my new map system.
coded by reza.jdp
this map system uses arrays to store and retreev map contents which i'm going to demonstrate briefly here:
this  is really fast on loading, ways faster than dictionaries. probably the best way i've found so far, and as you can see, it's just the 3d version.
so, let's go!

void spawn_tile(int x1, int x2, int y1, int y2, int z1, int z2, string tile)

parameters:
int x1: the minimum x coords the tile will spawn.
int x2: the maximum x coords the tile will spawn.
int y1: the minimum y coords the tile will spawn.
int y2: the maximum y coords the tile will spawn.
int z1: the minimum z coords the tile will spawn.
int z2: the maximum z coords the tile will spawn.
string tile: the tile type (the file name for the tile type you've stored)

remarks:
this function  stores tiles for the map.

string gt(int x, int y, int z)

parameters:
int x: the x value to retreev the tile from.
int y: the y value to retreev the tile from.
int z: the z value to retreev the tile from.

remarks:
this method  retreevs the tile type for the specified coords so that you can have conditions based on the tile type.

void playstep()

parameters:
none.

remarks:
this function will play the tile sound for the current "me" vector.

i've included sound pool, and declared the "me" vector so you can freely include this into your projects.
and here's the end :)!
hope you can all make very good and mesmerising uses of this little file i've coded.
by the way, you can contact me using these methods:
email: reza.jdp@gmail.com
skype: reza.jdp
please introduce yourselves in the introductory message.