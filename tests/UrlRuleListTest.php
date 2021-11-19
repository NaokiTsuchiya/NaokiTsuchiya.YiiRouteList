<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CUrlManager;
use CUrlRule;
use CWebApplication;
use PHPUnit\Framework\TestCase;
use Yii;

use function assert;
use function dirname;

final class UrlRuleListTest extends TestCase
{
    /** @var UrlRuleList */
    private $urlRuleList;

    protected function setUp(): void
    {
        $this->urlRuleList = new UrlRuleList();
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
        $urlManager = $app->getUrlManager();
        assert($urlManager instanceof CUrlManager);
        $rules = ($this->urlRuleList)($urlManager);

        foreach ($rules as $rule) {
            $this->assertInstanceOf(CUrlRule::class, $rule);
        }
    }

    public function testExtendUrlManager(): void
    {
        $app = new CWebApplication(
            [
                'basePath' => dirname(__DIR__) . '/tests/Fake/protected',
                'components' => [
                    'urlManager' => [
                        'class' => ExtendUrlManager::class,
                        'urlFormat' => 'path',
                        'rules' => [
                            'pattern' => ['route', 'urlSuffix' => '/', 'verb' => 'GET'],
                        ],
                    ],
                ],
            ]
        );
        $urlManager = $app->getUrlManager();
        assert($urlManager instanceof ExtendUrlManager);
        $rules = ($this->urlRuleList)($urlManager);

        foreach ($rules as $rule) {
            $this->assertInstanceOf(CUrlRule::class, $rule);
        }
    }

    public function testExtendExtendUrlManager(): void
    {
        $app = new CWebApplication(
            [
                'basePath' => dirname(__DIR__) . '/tests/Fake/protected',
                'components' => [
                    'urlManager' => [
                        'class' => ExtendExtendUrlManager::class,
                        'urlFormat' => 'path',
                        'rules' => [
                            'pattern' => ['route', 'urlSuffix' => '/', 'verb' => 'GET'],
                        ],
                    ],
                ],
            ]
        );
        $urlManager = $app->getUrlManager();
        assert($urlManager instanceof ExtendExtendUrlManager);
        $rules = ($this->urlRuleList)($urlManager);

        foreach ($rules as $rule) {
            $this->assertInstanceOf(CUrlRule::class, $rule);
        }
    }
}
