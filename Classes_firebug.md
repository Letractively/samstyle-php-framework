Back to [Classes](Classes.md).

# Introduction #

The `firebug` class is a class which you can use to do server-side debugging on Firebug - the popular web development plugin for Firefox. It is very useful for developers who are used to using Firebug and would love to see error messages and variable dumps in the console.

# Requirements #
This class requires the following classes to be included:
  * [php.class.php](Classes_php.md)
  * [html.class.php](Classes_html.md)

This class requires the following components:
  * Firebug on the client side
  * Output to Javascript

# Methods #

| **Method name** | **Args** | **Purpose** | **Example** |
|:----------------|:---------|:------------|:------------|
| `dump`          | variable number of args | implements `console.log` on Javascript and dumps out all the argument it receives. | `$fbug->dump($var1, $var2, $arr3);` |
| `group`         | variable number of args | start grouping for subsequent console output. | `$fbug->group('Debugging for Array Cleaning');` |
| `group_end`     | void     | ends grouping for console output | `$fbug->group_end();` |
| `log`           | variable number of args | alias of `dump()` | `$fbug->log($var1, $arr2);` |
| `debug`         | variable number of args | outputs variables for debugging on the console. | `$fbug->debug($msg);` |
| `error`         | variable number of args | outputs variables as error on the console. | `$fbug->error($var);` |
| `warn`          | variable number of args | outputs variable as warning on the console. | `$fbug->warn($msg);` |
| `timer_start`   | (string)$timer\_id | starts a new timer using the identifier. | `$fbug->timer_start('speedtest');` |
| `timer_stop`    | (string)$timer\_id | stops timer with identifier $timer\_id and return the timing between start and stop in seconds (float) | `$t = $fbug->timer_stop();` |
| `commit`        | void     | commits the javascript code into the output and resets the buffer | `$fbug->commit();` |