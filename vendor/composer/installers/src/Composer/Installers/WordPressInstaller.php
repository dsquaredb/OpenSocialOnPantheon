<?php
namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'wp-content/plugins/{$name}/',
        'theme'     => 'wp-content/themes/{$name}/',
        'muplugin'  => 'wp-content/mu-plugins/{$name}/',
<<<<<<< HEAD
        'dropin'    => 'wp-content/{$name}/',
=======
>>>>>>> web and vendor directory from composer install
    );
}
