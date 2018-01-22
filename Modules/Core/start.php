<?php

if (!app()->routesAreCached()) {
    require __DIR__ . '/Http/routes.php';
}

// load helpers
foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
    require_once($filename);
}
