<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxProductComparison\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxProductComparison\Services\ComparisonListFilterInterface;
use nlxProductComparison\Subscriber\Compare;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompareSpec extends ObjectBehavior
{
    public function let(ComparisonListFilterInterface $comparisonListFilter): void
    {
        $this->beConstructedWith($comparisonListFilter);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Compare::class);
    }

    public function it_implements_interface(): void
    {
        $this->shouldImplement(SubscriberInterface::class);
    }

    public function it_should_override_comparison_list(
        ComparisonListFilterInterface $comparisonListFilter,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_Controller_Action $subject,
        \Enlight_View_Default $view
    ): void {
        $comparisonList = ['article' => [], 'properties' => [1 => 'test', 2 => 'test2', 3 => 'test3']];
        $filteredComparisonList = ['article' => [], 'properties' => [1 => 'test', 2 => 'test2']];

        $args->getSubject()
            ->willReturn($subject);

        $subject->View()
            ->willReturn($view);

        $view->getAssign('sComparisonsList')
            ->willReturn($comparisonList);

        $comparisonListFilter->filterComparisonList($comparisonList)
            ->willReturn($filteredComparisonList);

        $view->assign('sComparisonsList', $filteredComparisonList)
            ->shouldBeCalled();

        $this->onPostDispatchCompare($args);
    }

    public function it_should_do_nothing_if_comparison_list_not_exist(
        ComparisonListFilterInterface $comparisonListFilter,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_Controller_Action $subject,
        \Enlight_View_Default $view
    ): void {
        $args->getSubject()
            ->willReturn($subject);

        $subject->View()
            ->willReturn($view);

        $view->getAssign('sComparisonsList')
            ->willReturn(null);

        $comparisonListFilter->filterComparisonList(Argument::any())
            ->shouldNotBeCalled();

        $view->assign(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->onPostDispatchCompare($args);
    }
}
