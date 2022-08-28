# TwigExt - Mercator Twig Extensions

TwigExt provides additiona Twig filters and functions for [WinterCMS](https://wintercms.com). In addition, it allows developers to easily add new Twig
functions and filters to a [WinterCMS](https://wintercms.com) theme.

The plugin was originally based OctoberCMS' [Twig Extensions](https://github.com/vojtasvoboda/oc-twigextensions-plugin) by Vojta Svoboda and included that functionality. Porting the original version to Winter 1.2 required quite some effort and it also became more and more apparant over time that
the plugin contains duplication in functionality, e.g., the filter ``truncate``, which is also provided as ``u.truncate``. Also, access to
built-in Laravel functionality, such as to the ``Storage``and other classes, had been maintained manually, which is prone to error.

This revised
version replaces the existing hand-coded functions to Laravel functionality by providing access through an object. For example, adding a key to
the cache for 10 seconds is now ``cache().add("key", "value", 10)`` as opposed to ``cacheAdd("key", "value", 10)``. While this looks trivial at
first sight, it is a true step forward as it reduces the number of filters and functions Winter has to read and maintain internally and -
maintenance-wise - 90% of the original code of this plugin can be removed.
In addtion, developers will at all times have access to the latest Laravel functions available through these classes and can consult the
original Laravel documentation if required.

Currently the following Laravel classes and related methods are available: Storage, Crypt, Cookie, Cache, Session, Hashing.

## Installation
Use Composer to install the plugin by executing

```
composer require mercator/wn-twigext-plugin "^2.0"
```

from the root of your [WinterCMS](https://wintercms.com) installation.

Alternatively, create a directory "mercator/twigext", download the [files from Github](https://github.com/helmutkaufmann/wn-twigext-plugin) and move them in the newly created sub-directory.

Installation from the [WinterCMS](https://wintercms.com) backend will be added once the [WinterCMS](https://wintercms.com) marketplace is available.

You can now use the newly added filters and functions in your theme (layouts, partials, ....). For example:

```
{% redirect('https://mercator.li') %}
```
or
```
{% redirect('/contact') %}
```
or
```
This is just {{ 'great' | uppercase }}
```

## Available functions

### Laravel Native Functionality
Similar to Twig's ``u`` filter, which provides access to Symfony's UnicodeString instance, TwigExt provides direct access to functions
provided by Laravel. At the moment, the following functionalities can be accesed:
- [Storage functionality](https://laravel.com/docs/9.x/filesystem) through Twig function ``storage``
- [Cryptograhic functionality](https://laravel.com/docs/9.x/encryption) through Twig function ``crypt``
- [Cache functionality](https://laravel.com/docs/9.x/cache) through Twig function ``cache``
- [Cookie functionality](https://laravel.com/docs/9.x/responses#attaching-cookies-to-responses) through Twig function ``cookie``
- [Session functionality](https://laravel.com/docs/9.x/session) through Twig function ``session``
- [Hashing functionality](https://laravel.com/docs/9.x/hashing#main-content) through Twig function ``hashing``

Usage is best illustrated by an example: Write a key/value pair to the cache for 10 seconds and retrieve it subsequently:
```
{{ cache().put("TwigExt", "is great", 10) }}
{{ cache().get("TwigExt") }}
```

As a second example, to retrieve all files on disk "portfolio", just use the following
```
{% set files = storage().disk("portfolio").allFiles() %}
```
All functions of the respective Laravel classes can be used in this way - simple, isn't it?
Please see the respective Laravel documentation mentioned above for details on the available functionality.

While the above approach will probably satisy 90% of the use cases, there are limitations, e.g., closures as ber the below
cannot be implemented:
```
$value = Cache::rememberForever('users', function () {
    return DB::table('users')->get();
});
```

In case you want to access other objects, you can do so by using the special function ``accesObject(class name)``.
To illustrate it, imagine for a second that the Twig function ``cache`` had not been defined as per the above,
in this case, you could access methods of the ``Cache``class through:
```
{{ accesObject("Cache").put("TwigExt", "is great", 10) }}
{{ accesObject("Cache").get("TwigExt") }}
```

Note: In the documentation below the description of the corresponding functions of version 1 of this plugin has been
removed, the functions itself have not been removed for the very time being.

### QR Code
#### QR code for inline use (qrcodeSRC and qrcodeIMG)
Create a GIF with a red QR code on a transparent background pointing to *mercator.li*:
```
<img alt="mercator dot li" src="{{ qrcodeSRC("https://mercator.li", 2, "XXXXXX", "000000") }}">
```
alternatively, use the short version
```
{{ qrcodeIMG("https://mercator.li", 2, "XXXXXX", "FF0000") }}
```
to produce the full image tag, i.e.
```
<img alt="https://mercator.li" src="{{ qrcodeSRC("https://mercator.li", 2, "XXXXXX", "FF0000") }}">
```
In this case, *alt* will be the same as the actual QR code content.


You can create all different sorts of QR codes, e.g. a vcard:
```
{{ qrcodeIMG("
BEGIN:VCARD
VERSION:2.1
FN:Max Mustermann
N:Mustermann;Max
TITLE:Dr.sc.techn.
TEL;CELL:+41 23 456 78 90
TEL;WORK;VOICE:+41 44 123 45 67
TEL;HOME;VOICE:+41 43 123 45 67
EMAIL;HOME;INTERNET:max.mustermann@musterorg.com
EMAIL;WORK;INTERNET:max.mustermann.private@mustermax.ch
URL:http://musterorg.com
ADR:;;Haputplatz 1;Kussnacht am Rigi;SZ;6403;Schweiz
ORG: Musterorg
END:VCARD
", 4) }}
```

Parameters for the above functions are:
- text: Text to be converted to a QR code, e.g. https://mercator.li. Defaults to "no data here".
- scale: Scale factor of the QR code, 1 being the smallest. Defaults to 2.
- background: Background color in RGB hex format. Set to XXXXXX to generate a transparent background. Defaults to XXXXXX, which is transparent.
- foreground: Foreground color in RGB hex format. Defaults to 000000, which is black.
- ecc: Error correction level, valid values: qr, qr-l, qr-m, qr-q, qr-h. Defaults to qr-l.

### Geo-Coding
Provide geo coordinates (longitude and latitude) for a given street address. Usage:

```
{% set geo = geocodeAddress("Pardeplatz, Zurich, Switzerland) %}
The address is located at {{ geo.longitude }} {{ geo.latitude }} (long/lat).
```

### Paths
Providing Winter's path helper functionality as Twig functions:
- pathBase([file = ""]) --> fully qualified path to a given file relative to Winter's root directory
- pathConfig([file = ""]) --> fully qualified path to a given file relative to the configuration directory
- pathDatabase([file = ""]) --> fully qualified path to a given file relative to the configuration directory
- pathMedia([file = ""]) --> fully qualified path to a given file relative to the media directory
- pathPlugins([file = ""]) --> fully qualified path to a given file relative to the plugins directory
- pathPublic([file = ""]) --> fully qualified path to a given file relative to the public directory
- pathStorage([file = ""]) --> fully qualified path to a given file relative to the storage directory
- pathTemp([file = ""]) --> fully qualified path to a given file relative to the temp directory
- pathThemes([file = ""]) --> fully qualified path to a given file relative to the themes directory
- pathUpload([file = ""]) --> fully qualified path to a given file relative to the upload directory

### preg_grep
Providing pattern matching capabilities.

preg_grep(array of strings, pattern, [flags = 0]) takes an array of *strings* and returns an array containing only elements from the input that match the given *pattern*, see the respective PHP function preg_grep for details.

Example pattern to identify all GIFs, JP(E)G and TIF(F) files: ```"/(\.+)(?i:png|jpg|jpeg|gif|tiff|tif)/"```

### Communication
#### telegram
telegram (message, [botID=null], [chatID=null]) sends a message to a Telegram ChatBot, using the said **chat**. If the ChatBot ID and chat ID are not defined, defaults as defined in the backend are used. Talk to [BOT Father](https://core.telegram.org/bots#6-botfather) to create a ChatBotID and a respective chat.

#### mailRawTo
mailRawTo(message, [recipient]) sends *message* to the recipient *recipient*. If recipient is not specified, the default recipient is used as defined in the backend settings.


### redirect

Redirects to a specific URL
```
{{ redirect('https://mercator.li') }}
```
or
```
{{ redirect('/contact') }}
```

### config

Function move the functionality of the Laravel `config()` helper function to Twig.

```
{{ config('app.locale') }}
```
The example would output the value currently stored in `app.locale`.
See [more about the Laravel config helper function here](https://laravel.com/docs/5.0/configuration#accessing-configuration-values).

### env

Function move the functionality of the Laravel `env()` helper function to Twig.

```
{{ env('APP_ENV', 'production') }}
```

The example would output the value currently stored in `APP_ENV` environment variable. Second parameter is default value, when ENV key does not exists.

### trans

Function move the functionality of the Laravel `trans()` helper function to Twig.

```
{{ trans('acme.blog::lang.app.name') }}
```
The example would output a value stored in a localization file of an imaginary blog plugin.
See [more about localization in Winter CMS here](https://wintercms.com/docs/plugin/localization).

### var_dump

Dumps information about a variable. Can be also used as filter.

```
<pre>{{ var_dump(users) }}</pre>
```

### template\_from\_string

Function loads a template from a string.

```
{% set name = 'John' %}
{{ include(template_from_string("Hello {{ name }}")) }}
{{ include(template_from_string("Hurry up it is: {{ 'now'|date('m/d/Y') }}")) }}
```

## Available filters

strftime, uppercase, lowercase, ucfirst, lcfirst, ltrim, rtrim, str\_repeat,
plural, truncate, wordwrap, strpad, str_replace, strip_tags, leftpad, rightpad, rtl, shuffle, time\_diff,
localizeddate, localizednumber, localizedcurrency, mailto, var\_dump, revision, sortbyfield

### ucfirst

Make a string's first character uppercase.

```
Hello I'm {{ 'jack' | ucfirst }}
```

The example would output *Hello I'm Jack*.

### lcfirst

Make a string's first character lowercase.

```
Hello I'm {{ 'Jack' | lcfirst }}
```

The example would output *Hello I'm jack*.

### str_repeat

Repeat a string.

```
I'm the {{ 'best' | str_repeat(3) }}!
```

The example would output *I'm the best best best!*

### plural

Get the plural form of an English word.

```
You have {{ count }} new {{ 'mail' | plural(count) }}
```

The example would output *You have 1 new mail* or *You have 3 new mails* - depending on mails count.

### str_replace

Replace all occurrences of the search string with the replacement string.

```
{{ 'Alice' | str_replace('Alice', 'Bob') }}
```

This would return:

```
Bob
```

### shuffle

Shuffle an array.

```
{{ songs | shuffle }}
```

or in foreach:

```
{% for fruit in ['apple', 'banana', 'orange'] | shuffle %}
	{{ fruit }}
{% endfor %}
```

### time_diff

Use the time_diff filter to render the difference between a date and now.

```
{{ post.published_at | time_diff }}
```

The example above will output a string like 4 seconds ago or in 1 month, depending on the filtered date.

Output is **translatable**. All translations are stored at `/lang` folder in this plugin. If you want more locales, just copy them from [this repository](https://github.com/KnpLabs/KnpTimeBundle/tree/master/Resources/translations), replace `%count%` with `:count` and send it as pull reqest to this repository.

#### Arguments

- date: The date for calculate the difference from now. Can be a string or a DateTime instance.
- now: The date that should be used as now. Can be a string or a DateTime instance. Do not set this argument to use current date.



### mailto

Filter for rendering email as normal mailto link, but with encryption against bots!

```
{{ 'do-not-reply-to-this@gmail.com' | mailto }}
```

returns something along the lines

```
<span id="e846043876">[javascript protected email address]</span><script type="text/javascript">/*<![CDATA[*/eval("var a=\"9IV1G0on6.ryWZYS28iPcNBwq4aeUJF5CskjuLQAh3XdlEz@7KtmpHbTxM-ODg_+Rvf\";var b=a.split(\"\").sort().join(\"\");var c=\"_TtD3O_TXTl3VdfZ@H3KpVdTH\";var d=\"\";for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));document.getElementById(\"e846043876\").innerHTML=\"<a href=\\\"mailto:\"+d+\"\\\">\"+d+\"</a>\"")/*]]>*/</script>
```

which will be rendered to page as normal

```
<a href="mailto:do-not-reply-to-this@gmail.com">do-not-reply-to-this@gmail.com</a>
```

PHP encrypts your email address and generates the JavaScript that decrypts it. Most bots can't execute JavaScript and that is what makes this work. A visitors of your web page will not notice that you used this script as long as they has JavaScript enabled. The visitors will see "[javascript protected email address]" instead of the email address if they has JavaScript disabled.

#### Filter parameters

```
{{ 'do-not-reply-to-this@gmail.com' | mailto(true, true, 'Let me know', 'my-class') }}
```

- first boolean parameter = returns email clickable (with link)
- second boolean parameter = encryption is enabled
- third string parameter = link text (not encrypted!)
- fourth (optional) parameter = CSS class name (will render &lt;a mailto:.. class="my-class"&gt;..)

### var_dump

Dumps information about a variable.

```
<pre>{{ users | var_dump }}</pre>
```

### revision

Force the browser to reload cached modified/updated asset files.
You can provide a format parameter so that the prepended timestamp get converted accordingly to the PHP date() function.

```
<img src="{{ 'assets/images/image_file.jpg' | theme | revision("m.d.y.H.i.s") }}" alt="an image" />
```

will return something like
```
<img src="https://www.example.com/themes/my-theme/assets/image_file.png?12.03.16.04.52.38" alt="An image" />
```

### sortbyfield

Sort array/collection by given field (key).

```
{% set data = [{'name': 'David', 'age': 31}, {'name': 'John', 'age': 28}] %}
{% for item in data | sortbyfield('age') %}
    {{ item.name }}&nbsp;
{% endfor %}
```
Output will be: John David

# Adding New Filters and Functions
Often, a project requires a few specific functions. These can be added by adding **twig/functions** or **twig/filters** subdirectories to
the current theme and include files with functions and filters in there. TwigExt will load all files starting with an underscore **\_** and ending in **.php**
and make the included filters and functions available in Twig.

Functions are added as follow (by placing them, e.g, in **twig/functions/\_myFunctions.php** in the active themes directory):
```
<?php

$functions += [

   'myConfig' => function ($api_key, $g) {
       $res = Settings::get($api_key, $g);
       return "Result is: $res";
   }
];
```

Filters are added as follow (by placing them, e.g, in **twig/filters/\_myFilters.php** in the active themes directory):
```
<?php

$filters += [
'replacestring' => function ($greetings, $search, $replace) {
		return str_replace($search, $replace, $string);
	}
];
```

Filters and functions MUST provide return values. Multiple new filters or functions can be added to the respective arrays in one go.
See [Winter's documentation](https://wintercms.com/docs/plugin/registration#extending-twig) for additional details.

## Contributing

*Feel free to send pull request!* Please, send Pull Request to master branch.

## License

Twig extensions plugin is open source software licensed under the [MIT license](http://opensource.org/licenses/MIT).
