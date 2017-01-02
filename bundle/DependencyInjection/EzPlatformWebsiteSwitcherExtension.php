<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Clash82\EzPlatformWebsiteSwitcherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class EzPlatformWebsiteSwitcherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config as $key => $value) {
            $container->setParameter('ez_website_switcher.' . $key, $value);
        }
    }

    public function getAlias()
    {
        return 'ez_website_switcher';
    }
}
