(function($){

	function jQuerySelectorEscape(expression) {
	  return expression.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, '\\$&');
	}

	// http://css-tricks.com/snippets/jquery/smooth-scrolling/
	$(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      console.log(this.hash.slice(1));
	      target = target.length ? target : $('[name=' + jQuerySelectorEscape(this.hash.slice(1)) +']');
	      console.log(target);      
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top - 50
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
	
	$(document).ready(function() {
	        $('#nav-config a').click(function() {
	          $('#nav-config li').removeClass("active");
	          if ($(this).attr('href') == '#')
	          {
	            $('html,body').animate({
	          scrollTop: 0 }, 1000);
	            return true;
	          }
	          $(this).parent().addClass("active");
	          return true;
	        });
	});

	function resolveURL(url, base_url)
	{
	  var doc = document
	  , old_base = doc.getElementsByTagName('base')[0]
	  , old_href = old_base && old_base.href
	  , doc_head = doc.head || doc.getElementsByTagName('head')[0]
	  , our_base = old_base || doc_head.appendChild(doc.createElement('base'))
	  , resolver = doc.createElement('a')
	  , resolved_url
	  ;
	  our_base.href = base_url;
	  resolver.href = url;
	  resolved_url = resolver.href; // browser magic at work here
	   
	  if (old_base) old_base.href = old_href;
	  else doc_head.removeChild(our_base);
	   
	  return resolved_url;
	}

	function show_preview(el, animate)
	{
	  var src = $(el).val();
	  if (src == "")
	    src = $(el).attr('placeholder');
	  var base_url = $('#base_url').val();
	  var absolute_url = resolveURL(src, base_url);
	  var img = $(el).parent().parent().find('.img-thumbnail');
	  /*if (animate)
	    img.fadeOut('slow', function() { img.attr('src', absolute_url); img.fadeIn('slow')});
	  else*/
	    img.attr('src', absolute_url);
	}	

	function save_config(origin)
	{
		/*
	  console.log(origin);
	    var l = Ladda.create(origin);
	    if (l.isLoading())
	      return;
	    l.start();
	    */  
	  //console.log('save');
	  //console.log($('#config-form').serialize());
	  /*var datas = new Array();;
	  $('#config-form :input').each(function( index, input ) {
	    //console.log(input);
	    //console.log( $(input).attr('name') + ": " + $(input).val() );
	    datas[$(input).attr('name')] = $(input).val();
	  });
	  console.log(datas);*/
	  $.ajax({
	    url: $('#config-form').attr('action'),
	    type: $('#config-form').attr('method'),
	    data: $('#config-form').serialize(),
	    success:  function(html) {
	                console.log(html);
	                //l.stop();
	              }
	  });  
	}

	$(document).ready(function() {
	
	  $('#action-save').click(function() {
	    save_config(this);
	  });
	
	  $('#config-form :input').on('change', function() {
	    if ($('#auto-save input').prop('checked'))
	      $('#action-save').click();
	  });
	
	  $('.colorpicker-component').colorpicker({ /*options...*/ });
	
	  $('.image-picker').each(function(index, el) {
	    show_preview(el, false);
	  });
	
	  $('.image-picker').on('change', function() {
	    show_preview(this, true);
	  });
	
	  //save_config();
	
	/*  $('#username').editable({
	    type: 'text',
	    pk: 1,
	    url: function(params) {
	      console.log(params);
	    },
	    title: 'Enter username'
	  });*/
	
	  $('.add-new-screen').click(function() {
	    var new_screen = $('#new-screen-template').clone().html();
	    new_screen = new_screen.replaceAll('__ID__', $('.screens .panel').length);
	    new_screen = $(new_screen);
	    new_screen.hide();
	    $('.screens').append(new_screen);
	    new_screen.slideDown();
	    return false;
	  });
	
	  $('.delete-screen').click(function() {
	    console.log('delete');
	    $(this).parent().parent().slideUp('default', function(){
	      $(this).remove();
	    });
	    return false;
	  });
	
	});

})( jQuery );
