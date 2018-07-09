<?php
namespace Composer\Installers;

class Concrete5Installer extends BaseInstaller
{
    protected $locations = array(
 
        'core'       => 'concrete/',
        'block'      => 'application/blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'application/themes/{$name}/',
=======
        'block'      => 'blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'themes/{$name}/',
        'update'     => 'updates/{$name}/',
    );
}
