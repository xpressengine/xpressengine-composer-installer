<?php
/**
 * This file is XpressEngine installer append to Composer installer.
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

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * This class is register composer plugin.
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Team (jhyeon1010) <cjh1010@xpressengine.com>
 * @copyright   2014 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XpressengineInstallerPlugin implements PluginInterface
{
    /**
     * Apply plugin modifications to composer
     *
     * @param Composer    $composer composer instance
     * @param IOInterface $io       IO instance
     * @return void
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new XpressengineInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
