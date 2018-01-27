<?php
/**
 * This file holds module macros.
 *
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/19/2017
 * Time: 1:57 PM
 */

// System modules that should NOT be deleted
Module::macro('getSystemModules', function () {
    return [
        "Admin",
        "Main",
        "Core",
        "Crud",
        "User",
    ];
});