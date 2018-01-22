<?php
// Shows sweet alert message with a close button
// Usage: @alert('Hello World')
Blade::directive('alert', function ($message) {
    return "<?php alert($message)->persistent('Close');?>";
});