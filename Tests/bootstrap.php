<?php

/*
* This file is part of the Blizzard Starcraft Api package.
*
* (c) Petre Pătrașc <petre@dreamlabs.ro>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

if (file_exists($file = __DIR__ . '/../vendor/autoload.php')) {
    $autoload = require_once $file;
} else {
    throw new RuntimeException('Install dependencies to run test suite.');
}

spl_autoload_register(function ($class) {
    if (0 === strpos($class, 'petrepatrasc\\BlizzardStarcraftBundle')) {
        $path = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 3)) . '.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;

        return true;
    }
});