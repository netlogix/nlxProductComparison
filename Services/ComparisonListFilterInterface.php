<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxProductComparison\Services;

interface ComparisonListFilterInterface
{
    /**
     * @param mixed[] $comparisonList
     *
     * @return mixed[]
     */
    public function filterComparisonList(array $comparisonList): array;
}
