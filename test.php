<?php

$autoload = __DIR__.'/vendor/autoload.php';

if ( ! file_exists($autoload))
{
	exit("Need to run \"composer install\"!");
}

require $autoload;

use MyanFont\MyanFont;

$unicode_string = "ကြွားသီဟိုဠ်မှ ဉာဏ်ကြီးရှင်သည် အာယုဝဍ်ဎနဆေးညွှန်းစာကို ဇလွန်ဈေးဘေးဗာဒံပင်ထက် အဓိဋ္ဌာန်လျက် ဂဃနဏဖတ်ခဲ့သည်။ယေဓမ္မာ ဟေတုပ္ပဘဝါ တေသံ ဟေတုံ တထာဂတော အာဟ တေသဉ္စ ယောနိရောဓေါ ဧဝံ ဝါဒီ မဟာသမဏော။(မြန်မာပြန်)မြတ်စွာဘုရားရှင်သည် ရှေးကပြုခဲ့ဖူးသော အကြောင်းတရားကြောင့် ဖြစ်ပေါ်လာကြသော အကျိုးတရားကို ဟောကြားတော်မူသည်။ထိုအကြောင်းတရားတို့၏ ချုပ်ငြိမ်းရာတရားတို့ကိုလည်း ဟောတော်မူ၏။ရဟန်းကြီးဖြစ်သော ဗုဒ္ဓမြတ်စွာဘုရားသည် ဤသို့သောအယူရှိတော်မူ၏။ကြွမြန်းတော်မူသွားလေသည်။";
$zawgyi_string = "ကြွားသီဟိုဠ္မွ ဉာဏ္ႀကီးရွင္သည္ အာယုဝဍ္ဎနေဆးၫႊန္းစာကို ဇလြန္ေဈးေဘးဗာဒံပင္ထက္ အဓိ႒ာန္လ်က္ ဂဃနဏဖတ္ခဲ့သည္။ေယဓမၼာ ေဟတုပၸဘဝါ ေတသံ ေဟတုံ တထာဂေတာ အာဟ ေတသၪၥ ေယာနိေရာေဓါ ဧဝံ ဝါဒီ မဟာသမေဏာ။(ျမန္မာျပန္)ျမတ္စြာဘုရားရွင္သည္ ေရွးကျပဳခဲ့ဖူးေသာ အေၾကာင္းတရားေၾကာင့္ ျဖစ္ေပၚလာၾကေသာ အက်ိဳးတရားကို ေဟာၾကားေတာ္မူသည္။ထိုအေၾကာင္းတရားတို႔၏ ခ်ဳပ္ၿငိမ္းရာတရားတို႔ကိုလည္း ေဟာေတာ္မူ၏။ရဟန္းႀကီးျဖစ္ေသာ ဗုဒၶျမတ္စြာဘုရားသည္ ဤသို႔ေသာအယူရွိေတာ္မူ၏။ၾကြျမန္းေတာ္မူသြားေလသည္။";
$unicode_string_2 = "ဇော်ဂျီကနေ ယူနီကုဒ် ၊ ယူနီကုဒ် ကနေ ဇော်ဂျီ ကို auto detect လုပ်ပြီး ပြောင်းနိုင် မည့် နည်းလမ်းကောင်း လေးသိချင်ပါတယ်။ အခု ကျွန်တော် rabbit ကိုသုံး ပါတယ်။";

// echo "မင်္ဂလာပါ " . MyanFont::fontDetect("မင်္ဂလာပါ");
// echo "<br />";
echo "Rabbit ကြန္ဗက္တာကို သိလား " . MyanFont::fontDetect('Rabbit ကွန်ဗက်တာကို သိလား');
echo "<br />";

// echo MyanFont::isMyanmarSar("မြန်မာစာ") ? 'true' : 'false';
// echo "<br />";

echo MyanFont::uni2zg("av");