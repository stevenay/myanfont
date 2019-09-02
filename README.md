# MyanFont

**MyanFont** is simple php library for Zawgyi/Unicode font detection plus convertion utilities.

## Features
  - Myanmar Sar Checker
  - Zawgyi/Unicode Encoding Detector (using Regular Expression)
  - Zawgyi/Unicode Encoding Detector (using Machine Learning based Markov Model)
  - Zawgyi <=> Unicode Converter

As a **notice**, it cannot get 100% correction in detecting zawgyi or unicode just by checking to the text.
But it will be correct like 80% in most cases. For longer text, it is safe enough to assume 95% correct to detect zawgyi/unicode.

## Installation

Install using composer:

```
composer require "stevenay/myanfont:0.2.0"
```

## Usage
```
<?php
$autoload = __DIR__.'/vendor/autoload.php';
if (!file_exists($autoload))
{
	exit("Need Composer!");
}
require $autoload;

use SteveNay\MyanFont\MyanFont;

// Machine Learning Approach (by Default)
echo MyanFont::fontDetect('ျမန္မာလိုေျပာမယ္လကြာ'); // Zawgyi
echo MyanFont::fontDetect('မြန်မာလိုပြောမယ်လကွာ'); // Unicode

// Regular Expression Approach
echo MyanFont::fontDetectByRegularExpression('ျမန္မာလိုေျပာမယ္လကြာ'); // Zawgyi
echo MyanFont::fontDetectByRegularExpression('မြန်မာလိုပြောမယ်လကွာ'); // Unicode

// Machine Learning Approach (Deprecated - will remove in next version)
echo MyanFont::fontDetectByMachineLearning('ျမန္မာလိုေျပာမယ္လကြာ'); // Zawgyi
echo MyanFont::fontDetectByMachineLearning('မြန်မာလိုပြောမယ်လကွာ'); // Unicode

echo MyanFont::isMyanmarSar("မြန်မာစာ") ? 'true' : 'false'; // true
echo MyanFont::isMyanmarSar("English") ? 'true' : 'false'; // false

echo MyanFont::uni2zg("ယူနီကုဒ် ကနေ ဇော်ဂျီ");
echo MyanFont::zg2uni("ေဇာ္ဂ်ီ ကေန ယူနီကုဒ္");
```

## Usage for Laravel Projects
In these days, a lot of Php projects are developed with Laravel Framework including me. Therefore, the following is the recommended way to use this library in Laravel projects;

### To use in Controllers and any Php classes:
Just import the class and call the static methods from the class like accessing Utility methods.

```
use SteveNay\MyanFont\MyanFont;

class LanguageController extends Controller  
{
	public function controllerMethod(String $message)  
	{  
		// ...
		$lan = MyanFont::fontDetect($message);  
		
		// ... any code
	}
}
```

### To use as Global Helper Functions:
There may be the cases that you want to use as clean helper functions (for example., in your blade views).

In this case, I recommend to create **helpers.php** file in your **app** folder (folder structure is your preference). For example: `app\Helpers\helpers.php`

Then add "**helpers.php**" file to your **composer.json** file to autoload:
```
"autoload": {
    "classmap": [
        "database"
    ],
    "psr-4": {
        "App\\": "app/"
    },
    "files": ["app/Helpers/helpers.php"] // <- add this line
},
```
Then run the commend:
```
composer dump-autoload
```
Finally in your **app/Helpers/helpers.php** file, put the following code to call the functions globally.
```
if (! function_exists('fontDetect')) {  
	function fontDetect(string $content, $default = "zawgyi")  
	{
		return SteveNay\MyanFont\MyanFont::fontDetect($content, $default);  
	}
}  
  
if (! function_exists('isMyanmarSar')) {  
	function isMyanmarSar(string $content)  
	{
		return SteveNay\MyanFont\MyanFont::isMyanmarSar($content);  
	}
}  
  
if (! function_exists('uni2zg')) {  
	function uni2zg(string $content)  
	{
		return SteveNay\MyanFont\MyanFont::uni2zg($content);  
	}
}  
  
if (! function_exists('zg2uni')) {  
	function zg2uni(string $content)  
	{
		return SteveNay\MyanFont\MyanFont::zg2uni($content);  
	}
}
```
Then, you can use like

