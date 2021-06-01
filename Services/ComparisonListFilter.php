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

    /**
     * {@inheritdoc}
     */
    public function filterComparisonList(array $comparisonList): array
    {
        $hiddenOptionKeys = $this->config->getHiddenOptions();

        if (null === $hiddenOptionKeys) {
            return $comparisonList;
        }

        if (false === isset($comparisonList['properties']) || false === isset($comparisonList['articles'])) {
            return $comparisonList;
        }
        $comparisonProperties = $comparisonList['properties'];
        $comparisonList['properties'] = $this->filterProperties($comparisonProperties, $hiddenOptionKeys);

        $comparisonArticles = $comparisonList['articles'];
        $comparisonList['articles'] = $this->filterArticles($comparisonArticles, $hiddenOptionKeys);

        return $comparisonList;
    }

    /**
     * @param string[] $comparisonProperties
     * @param int[]    $hiddenOptionKeys
     *
     * @return string[]
     */
    private function filterProperties(array $comparisonProperties, array $hiddenOptionKeys): array
    {
        $filteredComparisonProperties = [];

        foreach ($comparisonProperties as $key => $value) {
            if (false === \in_array($key, $hiddenOptionKeys)) {
                $filteredComparisonProperties[$key] = $value;
            }
        }

        return $filteredComparisonProperties;
    }

    /**
     * @param mixed[] $comparisonArticles
     * @param int[]   $hiddenOptionKeys
     *
     * @return mixed[]
     */
    private function filterArticles(array $comparisonArticles, array $hiddenOptionKeys): array
    {
        foreach ($comparisonArticles as $key => $article) {
            if (false === isset($article['sProperties'])) {
                return $comparisonArticles;
            }
            $filteredComparisonProperties = [];

            foreach ($article['sProperties'] as $propertyKey => $property) {
                if (false === \in_array($propertyKey, $hiddenOptionKeys)) {
                    $filteredComparisonProperties[$propertyKey] = $property;
                }
            }
            $comparisonArticles[$key]['sProperties'] = $filteredComparisonProperties;
        }

        return $comparisonArticles;
    }
}
