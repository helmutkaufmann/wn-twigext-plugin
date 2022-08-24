<?php namespace Mercator\TwigExt;

use App;
use Twig\Extra\String\StringExtension;
use Twig\Extra\Intl\IntlExtension;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\CodePointString;
use Symfony\Component\String\UnicodeString;


//
// Add Twig\Extra\String\StringExtension
// Add Twig\Extra\Intl\IntlExtension
//

$functions += [

    'country_timezones' => function (?string $country){
      return (new IntlExtension())->getCountryTimezones($country);
    },

    'u' => function ($string) {
      return new UnicodeString($string ?? '');
    },

    'b' => function ($string) {
      return new ByteString($string ?? '');
    },

    'UnicodeString' => function ($string) {
      return new UnicodeString($string ?? '');
    },

    'ByteString' => function ($string) {
      return new ByteString($string ?? '');
    }
    
];



?>