``` {{ fontDetect("ကျွန်တော် မြန်မာတစ်ယောက်ပါ။") }} ```

## Why this Library
At the time of this library implementation, I've not found proper **Php** library for zawgyi/unicode font detection. Currently I'm developing Messenger Chatbot where users can also talk with Bot in Burmese.
To respond correctly to users, I need to detect the user's input string is whether zawgyi or unicode.

Using regular expression for unicode characters is not easy enough in php. You have to correctly decode them as well as take care of Escaped characters (e.g. \t\r\n\f) when decoding.

I also have a strong desire to write proper documentation for each **regular expression** conditions. So I decided to build standard open-source php library for this utility.


## Implementation
This library source code is primarily referenced from Ko [ThuraMyoNyunt](https://github.com/greenlikeorange) [Knayi](https://github.com/greenlikeorange/knayi-myscript) Javascript library. I have to admit that [Knayi](https://github.com/greenlikeorange/knayi-myscript) is **awesome**. 

### Machine Learning
For the machine learning version, I've used official Google Myanmar Tools which is also contributed by me. 

In this approach, we can detect the encoding correctly even with the short length of text.

### Regular Expression for Detection
I found out popular **regular expression** to detect zawgyi/unicode which is as below, 

```
var regexUni = new RegExp("[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်|ျ[က-အ]ါ|ျ[ါ-း]|\u103e|\u103f|\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]|\u1031$|\u1031[က-အ]\u1032|\u1025\u102f|\u103c\u103d[\u1000-\u1001]|ည်း|ျင်း|င်|န်း|ျာ|င့်");
var regexZG = new RegExp("\s\u1031| ေ[က-အ]်|[က-အ]း");
```

The above regular expression is used in Ko [SaturnGod](https://github.com/saturngod/) [Tagu](https://github.com/saturngod/Tagu-firefox) browser addons. Accord to this [conversation](https://github.com/Rabbit-Converter/Rabbit/issues/10), the origin developer of this regexp is Ko [Ravi](https://github.com/ravichhabra). Then it is modified by Ko [Thant Thet](https://github.com/thantthet).

On top of that, the regular expression used in Ko [ThuraMyoNyunt](https://github.com/greenlikeorange) [Knayi](https://github.com/greenlikeorange/knayi-myscript) Library is also very good but I added some necessary regular expressions from Ko [Ravi](https://github.com/ravichhabra)'s code.

Here is the complete **RegExps** used in this library.

```
'unicode' => [
            '[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်', 'ျ[က-အ]ါ', 'ျ[ါ-း]', '\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]', '\u1031$', '\u1025\u102f', '\u103c\u103d[\u1000-\u1001]', 'ျင်း', 'ျာ', 'င့်','\u103e', '\u103f', '\u100a\u103a', '\u1014\u103a', '\u1031\u1038', '\u1031\u102c', '\u103a\u1038', '\u1035', '[\u1050-\u1059]', '^([\u1000-\u1021]\u103c|[\u1000-\u1021]\u1031)'
        ],
        'zawgyi' => [
            '\u102c\u1039', '\u103a\u102c', self::WHITESPACE . '(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]','^(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]', '[\u1000-\u1021]\u1039[^\u1000-\u1021]', '\u1025\u1039' ,'\u1039\u1038' ,'[\u102b-\u1030\u1031\u103a\u1038](\u103b|[\u107e-\u1084])[\u1000-\u1021]' ,'\u1036\u102f','[\u1000-\u1021]\u1039\u1031' , '\u1064','\u1039' . self::WHITESPACE, '\u102c\u1031','[\u102b-\u1030\u103a\u1038]\u1031[\u1000-\u1021]', '\u1031\u1031', '\u102f\u102d', '\u1039$'
        ]


```
You can find this **RegExps** in RuleBase.php class.

### Converter
Converter functions are actually defer to [Rabbit](https://github.com/Rabbit-Converter/Rabbit-PHP) converter library. I've implemented php magic methods as wrapper around Rabbit original functions.

## Documentation of Regular Expressions
### Unicode 
#### (please read in Unicode font to properly understand these regular expressions for Unicode)

[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်
-  ် is ya_pin in zawgyi
- ဃ ya_pin is impossible in burmese.
- That's why it is unicode.

ျ[က-အ]ါ
- ျ is ya_yit in zawgyi 
- Have no idea.

ျ[ါ-း]

-  ျ is ya_yit in zawgyi
- So after ya_yit, the alphabet letter must be followed such as က ခ
- If any other helping characters are followed, it must be unicode character

\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]

- 1031 is ေ in both unicode and zawgyi.
- In unicode, ta_way_htoe must be writter later only after alphabet is writtern.
- So after ta_way_htoe char, there must not be က to အ 
- And 103b is ya_yint, 
- 1040 is actually zero but sometimes people use zero as wa_lone.
- 106a, 106b, 107e and all others are kinds of other ethnics' languages.

\u103e|\u103f

- These characters are blank in Zawgyi Character map.

\u1031$

- 1031 is 'ta_way_htoe' ေ
- In unicode, ta_way_htoe must be writter later only after alphabet is writtern
- If ta_way_htoe is at the last position of the sentence, it is also unicode.

\u1031[က-အ]\u1032

- Have no idea.

\u1025\u102f

- 1025 is ဥ and 102f is 'ta_chaung_yin'  ု in unicode
- These are also the same in zawgyi.
- But unicode automatically change ta_chaung_yin to long form like ဥု
- But zawgyi cannot do it. 
- So zawgyi user have to type long form of ta_chaung_yin which is u1033


\u103c\u103d[\u1000-\u1001]
- ြွ - က and ခ in unicode
- In zawgyi, they are wa_swe and ha_htoe. so က ခ cannot be combined with wa_swe and ha_htoe.
- But I think it should be [\u1000-\u1001]\u103c\u103d

ည်း (\u100a\u103a)
- it is ည်း in unicode
-  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi.

ျင်း
- it is ျင်း in unicode
-  ျ is ya_yint in zawgyi, and
-  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi.

င် (\u1004\u103a)
- it is င် in unicode
-  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi.

န်း (\u1014\u103a)

- it is န်း in unicode
-  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi.

ျာ

- It is ျာ in unicode
- 'ya_pin' is 'ya_yit' in zawgyi code.
- So without any alphabet intervention, this combination is impossible in zawgyi.

င့်

- it is င့် in unicode
-  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi


### Zawgyi

'u102c\u1039'

- 102c is 'yay_char', 1039 is 'nga_thet' in zawgyi for e.g. ေမာ္

- 1039 is 'wa_swe' in unicode. So 102c+1039 character continuation will be like ာွ

- To use 'wa_swe' in unicode, the alphabet (က-အ) must be written first.

- That's why "102c+1039" is impossible in unicode.

'\u103a\u102c'

- 103a is 'ya_pin' and 102c is 'yay_char' in zg for e.g. က်ာ

- 103a is 'nga_thet' and 102c is 'yay_char' in unicode like ်ာ

- In unicode, if 'yay_char' is written later 'nga_thet', it will take as another word.

- So it is impossible in unicode and it must be zawgyi.

whitespace + '(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]

- 103b is 'ya_yit', 1031 is 'ta_way_htoe', 107e to 1084 are also different kinds of 'ya_yit' in zawgyi.
- 1000 to 1021 is က - အ.
- So if someone write 'ya_yit' or 'ta_way_htoe' first, it must be written in Zawgyi.

^(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]

- It is same as above.
- But it states that it must be at the start of the string.

[\u1000-\u1021]\u1039[^\u1000-\u1021]

- 1000 to 1021 is (က - အ). 1039 is 'nga_thet'.
- 1039 is (ပါဥ္ဆင့္ as ကမာၻ) in Unicode, 
- So in unicode, a valid alphabet must be followed after '1039' character code.
- If there is no alphabet is followed, we can generally assume this combniation is zawgyi.

\u1025\u1039

- 1025 is ဥ , 1039 is 'nga_thet' in zawgyi
- 1025 is ဥ , 1039 is (ပါဥ္ဆင့္ as ကမာၻ) in unicode
- ဥ cannot have character under him, so it can generally assume this combination is zawgyi.

\u1039\u1038

- 1039 is 'nga_thet' in zawgyi
- 1039 is (ပါဥ္ဆင့္ as ကမာၻ) in unicode
- 1038 is 'way_sa_na_lone_pone' in both.
- In unicode, 1039 must be followed by valid alphabet such as က - အ.
- So it can be assumed as zawgyi.

\u1036\u102f

- 1036 is 'tay_tayy_tin', 102f is 'ta_chaung_yin' in both zawgyi and unicode.
- In unicode, 'ta_chaung_yin' must be written first before tay_tayy_tin.
- So if tay_tayy_tin is written first, we can assume it is zawgyi.

[\u1000-\u1021]\u1039\u1031

- 1000 to 1021 is က - အ.
- 1039 is 'nga_thet' in zawgyi, 1031 is 'ta_way_htoe'.
- 1039 is (ပါဥ္ဆင့္ as ကမာၻ) in unicode.
- 1031 is 'ta_way_htoe' in both zawgyi and unicode.
- In unicode, 1039 must be followed by valid alphabet such as က - အ.
- So it can be assumed as zawgyi in this combination.

\u1064
- 1064 is S'gaw Karen character in unicode but it is valid code in zg.
- So it will be zawgyi.

'\u1039'+whitespace

- 1039 is 'nga_thet' in zawgyi
- 1039 is (ပါဥ္ဆင့္ as ကမာၻ) in unicode
- So in unicode, 1039 must be followed by valid alphabet such as က - အ.
- If whitespace is followed, we can assume it is zawgyi.

\u102c\u1031

- 102c is 'yay_char', 1031 is 'ta_way_htoe' in zawgyi.
- In unicode, 'ta_way_htoe' must be written first before 'ya_char' to write like ကော
- So if ya_char is written first it must be another kind of combination.
- It will only be meaningful in zawgyi.

[\u102b-\u1030\u103a\u1038]\u1031[\u1000-\u1021]

- Have no complete idea.
- Basic idea - 1031 is 'ta_way_htoe' in both unicode and zawgyi.
- 1000 to 1021 is က - အ.
- In unicode, alphabet (က - အ) has to written first before 'ta_way_htoe'.
- If 'ta_way_htoe' is come first, then it will be Zawgyi.


'\u1031\u1031'

- Have no idea.

'\u102f\u102d'

- 102f is 'ta_chaung_yin', 102d is 'lone_gyi_tin' in both zawgyi and unicode.
- In unicode 'lone_gyi_tin' has to written first before 'ta_chaung_yin' to get proper word.
- So in this combination, it will be zawgyi.

'\u1039$'

- 1039 is 'nga_thet'. It has to be at the last of the sentence.
- Have no idea.

## Todo
- To complete documentation of 'Have no idea' regular expression
- Contribution Guide
- Version Release Note

## Credit

-  Ko [ThuraMyoNyunt](https://github.com/greenlikeorange) [Knayi](https://github.com/greenlikeorange/knayi-myscript) Javascript library.
- Ko [@saturngod's](https://github.com/saturngod) [Rabbit](https://github.com/Rabbit-Converter/Rabbit-PHP) Converter

## License
[MIT](./LICENSE)