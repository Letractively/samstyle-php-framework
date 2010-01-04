$.fontreplace = {
php:'deck/fontreplace.php'
};

$.fn.fontreplace = function(font){
this.each(function(){
var $this = $(this);
var cfont = font;
if(!cfont){
cfont = $this.css('font-family').split(',')[0];
}

var detect = new FontDetect();
if(!detect.test(cfont)){
var arr = $this.text().split(' ') ;
$this.text('');
var c = arr.length;
for(var i = 0; i < c; ++i){
$this.append('<img src="'+$.fontreplace.php+'?t='+escape(arr[i]+' ')+'&f='+escape(cfont)+'&c='+escape($this.css('color'))+'&s='+escape($this.css('font-size'))+'" alt="'+arr[i]+' " />');
}
}else{
$this.css('font-family',cfont);
}

});
};

var FontDetect = function(){
var $h = $('body');
var $d = $(document.createElement('div'));
var $s = $(document.createElement('span'));
$d.append($s);
$d.attr('id','fontdetect_unique');
$d.css('font-family','sans');
$d.css('display','none');
$s.css('font-family','sans');
$s.css('font-size','100pt');
$s.text('mmmmmmmmmooomlil');
$h.append($d);
var defaultWidth   = $s[0].offsetWidth;
var defaultHeight  = $s[0].offsetHeight;
$h.children('#fontdetect_unique').remove();
	/* test
	 * params:
	 * font - name of the font you wish to detect
	 * return: 
	 * f[0] - Input font name.
	 * f[1] - Computed width.
	 * f[2] - Computed height.
	 * f[3] - Detected? (true/false).
	 */
	function prode(font) {
		$h.append($d);
		var f = [];
		$s.css('font-family',font);
		f[0] = font;
		f[1] = $s[0].offsetWidth;
		f[2] = $s[0].offsetHeight;
		$h.children('#fontdetect_unique').remove();
		font = font.toLowerCase();
		if (font == 'serif'){
			f[3] = true;
		} else {
			f[3] = (f[1] != defaultWidth || f[2] != defaultHeight);
		}
		return f;
	}
	function test(font){
		f = prode(font);
		return f[3];
	}
	this.test = test;	
}
