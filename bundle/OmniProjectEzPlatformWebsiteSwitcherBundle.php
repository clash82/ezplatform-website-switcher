<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace OmniProject\EzPlatformWebsiteSwitcherBundle;

use OmniProject\EzPlatformWebsiteSwitcherBundle\DependencyInjection\EzPlatformWebsiteSwitcherExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OmniProjectEzPlatformWebsiteSwitcherBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new EzPlatformWebsiteSwitcherExtension();
    }
}
