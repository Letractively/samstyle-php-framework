Back to [CustomHTMLTags](CustomHTMLTags.md).

# Introduction #

In Samstyle PHP Framework, we support several non-standard HTML tags which are rendered server-side before passing to the client.

All the customized tags are parsed at template.inc.php before displaying to client side.

This tag will not work if you use the `echo` statement. You will need to use the Samstyle PHP Framework standard output system i.e. the `p()` function.

# `<nohtml>` tag #

| **Tag** | **Description** | **Example** |
|:--------|:----------------|:------------|
| nohtml  | html entity encode all html codes within it. | `p('<nohtml><b>html code</b></nohtml>');` |

The `nohtml` tag encodes all active characters within it into HTML entities. This can be used in place of `html::encode()`, since `nohtml` also uses `html::encode()`.

| **Example** |
|:------------|
| `p('<nohtml><div class="d5">html <b>code</b></div></nohtml>');` |
| output at browser source: |
| `&lt;div class="d5"&gt;html &lt;b&gt;code&lt;/b&gt;&lt;/div&gt;` |

This can be useful to remove XSS bugs where you need to display user-generated variables.