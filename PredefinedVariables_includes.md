Back to [PredefinedVariables](PredefinedVariables.md).

# Introduction #

This article documents the `$includes` predefined variable of the Samstyle PHP Framework.

# Purpose of $includes #
In the framework, codes are broken down into

  * TDG/DAO database access files
  * class files
  * include core files
  * block (template) files

Thus these files are required by the framework.

So we put them all in `$includes` array so that when the page loads, all these components are loaded as well. At `inc/head.inc.php`, the code will loop through the `$includes` array and include the files.

# Security warning #

Only place files that you trust into this variable as they will be included (if they exists at the pathname) unconditionally.

# Example #

```
$_includes = array(
  'inc/library.inc.php',
  'class/firebug.class.php',
  'class/validate.class.php',
  'class/http.class.php',
  'class/php.class.php',
  'class/html.class.php',
  'class/form.class.php',
  'class/bit.class.php',
  'class/pwd.class.php',
  'inc/func.inc.php',
  'inc/dao.inc.php', // mysql DAO management
  'inc/cache.inc.php', // cache
  'dao/settings.dao.php' // settings dao
);
```