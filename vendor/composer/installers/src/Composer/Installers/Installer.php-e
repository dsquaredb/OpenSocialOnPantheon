<?php
namespace Composer\Installers;

use Composer\IO\IOInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class Installer extends LibraryInstaller
{
    /**
     * Package types to installer class map
     *
     * @var array
     */
    private $supportedTypes = array(
        'aimeos'       => 'AimeosInstaller',
        'asgard'       => 'AsgardInstaller',
        'attogram'     => 'AttogramInstaller',
        'agl'          => 'AglInstaller',
        'annotatecms'  => 'AnnotateCmsInstaller',
        'bitrix'       => 'BitrixInstaller',
        'bonefish'     => 'BonefishInstaller',
        'cakephp'      => 'CakePHPInstaller',
        'chef'         => 'ChefInstaller',
        'ccframework'  => 'ClanCatsFrameworkInstaller',
        'cockpit'      => 'CockpitInstaller',
        'codeigniter'  => 'CodeIgniterInstaller',
        'concrete5'    => 'Concrete5Installer',
        'craft'        => 'CraftInstaller',
        'croogo'       => 'CroogoInstaller',
        'dokuwiki'     => 'DokuWikiInstaller',
        'dolibarr'     => 'DolibarrInstaller',
        'decibel'      => 'DecibelInstaller',
        'drupal'       => 'DrupalInstaller',
        'elgg'         => 'ElggInstaller',
<<<<<<< HEAD
        'eliasis'      => 'EliasisInstaller',
        'ee3'          => 'ExpressionEngineInstaller',
        'ee2'          => 'ExpressionEngineInstaller',
        'ezplatform'   => 'EzPlatformInstaller',
=======
        'ee3'          => 'ExpressionEngineInstaller',
        'ee2'          => 'ExpressionEngineInstaller',
>>>>>>> web and vendor directory from composer install
        'fuel'         => 'FuelInstaller',
        'fuelphp'      => 'FuelphpInstaller',
        'grav'         => 'GravInstaller',
        'hurad'        => 'HuradInstaller',
        'imagecms'     => 'ImageCMSInstaller',
<<<<<<< HEAD
        'itop'         => 'ItopInstaller',
        'joomla'       => 'JoomlaInstaller',
        'kanboard'     => 'KanboardInstaller',
        'kirby'        => 'KirbyInstaller',
        'kodicms'      => 'KodiCMSInstaller',
        'kohana'       => 'KohanaInstaller',
        'lms'      => 'LanManagementSystemInstaller',
        'laravel'      => 'LaravelInstaller',
        'lavalite'     => 'LavaLiteInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'majima'       => 'MajimaInstaller',
        'mako'         => 'MakoInstaller',
        'maya'         => 'MayaInstaller',
=======
        'joomla'       => 'JoomlaInstaller',
        'kirby'        => 'KirbyInstaller',
        'kodicms'      => 'KodiCMSInstaller',
        'kohana'       => 'KohanaInstaller',
        'laravel'      => 'LaravelInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'mako'         => 'MakoInstaller',
>>>>>>> web and vendor directory from composer install
        'mautic'       => 'MauticInstaller',
        'mediawiki'    => 'MediaWikiInstaller',
        'microweber'   => 'MicroweberInstaller',
        'modulework'   => 'MODULEWorkInstaller',
<<<<<<< HEAD
        'modx'         => 'ModxInstaller',
        'modxevo'      => 'MODXEvoInstaller',
        'moodle'       => 'MoodleInstaller',
        'october'      => 'OctoberInstaller',
        'ontowiki'     => 'OntoWikiInstaller',
        'oxid'         => 'OxidInstaller',
        'osclass'         => 'OsclassInstaller',
        'pxcms'        => 'PxcmsInstaller',
=======
        'modxevo'      => 'MODXEvoInstaller',
        'moodle'       => 'MoodleInstaller',
        'october'      => 'OctoberInstaller',
        'oxid'         => 'OxidInstaller',
>>>>>>> web and vendor directory from composer install
        'phpbb'        => 'PhpBBInstaller',
        'pimcore'      => 'PimcoreInstaller',
        'piwik'        => 'PiwikInstaller',
        'plentymarkets'=> 'PlentymarketsInstaller',
        'ppi'          => 'PPIInstaller',
        'puppet'       => 'PuppetInstaller',
        'radphp'       => 'RadPHPInstaller',
        'phifty'       => 'PhiftyInstaller',
<<<<<<< HEAD
        'porto'        => 'PortoInstaller',
=======
>>>>>>> web and vendor directory from composer install
        'redaxo'       => 'RedaxoInstaller',
        'reindex'      => 'ReIndexInstaller',
        'roundcube'    => 'RoundcubeInstaller',
        'shopware'     => 'ShopwareInstaller',
<<<<<<< HEAD
        'sitedirect'   => 'SiteDirectInstaller',
        'silverstripe' => 'SilverStripeInstaller',
        'smf'          => 'SMFInstaller',
        'sydes'        => 'SyDESInstaller',
=======
        'silverstripe' => 'SilverStripeInstaller',
        'smf'          => 'SMFInstaller',
>>>>>>> web and vendor directory from composer install
        'symfony1'     => 'Symfony1Installer',
        'thelia'       => 'TheliaInstaller',
        'tusk'         => 'TuskInstaller',
        'typo3-cms'    => 'TYPO3CmsInstaller',
        'typo3-flow'   => 'TYPO3FlowInstaller',
<<<<<<< HEAD
        'userfrosting' => 'UserFrostingInstaller',
=======
>>>>>>> web and vendor directory from composer install
        'vanilla'      => 'VanillaInstaller',
        'whmcs'        => 'WHMCSInstaller',
        'wolfcms'      => 'WolfCMSInstaller',
        'wordpress'    => 'WordPressInstaller',
        'yawik'        => 'YawikInstaller',
        'zend'         => 'ZendInstaller',
        'zikula'       => 'ZikulaInstaller',
        'prestashop'   => 'PrestashopInstaller'
    );

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();
        $frameworkType = $this->findFrameworkType($type);

        if ($frameworkType === false) {
            throw new \InvalidArgumentException(
                'Sorry the package type of this package is not yet supported.'
            );
        }

        $class = 'Composer\\Installers\\' . $this->supportedTypes[$frameworkType];
        $installer = new $class($package, $this->composer, $this->getIO());

        return $installer->getInstallPath($package, $frameworkType);
    }

    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
