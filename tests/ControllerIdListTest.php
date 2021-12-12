<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CWebApplication;
use PHPUnit\Framework\TestCase;
use Yii;

use function dirname;

class ControllerIdListTest extends TestCase
{
    private ControllerIdList $controllerIdList;

    protected function setUp(): void
    {
        $this->controllerIdList = new ControllerIdList();
    }

    protected function tearDown(): void
    {
        Yii::setApplication(null); // @phpstan-ignore-line
    }

    public function testInvoke(): void
    {
        $app = new CWebApplication(
            [
                'basePath' => dirname(__DIR__) . '/tests/Fake/protected',
                'components' => [
                    'urlManager' => [
                        'urlFormat' => 'path',
                        'rules' => [
                            'pattern' => ['route', 'urlSuffix' => '/', 'verb' => 'GET'],
                        ],
                    ],
                ],
            ]
        );

        $actual = ($this->controllerIdList)($app->getControllerPath());

        $this->assertCount(3, $actual);
        $this->assertSame('path1/deps1', $actual[0]);
        $this->assertSame('path1/path2/deps2', $actual[1]);
        $this->assertSame('pattern', $actual[2]);
    }
}
