Hi. First, who ever knew this was so simple? Our games getting speed hacked is always something we were worried about, and finily I believe I have come up with quite a reliable fix. This thing here, if used right, will detect speed hacking in less than a second of it being activated! 
To use this script, simply, quite litterily, in your loop, just do something like this! 
if(speed_stop_is_hacking()==true)
{
alert("cheater", "Sorry, cheaters are not allowed in this game! ");
exit();
}
This has been tested again multiple loops and input boxes etc, and I have found no false speedhacks. However, if this should start happening in your game, there are things included that are ment to help stop that. 
First, the reset method:
speed_stop_reset();
This just resets the timers used to there default values and allows 2 seconds of equilization time between the 2 timers. You shouldn't need to use this, but if you do, just call reset before using the is_hacked method. Not in the loop, but something like. 
speed_stop_reset();
while(true
{
...
})
Next we have the slack time option. 
speed_stop_is_hacked(200);
If your game starts showing false speedhacks, it could also be that you arn't atending to the loop enough. So changing that value which defaults to 50, you can allow more safe time. Be warned, that the higher you set this number, the more speed hacking can get threw. Usually, 50 is fine. 
Finily, the pause and resume methods. 
speed_stop_disable();
and
speed_stop_enable();
Disable makes it so that even if you are calling the loop, it will always return false and no speedhacks will be found. This could be useful if you are going a long period with out checking the loop. It shouldn't be reequired, but another measure to stop false speedhacks. 
Enable just stopps the pause, and when the loop/is_hacked method is called, it returns speedhacks again. 
So, just remember to call the loop     as much as you can, and it should work. But if you get false speedhacks, utalizing the methods above should stop that. 
Hope this obliterates speed hacking in BGT! 
Oh, also, if your wondering how I did it? I took advantage of BGT's TIME_STAMP method, which greatfully is not effected by at least cheat engines speedhacks! Yay! 
Email: webmaster@samtupy.com
skype: sam.tupy1
twitter: @samtupy1
Hope you all enjoy and hope we can all get rid of cheaters as much as possible! 
