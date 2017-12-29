<?php

namespace App\Domain\Query;

use IteratorAggregate;
use ArrayIterator;
use InvalidArgumentException;

class ResultSet implements IteratorAggregate
{
    /**
     * @var array
     */
    private $documents;

    /**
     * @var int
     */
    private $hits;

    public static function create(array $documents, array $options = [])
    {
        $new = new self();
        $new->documents = $documents;
        foreach ($options as $key => $value) {
            if (false === property_exists($new, $key)) {
                throw new InvalidArgumentException(sprintf(
                    'Option "%s" is invalid', $key
                ));
            }
        }

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->documents);
    }

    public function hits(): int
    {
        return $this->hits;
    }

    public function toArray()
    {
        return $this->documents;
    }
}
