/** WP Appdeck Plugin back-end jQuery script v.0.1 **/

(function($){
	
	$( document ).ready(function() {
		
		//console.log( 'Appdeck back-end js ready.' );	//Debug
		
		/** Theme preview drop-down **/
		$('select#theme').change( function(e){
			//console.log( 'Theme selector changed.' );	//Debug
			var theme_img = themes[$(this).val()]['theme_url']+'/screenshot.png';
			//console.log( theme_img );					//Debug
			$('.appdeck_theme_preview img').attr('src',theme_img);
			//$('.appdeck_theme_preview img').fadeOut(200, function(){
				//$('img',this).attr('src',theme_img).bind('onreadystatechange load', function(){
					//if (this.complete) $(this).fadeIn(400);
				//});
			//});
		});
		
	});
	
})( jQuery );