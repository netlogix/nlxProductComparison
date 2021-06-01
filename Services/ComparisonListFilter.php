<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxProductComparison\Services;

class ComparisonListFilter implements ComparisonListFilterInterface
{
    /** @var ConfigInterface */
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function filterComparisonList(array $comparisonList): array
    {
        $hiddenOptions = $this->config->getHiddenOptions();

        if (null === $hiddenOptions) {
            return $comparisonList;
        }

        if (false === isset($comparisonList['properties'])) {
            return $comparisonList;
        }
        $comparisonProperties = $comparisonList['properties'];
        $filteredComparisonList = [];

        foreach ($comparisonProperties as $key => $value) {
            if (false === isset($hiddenOptions[$key])) {
                $filteredComparisonList[$key] = $value;
            }
        }
        $comparisonList['properties'] = $filteredComparisonList;

        return $comparisonList;
    }
}
