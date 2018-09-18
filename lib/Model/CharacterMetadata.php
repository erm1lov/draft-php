<?php

namespace Prezly\DraftPhp\Model;

use InvalidArgumentException;

/**
 * @property array $style
 * @property string|null $entity
 */
class CharacterMetadata
{
    /** @var CharacterMetadata[] */
    private static $pool = [];

    /** @var array */
    private $_style;
    /** @var string */
    private $_entity;

    /**
     * @param string[] $style
     * @param string|null $entity
     * @return static
     */
    public static function create(array $style, $entity = null)
    {
        foreach ($style as $s) {
            if (! is_string($s)) {
                throw new InvalidArgumentException('$style should be an array of strings');
            }
        }
        $style = array_unique($style);
        sort($style);

        $fingerprint = md5(serialize($style) . '/' . $entity);

        if (! isset(self::$pool[$fingerprint])) {
            self::$pool[$fingerprint] = new static($style, $entity);
        }

        return self::$pool[$fingerprint];
    }

    private function __construct(array $style, $entity = null)
    {
        $this->_style = $style;
        $this->_entity = $entity;
    }

    /**
     * @return string[]
     */
    public function getStyle()
    {
        return $this->_style;
    }

    public function hasStyle(string $style)
    {
        return in_array($style, $this->_style);
    }

    /**
     * @return string|null
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    public function __get($name)
    {
        // public read-only access to internal properties
        return $this->{'_' . $name};
    }
}
