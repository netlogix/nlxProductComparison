<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

use Doctrine\ORM\EntityManagerInterface;
use Shopware\Models\Property\Option;

class Shopware_Controllers_Backend_ProductOptions extends Shopware_Controllers_Backend_ExtJs
{
    public function getOptionsAction(): void
    {
        $data = [];
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('Models');

        $optionRepository = $entityManager->getRepository(Option::class);

        $options = $optionRepository->findAll();

        /** @var Option $option */
        foreach ($options as $option) {
            $data[] = ['id' => $option->getId(), 'name' => $option->getName()];
        }

        $this->view->assign([
            'data' => $data,
            'total' => \count($data),
        ]);
    }
}
