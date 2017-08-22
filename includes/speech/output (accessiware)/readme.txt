The Output Class
By: Accessiware

Hello and welcome to this readme. Here you'll find the documentation, license and more for the Output bgt class.

1. Documentation.
output(string packfile)

Parameters:
packfile:
The file path to the pack file containing the screen reader libraries ("libraries.dll" from this download).

Remarks
Constructor for the output class.

bool speak(string text, bool interrupt=false, bool wait=false, int reader=-1)

Parameters:
string text:
The text to be spoken and outputted to braille.

bool interrupt:
if this is set to true it will interrupt speech if sapi is talking.

bool wait:
If set to true, it will pause all other executions until the string is spoken.

int reader:
The screen reader to use (-1 for auto selection). Will default to sapi if no screen reader is found.

Remarks:
This function will both output speech and braille.

Look in the "example.bgt" for a small example.

2. License
This include is licensed under the Apache License 2.0. You can view the full license in the "license.txt" file or on http://www.apache.org/licenses/LICENSE-2.0.

