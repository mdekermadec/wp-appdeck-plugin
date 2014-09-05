<?php if ($datas == false): ?>
<div class="alert alert-danger" role="alert">Failed to connect to AppDeck Cloud Services, Please check your configuration.</div>
<?php else: ?>


<div style="height: 49px; width: 100%;">
  <div id="nav-config" data-spy="affix" data-offset-top="122">
    <div class="no-pull-right">
      
    </div>
    <ul class="nav nav-pills ">
		<li><a href="#"><i class="fa fa-home"></i></a></li>
    	<?php
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
<div style="clear:both;height:10px;">&nbsp;</div>

<style>
#config-form
{
  margin: 10px;
}
</style>

<!--<p>&nbsp;</p>

<div class="row">
  <div class="col-xs-3">
    <div class="panel panel-default">
       <div class="panel-heading">Options</div>
      <div class="panel-body">
        Auto save modification
          <div class="make-switch switch-small" data-text-label="Auto" id="auto-save">
            <input name="autosave" type="checkbox" >
          </div>
      </div>
    </div>
  </div>
</div>-->

<form class="form-horizontal" role="form" id="config-form" action="/wp-admin/admin-ajax.php" method="POST">

<input type="hidden" name="action" value="appdeckconfig" />

<?php //{foreach from=$datas key=section item=section_info}
	foreach( $datas as $section => $section_info ) : ?>

	<?php if( isset( $section_info['class'] ) ) : ?><div class="<?php echo $section_info['class']; ?>"><?php endif; ?>

	<a id="<?php echo htmlspecialchars( $section ); ?>" name="<?php echo htmlspecialchars( $section ); ?>"></a><h2><?php echo htmlspecialchars( $section ); ?></h2>

	<?php if( isset( $section_info['helper'] ) ) : ?><p><?php echo $section_info['helper']; ?></p><?php endif; ?>
            
	<?php foreach( $section_info['item'] as $item_name => $item ) : //debug echo $item->type . '<br/>'; ?>

    <div class="config-item <?php echo $item->class; ?>">

            <?php if( strpos($item->type, "select:") === 0 ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div class="col-xs-2 col-xs-offset-1">
                <select class="form-control" id="<?php echo $item->name; ?>" name="<?php echo $item_name; ?>" >
                  <?php foreach( $item->info as $k=>$v ) : ?>
                  	<option value="<?php echo $k; ?>" <?php if( $k == $item->value ) echo 'selected="selected"'; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'text[]' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div class="col-xs-7 col-xs-offset-1">
                <textarea id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" class="form-control" rows="<?php echo count($item->value); ?>"><?php 
                	if( is_array($item->value) ) implode( "\n", $item->value ); ?></textarea>
              </div>
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset( $item->helper ) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'static' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-2 control-label"><?php echo $item->title; ?></label>
              <div class="col-xs-10">
                <p class="form-control-static"><?php echo $item->value; ?></p>
              </div>
              <div class="col-xs-10 col-xs-offset-2">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'color' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div data-color-format="hex" data-color="<?php echo $item->value?$item->value:$item->default; ?>" class="col-xs-2 col-xs-offset-3 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value?$item->value:$item->default; ?>;"></i></span>
              </div>              
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'gradient' ) : ?>

            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div data-color-format="hex" data-color="<?php echo $item->value[0]?$item->value[0]:$item->default[0]; ?>" class="col-xs-2 col-xs-offset-3 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default[0]; ?>" name="<?php echo $item_name ?>[0]" value="<?php echo $item->value[0]; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value[0]?$item->value[0]:$item->default[0]; ?>;"></i></span>
              </div>
              <div data-color-format="hex" data-color="<?php echo $item->value[1]?$item->value[1]:$item->default[1]; ?>" class="col-xs-2 col-xs-offset-3 input-group colorpicker-component bscp colorpicker-element" >
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default[1]; ?>" name="<?php echo $item_name ?>[1]" value="<?php echo $item->value[1]; ?>">
                <span class="input-group-addon"><i style="border: 1px solid black; background-color: <?php echo $item->value[1]?$item->value[1]:$item->default[1]; ?>;"></i></span>
              </div>
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'icon' || $item->type == 'image' || $item->type == 'logo' ) : ?>
            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div class="col-xs-7 col-xs-offset-1">
                <input type="text" class="form-control image-picker" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-xs-2 pull-right" >
                <img old-src="<?php echo $item->value?$item->value:$item->default; ?>" style="max-height: 64px; min-height: 64px; min-width: 64px; background-image: url(<?php echo plugins_url( 'img/transparent_graphic.png', dirname( __FILE__ ) ); ?>);" class="img-thumbnail" />
              </div>              
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php elseif( $item->type == 'screen[]' ) : ?>
            <div class="form-group">

				<div class="col-xs-1 col-xs-offset-1">
				  <label for="<?php echo $item->name; ?>" class="col-xs-2 control-label"><?php echo $item->title; ?></label>
				</div>
				
				<div class="col-xs-5 col-xs-offset-1 screens">
				
				  <?php if( $item->value !== NULL ) foreach( $item->value as $index=>$screen ) : ?>
				  <div class="panel panel-default">
				
				    <div class="panel-heading">
				      <a href="#" class="delete-screen"><i class="fa fa-times pull-right"></i></a>
				      <h3 class="panel-title">screen</h3>
				    </div>
				
				    <div class="panel-body">
				        <div class="form-group">
				          <label for="screen_title_<?php echo $index; ?>" class="col-xs-2 control-label">Title</label>
				          <div class="col-xs-8">
				            <input type="text" class="form-control" id="screen_title_<?php echo $index; ?>" name="<?php echo $screen['title']; ?>" placeholder="Title" value="<?php echo htmlspecialchars($screen['title']); ?>" />
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_logo_<?php echo $index; ?>" class="col-xs-2 control-label">Logo</label>
				          <div class="col-xs-8">
				            <input type="text" class="form-control" id="screen_logo_<?php echo $index; ?>" name="<?php echo $screen['logo']; ?>" placeholder="Logo" value="<?php echo htmlspecialchars($screen['logo']); ?>" />
				          </div>
				        </div>        
				        <div class="form-group">
				          <label for="screen_urls_<?php echo $index; ?>" class="col-xs-2 control-label">URLs</label>
				          <div class="col-xs-8">
				            <textarea id="screen_urls_<?php echo $index; ?>" name="<?php echo $screen['urls'] ?>" placeholder="Urls" class="form-control" rows="<?php echo count($item->value); ?>"><?php echo implode("\n", $screen['urls']); ?></textarea>
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_type_<?php echo $index; ?>" class="col-xs-2 control-label">Type</label>
				          <div class="col-xs-8">
				            <select class="form-control" id="screen_type_<?php echo $index; ?>" name="<?php echo $screen[type]; ?>">
				              <?php foreach( array('default', 'browser') as $v ) : ?>
				              <option value="<?php echo $v ?>" <?php if( $v == $screen['type'] ) echo 'selected="selected"'; ?>><?php echo $v; ?></option>
				              <?php endforeach; ?>
				            </select>            
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_ttl_<?php echo $index; ?>" class="col-xs-2 control-label">TTL</label>
				          <div class="col-xs-8">
				            <input type="number" class="form-control" id="screen_ttl_<?php echo $index; ?>" name="<?php echo $screen['ttl']; ?>" placeholder="TTL" value="<?php echo htmlspecialchars($screen['ttl']); ?>" />
				          </div>
				        </div>
				        <div class="form-group">
				          <label for="screen_popup_<?php echo $index; ?>" class="col-xs-2 control-label">Popup</label>
				          <div class="col-xs-8">
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
				<div class="col-xs-5 col-xs-offset-3">
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
              <label for="<?php echo $item->name; ?>" class="col-xs-1 col-xs-offset-1 control-label"><?php echo $item->title; ?></label>
              <div class="col-xs-7 col-xs-offset-1">
                <input type="<?php echo $item->type; ?>" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            <?php else : ?>

            <div class="form-group">
              <label for="<?php echo $item->name; ?>" class="col-xs-2 control-label"><?php echo $item->title; ?>*</label>
              <div class="col-xs-10">
                <input type="text" class="form-control" id="<?php echo $item->name; ?>" placeholder="<?php echo $item->default; ?>" name="<?php echo $item_name; ?>" value="<?php echo $item->value; ?>">
              </div>
              <div class="col-xs-7 col-xs-offset-3">
                <?php if( isset($item->helper) ) : ?><p class="help-block"><?php echo $item->helper; ?></p><?php endif; ?>
              </div>
            </div>

            </div>

            <?php endif; ?>
    </div>

	<?php endforeach; ?>

  <?php if( isset( $section_info['class'] ) ) : ?></div><?php endif; ?>

