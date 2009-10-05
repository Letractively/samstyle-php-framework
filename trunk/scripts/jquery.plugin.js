
/* *******************************

$(selector).scrollto();
scrolls smoothly to the position of the selected element. 

******************************* */

$.fn.scrollto = function(d){
    $("html,body").animate({scrollTop: $(this).offset().top}, d,'linear');
    return this;
}