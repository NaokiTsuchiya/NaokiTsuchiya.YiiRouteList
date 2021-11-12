<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use PHPUnit\Framework\TestCase;

class YiiRouteListTest extends TestCase
{
    /** @var YiiRouteList */
    protected $yiiRouteList;

    protected function setUp(): void
    {
        $this->yiiRouteList = new YiiRouteList();
    }

    public function testIsInstanceOfYiiUrlList(): void
    {
        $actual = $this->yiiRouteList;
        $this->assertInstanceOf(YiiRouteList::class, $actual);
    }
}
