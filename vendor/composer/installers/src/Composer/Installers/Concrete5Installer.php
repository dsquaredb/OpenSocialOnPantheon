<?php
namespace Composer\Installers;

class Concrete5Installer extends BaseInstaller
{
    protected $locations = array(
<<<<<<< HEAD
        'core'       => 'concrete/',
        'block'      => 'application/blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'application/themes/{$name}/',
=======
        'block'      => 'blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'themes/{$name}/',
>>>>>>> web and vendor directory from composer install
        'update'     => 'updates/{$name}/',
    );
}
