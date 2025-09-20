<?php namespace Mercator\TwigExt;

use App;
use Twig\Extra\String\StringExtension;
use Twig\Extra\Intl\IntlExtension;
use Symfony\Component\String\UnicodeString;

$filters += [

  //
  // Deprecated, use u.truncate
  //
  'truncate' => function (?string $text, $length, $flag=null, $ellipsis=""){
    return (new UnicodeString($text))->truncate($length, $ellipsis, $flag);
  },
  //
  // Deprecated, use u.wordwrap
  //
  'wordwrap' => function (?string $text, $length, $separator="<br>"){
    return (new UnicodeString($text))->wordwrap($length,$separator,true);
  },

  //
  // Deprecated, use native format_datetime
  //
  'localizeddate' => function (?string $text, ?string $dateFormat="medium", ?string $timeFormat="medium", ?string $pattern="", ?string $timezone=null){
        $twig = App::make('twig.environment');
        return (new IntlExtension())->formatDateTime($twig, $text, $dateFormat, $timeFormat, $pattern, $timezone);
  },
  //
  // Deprecated, use native format_number
  //
  'localizednumber' => function ($number, $style = 'decimal', $type = 'default', $locale = null) {
        return (new IntlExtension())->formatNumberStyle($style, $number, [], $type, $locale);
  },
  //
  // Deprecated, use native format_currency
  //
  'localizedcurrency' => function ($number, $currency = null, $locale = null)  {
        return (new IntlExtension())-> formatCurrency($number, $currency, [], $locale);
      },
/*
    'country_name' => function (?string $country, string $locale = null){
      return (new IntlExtension())->getCountryName($country, $locale);
    },

    'currency_name' => function (?string $currency, string $locale = null) {
      return (new IntlExtension())->getCurrencyName($currency, $locale);
    },

    'currency_symbol' => function (?string $currency, string $locale = null){
      return (new IntlExtension())->getCurrencySymbol($currency, $locale);
    },

    'language_name' => function (?string $language, string $locale = null){
      return (new IntlExtension())->getLanguageName($language, $locale);
    },

    'locale_name' => function (?string $data, string $locale = null){
      return (new IntlExtension())->getLocaleName($data, $locale);
    },

    'timezone_name' => function (?string $timezone, string $locale = null){
      return (new IntlExtension())->getTimezoneName($timezone, $locale);
    },

    'format_time' => function($date, $timeFormat = 'medium', $pattern = '', $timezone = null,
                               $calendar = 'gregorian',  $locale = null) {
      return (new IntlExtension())->formatTime($date, $timeFormat,  $pattern, $timezone, $calendar, $locale);
    },

    'format_currency' => function($amount, string $currency, array $attrs = [], string $locale = null) {
        return (new IntlExtension())->formatCurrency($amount,  $currency, $attrs, $locale);
    },

    'format_number' => function($number, array $attrs = [], string $style = 'decimal', string $type = 'default', string $locale = null) {
        return (new IntlExtension())->formatNumber($number,  $attrs, $style, $type, $locale);
    },

    'format_*_number' => function(string $style, $number, array $attrs = [], string $type = 'default', string $locale = null) {
        return (new IntlExtension())->formatNumber($style, $number, $attrs, $type, $locale);
    },

    'format_datetime' => function($date, ?string $dateFormat = 'medium', ?string $timeFormat = 'medium',
                                   string $pattern = '', $timezone = null, string $calendar = 'gregorian', string $locale = null) {
      return (new IntlExtension())->formatDateTime(App::make('twig.environment'), $date, $dateFormat,  $timeFormat, $pattern, $timezone, $calendar, $locale);
    },

    'format_date' => function(Environment $env, $date, ?string $dateFormat = 'medium',
                      string $pattern = '', $timezone = null, string $calendar = 'gregorian', string $locale = null) {
      return (new IntlExtension())->formatDate(App::make('twig.environment'), $date, $dateFormat, $pattern, $timezone, $calendar, $locale);
    },

    'format_time' => function(Environment $env, $date, ?string $timeFormat = 'medium',
                      string $pattern = '', $timezone = null, string $calendar = 'gregorian', string $locale = null) {
      return (new IntlExtension())->formatTime(App::make('twig.environment'), $date, $timeFormat, $pattern, $timezone, $calendar, $locale);
    },

    'data_uri' => function (string $data, string $mime = null, array $parameters = []){
      return (new HtmlExtension())->dataUri($data, $mime, $parameters);
    },
  */
];

?>
