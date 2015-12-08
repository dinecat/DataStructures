<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Entity;

/**
 * Base dataset class.
 * @package DinecatDataStructures\Entity
 * @author  Mykola Zyk <relo.san.pub@gmail.com>
 */
class Dataset
{
    /**
     * Dataset completion state.
     * @var int
     */
    protected $datasetComplete = false;

    /**
     * Get boolean flag of dataset completeness.
     * @return  bool
     */
    public function isDatasetComplete()
    {
        return $this->datasetComplete;
    }

    /**
     * Set state of dataset completion.
     * @param   bool    $state
     * @return  static
     */
    public function setDatasetCompletion($state)
    {
        $this->datasetComplete = $state;
        return $this;
    }

    /**
     * Get dataset identifier.
     * @return  string
     */
    public function getDatasetIdent()
    {
        return substr(sha1(get_class($this)), 0, 8);
    }
}
