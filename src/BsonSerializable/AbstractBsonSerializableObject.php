<?php

/*
 * This file is part of the Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\BsonSerializable;

use MongoDB\BSON\ObjectID;

abstract class AbstractBsonSerializableObject implements BsonSerializableInterface
{
    /** @var ObjectID */
    protected $BSONObjectId;

    /** @var string|null */
    protected $Hash;

    /** @var bool */
    protected $IsDirty = false;

    public function __construct()
    {
        $this->BSONObjectId = new ObjectID();
    }

    public function setHash($hash)
    {
        $this->Hash = $hash;
    }

    public function getHash()
    {
        return $this->Hash;
    }

    public function isDirty()
    {
        return $this->IsDirty;
    }

    protected function setDirty()
    {
        $this->IsDirty = true;
    }

    public function bsonSerialize()
    {
        $data = ['_id' => $this->BSONObjectId];

        foreach ($this->getSerializableProperties() as $property) {
            $data[$property] = $this->{$property};
        }

        return $data;
    }

    public function bsonUnserialize(array $data)
    {
        $this->IsDirty = false;
        $this->BSONObjectId = isset($data['_id']) ? $data['_id'] : new ObjectID();

        foreach ($this->getSerializableProperties() as $property) {
            if (isset($data[$property])) {
                $this->{$property} = $data[$property];
            }
        }
    }

    public function toBinary()
    {
        return \MongoDB\BSON\fromPHP($this->bsonSerialize());
    }

    public function fromBinary($string)
    {
        return \MongoDB\BSON\toPHP($string, ['root' => get_class($this)]);
    }

    /**
     * @return array
     */
    abstract protected function getSerializableProperties();
}
