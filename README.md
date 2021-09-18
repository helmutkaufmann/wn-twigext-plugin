# TwigExt - Mercator Twig Extensions


TwigExt provides a set of Twig filters and functions for [WinterCMS](https://wintercms.com).  In addition, it allows developers to easily add new Twig
functions and filters to a [WinterCMS](https://wintercms.com) theme.

The plugin is based on OctoberCMS' [Twig Extensions](https://github.com/vojtasvoboda/oc-twigextensions-plugin) by Vojta Svoboda and includes that functionality.
It has been tested with [WinterCMS](https://wintercms.com) 1.1.3.

## Installation

Use Composer to install the plugin by executing

```
composer require mercator/wn-twigext-plugin
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

### QR Code
#### QR code for inline use (qrcodeSRC and qrcodeIMG)
Generate QR Code as GIF image for inline usage:
```
Create a GIF with a red QR code on a transparent background pointing to *mercator.li*: 
```
<img alt="mercator dot li" src="{{ qrcodeSRC("https://mercator.li", 2, "XXXXXX", "000000") }}">
```
alternatively, use the short version
```
{{ qrcodeIMG("https://mercator.li", 2, "XXXXXX", "FF0000") }} 
```
to produce the full image tag, i.e. ``"<img alt="https://mercator.li" src="{{ qrcodeSRC("https://mercator.li", 2, "XXXXXX", "000000") }}">``. In this case, *alt* will be the same as the actual QR code content.

Parameters for the above functions are:
- text: Text to be converted to a QR code, e.g. https://mercator.li. Defaults to "no data here".
- scale: Scale factor of the QR code, 1 being the smallest. Defaults to 2.
- background: Background color in RGB hex format. Set to XXXXXX to generate a transparent background. Defaults to XXXXXX, which is transparent.
- foreground: Foreground color in RGB hex format. Defaults to 000000, which is black.
- ecc: Error correction level, valid values: qr, qr-l, qr-m, qr-q, qr-h. Defaults to qr-l.

### Storage
Providing [Laravel's storage functionality](https://laravel.com/docs/8.x/filesystem):
#### Directories
- storageDirectories(directory, [disk="local"]) --> returns array of directories in *directory* on the respective *disk*
- storageAllDirectories(directory, [disk="local"]) --> returns array of directories in *directory* and its sub-directories on the respective *disk*
- storageDeleteDirectory(directory, [disk="local"]) deletes the *directory* on the respective *disk*
- storageFiles(directory, [disk="local"]) --> returns array of files in *directory* on the respective *disk*. The result excludes directories.
- storageAllFiles(directory, [disk="local"]) --> returns array of files in *directory* and its sub-directories on the respective *disk*. The result excludes directories.

#### Files
- storageExists(file,[disk="local"]) returns true/false: Checks if *file* on the respective *disk* exists
- storageGet(file,[disk="local"]) return content of the *file* on the respective *disk*
- storageSize(file,[disk="local"]) return size of the *file* on the respective *disk*
- storageLastModified(file,[disk="local"]) return the last modification date of the *file* on the respective *disk*
- storagePut(file, content,[disk="local"]) write the *content* the *file* on the respective *disk*
- storageCopy(from, to, [disk="local"]) copies a file
- storageMove(from, to, [disk="local"]) moves a file
- storagePrepend(file, content,[disk="local"]) prepends *content* to a *sile* om the respective *disk*
- storageAppemd(file, content,[disk="local"]) appends *content* to a *sile* om the respective *disk*
- storageDelete(file,[disk="local"]) deletes the *file* on the respective *disk*

### Geo-Coding
Provide geo coordinates (longitude and latitude) for a given street address. Usage:

```
{% set geo = geocodeAddress("Pardeplatz, Zurich, Switzerland) %}
The address is located at {{ geo.longitude }} {{ geo.latitude }} (long/lat).
```


### Cryptography
Providing [Laravel's cryptograhic functionality](https://laravel.com/docs/8.x/encryption) as Twig functions:
- cryptEncryptString(value) implements Crypt::encryptString
- cryptDecryptString(vakue) implements Crypt::decryptString
- cryptEncrypt(value) implements Crypt::encrypt
- cryptDecrypt(vakue) implements Crypt::decrypt

### Cookies
Providing [Laravel's cookie functionality](https://laravel.com/docs/8.x/responses#attaching-cookies-to-responses) as Twig functions:
- cookieQueue(key, [value = true], [duration in seconds = 86400])
- cookieForever(key, [value = true])
- cookieGet(key)
- cookieExpire(key)

Use cookies for example to (re-)display text only after a certain time, e.g. once a day (after 86400 seconds):
```
{% set key = ("cookie-key" %}
{% set updated = (element.published | strftime('%Y-%m-%d-%H-%M-%S')) %}

{% if (not cookieGet(key)) or (cookieGet(key) < updated) %}

    Hello, this is the text you want to display once a day (every 86400 seconds)

{% endif %}
{{ cookieQueue(key, updated, 86400) }}
```

### Cache
Providing [Laravel's cache functionality](https://laravel.com/docs/8.x/cache) as Twig functions:
- cacheAdd(key, value, [duration=3600 seconds]) implements Cache::Add
- cachePut(key, value, [duration=3600 seconds]) implements Cache::Put
- cacheForever(key) implements Cache::Forever
- cacheForget(key) implements Cache::Forget
- cacheFlush()  implements Cache::Flush
- cacheGet(key, [default value if not found = null]) implements Cache::Get
- cacheImcrement(key, [default increment value = 1]) implements Cache::Increement
- cacheDecrement(key, [default decrement value = 1]) implements Cache::Increement
- cachePull(key, default value if not found = null]) implements Cache::Pull


### Session
Providing [Laravel's session functionality](https://laravel.com/docs/8.x/session) as Twig functions:
- sessionPush(key, value)
- sessionGet(key, [default vaklue when key is not found = ""]) --> value
- sessionPull(key, [default vaklue when key is not found = ""]) --> value
- sessionHas(key)
- sessionForget(key)
- sessionFlush()
- sessionRegenerate()
- sessionFlash(key, value)
- sessionReflash()

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
{% redirect('https://mercator.li') %}
```
or
```
{% redirect('/contact') %}
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

### session

Function move the functionality of the Laravel `session()` helper function to Twig.

```
{{ session('my.session.key') }}
```
The example would output the value currently stored in `my.session.key`.
See [more about the Laravel session helper function here](https://laravel.com/docs/5.0/session#session-usage).

Note that additional Session functionality has been made available, see below.

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
{{ include(template_from_string("Hurry up it is: {{ "now"|date("m/d/Y") }}")) }}
```

## Available filters

strftime, uppercase, lowercase, ucfirst, lcfirst, ltrim, rtrim, str\_repeat,
plural, truncate, wordwrap, strpad, str_replace, strip_tags, leftpad, rightpad, rtl, shuffle, time\_diff,
localizeddate, localizednumber, localizedcurrency, mailto, var\_dump, revision, sortbyfield

### strftime

Format a local time/date according to locale settings.

```
Posted at {{ article.date | strftime('%d.%m.%Y %H:%M:%S') }}
```

The example would output *Posted at 04.01.2016 22:57:42*. See [more format parameters](http://php.net/manual/en/function.strftime.php#refsect1-function.strftime-parameters).

### uppercase

Make a string uppercase.

```
Hello I'm {{ 'Jack' | uppercase }}
```

The example would output *Hello I'm JACK*.

### lowercase

Make a string lowercase.

```
Hello I'm {{ 'JACK' | lowercase }}
```

The example would output *Hello I'm jack*.

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

### ltrim

Strip whitespace (or other characters) from the beginning of a string.

```
Hello I'm {{ ' jack' | ltrim }}
```

The example would output *Hello I'm jack* without whitespaces from the start.

### rtrim

Strip whitespace (or other characters) from the end of a string.

```
Hello I'm {{ 'jack ' | rtrim }}
```

The example would output *Hello I'm jack* without whitespaces from the end.

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

### truncate

Use the truncate filter to cut off a string after limit is reached.

```
{{ "Hello World!" | truncate(5) }}
```

The example would output *Hello...*, as ... is the default separator.

You can also tell truncate to preserve whole words by setting the second parameter to true. If the last Word is on the the separator, truncate will print out the whole Word.

```
{{ "Hello World!" | truncate(7, true) }}
```

Here *Hello World!* would be printed.

If you want to change the separator, just set the third parameter to your desired separator.

```
{{ "Hello World!" | truncate(7, false, "??") }}
```

This example would print *Hello W??*.

### wordwrap

Use the wordwrap filter to split your text in lines with equal length.

```
{{ "Lorem ipsum dolor sit amet, consectetur adipiscing" | wordwrap(10) }}
```
This example would print:

```
Lorem ipsu  
m dolor si  
t amet, co  
nsectetur  
adipiscing  
```

The default separator is "\n", but you can easily change that by providing one:

```
{{ "Lorem ipsum dolor sit amet, consectetur adipiscing" | wordwrap(10, "zz\n") }}
```

This would result in:

```
Lorem ipsuzz  
m dolor sizz  
t amet, cozz  
nsectetur zz  
adipiscing  
```

### strpad

Pad a string to a certain length with another string from both sides.

```
{{ 'xxx' | strpad(7, 'o') }}
```

This would print:

```
ooxxxoo
```

### str_replace

Replace all occurrences of the search string with the replacement string.

```
{{ 'Alice' | str_replace('Alice', 'Bob') }}
```

This would return:

```
Bob
```

### strip_tags

Strip HTML and PHP tags from a string. In first parameter you can specify allowable tags.

```
{{ '<p><b>Text</b></p>' | strip_tags('<p>') }}
```

This would return:

```
<p>Text</p>
```

### leftpad

Pad a string to a certain length with another string from left side.

```
{{ 'xxx' | leftpad(5, 'o') }}
```

This would print:

```
ooxxx
```

### rightpad

Pad a string to a certain length with another string from right side.

```
{{ 'xxx' | rightpad(5, 'o') }}
```

This would print:

```
xxxoo
```

### rtl

Reverse a string.

```
{{ 'Hello world!' | rtl }}
```

This would print:

```
!dlrow olleH
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

#### Translation

To get a translatable output, give a Symfony\Component\Translation\TranslatorInterface as constructor argument. The returned string is formatted as diff.ago.XXX or diff.in.XXX where XXX can be any valid unit: second, minute, hour, day, month, year.

### localizeddate

Use the localizeddate filter to format dates into a localized string representating the date. Note that **php5-intl extension**/**php7-intl extension** has to be installed!

```
{{ post.published_at | localizeddate('medium', 'none', locale) }}
```

The localizeddate filter accepts strings (it must be in a format supported by the strtotime function), DateTime instances, or Unix timestamps.

#### Arguments
- date_format: The date format. Choose one of these formats:
    - 'none': IntlDateFormatter::NONE
    - 'short': IntlDateFormatter::SHORT
    - 'medium': IntlDateFormatter::MEDIUM
    - 'long': IntlDateFormatter::LONG
    - 'full': IntlDateFormatter::FULL
- time_format: The time format. Same formats possible as above.
- locale: The locale used for the format. If NULL is given, Twig will use Locale::getDefault()
- timezone: The date timezone
- format: Optional pattern to use when formatting or parsing. Possible patterns are documented in the ICU user guide.

### localizednumber

Use the localizednumber filter to format numbers into a localized string representating the number. Note that **php5-intl extension** has to be installed!

```
{{ product.quantity | localizednumber }}
```

Internally, Twig uses the PHP NumberFormatter::create() function for the number.

#### Arguments

- style: Optional date format (default: 'decimal'). Choose one of these formats:
    - 'decimal': NumberFormatter::DECIMAL
    - 'currency': NumberFormatter::CURRENCY
    - 'percent': NumberFormatter::PERCENT
    - 'scientific': NumberFormatter::SCIENTIFIC
    - 'spellout': NumberFormatter::SPELLOUT
    - 'ordinal': NumberFormatter::ORDINAL
    - 'duration': NumberFormatter::DURATION
- type: Optional formatting type to use (default: 'default'). Choose one of these types:
    - 'default': NumberFormatter::TYPE_DEFAULT
    - 'int32': NumberFormatter::TYPE_INT32
    - 'int64': NumberFormatter::TYPE_INT64
    - 'double': NumberFormatter::TYPE_DOUBLE
    - 'currency': NumberFormatter::TYPE_CURRENCY
- locale: The locale used for the format. If NULL is given, Twig will use Locale::getDefault()

### localizedcurrency

Use the localizedcurrency filter to format a currency value into a localized string. Note that **php5-intl extension** has to be installed!

```
{{ product.price | localizedcurrency('EUR') }}
```

#### Arguments

- currency: The 3-letter ISO 4217 currency code indicating the currency to use.
- locale: The locale used for the format. If NULL is given, Twig will use Locale::getDefault()

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
the current theme and include functions an filters in there. TwigExt will load all files startung with an underscore ** \_ ** and ending in **.php**
and make the included filters and functions available in Twig.

Functions are added as follow (by placing them, e.g, in **twig/functions/\_myFucntions.php** in the active themes directory):
```
<?php

$functions += [

   'myConfig' => function ($api_key, $g) {
       $res = Settings::get($api_key, $g);
       return "Result is: $res";
   }
];
```

Filters are added as follow (by placing them, e.g, in **twig/filters/\_myFucntions.php** in the active themes directory):
```
<?php

$filters += [
'replacestring' => function ($greetings, $search, $replace) {
		return str_replace($search, $replace, $string);
	}
];
```

Filters and functions MUST provide return values. Multiple new filters or functions can be added to the respective arrays in one go.
See [Winter's documenttation](https://wintercms.com/docs/plugin/registration#extending-twig) for additional details.

## Contributing

**Feel free to send pull request!** Please, send Pull Request to master branch.

## License

Twig extensions plugin is open source software licensed under the [MIT license](http://opensource.org/licenses/MIT).
