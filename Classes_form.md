Back to [Classes](Classes.md).

# Introduction #

The `form` class is a class of static methods which you can use to generate form components easily.

Note that all the static methods return the HTML code. You will need to use `p()` to output the value returned by the methods.

# Requirements #
This class requires the following classes to be included:
  * [html.class.php](Classes_html.md)
  * [bit.class.php](Classes_bit.md)

# Methods #

| **Method name** | **Args** | **Purpose** | **Example** |
|:----------------|:---------|:------------|:------------|
| `input`         | `$name`,`[$type = 'text']`,`[$default_value = '']` | Creates an input component based on the name, type and default value | `p(form::input('username'));` |
| `select`        | `$arr`, `$name`, `[$selected = '']` | Creates a select field based on the array $arr and $name | `p(form::select($values,'gender','M'))` |
| `counter`       | `$domID`, `[$maxlength = 0]` | creates a counter for any input or textarea boxes. e.g. 342 characters remaining...<br />NOTE: this function requires jQuery. | `p(form::counter('description',500));` |
| `security`      | `$key_id` | creates 2 hidden input field for preventing cross site forgeries. Only for POST methods. Use `form::chksecurity` to check and validate. | `p(form::security('userlogin'));` |
| `chksecurity`   | `$key_id` | Checks the postback for security fields and validate them. Only for POST methods. With use with `form::security`. Returns true on valid, false on failure. | `if(form::chksecurity('userlogin')){}else{}` |