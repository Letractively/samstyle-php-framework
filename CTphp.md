Back to [CustomHTMLTags](CustomHTMLTags.md).

# Introduction #

In Samstyle PHP Framework, we support several non-standard HTML tags which are rendered server-side before passing to the client.

All the customized tags are parsed at template.inc.php before displaying to client side.

This tag will not work if you use the `echo` statement. You will need to use the Samstyle PHP Framework standard [output system](OutputControl.md) i.e. the `p()` function.

# `<php>` tag #

| **Tag** | **Description** | **Example** |
|:--------|:----------------|:------------|
| php     | highlights php source code between the tags | `p('<php><?php $data = file_get_contents($file); ?></php>');` |

**Example**
```
p('<php><?php
$data = file_get_contents("testingfile.txt"); // test
?></php>');
```
output at browser source:
```
<code><span style="color: #000000">
<span style="color: #0000BB">&lt;?php
<br />$data&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">file_get_contents</span><span style="color: #007700">(</span><span style="color: #DD0000">"testingfile.txt"</span><span style="color: #007700">);&nbsp;</span><span style="color: #FF8000">//&nbsp;test

<br /></span><span style="color: #0000BB">?&gt;</span>
</span>
</code>
```