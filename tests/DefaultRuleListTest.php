<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CUrlRule;
use CWebApplication;
use PHPUnit\Framework\TestCase;
use Yii;

use function dirname;

final class DefaultRuleListTest extends TestCase
{
    private DefaultRuleList $target;

    protected function setUp(): void
    {
        $this->target = new DefaultRuleList();
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
                    'urlManager' => ['urlFormat' => 'path'],
                ],
            ]
        );

        $actual = ($this->target)($app, ['pattern']);
        $expected = [
            new CUrlRule('pattern/put', 'pattern/put'),
            new CUrlRule('pattern/invalid', 'pattern/invalid'),
            new CUrlRule('pattern/get', 'pattern/get'),
            new CUrlRule('pattern/post', 'pattern/post'),
        ];
        $this->assertEquals($expected, $actual);
    }
}
