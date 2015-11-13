<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Entity;

use Dinecat\DataStructures\Collection\Collection;
use Dinecat\DataStructures\Exception;
use Doctrine\Common\Collections\Collection as DoctrineCollection;

/**
 * Bridge class for doctrine entity.
 * @package     DinecatDataStructures
 * @subpackage  Entity
 * @author      Mykola Zyk <relo.san.pub@gmail.com>
 */
class DoctrineBridge
{
    /**
     * Chack if dataset and bridge match identifiers (representate same object).
     * @param   integer|string  $entityId
     * @param   integer|string  $dataId
     * @throws  Exception\IdentifiersNotMatch   If entity and DO identifier's not matched.
     */
    protected function matchIds($entityId, $dataId)
    {
        if ($entityId && $entityId !== $dataId) {
            throw new Exception\IdentifiersNotMatch(sprintf(
                'Entity %s with id:%s not matched with DO id:%s.',
                get_class($this),
                $entityId,
                $dataId
            ));
        }
    }

    /**
     * Check if dataset is complete.
     * @param   Dataset $dataset
     * @throws  Exception\IncompleteDataset If imported Dataset marked as partial/empty.
     */
    protected function validateDataset(Dataset $dataset)
    {
        if (!$dataset->isComplete()) {
            throw new Exception\IncompleteDataset(sprintf(
                'Entity (%s) accept only complete dataset, partial/empty dataset given.',
                get_class($this)
            ));
        }
    }

    /**
     * Import translations from dataset to bridge.
     * @param   DoctrineCollection  $bridgeNodes
     * @param   Collection          $dataNodes
     * @param   string|null         $bridgeNodeClass    Class name for data translation node [optional].
     */
    protected function importTranslations(DoctrineCollection $bridgeNodes, Collection $dataNodes, $bridgeNodeClass = null)
    {
        if (null === $bridgeNodeClass) {
            $bridgeNodeClass = substr(get_class($this), 0, -6) . 'TranslationBridge';
        }

        array_map(
            function ($lang) use ($bridgeNodes, $dataNodes, $bridgeNodeClass) {
                if (!$bridgeNodes->containsKey($lang)) {
                    $bridgeNodes->set($lang, (new $bridgeNodeClass($this, $lang))->import($dataNodes->get($lang)));
                } elseif (!$dataNodes->has($lang)) {
                    $bridgeNodes->remove($lang);
                } else {
                    $bridgeNodes->get($lang)->import($dataNodes->get($lang));
                }
            },
            array_unique(array_merge($bridgeNodes->getKeys(), $dataNodes->getKeys()))
        );
    }

    /**
     * Export translations from bridge to dataset.
     * @param   DoctrineCollection $bridgeNodes
     * @return  array
     */
    protected function exportTranslations(DoctrineCollection $bridgeNodes)
    {
        return array_map(
            function ($translation) {
                /** @var object $translation */
                return $translation->export();
            },
            $bridgeNodes->toArray()
        );
    }
}
