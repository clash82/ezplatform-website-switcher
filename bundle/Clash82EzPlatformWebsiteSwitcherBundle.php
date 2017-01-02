<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Clash82\EzPlatformWebsiteSwitcherBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Clash82\EzPlatformWebsiteSwitcherBundle\DependencyInjection\EzPlatformWebsiteSwitcherExtension;

class Clash82EzPlatformWebsiteSwitcherBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new EzPlatformWebsiteSwitcherExtension();
    }
}