<?php endforeach; ?>

</form>

  <div id="new-screen-template" style="display:none;">
  <div class="panel panel-default">

    <div class="panel-heading">
      <a href="#" class="close-password-reset"><i class="fa fa-times pull-right"></i></a>
      <h3 class="panel-title">screen</h3>
    </div>

    <div class="panel-body">
        <div class="form-group">
          <label for="screen_title___ID__" class="col-xs-2 control-label">Title</label>
          <div class="col-xs-8">
            <input type="text" class="form-control" id="screen_title___ID__" name="screen[__ID__][title]" placeholder="Title" value="" />
          </div>
        </div>
        <div class="form-group">
          <label for="screen_logo___ID__" class="col-xs-2 control-label">Logo</label>
          <div class="col-xs-8">
            <input type="text" class="form-control" id="screen_logo___ID__" name="screen[__ID__][logo]" placeholder="Logo" value="" />
          </div>
        </div>        
        <div class="form-group">
          <label for="screen_urls___ID__" class="col-xs-2 control-label">URLs</label>
          <div class="col-xs-8">
            <textarea id="screen_urls___ID__" name="screen[__ID__][urls]" placeholder="Urls" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="screen_type___ID__" class="col-xs-2 control-label">Type</label>
          <div class="col-xs-8">
            <select class="form-control" id="screen_type___ID__" name="screen[__ID__][type]">
              <?php foreach( array('default', 'browser') as $v ) : ?>
              <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="screen_ttl___ID__" class="col-xs-2 control-label">TTL</label>
          <div class="col-xs-8">
            <input type="number" class="form-control" id="screen_ttl___ID__" name="screen[__ID__][ttl]" placeholder="TTL" value="" />
          </div>
        </div>
        <div class="form-group">
          <label for="screen_popup___ID__" class="col-xs-2 control-label">Popup</label>
          <div class="col-xs-8">
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

  <?php endif; ?>