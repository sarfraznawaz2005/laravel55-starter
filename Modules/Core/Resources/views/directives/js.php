<?php
// Sets a php variable in javascript by binding to window global object.
// Usage: @js('varname', 'value')
Blade::directive('js', function ($arguments) {
    list($name, $value) = explode(',', str_replace(['(', ')', ' ', "'"], '', $arguments));

    return "<?php echo \"<script>window['{$name}'] = '{$value}';</script>\" ?>";
});