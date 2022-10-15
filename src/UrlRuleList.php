<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CUrlManager;
use CUrlRule;
use NaokiTsuchiya\YiiRouteList\Exception\RuntimeException;
use ReflectionClass;
use ReflectionProperty;

final class UrlRuleList
{
    /** @return list<CUrlRule> */
    public function __invoke(CUrlManager $urlManager): array
    {
        $reflectionClass = new ReflectionClass($urlManager);
        $rulesProperty = $this->getRulesProperty($reflectionClass);

        /** @var list<CUrlRule> $rules */
        $rules = $rulesProperty->getValue($urlManager);

        return $rules;
    }

    /** @param ReflectionClass<object> $reflectionClass */
    private function getRulesProperty(ReflectionClass $reflectionClass): ReflectionProperty
    {
        if ($reflectionClass->hasProperty('_rules')) {
            $_rules = $reflectionClass->getProperty('_rules');
            $_rules->setAccessible(true);

            return $_rules;
        }

        $parent = $reflectionClass->getParentClass();
        // @codeCoverageIgnoreStart
        if (! $parent) {
            throw new RuntimeException("{$reflectionClass->getName()} does not have _rules and parent class");
        }

        // @codeCoverageIgnoreEnd

        return $this->getRulesProperty($parent);
    }
}
