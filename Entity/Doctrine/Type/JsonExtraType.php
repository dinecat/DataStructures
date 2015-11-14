<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Entity\Doctrine\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type class for json type with extended transformations.
 * @package     DinecatDataStructures
 * @subpackage  Entity.Doctrine.Type
 * @author      Mykola Zyk <relo.san.pub@gmail.com>
 */
class JsonExtraType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return json_encode($this->encodeExtra($value), JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return [];
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        return $this->decodeExtra(json_decode($value, true));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'json_extra';
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return !$platform->hasNativeJsonType();
    }

    /**
     * Encode extra data for safe storing to JSON.
     * @param   mixed   $input  Input array (to JSON).
     * @return  mixed
     */
    protected function encodeExtra($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = $this->encodeExtra($value);
                } elseif ($value instanceof \DateTime) {
                    $input[$key] = 'datetime#' . $input->format(\DateTime::ISO8601);
                }
            }
        } elseif ($input instanceof \DateTime) {
            return 'datetime#' . $input->format(\DateTime::ISO8601);
        }
        return $input;
    }

    /**
     * Decode extra data from JSON.
     * @param   mixed   $input  Input array (from JSON).
     * @return  mixed
     */
    protected function decodeExtra($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = $this->decodeExtra($value);
                } elseif (mb_substr($value, 0, 9) === 'datetime#') {
                    $input[$key] = new \DateTime(mb_substr($value, 9));
                }
            }
        } elseif (is_string($input) && mb_substr($input, 0, 9) === 'datetime#') {
            return new \DateTime(mb_substr($input, 9));
        }
        return $input;
    }
}
