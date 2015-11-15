# Introduction #

Generic PHP code output functions/statement are:
`echo`, `print` and so on

In Samstyle PHP Framework, the one and only function is `p()`.

# Purpose of `p()` #
The `p()` function was inspired by the use of `$(id)` instead of document.getElementById(id) in Javascript. Shortening names commonly used statement can lessen the developer's load.

Secondly, `p()` saves the output content into a buffer variable called `$_PAGE['content']` (see [PredefinedVariables\_PAGE](PredefinedVariables_PAGE.md)), where later parsed with template tags into `$_PAGE['buffer']`. Then lastly using 1 real echo to write to client. Buffering output content into a variable has [proven to speed up applications](http://thephpcode.blogspot.com/2009/06/echo-vs-output-buffer.html).

With the output buffering in a variable, we eliminate or reduce the problem of "headers already sent". Thus allowing to put header redirects within logical code and without affecting the output.

# Usage of `p()` #

`p()`, like echo or print, accepts multiple parameters.<br />The usual way is to call it like:
```
  p('This is shown to the client browser.');
```
Using multiple parameters:
```
  p('This is shown to', ' ', 'the client browser.');
```
It's most powerful when used with the HTML class:
```
  p(html::css($CssCode));
  // outputs <style type="text/css"><!-- ... --></style>
```
Also, you can debug elegantly with:
```
  p(php::dump($var));
  // outputs <pre>array(0){}</pre>
  // and formats nicely on the browser.
```

With `p()` you will also be able to use [Customized HTML tags](CustomHTMLTags.md).