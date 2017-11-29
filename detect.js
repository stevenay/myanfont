// From saturngod
var regexUni = new RegExp("[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်|ျ[က-အ]ါ|ျ[ါ-း]|\u103e|\u103f|\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]|\u1031$|\u1031[က-အ]\u1032|\u1025\u102f|\u103c\u103d[\u1000-\u1001]|ည်း|ျင်း|င်|န်း|ျာ|င့်");
var regexZG = new RegExp("\s\u1031| ေ[က-အ]်|[က-အ]း");

// From thura_myo_nyunt
library.detect = {
    unicode: [
      '\u103e', '\u103f', '\u100a\u103a', '\u1014\u103a', '\u1004\u103a', '\u1031\u1038', '\u1031\u102c',
      '\u103a\u1038', '\u1035', '[\u1050-\u1059]', '^([\u1000-\u1021]\u103c|[\u1000-\u1021]\u1031)'
    ],
    zawgyi : [
      '\u102c\u1039', '\u103a\u102c', whitespace+'(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]'
      ,'^(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]', '[\u1000-\u1021]\u1039[^\u1000-\u1021]', '\u1025\u1039'
      ,'\u1039\u1038' ,'[\u102b-\u1030\u1031\u103a\u1038](\u103b|[\u107e-\u1084])[\u1000-\u1021]' ,'\u1036\u102f'
      ,'[\u1000-\u1021]\u1039\u1031' , '\u1064','\u1039'+whitespace, '\u102c\u1031'
      ,'[\u102b-\u1030\u103a\u1038]\u1031[\u1000-\u1021]', '\u1031\u1031', '\u102f\u102d', '\u1039$'
    ]
  };

// Documentation of Thura Myo Nyunt Zawgyi
// 102c is yay_char, 1039 is nga_thet in zg for e.g. မော်
// 1039 is wa_swe in unicode like ာွ, that's why it is impossible in unicode 
// '\u102c\u1039'

// 103a is ya_pin and 102c is yay_char in zg for e.g.  ျာ
// 103a is nga_thet and 102c is yay_char in unicode like ်ာ
// so it is impossible in unicode and it must be zawgyi
// \u103a\u102c

// 103b is ya_yit, 1031 is ta_way_htoe, 107e to 1084 are also different kinds of ya_yit
// 1000 to 1021 is က - အ.
// so if someone write ya_yit or ta_way_htoe first, it must be written in Zawgyi
// whitespace+'(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]

// It is same as above
// But it states that it must be at the start of the string
// ^(\u103b|\u1031|[\u107e-\u1084])[\u1000-\u1021]

// 1000 to 102 is ka_gyi to Ea. 1039 is nga_thet.
// 1039 is (character under character such as ကမ္ဘာ) in Unicode, 
// so in unicode, a valid alphabit must be followed after 1039
// if there is no alphabit is followed, we can generally assume this combniation is zg.
// [\u1000-\u1021]\u1039[^\u1000-\u1021]

// 1025 is ဥ , 1039 is ် in zg
// 1025 is ဥ , 1039 is (character under character such as ကမ္ဘာ) in unicode
// ဥ cannot have character under him, so it can generally assume this combination is zg.
// \u1025\u1039

// 1039 is ် in zg
// 1039 is (character under character such as ကမ္ဘာ) in unicode
// 1038 is way_sa_na_lone_pone in both.
// so in unicode, 1039 must be followed by valid alphabet such as က - အ.
// \u1039\u1038


// [\u102b-\u1030\u1031\u103a\u1038](\u103b|[\u107e-\u1084])[\u1000-\u1021]

// 1036 is tay_tayy_tin, 102f is ta_chaung_yin in zg and unicode.
// in unicode, ta_chaung_yin must be written first before tay_tayy_tin.
// so if tay_tayy_tin is written first, we can assume it is zg.
// \u1036\u102f

// 1039 is ် in zg, 1031 is ta_way_htoe
// 1039 is (character under character such as ကမ္ဘာ) in unicode
// [\u1000-\u1021]\u1039\u1031

// 1064 is shan character in unicode but it is valid code in zg.
// so it will be zg.
// \u1064

// 1039 is ် in zg
// 1039 is (character under character such as ကမ္ဘာ) in unicode
// so in unicode, 1039 must be followed by valid alphabet such as က - အ.
// if whitespace is followed, we can assume it is zg.
// '\u1039'+whitespace

// 102c is ya_char, 1031 is ta_way_htoe in zg
// in unicode, ta_way_htoe must be writter first before ya_char to write like ကော
// so if ya_char is written first it must be another kind of combination and
// it will only be meaningful in zawgyi.
// \u102c\u1031



































// Documentation of SaturnGod Regular Expression for Unicode
 ် is ya_pin in zawgyi
ဃ ya_pin is impossible in burmese.
that's why it is unicode.
[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်

// ျ is ya_yit in zawgyi
// I don't understand this logic
ျ[က-အ]ါ

 ျ is ya_yit in zawgyi
so after ya_yit, the alphabet letter must be followed such as က ခ
if any other helping characters are followed, it must be unicode character
ျ[ါ-း]

1031 is ေ
in unicode, ta_way_htoe must be writter later only after alphabet is writtern
so after ta_way_htoe char, there must not be က to အ 
and 103b is ya_yint, 
1040 is actually zero but sometimes people use zero as wa_lone
106a, 106b, 107e and all others are kinds of other ethnics
\u1031[^\u1000-\u1021\u103b\u1040\u106a\u106b\u107e-\u1084\u108f\u1090]

// These characters are blank in Zawgyi Character map.
\u103e|\u103f

1031 is ေ
in unicode, ta_way_htoe must be writter later only after alphabet is writtern
if ta_way_htoe is at the last position of the sentence, it is also unicode.
\u1031$

// I don't know
\u1031[က-အ]\u1032


1025 is ဥ and 102f is ု in unicode
these are also the same in zawgyi
but unicode automatically change ta_chaung_yin to long form like ဥု
but zawgyi cannot do it. 
So zawgyi user have to type long form of ta_chaung_yin which is u1033
\u1025\u102f

ြွ - က and ခ in unicode
in zawgyi, they are wa_swe and ha_htoe. so က ခ cannot be combined with wa_swe and ha_htoe.
but I think it should be [\u1000-\u1001]\u103c\u103d
\u103c\u103d[\u1000-\u1001]


it is ည်း in unicode
 ် is ya_pin in zawgyi, so this combination is impossible in zawgyi
ည်း (\u100a\u103a)

it is ျင်း in unicode
 ျ is ya_yint in zawgyi, and
 ် is ya_pin in zawgyi, so this combination is impossible in zawgyi
ျင်း

it is င် in unicode
 ် is ya_pin in zawgyi, so this combination is impossible in zawgyi
င် (\u1004\u103a)

it is န်း in unicode
  ် is ya_pin in zawgyi, so this combination is impossible in zawgyi
န်း (\u1014\u103a)

it is ျာ in unicode
ya_pin is ya_yit in zawgyi code,
so without any alphabet intervention, this combination is impossible in zawgyi 
ျာ

it is င့် in unicode
 ် is ya_pin in zawgyi, so this combination is impossible in zawgyi
င့်



