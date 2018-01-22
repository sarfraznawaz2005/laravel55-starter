<?php
//////////////////////////////////////////////////////////
// Allows to push same view only file
// Usage:
// @pushonce('stack_name')
// some stuff
// @endpushonce
//////////////////////////////////////////////////////////

Blade::directive('pushonce', function ($expression) {
    $isDisplayed = '__pushonce_' . trim(substr($expression, 1, -1));
    return "<?php if(!isset(\$__env->{$isDisplayed})): \$__env->{$isDisplayed} = true; \$__env->startPush({$expression}); ?>";
});

Blade::directive('endpushonce', function ($expression) {
    return '<?php $__env->stopPush(); endif; ?>';
});