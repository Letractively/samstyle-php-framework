Back to [Classes](Classes.md).

# Introduction #

The `html` class is a class of static methods which you can use to generate HTML tags and code.

It is specially useful to reduce the need to keep on writing `<script type="text/javascript">` ... `</script>` or CSS.

Note that the static methods returns the HTML code. You will need to use `p()` to output the HTML codes returned by these methods.

# Requirements #
This class has no requirements.

# Methods #

| **Method name** | **Args** | **Purpose** | **Example** |
|:----------------|:---------|:------------|:------------|
| `js`            | `$js_code` | creates a `<script>` tag and puts in the Javascript code  | `p(html::js('alert("Cool!");'));` |
| `jsf`           | `$js_file` | creates a `<script>` tag and includes an external Javsacript file. | `p(html::jsf('scripts/jquery.js'));` |
| `css`           | `$css_code` | creates a `<style>` tag and puts in the CSS code. | `p(html::css('span.bigfonts{font-size:150%;}'));` |
| `c`             | `$html_comment` | returns a HTML comment string | `p(html::c('Stop viewing my application HTML source. You're gonna get nothing!'));` |
| `img`           | `$src`, `[$alt = '']` | creates a `<img>` tag with the $img and $alt.| `p(html::img('img/logo.png', 'Logo'));` |
| `link`          | `$url`, `[$title='']` | creates a hypertext link using the $url. | `p(html::link('http://example.com'));` |
| `create`        | `$tag`, `[$content = '']`, `[$attr = array()]` | creates HTML tag | `p(html::create('div','in a div section.'), array('style'=>'font-size:150%'));` |
| `tag`           | `$tag`, `[$content = '']`, `[$attr = array()]` | alias of `html::create()` | see above   |
| `encode`        | `$string` | HTML encode the string and disable all HTML | `p(html::encode('<script>'));` |
| `decode`        | `$string` | HTML decode the string | `p(html::decode('&lt;script&gt;'));` |
| `flash`         | `$file`, `$width`, `$height` | returns a XHTML compatible Flash object string | `p(html::flash('banner.swf',700,200));` |
| `control`       | `$dom_id`, `$options` | Multiple options to control a input form field. | `p(html::control('email_address',array('maxlength' => 200)));` |