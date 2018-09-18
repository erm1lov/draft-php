<?php

namespace Prezly\DraftPhp\Model;

use InvalidArgumentException;

/**
 * @property string $key
 * @property string $type
 * @property string $text
 * @property CharacterMetadata[] $characterList
 * @property int $depth
 * @property array $data
 */
class ContentBlock
{
    /** @var string */
    private $_key;
    /** @var string */
    private $_type;
    /** @var string */
    private $_text;
    /** @var CharacterMetadata[] */
    private $_characterList;
    /** @var int */
    private $_depth;
    /** @var array */
    private $_data = [];

    public function __construct($key, $type, $text, array $characterList, $depth, array $data = [])
    {
        foreach ($characterList as $char) {
            if (! $char instanceof CharacterMetadata) {
                throw new InvalidArgumentException('$characterList should consist of CharacterMetadata instances exclusively.');
            }
        }

        if (mb_strlen($text) !== count($characterList)) {
            throw new InvalidArgumentException('Length of $text and length of $characterList should match.');
        }

        $this->_key = $key;
        $this->_type = $type;
        $this->_text = $text;
        $this->_characterList = $characterList;
        $this->_depth = $depth;
        $this->_data = $data;
    }

    public function getKey()
    {
        return $this->_key;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return CharacterMetadata[]
     */
    public function getCharacterList()
    {
        return $this->_characterList;
    }

    public function getLength()
    {
        return mb_strlen($this->_text);
    }

    public function getDepth()
    {
        return $this->_depth;
    }

    public function getInlineStyleAt(int $offset)
    {
        return $this->_characterList[$offset]->getStyle();
    }

    public function getEntityAt(int $offset)
    {
        return $this->_characterList[$offset]->getEntity();
    }

    public function getData()
    {
        return $this->_data;
    }

    public function __get($name)
    {
        // read-only access to private properties
        return $this->{'_' . $name};
    }
}
