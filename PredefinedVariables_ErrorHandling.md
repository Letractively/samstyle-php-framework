# Introduction #

This article highlights the format and the function of `$_SITE['error']` of the Samstyle PHP Framework. The variable will affect how PHP handles error messages and logging on the web application.

# Details #

The `$_SITE['error']` can be an array or false. When set to `false`, error handling is fully disabled. If the variable is an array, the keys are as follows

| **key** | **value meaning** | **values** | default |
|:--------|:------------------|:-----------|:--------|
| level   | level of error that is trapped.<br />Also see: http://www.php.net/manual/en/function.error-reporting.php | Combination of [Error Handling Predefined Constants](http://www.php.net/manual/en/errorfunc.constants.php) | E\_ALL & ~E\_NOTICE |
| handler\_func | the name of a custom user function that will handle errors. Set to false to disable | boolean-false or string | false or empty string |
| display | Sets whether errors are displayed on the page | boolean (true or false) | false   |
| log     | Sets whether errors are logged to the log file. | boolean (true or false) | true    |
| logfile | Sets the log file to use. Pathname. | string     | 'error.log' |

# Example #
```
$_SITE['error'] = array(
'level' => E_ALL  & ~E_NOTICE,
'handler_func' => '',
'display'=>false,
'log'=>true,
'logfile' => 'error.log'
);
```