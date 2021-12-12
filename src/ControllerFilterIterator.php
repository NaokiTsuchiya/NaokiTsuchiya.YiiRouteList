<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use FilterIterator;
use Iterator;
use SplFileInfo;

use function assert;
use function strrpos;

/**
 * @template T of SplFileInfo
 */
class ControllerFilterIterator extends FilterIterator
{
    private const EXTENSION = 'php';

    /** @param Iterator<SplFileInfo> $iterator */
    public function __construct(Iterator $iterator)
    {
        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        $current = $this->current();
        assert($current instanceof SplFileInfo);

        if ($current->getExtension() !== self::EXTENSION) {
            return false;
        }

        return strrpos($current->getBasename('.php'), 'Controller') !== false;
    }
}
