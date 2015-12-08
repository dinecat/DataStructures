<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Exception;

/**
 * Exception for attempt of setting data from wrong objest (object with other identifier).
 * @package DinecatDataStructures\Exception
 * @author  Mykola Zyk <relo.san.pub@gmail.com>
 */
class IdentifiersNotMatchException extends \RuntimeException
{
    /**
     * Constructor.
     * @param   string          $class      Entity class name.
     * @param   int             $entityId   Entity identifier.
     * @param   int             $datasetId  Dataset identifier.
     * @param   string          $field      Field name [optional, default "id"].
     * @param   int             $code       The Exception code [optional, default 0].
     * @param   \Exception|null $previous   The previous exception used for the exception chaining [optional].
     */
    public function __construct($class, $entityId, $datasetId, $field = 'id', $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf(
                'Entity "%s" with %s (%s) not matched with dataset %s (%s).',
                $class,
                $field,
                $entityId,
                $field,
                $datasetId
            ),
            $code,
            $previous
        );
    }
}
