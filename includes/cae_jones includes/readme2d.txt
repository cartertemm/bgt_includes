
Functions:
new_vector(x, y, z=0)
- Utility function for creating vectors.

double rad_limit(double theta)
parameters:
double theta - the angle to test, in radians
return value:
A double between 0 and 2*pi

double marmy(vector v1, vector v2, vector v3)
Parameters:
v1 - the first vector
v2 - the second vector
v3 - the third vector
Return value:
The z component of a vector that I won't pretend to understand.
Remarks:
The value returned by this function contains two useful pieces of information: sign, and magnitude.
The sign of this value tells the direction in which the vectors turn--clockwise or counterclockwise. Which sign corresponds to which direction depends on the coordinate system in use (is positive y up or down?).
The magnitude is twice the area of the triangle (v1, v2, v3).

bool segs_intersect(vector p1, vector p2, vector q1, vector q2)
parameters:
p1 - the first endpoint of segment p
p2 - the second endpoint of segment p
q1 - the first endpoint of segment q
q2 - the second endpoint of segment q
Return value:
true if p and q intersect, false otherwise.

bool triangle_contains(vector a, vector b, vector c, vector p)
Parameters:
a - a vertex of the triangle
b - the second vertex of the triangle
c - the third vertex of the triangle
p - the point to check
Return value:
true if the triangle represented by (a, b, c) contains the point at p, false otherwise.


vector[] addPoint(vector[] points, double x, double y)
Parameters:
points - an array of vectors
x - the x coordinate of the point to add
y - the y coordinate of the point to add
Return value:
The array with the new point added.
Remarks:
This is a convenience function for building lists of points.


bool convex_contains(vector[] points, vector p)
Parameters:
points - an array of vectors representing the verteces of a convex polygon, in counterclockwise order.
p - the point to test.

Return value:
 true if the convex polygon described by the points in the array contains the point at p, false otherwise.

Remarks:
 This function only works on simple convex polygons--that is, all internal angles are less than 180 degrees (<pi) and it never intersects itself.


vector[] get_intersections(shape@ s1, shape@ s2)
Parameters:
s1 - the first shape
s2 - the second shape
Return value:
An array containing the endpoints of all segments in s2 that intersect s1, or an empty array if the shapes do not intersect, or if one of the shapes if ully inside the other.

Remarks:
See the section on shapes below.
There should be no repeated endpoints in the returned array.
Points should be returned in counterclockwise order.
In some cases, it's possible for two segments without a vertex in common to be adjacent in the returned array. An example case might be testing two rectangles that overlap each other's centers to form a cross.



Shapes:

There are various types of shapes available, implementing the shape interface, which contains the vollowing methods:

shape@ translate(double tx, double ty)
Parameters:
tx - the horizontal translation
ty - the vertical translation
Return value:
a copy of this shape, translated by (tx, ty).
Remarks:
Translation is linear movement. So if you wanted to move a shape to the right 3, and down 5, you would call translate(3, 5).
This does not modify the original shape.

Example:

// create a 5x5 square
rect r(0, 0, 5, 5);
// Create a copy of this square, moved up and to the right:
shape@ translation=r.translate(4, -2);
// Make it so that r itself is translated:
@r=cast<rect>(translation);


	shape@ rotate(double theta, double ox, double oy)
Parameters:
double theta: the angle of rotation
double ox - the x coordinate of the point about which to rotate
oy - the y coordindate of the point about which to rotate
Return value:
A copy of this shape, rotated by theta radians about (ox, oy).
Remarks:
Angles are in radians.
You cannot rely on the returned shape being the same type as the original. The same methods used in axis-aligned shapes will not work on arbitrary shapes, so rotating an axis-aligned shape will result in a different shape being returned.
For example, rotating a rectangle by 45 degrees (pi/4) will return a convex object.


	shape@ scale(double sx, double sy)
Parameters:
sx - The horizontal scale amount
sy - the vertical scale amount
Return value:
A scaled copy of this shape.
Remarks:
Magnitudes between 0 and 1 will result in the shape shrinking along that axis, while magnitudes greater than 1 will result in a larger shape.
Negative values are equivalent to mirroring the shape over the axis.
A value of 1 is equivalent to changing nothing along the axis.
Shapes with a clearly defined center (rectangles, ellipses) can easily scale relative to their centers, but arbitrary polygons are more complicated and are not guaranteed to scale correctly.



	rect@ get_bounds()
Return value:
A rect object representing the rectangle that completely contains this shape.
Remarks:
Generally, this value will be the tightest-fitting bounding box, but it is not always guaranteed to be so for more complicated shapes.


	int get_type()
Return value:
The type constant which best describes this shape.

Remarks:
This method identifies types of shapes, so as to avoid frequent type-checking and class-casting.
Return values are:
SHAPE_UNKNOWN
    SHAPE_RECT (Only the rect object and its children should return this value)
    SHAPE_ROUND - a shape returning this type, or a type with this bit set, is expected to have a unique hit detection method that is incompatible with get_points
    SHAPE_POLY - polygons
    SHAPE_TRI=5, - unspecified triangle
    SHAPE_OTHER=8, - For shapes that don't fit anywhere else.
    SHAPE_ROUND_OTHER - misc round shape. It doesn't matter if your shapes return shape_round or shape_round_other.
    SHAPE_RIGHT_TRIANGLE
    SHAPE_STAR


	vector[] get_points()
