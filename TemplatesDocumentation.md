# Introduction #

On this page, you're going to learn more about Templates in Samstyle PHP Framework. Basically Samstyle PHP Framework uses a template system that is easy to implement and understand.

On top of the usual HTML and XHTML, Samstyle PHP Framework uses the <$tagname$> tags to insert content, variables and blocks into the template and then echo out the buffer.

# Work flow #

  1. The view controllers includes the `template.inc.php` file using `include('inc/template.inc.php');`
  1. the Template manager aka `template.inc.php` parses and renders all blocks.
  1. Template manager retrieves the template file from `$_PAGE['template']`.
  1. Template manager creates an array `$_TEMPLATE` with relationship of `$tag => $value`.
  1. Template manager then replaces all the instances of `$tag` with `$value`.
  1. lastly the manager parses all the [customized html tags](CustomHTMLTags.md).

# Tags in the templates #

These are the following standard tags that will be parsed from the templates and the contents of the corresponding tags will replace the tags.
```
$_TEMPLATE = array(
     '<$content$>'=>$_PAGE['content'],
     '<$title$>'=>$_PAGE['title'],
     '<$copyright$>' => $_SITE['copyright'],
     '<$cssurl$>' => $_PAGE['css'],
     '<$baseurl$>' => $_SITE['approot'],
     '<$robots$>' => $_PAGE['robots'],
     '<$header$>' => $_PAGE['header'],
     '<$metarevisit$>' => '1',
     '<$pagekeywords$>' => $_PAGE['keywords'],
     '<$pagedescription$>' => $_PAGE['description'],
     '<$logourl$>'=>$_PAGE['logourl'],
     '<$content$>'=>$_PAGE['content'],
     '<$version$>' => $_SITE['ver'],
     '<$footer$>' => $_PAGE['footer'],
     '<$sitename$>' => $_SITE['name'],
     '<$approot$>'=>$_SITE['approot'],
     '<$sitelang$>'=>'en-gb',
     '<$sessid$>' => session_id(),
     '<$self$>' => $_SERVER['PHP_SELF']
);
```
Note: `$_PAGE` and `$_SITE` are [predefined variables](PredefinedVariables.md) created by the framework.

# Blocks #
Block is a new feature introduced in v0.9 of Samstyle PHP Framework. It is to allow programmer/developers to break down the code into smaller files and reduce repetition.

Block is actually an included file which is take place of the `<$block:name$>` tag, where `name` is the key registered in `$_PAGE['blocks']`.

`$_PAGE['blocks']` is an array with the relation $key => $value, where $key is the identifier used with the tag name, e.g. `<$block:key$>`. $value is the content or file content to replace the tag. If $value is a PHP file in the blocks folder, the output of the file via `p()` will replace the tag instead.

Example:
```

$_PAGE['blocks'] = array(
'test' => 'foobar is awesome'
);

p('<$block:test$>');
// outputs "foobar is awesome"

```