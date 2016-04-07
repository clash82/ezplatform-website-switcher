<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace OmniProject\EzPlatformWebsiteSwitcherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ez_website_switcher');

        $rootNode
            ->children()
                ->scalarNode('cookie_name')
                    ->defaultValue('websiteSwitcherStatus')
                    ->info('name to be used to store banner status')
                ->end()

                ->integerNode('days')
                    ->defaultValue('365')
                    ->info('how many days banner should be hidden when user disables the banner?')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
