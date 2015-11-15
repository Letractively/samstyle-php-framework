# Introduction #

This article documents the `$_ajax` predefined variable of the Samstyle PHP Framework.

To disable calls to PHP function from Javascript/AJAX, simply set `$_ajax` to false.

# Keys of `$_ajax` array #
The column **key** represents `$_ajax[key]`. The meaning of the `$_ajax[key]` value will be explained in the **value meaning** column.

| **key** | **value meaning** | **values** |
|:--------|:------------------|:-----------|
| callback | the default Javascript callback function to call when returning javascript code | string     |
| func    | an array containing a list of PHP functions that are allowed to be registered/declared and be used from Javascript. | array with no index |
| err     | an error of error messages to return when an error occurred. See more below at the error section | array      |
| sessCheck | sets whether `$_GET['sh']` is checked against $session\_hash to prevent cross session hacking | boolean (true or false) |
| refCheck | sets whether `$_SERVER[HTTP_REFERER]` is checked against `$_SITE['approot']` to see if the call was from the same domain | boolean (true or false) |

# Error Messages to return - `$_ajax['err']` #

As discussed, `$_ajax['err']` is an array of predefined error messages, returned when the specific error occured.

| **key** | **value meaning** |
|:--------|:------------------|
| funcNotFound | The function called was not declared or disabled |
| sessionFail | The session hash was invalid. Probably an expired session or cross session hacking.<br />This will only be sent when `$_ajax['sessCheck']` is set to `true`. |
| invalidRef | The referral URL domain does not match with the current host. Probably the call was from another domain.<br />This will only be sent when `$_ajax['refCheck']` is set to `true`. |