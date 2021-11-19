<?php

declare(strict_types=1);

class PatternController extends CController
{
    public function actionGet(): void
    {
        echo 'get';
    }

    public function actionPost(): void
    {
        echo 'post';
    }

    /** @return array<string, string> */
    public function actions(): array
    {
        return ['put' => 'application.controllers.pattern.PutAction'];
    }
}
