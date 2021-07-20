<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxProductComparison\Services;

use nlxProductComparison\Services\ComparisonListFilter;
use nlxProductComparison\Services\ComparisonListFilterInterface;
use nlxProductComparison\Services\ConfigInterface;
use PhpSpec\ObjectBehavior;

class ComparisonListFilterSpec extends ObjectBehavior
{
    public function let(ConfigInterface $config): void
    {
        $this->beConstructedWith($config);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ComparisonListFilter::class);
    }

    public function it_implements_interface(): void
    {
        $this->shouldImplement(ComparisonListFilterInterface::class);
    }

    public function it_should_filter_comparison_list(ConfigInterface $config): void
    {
        $comparisonList = [
            'articles' => [
                [
                    'sProperties' => [
                        1 => 'property1',
                        2 => 'property2',
                        3 => 'property3',
                    ],
                ],
                [
                    'sProperties' => [
                        1 => 'property1',
                        2 => 'property2',
                        3 => 'property3',
                    ],
                ],
            ],
            'properties' => [
                1 => 'test',
                2 => 'test2',
                3 => 'test3',
            ],
        ];
        $hiddenOptionKeys = [0 => 3];
        $expectedResult = [
            'articles' => [
                [
                    'sProperties' => [
                        1 => 'property1',
                        2 => 'property2',
                    ],
                ],
                [
                    'sProperties' => [
                        1 => 'property1',
                        2 => 'property2',
                    ],
                ],
            ],
            'properties' => [
                1 => 'test',
                2 => 'test2',
            ],
        ];

        $config->getHiddenOptions()
            ->willReturn($hiddenOptionKeys);

        $this->filterComparisonList($comparisonList)
            ->shouldBe($expectedResult);
    }

    public function it_should_do_nothing_if_hidden_properties_are_empty(ConfigInterface $config): void
    {
        $comparisonList = ['articles' => [], 'properties' => [1 => 'test', 2 => 'test2', 3 => 'test3']];

        $config->getHiddenOptions()
            ->willReturn([]);

        $this->filterComparisonList($comparisonList)
            ->shouldBe($comparisonList);
    }

    public function it_should_do_nothing_if_properties_are_not_exists(ConfigInterface $config): void
    {
        $comparisonList = ['articles' => []];
        $hiddenOptionKeys = [0 => 3];

        $config->getHiddenOptions()
            ->willReturn($hiddenOptionKeys);

        $this->filterComparisonList($comparisonList)
            ->shouldBe($comparisonList);
    }

    public function it_should_do_nothing_if_articles_are_not_exists(ConfigInterface $config): void
    {
        $comparisonList = ['properties' => []];
        $hiddenOptionKeys = [0 => 3];

        $config->getHiddenOptions()
            ->willReturn($hiddenOptionKeys);

        $this->filterComparisonList($comparisonList)
            ->shouldBe($comparisonList);
    }
}
