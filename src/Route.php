<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use CAction;
use CController;
use CUrlRule;

/** @psalm-immutable */
final class Route
{
    /** @var CUrlRule */
    public $rule;

    /** @var CController */
    public $controller;

    /** @var CAction|null */
    public $action;

    public function __construct(
        CUrlRule $rule,
        CController $controller,
        ?CAction $action = null
    ) {
        $this->rule = $rule;
        $this->controller = $controller;
        $this->action = $action;
    }
}
