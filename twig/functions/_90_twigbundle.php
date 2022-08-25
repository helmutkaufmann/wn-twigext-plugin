<?php namespace Mercator\TwigExt;

use App;
use Twig\Extra\String\StringExtension;
use Twig\Extra\Intl\IntlExtension;
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

];



?>
