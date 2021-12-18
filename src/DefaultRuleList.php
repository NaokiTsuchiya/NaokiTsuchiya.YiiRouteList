<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CController;
use CUrlRule;
use CWebApplication;
use ReflectionClass;
use ReflectionMethod;

use function array_keys;
use function array_map;
use function array_merge;
use function array_reduce;
use function assert;
use function lcfirst;
use function strlen;
use function substr;

use const DIRECTORY_SEPARATOR;

final class DefaultRuleList
{
    /**
     * @param list<string> $controllerIdList
     *
     * @return list<CUrlRule>
     */
    public function __invoke(CWebApplication $app, array $controllerIdList): array
    {
        $list = [];
        foreach ($controllerIdList as $controllerId) {
            [$controller] = $app->createController($controllerId . DIRECTORY_SEPARATOR);
            assert($controller instanceof CController);

            $list[] = $this->getActionsRule($controller);
            $list[] = $this->getActionMethodRules($controller);
        }

        return array_reduce(
            $list,
            /**
             * @param list<CUrlRule> $carry
             * @param list<CUrlRule> $item
             *
             * @return list<CUrlRule>
             */
            static function (array $carry, array $item): array {
                return array_merge($carry, $item);
            },
            []
        );
    }

    /** @return list<CUrlRule> */
    private function getActionMethodRules(CController $controller): array
    {
        $reflectionClass = new ReflectionClass($controller);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $list = [];
        foreach ($methods as $method) {
            $name = $method->getName();
            if ($name === 'actions') {
                continue;
            }

            $prefixLength = strlen('action');
            $prefix = substr($name, 0, $prefixLength);

            if ($prefix !== 'action') {
                continue;
            }

            $actionId = lcfirst(substr($name, $prefixLength));

            $list[] = $this->createRule($controller, $actionId);
        }

        return $list;
    }

    /**
     * @return list<CUrlRule>
     */
    private function getActionsRule(CController $controller): array
    {
        /** @var list<string> $actionIdList */
        $actionIdList = array_keys($controller->actions());

        return array_map(
            function (string $actionId) use ($controller): CUrlRule {
                return $this->createRule($controller, $actionId);
            },
            $actionIdList
        );
    }

    private function createRule(CController $controller, string $actionId): CUrlRule
    {
        $route =  $controller->getId() . '/' . $actionId;

        return new CUrlRule($route, $route);
    }
}
