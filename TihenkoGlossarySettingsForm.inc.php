<?php

import('lib.pkp.classes.form.Form');

class TihenkoGlossarySettingsForm extends Form {

    /** @var TihenkoGlossaryPlugin  */
    public $plugin;

    public function __construct($plugin) {

        // Define the settings template and store a copy of the plugin object
        parent::__construct($plugin->getTemplateResource('settings.tpl'));
        $this->plugin = $plugin;

        // Always add POST and CSRF validation to secure your form.
        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));
    }

//use http://www.1728.org/codes.htm to get HTML Character Entities and correct transliteration    
    public function translit($InStr) {
        $trans = array(
            html_entity_decode('&#138;', 0, 'UTF-8')  => 'S'
            , html_entity_decode('&#142;', 0, 'UTF-8')  => 'Z', html_entity_decode('&#154;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#156;', 0, 'UTF-8')  => 'a', html_entity_decode('&#158;', 0, 'UTF-8')  => 'Z'
            , html_entity_decode('&#159;', 0, 'UTF-8')  => 'Y'
            , html_entity_decode('&#192;', 0, 'UTF-8')  => 'A', html_entity_decode('&#193;', 0, 'UTF-8')  => 'A'
            , html_entity_decode('&#194;', 0, 'UTF-8')  => 'A', html_entity_decode('&#195;', 0, 'UTF-8')  => 'A'
            , html_entity_decode('&#196;', 0, 'UTF-8')  => 'A', html_entity_decode('&#197;', 0, 'UTF-8')  => 'A'
            , html_entity_decode('&#198;', 0, 'UTF-8')  => 'A', html_entity_decode('&#199;', 0, 'UTF-8')  => 'C'
            , html_entity_decode('&#200;', 0, 'UTF-8')  => 'E', html_entity_decode('&#201;', 0, 'UTF-8')  => 'E'
            , html_entity_decode('&#202;', 0, 'UTF-8')  => 'E', html_entity_decode('&#203;', 0, 'UTF-8')  => 'E'
            , html_entity_decode('&#204;', 0, 'UTF-8')  => 'I', html_entity_decode('&#205;', 0, 'UTF-8')  => 'I'
            , html_entity_decode('&#206;', 0, 'UTF-8')  => 'I', html_entity_decode('&#207;', 0, 'UTF-8')  => 'I'
            , html_entity_decode('&#208;', 0, 'UTF-8')  => 'D', html_entity_decode('&#209;', 0, 'UTF-8')  => 'N'
            , html_entity_decode('&#210;', 0, 'UTF-8')  => 'O', html_entity_decode('&#211;', 0, 'UTF-8')  => 'O'
            , html_entity_decode('&#212;', 0, 'UTF-8')  => 'O', html_entity_decode('&#213;', 0, 'UTF-8')  => 'O'
            , html_entity_decode('&#214;', 0, 'UTF-8')  => 'O', html_entity_decode('&#215;', 0, 'UTF-8')  => 'X'
            , html_entity_decode('&#216;', 0, 'UTF-8')  => 'O', html_entity_decode('&#217;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#218;', 0, 'UTF-8')  => 'U', html_entity_decode('&#219;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#220;', 0, 'UTF-8')  => 'U', html_entity_decode('&#221;', 0, 'UTF-8')  => 'Y'
            , html_entity_decode('&#222;', 0, 'UTF-8')  => 'p', html_entity_decode('&#223;', 0, 'UTF-8')  => 'ss'
            , html_entity_decode('&#224;', 0, 'UTF-8')  => 'a', html_entity_decode('&#225;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#226;', 0, 'UTF-8')  => 'a', html_entity_decode('&#227;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#228;', 0, 'UTF-8')  => 'a', html_entity_decode('&#229;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#230;', 0, 'UTF-8')  => 'a', html_entity_decode('&#231;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#232;', 0, 'UTF-8')  => 'e', html_entity_decode('&#233;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#234;', 0, 'UTF-8')  => 'e', html_entity_decode('&#235;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#236;', 0, 'UTF-8')  => 'i', html_entity_decode('&#237;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#238;', 0, 'UTF-8')  => 'i', html_entity_decode('&#239;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#240;', 0, 'UTF-8')  => 'o', html_entity_decode('&#241;', 0, 'UTF-8')  => 'n'
            , html_entity_decode('&#242;', 0, 'UTF-8')  => 'o', html_entity_decode('&#243;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#244;', 0, 'UTF-8')  => 'o', html_entity_decode('&#245;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#246;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#248;', 0, 'UTF-8')  => 'o', html_entity_decode('&#249;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#250;', 0, 'UTF-8')  => 'u', html_entity_decode('&#251;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#252;', 0, 'UTF-8')  => 'u', html_entity_decode('&#253;', 0, 'UTF-8')  => 'y'
            , html_entity_decode('&#254;', 0, 'UTF-8')  => 'p', html_entity_decode('&#255;', 0, 'UTF-8')  => 'y'
            , html_entity_decode('&#256;', 0, 'UTF-8')  => 'A', html_entity_decode('&#257;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#258;', 0, 'UTF-8')  => 'A', html_entity_decode('&#259;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#260;', 0, 'UTF-8')  => 'A', html_entity_decode('&#261;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#262;', 0, 'UTF-8')  => 'C', html_entity_decode('&#263;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#264;', 0, 'UTF-8')  => 'C', html_entity_decode('&#265;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#266;', 0, 'UTF-8')  => 'C', html_entity_decode('&#267;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#268;', 0, 'UTF-8')  => 'C', html_entity_decode('&#269;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#270;', 0, 'UTF-8')  => 'D', html_entity_decode('&#271;', 0, 'UTF-8')  => 'd'
            , html_entity_decode('&#272;', 0, 'UTF-8')  => 'Dj', html_entity_decode('&#273;', 0, 'UTF-8')  => 'dj'
            , html_entity_decode('&#274;', 0, 'UTF-8')  => 'E', html_entity_decode('&#275;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#276;', 0, 'UTF-8')  => 'E', html_entity_decode('&#277;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#278;', 0, 'UTF-8')  => 'E', html_entity_decode('&#279;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#280;', 0, 'UTF-8')  => 'E', html_entity_decode('&#281;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#282;', 0, 'UTF-8')  => 'E', html_entity_decode('&#283;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#284;', 0, 'UTF-8')  => 'G', html_entity_decode('&#285;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#286;', 0, 'UTF-8')  => 'G', html_entity_decode('&#287;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#288;', 0, 'UTF-8')  => 'G', html_entity_decode('&#289;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#290;', 0, 'UTF-8')  => 'G', html_entity_decode('&#291;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#292;', 0, 'UTF-8')  => 'H', html_entity_decode('&#293;', 0, 'UTF-8')  => 'h'
            , html_entity_decode('&#294;', 0, 'UTF-8')  => 'H', html_entity_decode('&#295;', 0, 'UTF-8')  => 'h'
            , html_entity_decode('&#296;', 0, 'UTF-8')  => 'I', html_entity_decode('&#297;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#298;', 0, 'UTF-8')  => 'I', html_entity_decode('&#299;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#300;', 0, 'UTF-8')  => 'I', html_entity_decode('&#301;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#302;', 0, 'UTF-8')  => 'I', html_entity_decode('&#303;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#304;', 0, 'UTF-8')  => 'I', html_entity_decode('&#305;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#306;', 0, 'UTF-8')  => '?', html_entity_decode('&#307;', 0, 'UTF-8')  => '?'
            , html_entity_decode('&#308;', 0, 'UTF-8')  => 'J', html_entity_decode('&#309;', 0, 'UTF-8')  => 'j'
            , html_entity_decode('&#310;', 0, 'UTF-8')  => 'K', html_entity_decode('&#311;', 0, 'UTF-8')  => 'k'
            , html_entity_decode('&#312;', 0, 'UTF-8')  => 'K', html_entity_decode('&#313;', 0, 'UTF-8')  => 'L'
            , html_entity_decode('&#314;', 0, 'UTF-8')  => 'l', html_entity_decode('&#315;', 0, 'UTF-8')  => 'L'
            , html_entity_decode('&#316;', 0, 'UTF-8')  => 'l', html_entity_decode('&#317;', 0, 'UTF-8')  => 'L'
            , html_entity_decode('&#318;', 0, 'UTF-8')  => 'l', html_entity_decode('&#319;', 0, 'UTF-8')  => 'L'
            , html_entity_decode('&#320;', 0, 'UTF-8')  => 'l', html_entity_decode('&#321;', 0, 'UTF-8')  => 'L'
            , html_entity_decode('&#322;', 0, 'UTF-8')  => 'l', html_entity_decode('&#323;', 0, 'UTF-8')  => 'N'
            , html_entity_decode('&#324;', 0, 'UTF-8')  => 'n', html_entity_decode('&#325;', 0, 'UTF-8')  => 'N'
            , html_entity_decode('&#326;', 0, 'UTF-8')  => 'n', html_entity_decode('&#327;', 0, 'UTF-8')  => 'N'
            , html_entity_decode('&#328;', 0, 'UTF-8')  => 'n', html_entity_decode('&#329;', 0, 'UTF-8')  => 'n'
            , html_entity_decode('&#330;', 0, 'UTF-8')  => 'B', html_entity_decode('&#331;', 0, 'UTF-8')  => 'n'
            , html_entity_decode('&#332;', 0, 'UTF-8')  => 'O', html_entity_decode('&#333;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#334;', 0, 'UTF-8')  => 'O', html_entity_decode('&#335;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#336;', 0, 'UTF-8')  => 'O', html_entity_decode('&#337;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#340;', 0, 'UTF-8')  => 'R', html_entity_decode('&#341;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#342;', 0, 'UTF-8')  => 'R', html_entity_decode('&#343;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#344;', 0, 'UTF-8')  => 'R', html_entity_decode('&#345;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#346;', 0, 'UTF-8')  => 'S', html_entity_decode('&#347;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#348;', 0, 'UTF-8')  => 'S', html_entity_decode('&#349;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#350;', 0, 'UTF-8')  => 'S', html_entity_decode('&#351;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#352;', 0, 'UTF-8')  => 'S', html_entity_decode('&#353;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#354;', 0, 'UTF-8')  => 'T', html_entity_decode('&#355;', 0, 'UTF-8')  => 't'
            , html_entity_decode('&#356;', 0, 'UTF-8')  => 'T', html_entity_decode('&#357;', 0, 'UTF-8')  => 't'
            , html_entity_decode('&#358;', 0, 'UTF-8')  => 'T', html_entity_decode('&#359;', 0, 'UTF-8')  => 't'
            , html_entity_decode('&#360;', 0, 'UTF-8')  => 'U', html_entity_decode('&#361;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#362;', 0, 'UTF-8')  => 'U', html_entity_decode('&#363;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#364;', 0, 'UTF-8')  => 'U', html_entity_decode('&#365;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#366;', 0, 'UTF-8')  => 'U', html_entity_decode('&#367;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#368;', 0, 'UTF-8')  => 'U', html_entity_decode('&#369;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#370;', 0, 'UTF-8')  => 'U', html_entity_decode('&#371;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#372;', 0, 'UTF-8')  => 'W', html_entity_decode('&#373;', 0, 'UTF-8')  => 'w'
            , html_entity_decode('&#374;', 0, 'UTF-8')  => 'Y', html_entity_decode('&#375;', 0, 'UTF-8')  => 'y'
            , html_entity_decode('&#376;', 0, 'UTF-8')  => 'Y', html_entity_decode('&#377;', 0, 'UTF-8')  => 'Z'
            , html_entity_decode('&#378;', 0, 'UTF-8')  => 'z', html_entity_decode('&#379;', 0, 'UTF-8')  => 'Z'
            , html_entity_decode('&#380;', 0, 'UTF-8')  => 'z', html_entity_decode('&#381;', 0, 'UTF-8')  => 'Z'
            , html_entity_decode('&#382;', 0, 'UTF-8')  => 'z', html_entity_decode('&#383;', 0, 'UTF-8')  => 'f'
            , html_entity_decode('&#384;', 0, 'UTF-8')  => 'b', html_entity_decode('&#385;', 0, 'UTF-8')  => 'b'
            , html_entity_decode('&#386;', 0, 'UTF-8')  => 'b', html_entity_decode('&#387;', 0, 'UTF-8')  => 'b'
            , html_entity_decode('&#389;', 0, 'UTF-8')  => 'b', html_entity_decode('&#391;', 0, 'UTF-8')  => 'c'
            , html_entity_decode('&#428;', 0, 'UTF-8')  => 'T', html_entity_decode('&#430;', 0, 'UTF-8')  => 'T'
            , html_entity_decode('&#432;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#434;', 0, 'UTF-8')  => 'u', html_entity_decode('&#435;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#436;', 0, 'UTF-8')  => 'y', html_entity_decode('&#437;', 0, 'UTF-8')  => 'z'
            , html_entity_decode('&#438;', 0, 'UTF-8')  => 'z', html_entity_decode('&#439;', 0, 'UTF-8')  => 'z'
            , html_entity_decode('&#452;', 0, 'UTF-8')  => 'DZ', html_entity_decode('&#453;', 0, 'UTF-8')  => 'Dz'
            , html_entity_decode('&#454;', 0, 'UTF-8')  => 'dz', html_entity_decode('&#455;', 0, 'UTF-8')  => 'LJ'
            , html_entity_decode('&#456;', 0, 'UTF-8')  => 'Lj', html_entity_decode('&#457;', 0, 'UTF-8')  => 'lj'
            , html_entity_decode('&#458;', 0, 'UTF-8')  => 'NJ', html_entity_decode('&#459;', 0, 'UTF-8')  => 'Nj'
            , html_entity_decode('&#460;', 0, 'UTF-8')  => 'nj', html_entity_decode('&#461;', 0, 'UTF-8')  => 'A'
            , html_entity_decode('&#462;', 0, 'UTF-8')  => 'a', html_entity_decode('&#463;', 0, 'UTF-8')  => 'I'
            , html_entity_decode('&#464;', 0, 'UTF-8')  => 'i', html_entity_decode('&#465;', 0, 'UTF-8')  => 'O'
            , html_entity_decode('&#466;', 0, 'UTF-8')  => 'o', html_entity_decode('&#467;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#468;', 0, 'UTF-8')  => 'u', html_entity_decode('&#469;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#470;', 0, 'UTF-8')  => 'u', html_entity_decode('&#471;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#472;', 0, 'UTF-8')  => 'u', html_entity_decode('&#473;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#474;', 0, 'UTF-8')  => 'u', html_entity_decode('&#475;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#476;', 0, 'UTF-8')  => 'u', html_entity_decode('&#477;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#478;', 0, 'UTF-8')  => 'A', html_entity_decode('&#479;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#480;', 0, 'UTF-8')  => 'A', html_entity_decode('&#481;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#482;', 0, 'UTF-8')  => 'A', html_entity_decode('&#483;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#484;', 0, 'UTF-8')  => 'G', html_entity_decode('&#485;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#486;', 0, 'UTF-8')  => 'G', html_entity_decode('&#487;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#488;', 0, 'UTF-8')  => 'K', html_entity_decode('&#489;', 0, 'UTF-8')  => 'k'
            , html_entity_decode('&#490;', 0, 'UTF-8')  => 'Q', html_entity_decode('&#491;', 0, 'UTF-8')  => 'q'
            , html_entity_decode('&#492;', 0, 'UTF-8')  => 'Q', html_entity_decode('&#493;', 0, 'UTF-8')  => 'q'
            , html_entity_decode('&#496;', 0, 'UTF-8')  => 'j', html_entity_decode('&#497;', 0, 'UTF-8')  => '?'
            , html_entity_decode('&#498;', 0, 'UTF-8')  => 'Dz', html_entity_decode('&#499;', 0, 'UTF-8')  => 'dz'
            , html_entity_decode('&#500;', 0, 'UTF-8')  => 'G', html_entity_decode('&#501;', 0, 'UTF-8')  => 'g'
            , html_entity_decode('&#503;', 0, 'UTF-8')  => 'p'
            , html_entity_decode('&#504;', 0, 'UTF-8')  => 'N', html_entity_decode('&#505;', 0, 'UTF-8')  => 'n'
            , html_entity_decode('&#506;', 0, 'UTF-8')  => 'A', html_entity_decode('&#507;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#508;', 0, 'UTF-8')  => 'A', html_entity_decode('&#509;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#510;', 0, 'UTF-8')  => 'O', html_entity_decode('&#511;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#512;', 0, 'UTF-8')  => 'A', html_entity_decode('&#513;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#514;', 0, 'UTF-8')  => 'A', html_entity_decode('&#515;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#516;', 0, 'UTF-8')  => 'E', html_entity_decode('&#517;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#518;', 0, 'UTF-8')  => 'E', html_entity_decode('&#519;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#520;', 0, 'UTF-8')  => 'I', html_entity_decode('&#521;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#522;', 0, 'UTF-8')  => 'I', html_entity_decode('&#523;', 0, 'UTF-8')  => 'i'
            , html_entity_decode('&#524;', 0, 'UTF-8')  => 'O', html_entity_decode('&#525;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#526;', 0, 'UTF-8')  => 'O', html_entity_decode('&#527;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#528;', 0, 'UTF-8')  => 'R', html_entity_decode('&#529;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#530;', 0, 'UTF-8')  => 'R', html_entity_decode('&#531;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#532;', 0, 'UTF-8')  => 'U', html_entity_decode('&#533;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#534;', 0, 'UTF-8')  => 'U', html_entity_decode('&#535;', 0, 'UTF-8')  => 'u'
            , html_entity_decode('&#536;', 0, 'UTF-8')  => 'S', html_entity_decode('&#537;', 0, 'UTF-8')  => 's'
            , html_entity_decode('&#538;', 0, 'UTF-8')  => 'T', html_entity_decode('&#539;', 0, 'UTF-8')  => 't'
            , html_entity_decode('&#542;', 0, 'UTF-8')  => 'H', html_entity_decode('&#543;', 0, 'UTF-8')  => 'h'
            , html_entity_decode('&#544;', 0, 'UTF-8')  => 'N'
            , html_entity_decode('&#548;', 0, 'UTF-8')  => 'Z', html_entity_decode('&#549;', 0, 'UTF-8')  => 'z'
            , html_entity_decode('&#550;', 0, 'UTF-8')  => 'A', html_entity_decode('&#551;', 0, 'UTF-8')  => 'a'
            , html_entity_decode('&#552;', 0, 'UTF-8')  => 'E', html_entity_decode('&#553;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#554;', 0, 'UTF-8')  => 'O', html_entity_decode('&#555;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#556;', 0, 'UTF-8')  => 'O', html_entity_decode('&#557;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#558;', 0, 'UTF-8')  => 'O', html_entity_decode('&#559;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#560;', 0, 'UTF-8')  => 'O', html_entity_decode('&#561;', 0, 'UTF-8')  => 'o'
            , html_entity_decode('&#562;', 0, 'UTF-8')  => 'Y', html_entity_decode('&#563;', 0, 'UTF-8')  => 'y'
            , html_entity_decode('&#580;', 0, 'UTF-8')  => 'U'
            , html_entity_decode('&#582;', 0, 'UTF-8')  => 'E', html_entity_decode('&#583;', 0, 'UTF-8')  => 'e'
            , html_entity_decode('&#584;', 0, 'UTF-8')  => 'J', html_entity_decode('&#585;', 0, 'UTF-8')  => 'j'
            , html_entity_decode('&#586;', 0, 'UTF-8')  => 'Q', html_entity_decode('&#587;', 0, 'UTF-8')  => 'q'
            , html_entity_decode('&#588;', 0, 'UTF-8')  => 'R', html_entity_decode('&#589;', 0, 'UTF-8')  => 'r'
            , html_entity_decode('&#590;', 0, 'UTF-8')  => 'Y', html_entity_decode('&#591;', 0, 'UTF-8')  => 'y'
            , html_entity_decode('&#1026;', 0, 'UTF-8') => 'Dz'
            , html_entity_decode('&#1025;', 0, 'UTF-8') => 'Jo', html_entity_decode('&#1027;', 0, 'UTF-8') => 'G'
            , html_entity_decode('&#1032;', 0, 'UTF-8') => 'J'
            , html_entity_decode('&#1028;', 0, 'UTF-8') => 'E', html_entity_decode('&#1029;', 0, 'UTF-8') => 'S'
            , html_entity_decode('&#1030;', 0, 'UTF-8') => 'I', html_entity_decode('&#1031;', 0, 'UTF-8') => 'Ji'
            , html_entity_decode('&#1035;', 0, 'UTF-8') => 'Ch'
            , html_entity_decode('&#1036;', 0, 'UTF-8') => 'K', html_entity_decode('&#1037;', 0, 'UTF-8') => 'J'
            , html_entity_decode('&#1038;', 0, 'UTF-8') => 'U', html_entity_decode('&#1039;', 0, 'UTF-8') => 'Dz'
            , html_entity_decode('&#1040;', 0, 'UTF-8') => 'A', html_entity_decode('&#1041;', 0, 'UTF-8') => 'B'
            , html_entity_decode('&#1042;', 0, 'UTF-8') => 'V', html_entity_decode('&#1043;', 0, 'UTF-8') => 'G'
            , html_entity_decode('&#1044;', 0, 'UTF-8') => 'D', html_entity_decode('&#1045;', 0, 'UTF-8') => 'E'
            , html_entity_decode('&#1046;', 0, 'UTF-8') => 'Zh', html_entity_decode('&#1047;', 0, 'UTF-8') => 'Z'
            , html_entity_decode('&#1048;', 0, 'UTF-8') => 'I', html_entity_decode('&#1049;', 0, 'UTF-8') => 'J'
            , html_entity_decode('&#1050;', 0, 'UTF-8') => 'K', html_entity_decode('&#1051;', 0, 'UTF-8') => 'L'
            , html_entity_decode('&#1052;', 0, 'UTF-8') => 'M', html_entity_decode('&#1053;', 0, 'UTF-8') => 'N'
            , html_entity_decode('&#1054;', 0, 'UTF-8') => 'O', html_entity_decode('&#1055;', 0, 'UTF-8') => 'P'
            , html_entity_decode('&#1056;', 0, 'UTF-8') => 'R', html_entity_decode('&#1057;', 0, 'UTF-8') => 'S'
            , html_entity_decode('&#1058;', 0, 'UTF-8') => 'T', html_entity_decode('&#1059;', 0, 'UTF-8') => 'U'
            , html_entity_decode('&#1060;', 0, 'UTF-8') => 'F', html_entity_decode('&#1061;', 0, 'UTF-8') => 'H'
            , html_entity_decode('&#1062;', 0, 'UTF-8') => 'C', html_entity_decode('&#1063;', 0, 'UTF-8') => 'Ch'
            , html_entity_decode('&#1064;', 0, 'UTF-8') => 'Sh', html_entity_decode('&#1065;', 0, 'UTF-8') => 'Sh'
            , html_entity_decode('&#1066;', 0, 'UTF-8') => '"', html_entity_decode('&#1067;', 0, 'UTF-8') => 'Y'
            , html_entity_decode('&#1068;', 0, 'UTF-8') => "'", html_entity_decode('&#1069;', 0, 'UTF-8') => 'Je'
            , html_entity_decode('&#1070;', 0, 'UTF-8') => 'Ju', html_entity_decode('&#1071;', 0, 'UTF-8') => 'Ja'
            , html_entity_decode('&#1072;', 0, 'UTF-8') => 'a', html_entity_decode('&#1073;', 0, 'UTF-8') => 'b'
            , html_entity_decode('&#1074;', 0, 'UTF-8') => 'v', html_entity_decode('&#1075;', 0, 'UTF-8') => 'g'
            , html_entity_decode('&#1076;', 0, 'UTF-8') => 'd', html_entity_decode('&#1077;', 0, 'UTF-8') => 'e'
            , html_entity_decode('&#1078;', 0, 'UTF-8') => 'zh', html_entity_decode('&#1079;', 0, 'UTF-8') => 'z'
            , html_entity_decode('&#1080;', 0, 'UTF-8') => 'i', html_entity_decode('&#1081;', 0, 'UTF-8') => 'j'
            , html_entity_decode('&#1082;', 0, 'UTF-8') => 'k', html_entity_decode('&#1083;', 0, 'UTF-8') => 'l'
            , html_entity_decode('&#1084;', 0, 'UTF-8') => 'm', html_entity_decode('&#1085;', 0, 'UTF-8') => 'n'
            , html_entity_decode('&#1086;', 0, 'UTF-8') => 'o', html_entity_decode('&#1087;', 0, 'UTF-8') => 'p'
            , html_entity_decode('&#1088;', 0, 'UTF-8') => 'r', html_entity_decode('&#1089;', 0, 'UTF-8') => 's'
            , html_entity_decode('&#1090;', 0, 'UTF-8') => 't', html_entity_decode('&#1091;', 0, 'UTF-8') => 'u'
            , html_entity_decode('&#1092;', 0, 'UTF-8') => 'f', html_entity_decode('&#1093;', 0, 'UTF-8') => 'h'
            , html_entity_decode('&#1094;', 0, 'UTF-8') => 'c', html_entity_decode('&#1095;', 0, 'UTF-8') => 'ch'
            , html_entity_decode('&#1096;', 0, 'UTF-8') => 'sh', html_entity_decode('&#1097;', 0, 'UTF-8') => 'sh'
            , html_entity_decode('&#1098;', 0, 'UTF-8') => '``', html_entity_decode('&#1099;', 0, 'UTF-8') => 'y'
            , html_entity_decode('&#1100;', 0, 'UTF-8') => "`", html_entity_decode('&#1101;', 0, 'UTF-8') => 'je'
            , html_entity_decode('&#1102;', 0, 'UTF-8') => 'ju', html_entity_decode('&#1103;', 0, 'UTF-8') => 'ja'
            , html_entity_decode('&#1104;', 0, 'UTF-8') => 'e', html_entity_decode('&#1105;', 0, 'UTF-8') => 'jo'
            , html_entity_decode('&#1106;', 0, 'UTF-8') => 'dz', html_entity_decode('&#1107;', 0, 'UTF-8') => 'g'
            , html_entity_decode('&#1108;', 0, 'UTF-8') => 'e', html_entity_decode('&#1109;', 0, 'UTF-8') => 's'
            , html_entity_decode('&#1110;', 0, 'UTF-8') => 'i', html_entity_decode('&#1111;', 0, 'UTF-8') => 'ji'
            , html_entity_decode('&#1112;', 0, 'UTF-8') => 'j', html_entity_decode('&#1033;', 0, 'UTF-8') => 'Lj'
            , html_entity_decode('&#1113;', 0, 'UTF-8') => 'lj', html_entity_decode('&#1034;', 0, 'UTF-8') => 'Nj'
            , html_entity_decode('&#1114;', 0, 'UTF-8') => 'nj', html_entity_decode('&#1115;', 0, 'UTF-8') => 'ch'
            , html_entity_decode('&#1116;', 0, 'UTF-8') => 'k', html_entity_decode('&#1117;', 0, 'UTF-8') => 'ij'
            , html_entity_decode('&#1118;', 0, 'UTF-8') => 'u', html_entity_decode('&#1119;', 0, 'UTF-8') => 'dz'
            , html_entity_decode('&#1140;', 0, 'UTF-8') => 'V', html_entity_decode('&#1141;', 0, 'UTF-8') => 'v'
            , html_entity_decode('&#1142;', 0, 'UTF-8') => 'V', html_entity_decode('&#1143;', 0, 'UTF-8') => 'v'
            , html_entity_decode('&#1144;', 0, 'UTF-8') => 'O', html_entity_decode('&#1145;', 0, 'UTF-8') => 'o'
            , html_entity_decode('&#1162;', 0, 'UTF-8') => 'J', html_entity_decode('&#1163;', 0, 'UTF-8') => 'J'
            , html_entity_decode('&#1166;', 0, 'UTF-8') => 'R', html_entity_decode('&#1167;', 0, 'UTF-8') => 'r'
            , html_entity_decode('&#1168;', 0, 'UTF-8') => 'G', html_entity_decode('&#1169;', 0, 'UTF-8') => 'g'
            , html_entity_decode('&#1170;', 0, 'UTF-8') => 'F', html_entity_decode('&#1171;', 0, 'UTF-8') => 'f'
            , html_entity_decode('&#1174;', 0, 'UTF-8') => 'Zh', html_entity_decode('&#1175;', 0, 'UTF-8') => 'zh'
            , html_entity_decode('&#1176;', 0, 'UTF-8') => 'Z', html_entity_decode('&#1177;', 0, 'UTF-8') => 'z'
            , html_entity_decode('&#1178;', 0, 'UTF-8') => 'K', html_entity_decode('&#1179;', 0, 'UTF-8') => 'k'
            , html_entity_decode('&#1180;', 0, 'UTF-8') => 'K', html_entity_decode('&#1181;', 0, 'UTF-8') => 'k'
            , html_entity_decode('&#1182;', 0, 'UTF-8') => 'K', html_entity_decode('&#1183;', 0, 'UTF-8') => 'k'
            , html_entity_decode('&#1184;', 0, 'UTF-8') => 'K', html_entity_decode('&#1185;', 0, 'UTF-8') => 'k'
            , html_entity_decode('&#1186;', 0, 'UTF-8') => 'N', html_entity_decode('&#1187;', 0, 'UTF-8') => 'n'
            , html_entity_decode('&#1188;', 0, 'UTF-8') => 'N', html_entity_decode('&#1189;', 0, 'UTF-8') => 'n'
            , html_entity_decode('&#1190;', 0, 'UTF-8') => 'N'
            , html_entity_decode('&#1244;', 0, 'UTF-8') => 'Zh', html_entity_decode('&#1245;', 0, 'UTF-8') => 'zh'
            , html_entity_decode('&#1246;', 0, 'UTF-8') => 'z', html_entity_decode('&#1247;', 0, 'UTF-8') => 'z'
            , html_entity_decode('&#1248;', 0, 'UTF-8') => 'z', html_entity_decode('&#1249;', 0, 'UTF-8') => 'z'
            , html_entity_decode('&#1250;', 0, 'UTF-8') => 'J', html_entity_decode('&#1251;', 0, 'UTF-8') => 'j'
            , html_entity_decode('&#1252;', 0, 'UTF-8') => 'I', html_entity_decode('&#1253;', 0, 'UTF-8') => 'i'
            , html_entity_decode('&#1254;', 0, 'UTF-8') => 'O', html_entity_decode('&#1255;', 0, 'UTF-8') => 'O'
            , html_entity_decode('&#1256;', 0, 'UTF-8') => 'O', html_entity_decode('&#1257;', 0, 'UTF-8') => 'e'
            , html_entity_decode('&#1258;', 0, 'UTF-8') => 'E', html_entity_decode('&#1259;', 0, 'UTF-8') => 'e'
            , html_entity_decode('&#1260;', 0, 'UTF-8') => 'Je', html_entity_decode('&#1261;', 0, 'UTF-8') => 'je'
            , html_entity_decode('&#1262;', 0, 'UTF-8') => 'u', html_entity_decode('&#1263;', 0, 'UTF-8') => 'u'
            , html_entity_decode('&#1264;', 0, 'UTF-8') => 'U', html_entity_decode('&#1265;', 0, 'UTF-8') => 'u'
            , html_entity_decode('&#1266;', 0, 'UTF-8') => 'U', html_entity_decode('&#1267;', 0, 'UTF-8') => 'u'
            , html_entity_decode('&#1268;', 0, 'UTF-8') => 'Ch', html_entity_decode('&#1269;', 0, 'UTF-8') => 'ch');

        return strtr($InStr, $trans);
    }

    //remove specific symbols from js output
    public function slashWord($word) {
        return trim(str_replace(array('"', '\s', '\n', '\r'), array("'", ' ', ' ', ' '), $word));
    }

    /**
     * Load settings already saved in the database
     *
     * Settings are stored by context, so that each journal or press
     * can have different settings.
     */
    public function initData() {
        $contextId = Application::get()->getRequest()->getContext()->getId();
        $secretKey = $this->plugin->getSetting($contextId, 'secretKey');
        $jsDBstatus = $this->plugin->getSetting($contextId, 'jsDBstatus');
        $this->setData('jsDBstatus', $jsDBstatus); 
        $this->setData('secretKey', date('Y-m-d H:i:s')); //$secretKey

        $this->setData('pluginDB', Application::get()->getRequest()->getBaseUrl() . '/' . $this->plugin->getPluginPath() . '/js/tihenkoGlossaryPluginDB_' . AppLocale::getLocale() . '.js?code=' . $secretKey);
        $this->setData('pluginScript', Application::get()->getRequest()->getBaseUrl() . '/' . $this->plugin->getPluginPath() . '/js/tihenkoGlossaryPlugin.js');

        parent::initData();
    }

    /**
     * Load data that was submitted with the form
     */
    public function readInputData() {
        $this->readUserVars(['secretKey']);
        $this->readUserVars(['jsDBstatus']);
        $this->readUserVars(['newWord']);
        $this->readUserVars(['newWordMeaning']);
        $this->readUserVars(['id']);
        $this->readUserVars(['synonymID']);
        $this->readUserVars(['dbAction']);
        parent::readInputData();
    }

    /**
     * Fetch any additional data needed for your form.
     *
     * Data assigned to the form using $this->setData() during the
     * initData() or readInputData() methods will be passed to the
     * template.
     */
    public function fetch($request, $template = null, $display = false) {

        // Pass the plugin name to the template so that it can be
        // used in the URL that the form is submitted to
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->plugin->getName());

        return parent::fetch($request, $template, $display);
    }

    /**
     * Save the settings
     */
    public function execute() {
        $result = ''; //this will be outputed for user
        $contextId = Application::get()->getRequest()->getContext()->getId();
        //$this->plugin->updateSetting($contextId, 'secretKey', $this->slashWord($this->getData('secretKey')));
        //update for both journals
        $this->plugin->updateSetting(1, 'secretKey', $this->slashWord($this->getData('secretKey')));
        $this->plugin->updateSetting(2, 'secretKey', $this->slashWord($this->getData('secretKey')));
        
        $this->plugin->updateSetting($contextId, 'jsDBstatus', $this->getData('jsDBstatus'));
        
        $newWord = $this->slashWord($this->getData('newWord'));
        $newWordMeaning = $this->slashWord($this->getData('newWordMeaning'));
        $id = $this->getData('id');
        $synonymID = $this->getData('synonymID');

        $glossDao = DAORegistry::getDAO('GlossaryDAO');

        if ($this->getData('dbAction') === 'insert' and $newWord != '' and $newWordMeaning != '') {

            $glossDao->insert($newWord, $this->translit($newWord), $newWordMeaning, $synonymID);
            $result.=$newWord." ". __('plugins.generic.tihenkoGlossary.inserted')." ";
        }
        else if ($this->getData('dbAction') == 'update') {
            $glossDao->updateWord($id, $newWord, $this->translit($newWord), $newWordMeaning, $synonymID);
            $result.=$newWord." ". __('plugins.generic.tihenkoGlossary.updated')." ";
        }
        else if ($this->getData('dbAction') == 'delete' and $newWord != '') {
            $glossDao->delete($id);
            $result.=$newWord." ". __('plugins.generic.tihenkoGlossary.deleted')." ";
        }
        
        //Now we will save only for currently selected language
        //$langs = $glossDao->getSupportedLang(); //get lang list
        //Create js script to highlite words in text for each supported language
        //foreach ($langs as $lang)
        $lang = AppLocale::getLocale(); 
        //update js db
        if ($this->getData('jsDBstatus')) {
            $glossaryCode = '//Script generated on ' . date('Y-m-d H:i:s') . ' with code: ' . $this->getData('secretKey') . '
                    glos = {';
            $glossResult = $glossDao->retrieve('SELECT id, word, wordtrans, synonymid
                                            FROM glossary  
                                            WHERE lang="' . $lang . '" 
                                            ORDER BY id');
            foreach ($glossResult as $row) 
		{                                                                                                                     
                $glossaryCode .= "\"" . $this->slashWord($row->word) . "\":[" . $row->id . ",\"" . $row->wordtrans . "\"," . $row->synonymid ."],";
            }
            $glossaryCode = substr($glossaryCode, 0, -1) . '}';
            $f = fopen($this->plugin->getPluginPath() . '/js/tihenkoGlossaryPluginDB_' . $lang . '.js', 'w');
            fwrite($f, $glossaryCode);
            fclose($f);
            $result.=__('plugins.generic.tihenkoGlossary.scriptgenerated') . ' ' . $lang . ' ' . __('plugins.generic.tihenkoGlossary.withkey') . ' ' . $this->getData('secretKey');
        }

        // Tell the user that the save was successful.
        import('classes.notification.NotificationManager');
        $notificationMgr = new NotificationManager();
        $notificationMgr->createTrivialNotification(
                Application::get()->getRequest()->getUser()->getId(),
                NOTIFICATION_TYPE_SUCCESS,
                ['contents' => $result] 
        );

        return parent::execute();
    }

}
