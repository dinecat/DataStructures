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
 * @package     DinecatDataStructures
 * @subpackage  Entity
 * @author      Mykola Zyk <relo.san.pub@gmail.com>
 */
class Dataset
{
    /**
     * Dataset completion state.
     * @var integer
     */
    protected $isComplete = false;

    /**
     * Check if dataset contain complete data.
     * @return  boolean
     */
    public function isComplete()
    {
        return $this->isComplete;
    }

    /**
     * Set state of completion dataset.
     * @param   boolean $state
     * @return  static
     */
    public function setCompletion($state)
    {
        $this->isComplete = $state;
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
