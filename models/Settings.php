<?php namespace  Mercator\TwigExt\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'mercator_twigext_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
