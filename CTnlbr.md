Back to [CustomHTMLTags](CustomHTMLTags.md).

# Introduction #

In Samstyle PHP Framework, we support several non-standard HTML tags which are rendered server-side before passing to the client.

All the customized tags are parsed at template.inc.php before displaying to client side.

This tag will not work if you use the `echo` statement. You will need to use the Samstyle PHP Framework standard output system i.e. the `p()` function.

# `<nlbr>` tag #

| **Tag** | **Description** | **Example** |
|:--------|:----------------|:------------|
| nlbr    | changes all new line characters (`\n`) to <br />  | `p("<nlbr>\n\n</nlbr>");` |

The `nlbr` tag changes all new line control characters `\n` into the breakline tag `<br/>`. This can be used in place of `nl2br`, since `nlbr` automatically uses `nl2br`.

| **Example** |
|:------------|
| `p("<nlbr>bar\n\nfoo!</nlbr>");` |
| output at browser source: |
| `bar<br/><br/>foo!` |