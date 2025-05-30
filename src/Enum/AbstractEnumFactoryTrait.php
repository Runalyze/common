<?php

/*
 * This file is part of Runalyze Common.
 *
 * (c) RUNALYZE <mail@runalyze.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Runalyze\Common\Enum;

trait AbstractEnumFactoryTrait
{
    private static ?array $ClassNames = null;
    private static string $Namespace = '';

    /**
     * Get object.
     * @param  int|string $enum from internal enum
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public static function get($enum)
    {
        if (null === self::$ClassNames) {
            self::generateNamespace();
            self::generateClassNamesArray();
        }

        if (!isset(self::$ClassNames[$enum])) {
            throw new \InvalidArgumentException('Invalid enum "'.$enum.'".');
        }

        $className = self::$Namespace.'\\'.self::$ClassNames[$enum];

        return new $className();
    }

    private static function generateNamespace(): void
    {
        self::$Namespace = substr(get_called_class(), 0, strrpos(get_called_class(), '\\'));
    }

    /**
     * @throws \Exception
     */
    private static function generateClassNamesArray(): void
    {
        if (!method_exists(get_called_class(), 'getEnum')) {
            throw new \BadMethodCallException('Classes using this trait must have static method getEnum().');
        }

        self::$ClassNames = array_map(function ($v) {
            return str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', $v))));
        }, array_flip(self::getEnum()));
    }
}
