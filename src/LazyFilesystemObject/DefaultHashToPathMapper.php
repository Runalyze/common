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

class DefaultHashToPathMapper implements HashToPathMapperInterface
{
    /** @var int */
    protected $NumberOfDirectories;

    /** @var int */
    protected $CharsPerDirectory;

    /** @var string */
    protected $DirectorySeparator;

    /**
     * @param int    $numberOfDirectories
     * @param int    $charsPerDirectory
     * @param string $directorySeparator
     */
    public function __construct($numberOfDirectories = 3, $charsPerDirectory = 2, $directorySeparator = '/')
    {
        $this->NumberOfDirectories = $numberOfDirectories;
        $this->CharsPerDirectory = $charsPerDirectory;
        $this->DirectorySeparator = $directorySeparator;
    }

    /**
     * @param  string $hash
     * @return string file path
     */
    public function hashToPath($hash)
    {
        $prefix = '';

        for ($i = 0; $i < $this->NumberOfDirectories; ++$i) {
            $prefix .= substr($hash, $i * $this->CharsPerDirectory, $this->CharsPerDirectory).$this->DirectorySeparator;
        }

        return $prefix.$hash;
    }

    /**
     * @param  string $filePath
     * @return string hash
     */
    public function pathToHash($filePath)
    {
        $start = $this->NumberOfDirectories * ($this->CharsPerDirectory + strlen($this->DirectorySeparator));

        return substr($filePath, $start);
    }
}
