<?php

/*
 * This file is part of the Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\LazyFilesystemObject;

use League\Flysystem\Filesystem;
use ProxyManager\Configuration;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Runalyze\Common\BsonSerializable\BsonSerializableInterface;

class LazyFilesystemObjectStorage
{
    /** @var Filesystem */
    protected $Filesystem;

    /** @var HashToPathMapperInterface */
    protected $PathMapper;

    /** @var LazyLoadingValueHolderFactory */
    protected $ProxyFactory;

    public function __construct(
        Filesystem $filesystem,
        HashToPathMapperInterface $pathMapper,
        Configuration $proxyConfiguration = null
    ) {
        $this->Filesystem = $filesystem;
        $this->PathMapper = $pathMapper;
        $this->ProxyFactory = new LazyLoadingValueHolderFactory($proxyConfiguration);
    }

    /**
     * @param  string                    $hash
     * @param  string                    $class
     * @return BsonSerializableInterface
     */
    public function getObject($hash, $class)
    {
        $path = $this->PathMapper->hashToPath($hash);

        return $this->ProxyFactory->createProxy(
            $class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) use ($path, $class) {
                try {
                    $contents = $this->Filesystem->read($path);
                } catch (\Exception $e) {
                    throw $e; // TODO
                }

                try {
                    $wrappedObject = \MongoDB\BSON\toPHP($contents, ['root' => $class]);
                } catch (\Exception $e) {
                    throw $e; // TODO
                }

                $initializer = null;
            }
        );
    }

    /**
     * @param string                    $hash
     * @param BsonSerializableInterface $object
     */
    public function storeObject($hash, BsonSerializableInterface $object)
    {
        $path = $this->PathMapper->hashToPath($hash);

        $this->Filesystem->put($path, $object->toBinary());
    }
}
