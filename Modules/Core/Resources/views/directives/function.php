<?php
///////////////////////////////////////////////////////////////
//  Allows to create and use functions inside view files
//
//  Usage:
//
//  @function(makeDropdown ($arg1, $arg1))
//  function body code...
//  @endfunction 
//
//  Calling function:
//      @makeDropdown('foo', 'bar')
//
///////////////////////////////////////////////////////////////

Blade::directive('function', function ($expression) {
    /**
     * Get the function name
     *
     * The regex pattern below is from php.net.
     * It's the rule for valid function names in PHP
     *
     * @link http://php.net/manual/en/functions.user-defined.php
     */
    if (!preg_match("/^\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/", $expression, $matches)) {
        throw new \Exception("Invalid function name given in blade template: '$expression' is invalid");
    }

    $name = $matches[1];

    /**
     * Get the parameter list
     */
    if (preg_match("/\((.*)\)/", $expression, $matches)) {
        $params = $matches[1];
    } else {
        $params = "";
    }

    /**
     * Define new directive named as the function
     * Call this like: @foo('bar')
     */
    Blade::directive($name, function ($expression) use ($name) {
        /**
         * We only need a comma if there are arguments passed
         */
        $expression = trim($expression);

        if ($expression) {
            $expression .= " , ";
        }

        return "<?php $name ($expression \$__env); ?>";
    });

    /**
     * We only need a comma if there are arguments
     */
    $params = trim($params);

    if ($params) {
        $params .= " , ";
    }

    /**
     * Define the global function
     * Call this like: foo('bar', $__env)
     */
    return "<?php function $name ( $params  \$__env ) { ?>";
});

Blade::directive('return', function ($expression) {
    return "<?php return ($expression); ?>";
});

Blade::directive('endfunction', function () {
    return "<?php } ?>";
});