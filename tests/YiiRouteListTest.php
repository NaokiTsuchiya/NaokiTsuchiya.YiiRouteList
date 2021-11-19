<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CWebApplication;
use PHPUnit\Framework\TestCase;
use Yii;

use function dirname;

class YiiRouteListTest extends TestCase
{
    /** @var YiiRouteList */
    protected $yiiRouteList;

    protected function setUp(): void
    {
        $this->yiiRouteList = new YiiRouteList();
    }

    protected function tearDown(): void
    {
        Yii::setApplication(null); // @phpstan-ignore-line
    }

    public function testIsInstanceOfYiiUrlList(): void
    {
        $actual = $this->yiiRouteList;
        $this->assertInstanceOf(YiiRouteList::class, $actual);
    }

    public function testInvoke(): void
    {
        $config = [
            'basePath' => dirname(__DIR__) . '/tests/Fake/protected',
            'components' => [
                'urlManager' => [
                    'urlFormat' => 'path',
                    'rules' => [
                        '/pattern' => [
                            'pattern/get',
                            'urlSuffix' => '/', // phpcs:ignore Squiz.Arrays.ArrayDeclaration.KeySpecified
                        ],
                        [
                            'pattern/post',
                            'pattern' => '/pattern', // phpcs:ignore Squiz.Arrays.ArrayDeclaration.KeySpecified
                            'urlSuffix' => '/',
                        ],
                        [
                            'pattern/put',
                            'pattern' => '/pattern', // phpcs:ignore Squiz.Arrays.ArrayDeclaration.KeySpecified
                            'urlSuffix' => '/',
                        ],
                    ],
                ],
            ],
        ];
        $list = ($this->yiiRouteList)(new CWebApplication($config));
        foreach ($list as $item) {
            $this->assertInstanceOf(Route::class, $item);
        }
    }
}
