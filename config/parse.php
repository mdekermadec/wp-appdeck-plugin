<?php

	function getConfigDoc()
	{
		$datas = array();

		$item = false;
		$section = false;

		$h = @fopen( dirname( dirname( __FILE__ ) ) . '/config/files/doc.txt', 'r');
		if ($h == false)
			die("failed to open doc.txt");

		while (($buffer = fgets($h, 4096)) !== false)
		{
			$buffer = str_replace("\n", "", $buffer);

			if (trim($buffer) == '')
			{
				continue;
			}

			// new section ?
			if (strpos($buffer, "\t") !== 0)
			{
				$info = explode("\t", $buffer);
				$section = $info[0];
				$datas[$section]['helper'] = (isset($info[1]) ? $info[1] : null);
				$datas[$section]['class'] = (isset($info[2]) ? $info[2] : false);
				continue;
			}

			// new item ?
			if (strpos($buffer, "\t\t") === false)
			{
				$info = explode("\t", $buffer);

				$item = new stdClass();
				$item->name = (isset($info[1]) ? $info[1] : null);
				$item->type = (isset($info[2]) ? $info[2] : null);
				$item->default = (isset($info[3]) ? $info[3] : null);
				$item->title = (isset($info[4]) ? $info[4] : trim(ucwords(str_replace('_', ' ', $item->name))));
				$item->value = null;
				$item->class = (isset($info[5])? $info[5] : '');;

				if (strpos($item->type, "select:") === 0)
					parse_str(substr($item->type, 7), $item->info);

				if (strpos($item->type, "gradient") === 0)
				{
					$item->default = explode(',', $item->default);
					if (!isset($item->default[1]))
						$item->default[1] = $item->default[0];
				//	$item->default = array($item->default);
				}

				if (strpos($item->name, "screens[].") === 0)
					$datas[$section]['screens']['options'] [$item->name]= $item;
				else
					$datas[$section]['item'] [$item->name]= $item;

				continue;
			}

			if (strpos($buffer, "\t\t") === 0)
			{
				$item->helper = trim($buffer);

				continue;
			}

		}

		if (!feof($h))
			die("failed to get line");

		fclose($h);

		return $datas;
	}

	function getAppConfigDoc()
	{
		/*
		$key = "doc.txt";
		$datas = apc_fetch($key, $success);
		if ($success == false || true)
		{
			$datas = $this->getConfigDoc();
			apc_store($key, $datas);
		}*/
		$datas = getConfigDoc();

		// patch value
		//$datas['Application']['item']['api_key']->value = $this->getApiKey();
		$datas['Application']['item']['api_key']->type = 'static';

		$datas['Application']['item']['version']->type = 'static';
		$datas['Application']['item']['version']->value = 1;

		return $datas;
	}

