<?php

declare(strict_types=1);

namespace NaokiTsuchiya\YiiRouteList;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function assert;
use function lcfirst;
use function strlen;
use function substr;

use const DIRECTORY_SEPARATOR;

class ControllerIdList
{
    private const CONTROLLER_FILE_SUFFIX = 'Controller.php';

    /** @return list<string> */
    public function __invoke(string $controllerPath): array
    {
        $controllerIdList = [];
        foreach ($this->files($controllerPath) as $controllerFile) {
            assert($controllerFile instanceof SplFileInfo);
            $controllerIdList[] = $this->getControllerId($controllerFile, $controllerPath);
        }

        return $controllerIdList;
    }

    /** @return ControllerFilterIterator<SplFileInfo> */
    private function files(string $path): ControllerFilterIterator
    {
        return new ControllerFilterIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $path,
                    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
                ),
                RecursiveIteratorIterator::LEAVES_ONLY
            )
        );
    }

    private function getControllerId(SplFileInfo $fileInfo, string $path): string
    {
        $fromPath = substr(
            $fileInfo->getPathname(),
            strlen($path . DIRECTORY_SEPARATOR)
        );

        $prefix = substr($fromPath, 0, -strlen($fileInfo->getFilename()));
        $name = lcfirst($fileInfo->getBasename(self::CONTROLLER_FILE_SUFFIX));

        return $prefix . $name;
    }
}
