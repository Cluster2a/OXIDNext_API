<?php

/**
 * This Software is the property of ITSOUP and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) ITSOUP Alexander Hirschfeld
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@itsoup.de>
 * @link               https://www.itsoup.de
 */

declare(strict_types=1);

namespace ITSOUP\VariantExtension\Core;

class DummyObject
{
    protected array $files = [];
    protected int $key = 0;
    protected \stdClass $wrapper;

    public function __construct(\stdClass $wrapper, int $key)
    {
        $this->wrapper = $wrapper;
        $this->key = $key;
    }

    public function setValue(string $value): void {
        $this->wrapper->files[$this->key] = $value;
        unset($this->wrapper);
        unset($this->key);
    }
}