Return value:
an array of vectors pointing at each vertex of this shape.
Remarks:
 When a shape's get_type method returns a value with the SHAPE_ROUND bit set, that shape should not invoke this method.
The points should be arranged in counterclockwise order, where negative y is up (screen coordinates).

	bool seg_intersects(vector p1, vector p2)
Parameters:
p1 - an endpoint of a line segment
p2 - another endpoint of a line segment
Return value:
true if this shape intersects the line segment defined by (p1, p2), false otherwise.
Remarks:
See segs_intersect(p1, p2, q1, q2).

	bool contains(double x, double y)
parameters:
x - the x coordinate of the point to test
y - the y coordinate of the point to test
Return value:
 true if this shape contains the point (x, y), false otherwise.

	bool contains(vector p)
Parameters:
p - the point to test
Return value:
true if this shape contains p, false otherwise.

Remarks:
 See triangle_contains and convex_contains.


	bool intersects(shape@ s)
Parameters:
s - the shape to test for intersection
Return value:
true if this shape intersects the given shape, false otherwise.
Remarks:
 This implimentation only requires that this shape intersects the bounding box of s, but more accurate detection is encouraged.

Specific shapes:

rect:
Represents a rectangle.

Constructor:

rect(double x, double y, double width, double height)
Parameters:
x - the x coordinate of the center of this rectangle
y - the y coordinate of the center of this rectangle
width - the width of this rectangle
height - the height of this rectangle

Remarks:
This class stores the center of this rectangle, not the corners.
To create a rect object using the corner, use the function rect_tl(x, y, width, height).
You can call new_rect(x, y, width, height) to generate a rect object from its center.

Methods in class rect:

bool collide_center(Rect@ r)
Parameters:
r = the rectangle to check
Return value:
true if this rect intersects r, false otherwise
Remarks:
This method is faster than calling intersects, if two objects are known to be rects.

bool triangle_intersects(vector a, vector b, vector c)
Parameters:
a - a vertex of the triangle to test
b - the second vertex of the triangle
c - the third vertex of the triangle
Return value:
true if the triangle (a, b, c) intersects this rectangle, false otherwise.



convex object:
Represents a simple convex polygon, in which all internal angles are less than 180 degrees (pi radians) and the shape never intersects itself.
Points should be added in clockwise or counterclockwise order.

Constructor:
convex()
Creates an empty convex shape.

Remarks:
The scale method uses the center of the bounding rectangle when creating a scaled copy of this shape.

Methods in class convex:

void addPoint(double x, double y)
Parameters:
x - the x coordinate of the point to add
y - the y coordinate of the point to add
Return value: none
Remarks:
Points should be added in clockwise or counterclockwise order (counterclockwise preferred).

Related functions:
convex_contains
new_convex()
new_convex(vector[] points)
new_convex(convex@ source)

circle object:
Represents a circle.

constructor:
circle()
Creates a circle centered at the origin (0, 0), with a radius of 1.

circle(double x, double y, double r)
Parameters:
x - the x coordinate of the center of the circle
y - the y coordinate of the center of the circle
r - the radius of the circle

Creates a circle centered at (x, y), with a radius of r.

Remarks:
Never change the radius of the circle directly after creating it; use the set_radius method instead.
The scale method will return a circle if and only if scale_x and scale_y are equivalent.

Methods in class circle:

void set_radius(double new_radius)
parameters:
new_radius - the value to which the radius should be set.
Return value: none
Remarks:
Always use this method when changing the radius of an existing circle.


right_triangle:
Object representing an axis-aligned right triangle.

Constructors:
right_triangle(double x1, double y1, double x2, double y2)
Parameters:
x1 - the x coordinate of the first vertex; corresponds to the center of the bounding ellipse
y1 - the y coordinate of the first vertex
x2 - the x coordinate of the second vertex, corresponds to the edge of the bounding ellipse
y2 - the y coordinate of the second vertex

right_triangle(vector p1, vector p2)
Parameters:
p1 - the first vertex, corresponds to the center of the bounding ellipse
p2 - the second vertex, corresponds to the edge of the bounding ellipse

Creates a right triangle.

Remarks:
Since the triangle is axis-aligned, the vertex of the right angle is always (p2.x, p1.y).
The hypotenuse, therefore, is (p1, p2).
While normal convex polygons will scale from the center of their bounding rectangle, even if that isn't the center of the polygon, right triangles will scale from their actual center, which lies on the midpoint of the line segment from the right angle to the center of the bounding rectangle.

Methods in class right_triangle:

bool seg_hypotenuse(vector p1, vector p2)
Parameters:
p1 - an endpoint of a line segment
p2 - another endpoint of a line segment
Return value:
true if the segment (p1, p2) intersects the hypotenuse, false otherwise.

