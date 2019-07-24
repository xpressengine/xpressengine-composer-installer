<?php
/**
 * This file is XpressEngine installer append to Composer installer.
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
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\InstallerEvent;
use Composer\Installer\InstallerEvents;
use Composer\IO\IOInterface;
use Composer\Json\JsonFormatter;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;

/**
 * This class is register composer plugin.
 *
 * @category    Installer
 * @package     Xpressengine\Installer
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XpressengineInstallerPlugin implements PluginInterface, EventSubscriberInterface
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

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [];
    }

}
