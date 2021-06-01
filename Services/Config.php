<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxProductComparison\Services;

use Shopware\Components\Plugin\CachedConfigReader;

class Config implements ConfigInterface
{
    const PLUGIN_NAME = 'nlxProductComparison';

    /** @var mixed[] */
    protected $config;

    public function __construct(CachedConfigReader $configReader)
    {
        $this->config = $configReader->getByPluginName(self::PLUGIN_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, string $value): void
    {
        $this->config[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getHiddenOptions(): ?array
    {
        return $this->get('hiddenOptions');
    }
}
