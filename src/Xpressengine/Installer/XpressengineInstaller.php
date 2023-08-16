<?php
/**
 * This file is XpressEngine 3rd party plugin installer.
 *
 * PHP version 5
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Installer;

use Composer\Composer;
use Composer\Downloader\TransportException;
use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;

/**
 * This class is extend composer installer for XpressEngine plugins.
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XpressengineInstaller extends LibraryInstaller
{

    /**
     * @var array
     */
    public static $changed = [];

    /**
     * @var array
     */
    public static $failed = [];

    /**
     * Initializes library installer.
     *
     * @param IOInterface $io
     * @param Composer $composer
     * @param string $type
     * @param Filesystem|null $filesystem
     * @param BinaryInstaller|null $binaryInstaller
     */
    public function __construct(IOInterface $io, Composer $composer, $type = 'library', Filesystem $filesystem = null, BinaryInstaller $binaryInstaller = null)
    {
        static::$changed = [
            'installed' => [],
            'updated' => [],
            'uninstalled' => [],
        ];

        static::$failed = [
            'install' => [],
            'update' => [],
        ];

        parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);
    }

    /**
     * Directory in which the plugin is installed
     *
     * @param PackageInterface $package 3rd party plugin package instance
     * @return string
     */
    public function getInstallPath(PackageInterface $package)
    {
        list(, $packageName) = explode('/', $package->getPrettyName());

        return 'plugins/' . $packageName;
    }

    /**
     * Decides if the installer supports the given type
     *
     * Check XpressEngine plugin type
     *
     * @param string $packageType type of package
     * @return bool
     */
    public function supports($packageType)
    {
        return 'xpressengine-plugin' === $packageType;
    }

    /**
     * {@inheritDoc}
     */
    public function isInstalled(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        return parent::isInstalled($repo, $package);
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (defined('__XE_PLUGIN_SKIP__') || $this->checkDevPlugin($package)) {
            $this->io->writeError(
                "  - Installing <info>".$package->getName()."</info> (<comment>".$package->getFullPrettyVersion(
                )."</comment>): <comment>Skip by Xpressengine-installer</comment>"
            );

            return null;
        }

        try {
            $promise = parent::install($repo, $package);
        } catch (TransportException $e) {
            static::$failed['install'][$package->getName()] = $e->getStatusCode();
            throw $e;
        }

        static::$changed['installed'][$package->getName()] = $package->getPrettyVersion();
        return $promise;
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        if (defined('__XE_PLUGIN_SKIP__') || $this->checkDevPlugin($initial)) {
            $this->io->writeError(
                "  - Updating <info>".$initial->getName()."</info> (<comment>".$initial->getFullPrettyVersion(
                )."</comment>): <comment>Skip by Xpressengine-installer</comment>"
            );

            return null;
        }

        try {
            $promise = parent::update($repo, $initial, $target);
        } catch (TransportException $e) {
            static::$failed['update'][$target->getName()] = $e->getStatusCode();
            throw $e;
        }

        static::$changed['updated'][$target->getName()] = $target->getPrettyVersion();
        return $promise;
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (defined('__XE_PLUGIN_SKIP__') || $this->checkDevPlugin($package)) {
            $this->io->writeError(
                "  - Removing <info>".$package->getName()."</info> (<comment>".$package->getFullPrettyVersion(
                )."</comment>): <comment>Skip by Xpressengine-installer</comment>"
            );

            if ($this->checkDevPlugin($package)) {
                $repo->removePackage($package);
            }

            return null;
        }

        $promise = parent::uninstall($repo, $package);
        static::$changed['uninstalled'][$package->getName()] = $package->getPrettyVersion();

        return $promise;
    }

    /**
     * Determine if given package is develop plugin for XE
     *
     * @param PackageInterface $package package instance
     * @return bool
     */
    protected function checkDevPlugin(PackageInterface $package)
    {
        $path = $this->getInstallPath($package);

        if(file_exists($path.'/vendor')) {
            return true;
        }
        return false;
    }
}
