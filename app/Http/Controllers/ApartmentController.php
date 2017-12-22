<?php

namespace App\Http\Controllers;

use App\Description;
use App\Image;
use Illuminate\Http\Request;
use App\Apartment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApartmentController extends Controller
{

    const COUNTRIES_ARRAY = array(
        "" => array('name'=>"", 'nativetongue'=>""),
        "AF" => array('name'=>"Afghanistan", 'nativetongue'=>"‫افغانستان"),
        "AX" => array('name'=>"Åland Islands", 'nativetongue'=>"Åland"),
        "AL" => array('name'=>"Albania", 'nativetongue'=>"Shqipëri"),
        "DZ" => array('name'=>"Algeria", 'nativetongue'=>"‫الجزائر"),
        "AS" => array('name'=>"American Samoa", 'nativetongue'=>""),
        "AD" => array('name'=>"Andorra", 'nativetongue'=>""),
        "AO" => array('name'=>"Angola", 'nativetongue'=>""),
        "AI" => array('name'=>"Anguilla", 'nativetongue'=>""),
        "AQ" => array('name'=>"Antarctica", 'nativetongue'=>""),
        "AG" => array('name'=>"Antigua and Barbuda", 'nativetongue'=>""),
        "AR" => array('name'=>"Argentina", 'nativetongue'=>""),
        "AM" => array('name'=>"Armenia", 'nativetongue'=>"Հայաստան"),
        "AW" => array('name'=>"Aruba", 'nativetongue'=>""),
        "AC" => array('name'=>"Ascension Island", 'nativetongue'=>""),
        "AU" => array('name'=>"Australia", 'nativetongue'=>""),
        "AT" => array('name'=>"Austria", 'nativetongue'=>"Österreich"),
        "AZ" => array('name'=>"Azerbaijan", 'nativetongue'=>"Azərbaycan"),
        "BS" => array('name'=>"Bahamas", 'nativetongue'=>""),
        "BH" => array('name'=>"Bahrain", 'nativetongue'=>"‫البحرين"),
        "BD" => array('name'=>"Bangladesh", 'nativetongue'=>"বাংলাদেশ"),
        "BB" => array('name'=>"Barbados", 'nativetongue'=>""),
        "BY" => array('name'=>"Belarus", 'nativetongue'=>"Беларусь"),
        "BE" => array('name'=>"Belgium", 'nativetongue'=>"België"),
        "BZ" => array('name'=>"Belize", 'nativetongue'=>""),
        "BJ" => array('name'=>"Benin", 'nativetongue'=>"Bénin"),
        "BM" => array('name'=>"Bermuda", 'nativetongue'=>""),
        "BT" => array('name'=>"Bhutan", 'nativetongue'=>"འབྲུག"),
        "BO" => array('name'=>"Bolivia", 'nativetongue'=>""),
        "BA" => array('name'=>"Bosnia and Herzegovina", 'nativetongue'=>"Босна и Херцеговина"),
        "BW" => array('name'=>"Botswana", 'nativetongue'=>""),
        "BV" => array('name'=>"Bouvet Island", 'nativetongue'=>""),
        "BR" => array('name'=>"Brazil", 'nativetongue'=>"Brasil"),
        "IO" => array('name'=>"British Indian Ocean Territory",'nativetongue'=>""),
        "VG" => array('name'=>"British Virgin Islands", 'nativetongue'=>""),
        "BN" => array('name'=>"Brunei", 'nativetongue'=>""),
        "BG" => array('name'=>"Bulgaria", 'nativetongue'=>"България"),
        "BF" => array('name'=>"Burkina Faso", 'nativetongue'=>""),
        "BI" => array('name'=>"Burundi", 'nativetongue'=>"Uburundi"),
        "KH" => array('name'=>"Cambodia", 'nativetongue'=>"កម្ពុជា"),
        "CM" => array('name'=>"Cameroon", 'nativetongue'=>"Cameroun"),
        "CA" => array('name'=>"Canada", 'nativetongue'=>""),
        "IC" => array('name'=>"Canary Islands", 'nativetongue'=>"islas Canarias"),
        "CV" => array('name'=>"Cape Verde", 'nativetongue'=>"Kabu Verdi"),
        "BQ" => array('name'=>"Caribbean Netherlands", 'nativetongue'=>""),
        "KY" => array('name'=>"Cayman Islands", 'nativetongue'=>""),
        "CF" => array('name'=>"Central African Republic",'nativetongue'=>"République centrafricaine"),
        "EA" => array('name'=>"Ceuta and Melilla", 'nativetongue'=>"Ceuta y Melilla"),
        "TD" => array('name'=>"Chad", 'nativetongue'=>"Tchad"),
        "CL" => array('name'=>"Chile", 'nativetongue'=>""),
        "CN" => array('name'=>"China", 'nativetongue'=>"中国"),
        "CX" => array('name'=>"Christmas Island", 'nativetongue'=>""),
        "CP" => array('name'=>"Clipperton Island", 'nativetongue'=>""),
        "CC" => array('name'=>"Cocos (Keeling) Islands", 'nativetongue'=>"Kepulauan Cocos (Keeling)"),
        "CO" => array('name'=>"Colombia", 'nativetongue'=>""),
        "KM" => array('name'=>"Comoros", 'nativetongue'=>"‫جزر القمر"),
        "CD" => array('name'=>"Congo (DRC)", 'nativetongue'=>"Jamhuri ya Kidemokrasia ya Kongo"),
        "CG" => array('name'=>"Congo (Republic)", 'nativetongue'=>"Congo-Brazzaville"),
        "CK" => array('name'=>"Cook Islands", 'nativetongue'=>""),
        "CR" => array('name'=>"Costa Rica", 'nativetongue'=>""),
        "CI" => array('name'=>"Côte d’Ivoire", 'nativetongue'=>""),
        "HR" => array('name'=>"Croatia", 'nativetongue'=>"Hrvatska"),
        "CU" => array('name'=>"Cuba", 'nativetongue'=>""),
        "CW" => array('name'=>"Curaçao", 'nativetongue'=>""),
        "CY" => array('name'=>"Cyprus", 'nativetongue'=>"Κύπρος"),
        "CZ" => array('name'=>"Czech Republic", 'nativetongue'=>"Česká republika"),
        "DK" => array('name'=>"Denmark", 'nativetongue'=>"Danmark"),
        "DG" => array('name'=>"Diego Garcia", 'nativetongue'=>""),
        "DJ" => array('name'=>"Djibouti", 'nativetongue'=>""),
        "DM" => array('name'=>"Dominica", 'nativetongue'=>""),
        "DO" => array('name'=>"Dominican Republic", 'nativetongue'=>"República Dominicana"),
        "EC" => array('name'=>"Ecuador", 'nativetongue'=>""),
        "EG" => array('name'=>"Egypt", 'nativetongue'=>"‫مصر"),
        "SV" => array('name'=>"El Salvador", 'nativetongue'=>""),
        "GQ" => array('name'=>"Equatorial Guinea",'nativetongue'=>"Guinea Ecuatorial"),
        "ER" => array('name'=>"Eritrea", 'nativetongue'=>""),
        "EE" => array('name'=>"Estonia", 'nativetongue'=>"Eesti"),
        "ET" => array('name'=>"Ethiopia", 'nativetongue'=>""),
        "FK" => array('name'=>"Falkland Islands", 'nativetongue'=>"Islas Malvinas"),
        "FO" => array('name'=>"Faroe Islands", 'nativetongue'=>"Føroyar"),
        "FJ" => array('name'=>"Fiji", 'nativetongue'=>""),
        "FI" => array('name'=>"Finland", 'nativetongue'=>"Suomi"),
        "FR" => array('name'=>"France", 'nativetongue'=>""),
        "GF" => array('name'=>"French Guiana", 'nativetongue'=>"Guyane française"),
        "PF" => array('name'=>"French Polynesia", 'nativetongue'=>"Polynésie française"),
        "TF" => array('name'=>"French Southern Territories", 'nativetongue'=>"Terres australes françaises"),
        "GA" => array('name'=>"Gabon", 'nativetongue'=>""),
        "GM" => array('name'=>"Gambia", 'nativetongue'=>""),
        "GE" => array('name'=>"Georgia", 'nativetongue'=>"საქართველო"),
        "DE" => array('name'=>"Germany", 'nativetongue'=>"Deutschland"),
        "GH" => array('name'=>"Ghana", 'nativetongue'=>"Gaana"),
        "GI" => array('name'=>"Gibraltar", 'nativetongue'=>""),
        "GR" => array('name'=>"Greece", 'nativetongue'=>"Ελλάδα"),
        "GL" => array('name'=>"Greenland", 'nativetongue'=>"Kalaallit Nunaat"),
        "GD" => array('name'=>"Grenada", 'nativetongue'=>""),
        "GP" => array('name'=>"Guadeloupe", 'nativetongue'=>""),
        "GU" => array('name'=>"Guam", 'nativetongue'=>""),
        "GT" => array('name'=>"Guatemala", 'nativetongue'=>""),
        "GG" => array('name'=>"Guernsey", 'nativetongue'=>""),
        "GN" => array('name'=>"Guinea", 'nativetongue'=>"Guinée"),
        "GW" => array('name'=>"Guinea-Bissau", 'nativetongue'=>"Guiné Bissau"),
        "GY" => array('name'=>"Guyana", 'nativetongue'=>""),
        "HT" => array('name'=>"Haiti", 'nativetongue'=>""),
        "HM" => array('name'=>"Heard & McDonald Islands", 'nativetongue'=>""),
        "HN" => array('name'=>"Honduras", 'nativetongue'=>""),
        "HK" => array('name'=>"Hong Kong", 'nativetongue'=>"香港"),
        "HU" => array('name'=>"Hungary", 'nativetongue'=>"Magyarország"),
        "IS" => array('name'=>"Iceland", 'nativetongue'=>"Ísland"),
        "IN" => array('name'=>"India", 'nativetongue'=>"भारत"),
        "ID" => array('name'=>"Indonesia", 'nativetongue'=>""),
        "IR" => array('name'=>"Iran", 'nativetongue'=>"‫ایران"),
        "IQ" => array('name'=>"Iraq", 'nativetongue'=>"‫العراق"),
        "IE" => array('name'=>"Ireland", 'nativetongue'=>""),
        "IM" => array('name'=>"Isle of Man", 'nativetongue'=>""),
        "IL" => array('name'=>"Israel", 'nativetongue'=>"‫ישראל"),
        "IT" => array('name'=>"Italy", 'nativetongue'=>"Italia"),
        "JM" => array('name'=>"Jamaica", 'nativetongue'=>""),
        "JP" => array('name'=>"Japan", 'nativetongue'=>"日本"),
        "JE" => array('name'=>"Jersey", 'nativetongue'=>""),
        "JO" => array('name'=>"Jordan", 'nativetongue'=>"‫الأردن"),
        "KZ" => array('name'=>"Kazakhstan", 'nativetongue'=>"Казахстан"),
        "KE" => array('name'=>"Kenya", 'nativetongue'=>""),
        "KI" => array('name'=>"Kiribati", 'nativetongue'=>""),
        "XK" => array('name'=>"Kosovo", 'nativetongue'=>"Kosovë"),
        "KW" => array('name'=>"Kuwait", 'nativetongue'=>"‫الكويت"),
        "KG" => array('name'=>"Kyrgyzstan", 'nativetongue'=>"Кыргызстан"),
        "LA" => array('name'=>"Laos", 'nativetongue'=>"ລາວ"),
        "LV" => array('name'=>"Latvia", 'nativetongue'=>"Latvija"),
        "LB" => array('name'=>"Lebanon", 'nativetongue'=>"‫لبنان"),
        "LS" => array('name'=>"Lesotho", 'nativetongue'=>""),
        "LR" => array('name'=>"Liberia", 'nativetongue'=>""),
        "LY" => array('name'=>"Libya", 'nativetongue'=>"‫ليبيا"),
        "LI" => array('name'=>"Liechtenstein", 'nativetongue'=>""),
        "LT" => array('name'=>"Lithuania", 'nativetongue'=>"Lietuva"),
        "LU" => array('name'=>"Luxembourg", 'nativetongue'=>""),
        "MO" => array('name'=>"Macau", 'nativetongue'=>"澳門"),
        "MK" => array('name'=>"Macedonia (FYROM)",'nativetongue'=>"Македонија"),
        "MG" => array('name'=>"Madagascar", 'nativetongue'=>"Madagasikara"),
        "MW" => array('name'=>"Malawi", 'nativetongue'=>""),
        "MY" => array('name'=>"Malaysia", 'nativetongue'=>""),
        "MV" => array('name'=>"Maldives", 'nativetongue'=>""),
        "ML" => array('name'=>"Mali", 'nativetongue'=>""),
        "MT" => array('name'=>"Malta", 'nativetongue'=>""),
        "MH" => array('name'=>"Marshall Islands", 'nativetongue'=>""),
        "MQ" => array('name'=>"Martinique", 'nativetongue'=>""),
        "MR" => array('name'=>"Mauritania", 'nativetongue'=>"‫موريتانيا"),
        "MU" => array('name'=>"Mauritius", 'nativetongue'=>"Moris"),
        "YT" => array('name'=>"Mayotte", 'nativetongue'=>""),
        "MX" => array('name'=>"Mexico", 'nativetongue'=>""),
        "FM" => array('name'=>"Micronesia", 'nativetongue'=>""),
        "MD" => array('name'=>"Moldova", 'nativetongue'=>"Republica Moldova"),
        "MC" => array('name'=>"Monaco", 'nativetongue'=>""),
        "MN" => array('name'=>"Mongolia", 'nativetongue'=>"Монгол"),
        "ME" => array('name'=>"Montenegro", 'nativetongue'=>"Crna Gora"),
        "MS" => array('name'=>"Montserrat", 'nativetongue'=>""),
        "MA" => array('name'=>"Morocco", 'nativetongue'=>"‫المغرب"),
        "MZ" => array('name'=>"Mozambique", 'nativetongue'=>"Moçambique"),
        "MM" => array('name'=>"Myanmar (Burma)", 'nativetongue'=>"မြန်မာ"),
        "NA" => array('name'=>"Namibia", 'nativetongue'=>"Namibië"),
        "NR" => array('name'=>"Nauru", 'nativetongue'=>""),
        "NP" => array('name'=>"Nepal", 'nativetongue'=>"नेपाल"),
        "NL" => array('name'=>"Netherlands", 'nativetongue'=>"Nederland"),
        "NC" => array('name'=>"New Caledonia", 'nativetongue'=>"Nouvelle-Calédonie"),
        "NZ" => array('name'=>"New Zealand", 'nativetongue'=>""),
        "NI" => array('name'=>"Nicaragua", 'nativetongue'=>""),
        "NE" => array('name'=>"Niger", 'nativetongue'=>"Nijar"),
        "NG" => array('name'=>"Nigeria", 'nativetongue'=>""),
        "NU" => array('name'=>"Niue", 'nativetongue'=>""),
        "NF" => array('name'=>"Norfolk Island", 'nativetongue'=>""),
        "MP" => array('name'=>"Northern Mariana Islands", 'nativetongue'=>""),
        "KP" => array('name'=>"North Korea", 'nativetongue'=>"조선 민주주의 인민 공화국"),
        "NO" => array('name'=>"Norway", 'nativetongue'=>"Norge"),
        "OM" => array('name'=>"Oman", 'nativetongue'=>"‫عُمان"),
        "PK" => array('name'=>"Pakistan", 'nativetongue'=>"‫پاکستان"),
        "PW" => array('name'=>"Palau", 'nativetongue'=>""),
        "PS" => array('name'=>"Palestine", 'nativetongue'=>"‫فلسطين"),
        "PA" => array('name'=>"Panama", 'nativetongue'=>""),
        "PG" => array('name'=>"Papua New Guinea", 'nativetongue'=>""),
        "PY" => array('name'=>"Paraguay", 'nativetongue'=>""),
        "PE" => array('name'=>"Peru", 'nativetongue'=>"Perú"),
        "PH" => array('name'=>"Philippines", 'nativetongue'=>""),
        "PN" => array('name'=>"Pitcairn Islands", 'nativetongue'=>""),
        "PL" => array('name'=>"Poland", 'nativetongue'=>"Polska"),
        "PT" => array('name'=>"Portugal", 'nativetongue'=>""),
        "PR" => array('name'=>"Puerto Rico", 'nativetongue'=>""),
        "QA" => array('name'=>"Qatar", 'nativetongue'=>"‫قطر"),
        "RE" => array('name'=>"Réunion", 'nativetongue'=>"La Réunion"),
        "RO" => array('name'=>"Romania", 'nativetongue'=>"România"),
        "RU" => array('name'=>"Russia", 'nativetongue'=>"Россия"),
        "RW" => array('name'=>"Rwanda", 'nativetongue'=>""),
        "BL" => array('name'=>"Saint Barthélemy", 'nativetongue'=>"Saint-Barthélemy"),
        "SH" => array('name'=>"Saint Helena", 'nativetongue'=>""),
        "KN" => array('name'=>"Saint Kitts and Nevis", 'nativetongue'=>""),
        "LC" => array('name'=>"Saint Lucia", 'nativetongue'=>""),
        "MF" => array('name'=>"Saint Martin", 'nativetongue'=>""),
        "PM" => array('name'=>"Saint Pierre and Miquelon", 'nativetongue'=>"Saint-Pierre-et-Miquelon"),
        "WS" => array('name'=>"Samoa", 'nativetongue'=>""),
        "SM" => array('name'=>"San Marino", 'nativetongue'=>""),
        "ST" => array('name'=>"São Tomé and Príncipe", 'nativetongue'=>"São Tomé e Príncipe"),
        "SA" => array('name'=>"Saudi Arabia", 'nativetongue'=>"‫المملكة العربية السعودية"),
        "SN" => array('name'=>"Senegal", 'nativetongue'=>"Sénégal"),
        "RS" => array('name'=>"Serbia", 'nativetongue'=>"Србија"),
        "SC" => array('name'=>"Seychelles", 'nativetongue'=>""),
        "SL" => array('name'=>"Sierra Leone", 'nativetongue'=>""),
        "SG" => array('name'=>"Singapore", 'nativetongue'=>""),
        "SX" => array('name'=>"Sint Maarten", 'nativetongue'=>""),
        "SK" => array('name'=>"Slovakia", 'nativetongue'=>"Slovensko"),
        "SI" => array('name'=>"Slovenia", 'nativetongue'=>"Slovenija"),
        "SB" => array('name'=>"Solomon Islands", 'nativetongue'=>""),
        "SO" => array('name'=>"Somalia", 'nativetongue'=>"Soomaaliya"),
        "ZA" => array('name'=>"South Africa", 'nativetongue'=>""),
        "GS" => array('name'=>"South Georgia & South Sandwich Islands", 'nativetongue'=>""),
        "KR" => array('name'=>"South Korea", 'nativetongue'=>"대한민국"),
        "SS" => array('name'=>"South Sudan", 'nativetongue'=>"‫جنوب السودان"),
        "ES" => array('name'=>"Spain", 'nativetongue'=>"España"),
        "LK" => array('name'=>"Sri Lanka", 'nativetongue'=>"ශ්‍රී ලංකාව"),
        "VC" => array('name'=>"St. Vincent & Grenadines", 'nativetongue'=>""),
        "SD" => array('name'=>"Sudan", 'nativetongue'=>"‫السودان"),
        "SR" => array('name'=>"Suriname", 'nativetongue'=>""),
        "SJ" => array('name'=>"Svalbard and Jan Mayen", 'nativetongue'=>"Svalbard og Jan Mayen"),
        "SZ" => array('name'=>"Swaziland", 'nativetongue'=>""),
        "SE" => array('name'=>"Sweden", 'nativetongue'=>"Sverige"),
        "CH" => array('name'=>"Switzerland", 'nativetongue'=>"Schweiz"),
        "SY" => array('name'=>"Syria", 'nativetongue'=>"‫سوريا"),
        "TW" => array('name'=>"Taiwan", 'nativetongue'=>"台灣"),
        "TJ" => array('name'=>"Tajikistan", 'nativetongue'=>""),
        "TZ" => array('name'=>"Tanzania", 'nativetongue'=>""),
        "TH" => array('name'=>"Thailand", 'nativetongue'=>"ไทย"),
        "TL" => array('name'=>"Timor-Leste", 'nativetongue'=>""),
        "TG" => array('name'=>"Togo", 'nativetongue'=>""),
        "TK" => array('name'=>"Tokelau", 'nativetongue'=>""),
        "TO" => array('name'=>"Tonga", 'nativetongue'=>""),
        "TT" => array('name'=>"Trinidad and Tobago", 'nativetongue'=>""),
        "TA" => array('name'=>"Tristan da Cunha", 'nativetongue'=>""),
        "TN" => array('name'=>"Tunisia", 'nativetongue'=>"‫تونس"),
        "TR" => array('name'=>"Turkey", 'nativetongue'=>"Türkiye"),
        "TM" => array('name'=>"Turkmenistan", 'nativetongue'=>""),
        "TC" => array('name'=>"Turks and Caicos Islands", 'nativetongue'=>""),
        "TV" => array('name'=>"Tuvalu", 'nativetongue'=>""),
        "UM" => array('name'=>"U.S. Outlying Islands", 'nativetongue'=>""),
        "VI" => array('name'=>"U.S. Virgin Islands", 'nativetongue'=>""),
        "UG" => array('name'=>"Uganda", 'nativetongue'=>""),
        "UA" => array('name'=>"Ukraine", 'nativetongue'=>"Україна"),
        "AE" => array('name'=>"United Arab Emirates", 'nativetongue'=>"‫الإمارات العربية المتحدة"),
        "GB" => array('name'=>"United Kingdom", 'nativetongue'=>""),
        "US" => array('name'=>"United States", 'nativetongue'=>""),
        "UY" => array('name'=>"Uruguay", 'nativetongue'=>""),
        "UZ" => array('name'=>"Uzbekistan", 'nativetongue'=>"Oʻzbekiston"),
        "VU" => array('name'=>"Vanuatu", 'nativetongue'=>""),
        "VA" => array('name'=>"Vatican City", 'nativetongue'=>"Città del Vaticano"),
        "VE" => array('name'=>"Venezuela", 'nativetongue'=>""),
        "VN" => array('name'=>"Vietnam", 'nativetongue'=>"Việt Nam"),
        "WF" => array('name'=>"Wallis and Futuna", 'nativetongue'=>""),
        "EH" => array('name'=>"Western Sahara", 'nativetongue'=>"‫الصحراء الغربية"),
        "YE" => array('name'=>"Yemen", 'nativetongue'=>"‫اليمن"),
        "ZM" => array('name'=>"Zambia", 'nativetongue'=>""),
        "ZW" => array('name'=>"Zimbabwe", 'nativetongue'=>"")
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function appIndex()
    {

        $apartments = Cache::remember('apartments', 22 * 60, function () {
            return Apartment::all();
        });
        //-- Delete all images that are not linked to any apartment
        $images = Image::where('apartment_id', 'like', '%apart_%')->get();
        foreach ($images as $item) {
            unlink(public_path() . '/images/' . $item->path);
            $item->delete();
        }
        $arrRooms = ['', 1, 2, 3, 4, 5];
        $arrCountries=self::COUNTRIES_ARRAY;

        //-- Replace country code with country name in collection
        foreach ($apartments as $apartment){
            foreach($arrCountries as $key=>$item){
                if($apartment->country==$key){
                    $apartment->country=$item['name'];
                }
            }
        }


        return view('index', compact('apartments','arrRooms','arrCountries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrRooms = [1, 2, 3, 4, 5];
        $arrCountries=self::COUNTRIES_ARRAY;
        return view('apartment.create', compact('arrRooms','arrCountries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        if(!($file->getClientSize()>1500000)) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            Image::create([
                'user_id' => Auth::id(),
                'apartment_id' => 'apart_' . Auth::id(),
                'path' => $name
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });


        $user = $apartment->user;
        $arrCountries=self::COUNTRIES_ARRAY;
        return view('apartment.show', compact('apartment', 'user','arrCountries'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });

        $user = $apartment->user;
        $arrRooms = [1, 2, 3, 4, 5];
        $arrCountries=self::COUNTRIES_ARRAY;
        return view('apartment.edit', compact('apartment', 'user', 'arrRooms','arrCountries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Apartment::find($id)->delete();
        $images = Image::where('apartment_id', $id)->get();

        foreach ($images as $item) {
            Description::where('image_id', $item->id)->delete();
            unlink(public_path() . '/images/' . $item->path);
            $item->delete();
        }

        if (Cache::has('apartment_' . $id)) {
            Cache::forget('apartment_' . $id);
        }

        if (Cache::has('apartments')) {
            Cache::forget('apartments');

            $apartments = Apartment::all();
            Cache::put('apartments', $apartments, 22 * 60);
        }

        return redirect('/');
    }


    public function createApartment()
    {
//              Schema::create('descriptions', function($collection) {
//                    $collection->index('user_id');
//                    $collection->index('image_id');
//
//                    $collection->unique('description');
//                });
//        Apartment::create([
//            'user_id' => Auth::id(),
//            'lat' => '-31.563910',
//            'lng' => '147.154312',
//            'city' => 'Mogilev',
//            'street' => 'Kalvaiyskaya',
//            'house' => '4',
//            'room' => '56'
//        ]);
//        Apartment::create([
//            'user_id' => Auth::id(),
//            'lat' => '-33.718234',
//            'lng' => '150.363181',
//            'city' => 'Minsk',
//            'street' => 'Beruta',
//            'house' => '4',
//            'room' => '16'
//        ]);
//        Apartment::create([
//            'user_id' => Auth::id(),
//            'lat' => '53.910000',
//            'lng' => '27.549999',
//            'city' => 'Bangkok',
//            'street' => 'Rama IX',
//            'house' => '9',
//            'room' => '58'
//        ]);
//        Apartment::create([
//            'user_id' => Auth::id(),
//            'lat' => '13.730000',
//            'lng' => '100.500000',
//            'city' => 'Minsk',
//            'street' => 'Octyabr\'skaya',
//            'house' => '23',
//            'room' => '123'
//        ]);

    }


    public function all()
    {
        $user = Apartment::where('_id', '5a2d08f85da4192c640024bd')->first();

//        $apar = Image::where('apartment_id', 'apart_'.Auth::id())->get();
//        foreach ($apar as $item){
//            echo $item->apartment_id."<br>";
//
//        }
        return $user;
        //return User::find(Auth::id())->apartments;
    }

    public function ajax(Request $request)
    {
        $id = $request['id'];
        //-- Like this possible too
        //$apartment = DB::collection('apartments')->where('_id', $id)->first();
        $apartment = Apartment::find($id);

        return ["status" => true,
            "id" => $id,
            "apartment" => $apartment];
    }


    public function addApartment(Request $request)
    {
        $country = $request['country'];
        $city = $request['city'];
        $description = $request['description'];
        $lat = $request['lat'];
        $room = $request['room'];
        $house = $request['house'];
        $email = $request['email'];
        $phone = $request['phone'];
        $price = $request['price'];
        $street = $request['street'];
        $flatsNo = $request['flatsNo'];
        $lng = $request['lng'];
        $apartmentCreated = Apartment::create([
            'user_id' => Auth::id(),
            'lat' => $lat,
            'lng' => $lng,
            'city' => $city,
            'country' => $country,
            'description' => $description,
            'phone' => $phone,
            'email' => $email,
            'house' => $house,
            'room' => $room,
            'price' => $price,
            'flatsNo' => $flatsNo,
            'street' => $street,
        ]);

        $images = Image::where('apartment_id', 'apart_' . Auth::id())->get();
        foreach ($images as $item) {
            $item->apartment_id = $apartmentCreated->id;
            $item->save();
        }


        if (Cache::has('apartment_' . $apartmentCreated->id)) {
            Cache::forget('apartment_' . $apartmentCreated->id);
        }


        $id = $apartmentCreated->id;
        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });
        $user = $apartment->user;


        if (Cache::has('apartments')) {
            Cache::forget('apartments');

            $apartments = Apartment::all();
            Cache::put('apartments', $apartments, 22 * 60);
        }


        return ["status" => true,
            "apartment" => $apartment,
            'id' => $apartmentCreated->id,
            "user" => $user
        ];
    }


    public function editApartment(Request $request)
    {
        $id = $request['id'];
        $country = $request['country'];
        $city = $request['city'];
        $description = $request['description'];
        $lat = $request['lat'];
        $room = $request['room'];
        $house = $request['house'];
        $email = $request['email'];
        $phone = $request['phone'];
        $price = $request['price'];
        $lng = $request['lng'];
        $street = $request['street'];
        $flatsNo = $request['flatsNo'];
        $apartment = Apartment::where('_id', $id)->first();

        $apartment->user_id = Auth::id();
        $apartment->lat = $lat;
        $apartment->lng = $lng;
        $apartment->city = $city;
        $apartment->country = $country;
        $apartment->description = $description;
        $apartment->phone = $phone;
        $apartment->email = $email;
        $apartment->price = $price;
        $apartment->house = $house;
        $apartment->room = $room;
        $apartment->street = $street;
        $apartment->flatsNo = $flatsNo;
        $apartment->save();
        $images = Image::where('apartment_id', 'apart_' . Auth::id())->get();
        foreach ($images as $item) {
            $item->apartment_id = $apartment->id;
            $item->save();
        }


        if (Cache::has('apartment_' . $id)) {
            Cache::forget('apartment_' . $id);
        }

        $apartment = Cache::remember('apartment_' . $id, 22 * 60, function () use ($id) {
            return Apartment::where('_id', $id)->first();
        });

        if (Cache::has('apartments')) {
            Cache::forget('apartments');

            $apartments = Apartment::all();
            Cache::put('apartments', $apartments, 22 * 60);
        }


        return ["status" => true,
            'id' => $id,
            //'apartment'=>$apartment

        ];
    }


}
