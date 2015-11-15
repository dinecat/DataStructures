<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Entity\Doctrine;

use Dinecat\DataStructures\Entity\Dataset;
use Dinecat\DataStructures\Entity\NodeInterface;
use Dinecat\DataStructures\Exception;

/**
 * Bridge class for doctrine entity.
 * @package     DinecatDataStructures
 * @subpackage  Entity.Doctrine
 * @author      Mykola Zyk <relo.san.pub@gmail.com>
 */
abstract class Bridge
{
    /**
     * Export data to dataset.
     * @return  Dataset|NodeInterface
     */
    abstract public function export();

    /**
     * Chack if dataset and bridge match identifiers (representate same object).
     * @param   integer|string  $entityId
     * @param   integer|string  $dataId
     * @throws  Exception\IdentifiersNotMatch   If entity and dataset identifier's not matched.
     */
    protected function matchIds($entityId, $dataId)
    {
        if ($entityId && $entityId !== $dataId) {
            throw new Exception\IdentifiersNotMatch(sprintf(
                'Entity %s with id:%s not matched with dataset id:%s.',
                get_class($this),
                $entityId,
                $dataId
            ));
        }
    }

    /**
     * Check if dataset is complete.
     * @param   Dataset $dataset
     * @throws  Exception\IncompleteDataset If imported dataset marked as partial/empty.
     */
    protected function validateDataset(Dataset $dataset)
    {
        if (!$dataset->isDatasetComplete()) {
            throw new Exception\IncompleteDataset(sprintf(
                'Entity (%s) accept only complete dataset, partial/empty dataset given.',
                get_class($this)
            ));
        }
    }
}
