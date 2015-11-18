<?php
/**
 * This file is XpressEngine 3rd party plugin installer.
 *
 * PHP version 5
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Team (jhyeon1010) <cjh1010@xpressengine.com>
 * @copyright   2014 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Installer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * This class is extend composer installer for XpressEngine plugins.
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Team (jhyeon1010) <cjh1010@xpressengine.com>
 * @copyright   2014 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XpressengineInstaller extends LibraryInstaller
{
    /**
     * Directory in which the plugin is installed
     *
     * @param PackageInterface $package 3rd party plugin package instance
     * @return string
     */
    public function getPackageBasePath(PackageInterface $package)
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
}
