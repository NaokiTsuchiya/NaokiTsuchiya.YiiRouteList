<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CController;
use CException;
use CUrlRule;
use CWebApplication;
use Generator;

use function assert;
use function is_string;

final class YiiRouteList
{
    /** @return Generator<Route> */
    public function __invoke(CWebApplication $yii): Generator
    {
        $ruleList = new UrlRuleList();

        foreach ($ruleList($yii->getUrlManager()) as $rule) {
            yield $this->createRoute($yii, $rule);
        }
    }

    private function createRoute(CWebApplication $app, CUrlRule $rule): Route
    {
        [$controller, $actionId] = $app->createController($rule->route);
        assert($controller instanceof CController);
        assert(is_string($actionId));

        try {
            $action = $controller->createAction($actionId);
        } catch (CException $e) {
            $action = null;
        }

        return new Route($rule, $controller, $action);
    }
}
