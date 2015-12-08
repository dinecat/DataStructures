<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Exception;

/**
 * Exception for none existent entity record.
 * @package DinecatDataStructures\Exception
 * @author  Mykola Zyk <relo.san.pub@gmail.com>
 */
class EntityNotFoundException extends \RuntimeException
{
    /**
     * Constructor.
     * @param   string          $class      Entity class name.
     * @param   int             $entityId   Entity identifier.
     * @param   string          $field      Field name [optional, default "id"].
     * @param   int             $code       The Exception code [optional, default 0].
     * @param   \Exception|null $previous   The previous exception used for the exception chaining [optional].
     */
    public function __construct($class, $entityId, $field = 'id', $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Entity "%s" with %s (%s) not found.', $class, $field, $entityId), $code, $previous);
    }
}
