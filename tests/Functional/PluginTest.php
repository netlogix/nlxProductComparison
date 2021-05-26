<?php

namespace nlxProductComparison\Tests;

use nlxProductComparison\nlxProductComparison as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'nlxProductComparison' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['nlxProductComparison'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
