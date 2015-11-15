Back to [PredefinedVariables](PredefinedVariables.md).

# Introduction #

This article documents the `$_PAGE` predefined variable of the Samstyle PHP Framework.

# Keys of `$_PAGE` array #
The column **key** represents `$_PAGE[key]`. The meaning of the `$_PAGE[key]` value will be explained in the **value meaning** column.

| **key** | **value meaning** | **values** | **default** |
|:--------|:------------------|:-----------|:------------|
| title   | the title of the current page | string     | `$_SITE['name']` |
| keywords | keywords of the page that can be set and used for META keywords | string     | `''`        |
| description | description of the page that can be set and used for META description | string     | `''`        |
| header  | _deprecated_      | string     | `''`        |
| logourl | _deprecated_      | string     | `''`        |
| filename | the current file name of the PHP script | string     | `basename($_SERVER['PHP_SELF'])` |
| css     | _deprecated_      | string     | `''`        |
| template | relative pathname to the template file to render tags into. | string     | `templates/default.html` |
| content | the page content. this is used by the `p()` function | string     | `''`        |
| buffer  | the page buffer, used by template management | string     | `''`        |
| footer  | the page footer - _deprecated_ | string     | `$_SITE['copyright']` |
| robots  | META robots       | string     | `'index,follow'` |
| blocks  | an array of blocks used by the template rendering | array      | `array('menubar'=>'blocks/menubar.php',`<br />`'footer'=>'blocks/footer.php')` |