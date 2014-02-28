<div style="height: 49px; width: 100%;">
  <div id="nav-config" data-spy="affix" data-offset-top="222">
    <div class="no-pull-right">
      
    </div>
    <ul class="nav nav-pills ">
		<li><a href="#"><i class="fa fa-home"></i></a></li>
    	<?php
    		//foreach from=$datas key=section item=section_info}
    		foreach( $datas as $section => $section_info ) : ?>
      			<?php if( $section_info['class'] != 'advanced' ) : ?>
      			<li><a href="#<?php echo htmlspecialchars( $section ); ?>"><?php echo htmlspecialchars( $section ); ?></a></li>
      			<?php endif; ?>
    	<?php endforeach; ?>
      <li class="pull-right"><button class="btn btn-success btn-s ladda-button" data-style="slide-left" id="action-save">
        <span class="ladda-label">Save</span>
      </button></li>    
    </ul>
  </div>
</div>
<div style="clear:both;height:300px;">&nbsp;</div>

<script>
function jQuerySelectorEscape(expression) {
  return expression.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, '\\$&');
}

(function($){

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

})( jQuery );
</script>

<p>&nbsp;</p>

<div class="panel panel-default">
   <div class="panel-heading">Options</div>
  <div class="panel-body">
    Auto save modification
      <div class="make-switch switch-small" data-text-label="Auto" id="auto-save">
        <input name="autosave" type="checkbox" >
      </div>
  </div>
</div>

<form class="form-horizontal" role="form" id="config-form" action="<?php echo plugins_url( 'config/app_config.php', dirname( __FILE__ ) ); ?>" method="POST">

