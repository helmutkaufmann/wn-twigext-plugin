<?php 

//
// Resize filter replacement, rendering webp (or avif at a later point) if browser accepts it.
// Based on Marc Jauvin's NGMMedia plugin skeleton (https://github.com/mjauvin/wn-ngmedia-plugin) - Thanks Marc
//

namespace Mercator\TwigExt\MercatorTwigExtImages;

use File;
use Request;
use System\Classes\ImageResizer;

class MercatorTwigExtImages {

	static $defaultOptions = [
        #'sizes' => '(min-width:992px) 33.3vw, 100vw',
        #'sizes' => '100vw',
        #'imageWidths' => [1300, 992, 768, 576],
        #'fallbackSize' => 400,
        'imageTypes' => [
            'image/webp' => [
                'extension' => 'webp',
                'quality' => 50,
            ],
            'image/jpeg' => [
                'extension' => 'jpg',
                'quality' => 90,
            ],
        ],
    ];

    public static function accepts($type) {
        $acceptableTypes = array_merge([
            'image/gif',
            'image/jpg',
            'image/jpeg',
            'image/png',
        ], Request::getAcceptableContentTypes());

        return in_array($type, $acceptableTypes) || in_array("image/$type", $acceptableTypes);
    }

	public static function ngresize($image, $width, $height, $options=[]) {
	
		$path = public_path(parse_url($image, PHP_URL_PATH));
		if (!File::exists($path)) {
			return $image;
		}

		// If the extension is set explicitly, honor it. 
		if (array_get($options, 'extension', false)) {
			$publicPath = File::localToPublic($path);
			$resizerPath = ImageResizer::filterGetUrl($publicPath, $width, $height, $options);
			return $resizerPath;
		}
		
		$options = array_merge(static::$defaultOptions, $options);
		list ($filename, $ext) = explode('.', $path);

		foreach ($options['imageTypes'] as $type => $typeOptions) {
			if (static::accepts($type)) {
				$ext = array_get($typeOptions, 'extension');
				$quality = array_get($typeOptions, 'quality', 90);
				$publicPath = File::localToPublic($path);
				$resizerPath = ImageResizer::filterGetUrl($publicPath, $width, $height, ['extension'=>$ext, 'quality'=>$quality]);
				return $resizerPath;
			}
		}
	}
}

$filters += [ 
	'ngresize' => [\Mercator\TwigExt\MercatorTwigExtImages\MercatorTwigExtImages::class, 'ngresize'],
];

?>

