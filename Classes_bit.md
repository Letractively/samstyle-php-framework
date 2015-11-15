Back to [Classes](Classes.md).

# Introduction #

The `bit` class is a class of static methods which you can use to manipulate bits of an int variable. It is specially useful to manipulate and store for example multiple error numbers, multiple flag parameter and so on.

# Requirements #
This class has no requirements.

# Methods #

| **Method name** | **Args** | **Purpose** | **Example** |
|:----------------|:---------|:------------|:------------|
| `init`          | `&$bf`   | initialize variable to manipulate with bits. a workaround to fix a [PHP bug : 3176](http://bugs.php.net/bug.php?id=3176) | `bit::init($i);` |
| `query`         | `$bf`, `$n` | returns true or false on whether the specified bit is set or not. | `$ok = bit::query($i, 3);` |
| `on`            | `&$bf`, `$n` | force a specific bit to turn on (i.e. set to 1) | `bit::on($i, 2);` |
| `off`           | `&$bf`, `$n` | force a specific bit to turn off (i.e. set to 0) | `bit::off($i, 2);` |
| `toggle`        | `&$bf`, `$n` | toggle a bit so that if the bit is on it will be turn off, if the bit is off it will be turned on. | `bit::toggle($i, 2);` |