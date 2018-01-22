<?php
/**
 * This file holds module macros.
 *
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/19/2017
 * Time: 1:57 PM
 */

//Checks if given module is enabled
Module::macro('isEnabled', function ($moduleName) {
    if ($this->has($moduleName)) {
        $module = $this->find($moduleName);
        return $module->isStatus(1);
    }

    return false;
});

//Checks if given module is available whether enabled or not
Module::macro('isAvailable', function ($moduleName) {
    if ($this->has($moduleName)) {
        return true;
    }

    return false;
});