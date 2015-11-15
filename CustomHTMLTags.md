# Introduction #

In Samstyle PHP Framework, we support several non-standard HTML tags which are rendered server-side before passing to the client.

All the customized tags are parsed at `template.inc.php` before displaying to client side.

| **Tag** | **Description** | **Example** |
|:--------|:----------------|:------------|
| [nohtml](CTnohtml.md) | html entity encode all html codes within it. | `p('<nohtml><b>html code</b></nohtml>');` |
| [php](CTphp.md) | parse content within it with `highlight_string()` | `p('<php><?php echo 'testing'; ?></php>');` |
| [nlbr](CTnlbr.md) | changes all new line characters to breakline `<br/>` html tag | `p('<nlbr>'."\r\n\r\n".'</nlbr>');` |

Availability: **After Samstyle PHP Framework v1.2.4**

Note that these html tags do not support attributes and attributes are all ignored.