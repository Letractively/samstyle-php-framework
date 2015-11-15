# Introduction #

Samstyle PHP Framework creates some variables which are loaded at `head.inc.php` and can be used throughout the whole script. However, these variables are not superglobal and thus using `global` or `g()` to call these variables is still required.


# Predefined Variables #

  * `config.inc.php`
    * [$\_SITE](PredefinedVariables_SITE.md) - contains information about the website
    * [$\_PAGE](PredefinedVariables_PAGE.md) - contains information about the page
    * [$\_CONF](PredefinedVariables_CONF.md) - contains configuration information for add ons and so on.
    * [$includes](PredefinedVariables_includes.md) - all files that are included (TDG/DAO, classes, includes)
    * [$\_ajax](PredefinedVariables_ajax.md) - PHP-JS function related information.

  * `head.inc.php`
    * `$session_hash` - a CRC32 hash of the session ID, can be used for form security validation
    * `$post` - all post headers. if `$_SITE['autoparsehttpargs']` is set to true, all post headers will be parsed with `parse_http_args()`
    * `$get` - all get headers.  if `$_SITE['autoparsehttpargs']` is set to true, all post headers will be parsed with `parse_http_args()`
