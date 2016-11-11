'use strict';
var www = document.body.clientWidth;

if (www > 1000) {
    console.log("больше 1000");
         $(function() {
		    $('.fon-slider').vegas({
		        delay: 7000,
		        transitionDuration: 3000,
		        slides: [
		            { src: 'static/img/general/1.jpg'},
		            { src: 'static/img/general/2.jpg' },
		            { src: 'static/img/general/3.jpg' },
		            { src: 'static/img/general/4.jpg' },
		            { src: 'static/img/general/5.jpg' },
		            { src: 'static/img/general/6.jpg' },
		            { src: 'static/img/general/7.jpg' },
		            { src: 'static/img/general/8.jpg' },
		            { src: 'static/img/general/9.jpg' },
		            { src: 'static/img/general/10.jpg'},
		            { src: 'static/img/general/11.jpg' },
		            { src: 'static/img/general/12.jpg' }

		        ],
                transition: [ 'zoomOut']
		    });
		});
}
else {
    console.log("меньше 1000");
}



$(document).ready(function($){

/*        $('.js-fansibox.btn').click(function (event) {
       event.preventDefault();
});*/
	$(".js-fansibox").fancybox({
		"padding" : 0

	});


(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();

//  прокрутка к элементу по клику
$(function(){
			$('.js-down-section').on('click', function(e){
				$('html,body').stop().animate({ scrollTop: $(this.hash).offset().top }, 1000);
				e.preventDefault();
			});
	});

//chekbox fix
    var a = document.getElementById('ch2');
    var ff = document.getElementById('parti_label');

    var a2 = document.getElementById('ch1');
    var ff2 = document.getElementById('igra2');
    
    a.onclick = function() {
        ff.click();
    };
     a2.onclick = function() {
        ff2.click();
    }
// загрузка файла
 var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName )
			label.querySelector( 'span' ).innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
});

// разблокрировка формы в профиле и нааборот
var editprof = document.getElementById('edit-profil');
var saveform = document.getElementById('verificator-save');
		editprof.onclick = function() {
        $(".verificator__btn").show();
        $(this).hide(); 
        $(".verificator__user-field, .verificator_line-border")
        .addClass("active")
        .attr("disabled", false);
        $(".verificator__password").attr("disabled", false);
    };
    saveform.onclick = function(ret) {
    	ret.stopPropagation();
    	ret.preventDefault;
    	$(".verificator__password, .verificator__user-field").attr("disabled", true);
      $(".verificator__user-field, .verificator_line-border").removeClass("active");
      $(this).hide();
      $(".verificator__btn").hide();
      $("#edit-profil").show();
    } ; 


});
