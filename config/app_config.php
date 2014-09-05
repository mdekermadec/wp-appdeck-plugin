<?php
include( dirname( dirname( __FILE__ ) ) . '/config/parse.php' );

global $datas;

// TODO: Get App JSON From AppDeck Cloud Services
//$file = dirname( dirname( __FILE__ ) ) . '/config/files/app.json';

$url = 'http://api.appdeck.mobi/config?key='.urlencode($this->appdeck_credentials['api_key']).'&secret='.urlencode($this->appdeck_credentials['api_secret']);

$result = wp_remote_get( $url );

if ($result['response']['code'] != 200)
{
	$datas = false;
	return;
}

$json = $result['body'];


//echo 'file: ' . $file . '<br/>'; 	//Debug
//$json = file_get_contents( $file );
$json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);

//echo 'json: ' . $json . '<br/>';	//Debug

$config = json_decode($json, true);
if( NULL === $config ) {
	echo 'json decode error: ' . json_last_error() . '<br/>';
	switch (json_last_error()) {
		case JSON_ERROR_NONE:
			echo ' - Aucune erreur';
			break;
		case JSON_ERROR_DEPTH:
			echo ' - Profondeur maximale atteinte';
			break;
		case JSON_ERROR_STATE_MISMATCH:
			echo ' - Inadéquation des modes ou underflow';
			break;
		case JSON_ERROR_CTRL_CHAR:
			echo ' - Erreur lors du contrôle des caractères';
			break;
		case JSON_ERROR_SYNTAX:
			echo ' - Erreur de syntaxe ; JSON malformé';
			break;
		case JSON_ERROR_UTF8:
			echo ' - Caractères UTF-8 malformés, probablement une erreur d\'encodage';
			break;
		default:
			echo ' - Erreur inconnue';
			break;
	}
	echo '<br/>';
	wp_die();
}

$config = $config['value']['config'];
//var_dump( $config );				//Debug


$datas = getAppConfigDoc();
//echo '<pre>';							//Debug
//var_dump( $datas );					//Debug
//echo '</pre>';						//Debug

// update config
if (count($_POST))
{
	unset($_POST['action']);
	$screens = array();
	foreach ($datas as $section_name => $section_info)
		foreach ($section_info['item'] as $item_name => $item)
		{
			if ($item->type == 'static')
				continue;
			// screen case
			if ($item->type == 'screen[]')
			{
				if (!isset($_POST['screen']))
					continue;
				if (!is_array($_POST['screen']))
					die('screen not an array');
				foreach ($_POST['screen'] as $screen)
				{
					$new_screen = array();
					if (isset($screen['title']) && $screen['title'] != '')
						$new_screen['title'] = $screen['title'];
					if (isset($screen['logo']) && $screen['logo'] != '')
						$new_screen['logo'] = $screen['logo'];					
					if (isset($screen['urls']) && $screen['urls'] != '')
					{
						$new_screen['urls'] = explode("\n", $screen['urls']);
						array_walk($new_screen['urls'], 'trim_value');
					}
					if (isset($screen['type']) && $screen['type'] != '')
						$new_screen['type'] = $screen['type'];
					if (isset($screen['ttl']) && $screen['ttl'] != '')
						$new_screen['ttl'] = $screen['ttl'];
					if (isset($screen['popup']) && $screen['popup'] != '')
						$new_screen['popup'] = $screen['popup'];
					$screens []= $new_screen;
				}

			}
			// array case
			elseif (preg_match('/([a-zA-Z0-9_]+)\\[([a-zA-Z0-9_]+)\\]/', $item_name, $m))
			{
				if (!isset($_POST[$m[1]][$m[2]]))
					die("{$m[1]} / {$m[2]} not found !");
				$value = $_POST[$m[1]][$m[2]];
				if ($value == "")
					unset($config[$m[1]][$m[2]]);
				else
					$config[$m[1]][$m[2]] = $value;
				if (isset($config[$m[1]]) && count($config[$m[1]]) == 0)
					unset($config[$m[1]]);
			}
			else // default case
			{
				if (!isset($_POST[$item_name]))
					die("{$item_name} not found !");
				$value = $_POST[$item_name];
				if ($value != "" && $item->type == 'text[]')
				{
					$value = array_map('trim', explode("\n", $value));
				}
				if (is_array($value))
				{
					$new_value = array();
					foreach ($value as $k => $v)
						if ($v != '')
							$new_value[$k] = $v;
					if (count($new_value) == 0)
						$new_value = '';
					$value = $new_value;
				}
				if ($value == "")
					unset($config[$item_name]);
				else
					$config[$item_name] = $value;
			}
		}
	$config['version'] = (isset($config['version']) ? ceil($config['version']) + 1 : time());
	$config['screens'] = $screens;
	/*$config['api_key'] = $app->getApiKey();
	$app->title = (isset($config['title']) ? $config['title'] : 'My App'.$app->id);
	$app->json = json_encode($config);
	$app->save();

	print $app->json;*/

	// TODO: Save json to AppDeck Cloud Services
	$url .= '&json='.urlencode(json_encode($config));

	print $url;

	$result = wp_remote_get( $url );

	var_dump($result);

	if ($result['response']['code'] != 200)
	{
		print json_encode(false);
		return;
	}


	print $result['body'];
	exit;
}

function trim_value(&$value)
{
    $value = trim($value);
}

function merge_conf($name, $value)
{
	global $datas;

	foreach ($datas as $section_name => $section_info)
		foreach ($section_info['item'] as $item_name => $item)
		{
			if (preg_match('/([a-zA-Z0-9_]+)\\[([a-zA-Z0-9_]+)\\]/', $item_name, $m))
				if ($m[1] == $name)
				{
					foreach ($value as $k => $v)
					{
						if ($k == $m[2])
						{
							$datas[$section_name]['item'][$item_name]->value = $v;
							return;
						}
					}
				}

			if ($item_name == $name)
			{
				// handle gradient
				if ($item->type == 'gradient')
				{
					if (!is_array($value))
						$value = array($value, null);
					if (count($value) == 1)
						$value[1] = '';
				}

				// set default value for screen if needed
				elseif ($item->type == 'screen[]')
					foreach ($value as &$screen)
					{
						foreach (array('title' => '', 'urls' => '', 'type' => 'default', 'ttl'  => '600', 'popup'  => '0') as $k => $v)
							if (!isset($screen[$k]))
								$screen[$k] = $v;
					}

				$datas[$section_name]['item'][$item_name]->value = $value;
				return;
			}
		}
}

foreach ($config as $k => $v)
{
	merge_conf($k, $v);
}

//$smarty->assign('datas', $datas);

//$smarty->display('app_config.tpl');


