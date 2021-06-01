<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxProductComparison\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxProductComparison\Services\ComparisonListFilterInterface;

class Compare implements SubscriberInterface
{
    /** @var ComparisonListFilterInterface */
    private $comparisonListFilter;

    public function __construct(ComparisonListFilterInterface $comparisonListFilter)
    {
        $this->comparisonListFilter = $comparisonListFilter;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Frontend_Compare' => 'onPostDispatchCompare',
        ];
    }

    public function onPostDispatchCompare(\Enlight_Controller_ActionEventArgs $args): void
    {
        $view = $subject = $args->getSubject()->View();
        $comparisonList = $view->getAssign('sComparisonsList');

        if (null === $comparisonList) {
            return;
        }
        $filteredComparisonList = $this->comparisonListFilter->filterComparisonList($comparisonList);

        $view->assign('sComparisonsList', $filteredComparisonList);
    }
}