<<<<<<< HEAD
        parent::uninstall($repo, $package);
        $installPath = $this->getPackageBasePath($package);
        $this->io->write(sprintf('Deleting %s - %s', $installPath, !file_exists($installPath) ? '<comment>deleted</comment>' : '<error>not deleted</error>'));
=======
        if (!$repo->hasPackage($package)) {
            throw new \InvalidArgumentException('Package is not installed: '.$package);
        }

        $repo->removePackage($package);

        $installPath = $this->getInstallPath($package);
        $this->io->write(sprintf('Deleting %s - %s', $installPath, $this->filesystem->removeDirectory($installPath) ? '<comment>deleted</comment>' : '<error>not deleted</error>'));
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        $frameworkType = $this->findFrameworkType($packageType);

        if ($frameworkType === false) {
            return false;
        }

        $locationPattern = $this->getLocationPattern($frameworkType);

        return preg_match('#' . $frameworkType . '-' . $locationPattern . '#', $packageType, $matches) === 1;
    }

    /**
     * Finds a supported framework type if it exists and returns it
     *
     * @param  string $type
     * @return string
     */
    protected function findFrameworkType($type)
    {
        $frameworkType = false;

        krsort($this->supportedTypes);

        foreach ($this->supportedTypes as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                $frameworkType = substr($type, 0, strlen($key));
                break;
            }
        }

        return $frameworkType;
    }

    /**
     * Get the second part of the regular expression to check for support of a
     * package type
     *
     * @param  string $frameworkType
     * @return string
     */
    protected function getLocationPattern($frameworkType)
    {
        $pattern = false;
        if (!empty($this->supportedTypes[$frameworkType])) {
            $frameworkClass = 'Composer\\Installers\\' . $this->supportedTypes[$frameworkType];
            /** @var BaseInstaller $framework */
            $framework = new $frameworkClass(null, $this->composer, $this->getIO());
            $locations = array_keys($framework->getLocations());
            $pattern = $locations ? '(' . implode('|', $locations) . ')' : false;
        }

        return $pattern ? : '(\w+)';
    }

    /**
     * Get I/O object
     *
     * @return IOInterface
     */
    private function getIO()
    {
        return $this->io;
    }
}