<?php //{foreach from=$datas key=section item=section_info}
	foreach( $datas as $section => $section_info ) : ?>

	<?php if( isset( $section_info['class'] ) ) : ?><div class="<?php echo $section_info['class']; ?>"><?php endif; ?>

	<a id="<?php echo htmlspecialchars( $section ); ?>" name="<?php echo htmlspecialchars( $section ); ?>"></a><h2><?php echo htmlspecialchars( $section ); ?></h2>

	<?php if( isset( $section_info['helper'] ) ) : ?><p><?php echo $section_info['helper']; ?></p><?php endif; ?>
            
	<?php foreach( $section_info['item'] as $item_name => $item ) : //debug echo $item->type . '<br/>'; ?>

    <div class="config-item <?php echo $item->class; ?>">

            <?php if( strpos($item->type, "select:") === 0 ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-sm-2">
                <select class="form-control" id="<?php echo $item->name; ?>" name="<?php echo $item_name; ?>" >
                  <?php foreach( $item->info as $k=>$v ) : ?>
                  	<option value="<?php echo $k; ?>" <?php if( $k == $item->value ) echo 'selected="selected"'; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'text[]' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-sm-10">
                <textarea id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" class="form-control" rows="<?php echo count($item->value); ?>"><?php 
                	if( is_array($item->value) ) implode( "\n", $item->value ); ?></textarea>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset( $item->helper ) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'static' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-sm-10">
                <p class="form-control-static"><?php echo $item->value; ?></p>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'color' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div data-color-format="hex" data-color="<?php echo $item->value?$item->value:$item->default; ?>" class="col-sm-2 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value?$item->value:$item->default; ?>;"></i></span>
              </div>              
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'gradient' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div data-color-format="hex" data-color="<?php echo $item->value[0]?$item->value[0]:$item->default[0]; ?>" class="col-sm-2 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default[0]; ?>" name="<?php echo $item_name[0]; ?>" value="<?php echo $item->value[0]; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value[0]?$item->value[0]:$item->default[0]; ?>;"></i></span>
              </div>
              <div data-color-format="hex" data-color="<?php echo $item->value[1]?$item->value[1]:$item->default[1]; ?>" class="col-sm-2 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default[1]; ?>" name="<?php echo $item_name[1]; ?>" value="<?php echo $item->value[1]; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value[1]?$item->value[1]:$item->default[1]; ?>;"></i></span>
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'icon' || $item->type == 'image' || $item->type == 'logo' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-sm-8 input-group" >
                <input type="text" class="form-control image-picker" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-sm-2 pull-right" >
                <img old-src="<?php echo $item->value?$item->value:$item->default; ?>" style="max-height: 64px; min-height: 64px; min-width: 64px; background-image: url(<?php echo plugins_url( 'img/transparent_graphic.png', dirname( __FILE__ ) ); ?>);" class="img-thumbnail" />
              </div>
              <div class="col-sm-8 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>              
            </div>

            <?php elseif( $item->type == 'screen[]' ) : ?>
				<div class="col-sm-2">
				  <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
				</div>
				
				<div class="col-sm-10 screens">
				
				  <?php if( $item->value !== NULL ) foreach( $item->value as $index=>$screen ) : ?>
				  <div class="panel panel-default">
				
				    <div class="panel-heading">
				      <a href="#" class="delete-screen"><i class="fa fa-times pull-right"></i></a>
				      <h3 class="panel-title">screen</h3>
				    </div>
				
				    <div class="panel-body">
				        <div class="form-group">
				          <label for="screen_title_<?php echo $index; ?>" class="col-sm-2 control-label">Title</label>
				          <div class="col-sm-8">
				            <input type="text" class="form-control" id="screen_title_<?php echo $index; ?>" name="<?php echo $screen['title']; ?>" placeholder="Title" value="<?php echo htmlspecialchars($screen['title']); ?>" />
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_logo_<?php echo $index; ?>" class="col-sm-2 control-label">Logo</label>
				          <div class="col-sm-8">
				            <input type="text" class="form-control" id="screen_logo_<?php echo $index; ?>" name="<?php echo $screen['logo']; ?>" placeholder="Logo" value="<?php echo htmlspecialchars($screen['logo']); ?>" />
				          </div>
				        </div>        
				        <div class="form-group">
				          <label for="screen_urls_<?php echo $index; ?>" class="col-sm-2 control-label">URLs</label>
				          <div class="col-sm-8">
				            <textarea id="screen_urls_<?php echo $index; ?>" name="<?php echo $screen['urls'] ?>" placeholder="Urls" class="form-control" rows="<?php echo count($item->value); ?>"><?php echo implode("\n", $screen['urls']); ?></textarea>
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_type_<?php echo $index; ?>" class="col-sm-2 control-label">Type</label>
				          <div class="col-sm-8">
				            <select class="form-control" id="screen_type_<?php echo $index; ?>" name="<?php echo $screen[type]; ?>">
				              <?php foreach( array('default', 'browser') as $v ) : ?>
				              <option value="<?php echo $v ?>" <?php if( $v == $screen['type'] ) echo 'selected="selected"'; ?>><?php echo $v; ?></option>
				              <?php endforeach; ?>
				            </select>            
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_ttl_<?php echo $index; ?>" class="col-sm-2 control-label">TTL</label>
				          <div class="col-sm-8">
				            <input type="number" class="form-control" id="screen_ttl_<?php echo $index; ?>" name="<?php echo $screen['ttl']; ?>" placeholder="TTL" value="<?php echo htmlspecialchars($screen['ttl']); ?>" />
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_popup_<?php echo $index; ?>" class="col-sm-2 control-label">Popup</label>
				          <div class="col-sm-8">
				            <select class="form-control" id="screen_popup_<?php echo $index; ?>" name="<?php echo $screen['popup']; ?>">
				              <?php foreach( array('no', 'yes') as $k=>$v ) : ?>
				              <option value="<?php echo $k; ?>" <?php if( $k == $screen['type'] ) echo 'selected="selected"'; ?>><?php echo $v; ?></option>
				              <?php endforeach; ?>
				            </select>
				          </div>
				        </div>
				    </div>
				  </div>
				  <?php endforeach; ?>
				</div>  
				<div class="col-sm-10 col-sm-offset-2">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <a href="#" class="add-new-screen"><i class="fa fa-plus-square pull-right"></i></a>
				      <h3 class="panel-title">New Screen</h3>
				    </div>
				  </div>
				  <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
				</div>

            <?php elseif( in_array($item->type, array('text', 'password', 'datetime', 'datetime-local', 'date', 'month', 'time', 'week', 'number', 'email', 'url', 'search', 'tel', 'color')) ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-sm-10">
                <input type="<?php echo $item->type; ?>" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php else : ?>

            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-sm-2 control-label"><?php echo $item->title; ?>*</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-sm-10 col-sm-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php endif; ?>
    </div>

	<?php endforeach; ?>

  <?php if( isset( $section_info['class'] ) ) : ?></div><?php endif; ?>

<?php endforeach; ?>

</form>

<!--<a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username">superuser</a>-->

<script>

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

(function($){
	

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
</script>


  <div id="new-screen-template" style="display:none;">
  <div class="panel panel-default">

    <div class="panel-heading">
      <a href="#" class="close-password-reset"><i class="fa fa-times pull-right"></i></a>
      <h3 class="panel-title">screen</h3>
    </div>

    <div class="panel-body">
        <div class="form-group">
          <label for="screen_title___ID__" class="col-sm-2 control-label">Title</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="screen_title___ID__" name="screen[__ID__][title]" placeholder="Title" value="" />
          </div>
        </div>
        <div class="form-group">
          <label for="screen_logo___ID__" class="col-sm-2 control-label">Logo</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="screen_logo___ID__" name="screen[__ID__][logo]" placeholder="Logo" value="" />
          </div>
        </div>        
        <div class="form-group">
          <label for="screen_urls___ID__" class="col-sm-2 control-label">URLs</label>
          <div class="col-sm-8">
            <textarea id="screen_urls___ID__" name="screen[__ID__][urls]" placeholder="Urls" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="screen_type___ID__" class="col-sm-2 control-label">Type</label>
          <div class="col-sm-8">
            <select class="form-control" id="screen_type___ID__" name="screen[__ID__][type]">
              <?php foreach( array('default', 'browser') as $v ) : ?>
              <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="screen_ttl___ID__" class="col-sm-2 control-label">TTL</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="screen_ttl___ID__" name="screen[__ID__][ttl]" placeholder="TTL" value="" />
          </div>
        </div>
        <div class="form-group">
          <label for="screen_popup___ID__" class="col-sm-2 control-label">Popup</label>
          <div class="col-sm-8">
            <select class="form-control" id="screen_popup___ID__" name="screen[__ID__][popup]">
              <?php foreach( array('no', 'yes') as $k=>$v ) : ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
    </div>
  </div>
  </div>