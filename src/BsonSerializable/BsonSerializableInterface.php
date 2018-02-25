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

use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

interface BsonSerializableInterface extends Serializable, Unserializable
{
    /**
     * @param string $hash
     */
    public function setHash($hash);

    /**
     * @return string|null
     */
    public function getHash();

    /**
     * @return bool
     */
    public function isDirty();

    /**
     * @return string
     */
    public function toBinary();

    /**
     * @param $string
     * @return static
     */
    public function fromBinary($string);
}
