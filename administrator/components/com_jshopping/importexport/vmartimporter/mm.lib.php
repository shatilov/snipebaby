<?php
/**
 * @package			"MM Functions Lib"
 * @description		"Various userful functions"
 * @version			1.11 [2011-09-06]
 * @compatibility	PHP 5.2/5.3
 * @author			Vova Olar vovaolar@gmail.com
 * @copyright		Copyright (C) 2011 Vova Olar - All rights reserved.
 * @license			GNU/GPL http://www.gnu.org/copyleft/gpl.html 
 */

class MMLib {
	# Parse date from format
	static function dateParseFromFormat($stFormat, $stData) {
		/*******************************************************
		 * Simple function to take in a date format and return array of associated
		 * formats for each date element
		 *
		 * @return array
		 * @param string $strFormat
		 *
		 * Example: Y/m/d g:i:s becomes
		 * Array
		 * (
		 *     [year] => Y
		 *     [month] => m
		 *     [day] => d
		 *     [hour] => g
		 *     [minute] => i
		 *     [second] => s
		 * )
		 *
		 *  This function is needed for  PHP < 5.3.0
		 ********************************************************/

		$aDataRet = array();
		$aPieces = preg_split('/[:\/.\ \-]/', $stFormat);
		$aDatePart = preg_split('/[:\/.\ \-]/', $stData);

		foreach($aPieces as $key=>$chPiece) {
			switch ($chPiece) {
				case 'd':
				case 'j':
					$aDataRet['day'] = $aDatePart[$key];

					break;
				case 'F':
				case 'M':
				case 'm':
				case 'n':
					$aDataRet['month'] = $aDatePart[$key];

					break;
				case 'o':
				case 'Y':
				case 'y':
					$aDataRet['year'] = $aDatePart[$key];
					break;

				case 'g':
				case 'G':
				case 'h':
				case 'H':
					$aDataRet['hour'] = $aDatePart[$key];

					break;
				case 'i':
					$aDataRet['minute'] = $aDatePart[$key];

					break;
				case 's':
					$aDataRet['second'] = $aDatePart[$key];

					break;
			}
		}

		return $aDataRet;
	}

	# Change date format
	static function changeDateFormat($stDate, $stFormatFrom, $stFormatTo) {
		# Changing format of empty date will produce non-empty but wrong date,
		# so returning empty as was
		if (empty($stDate))
			return $stDate;

		// When PHP 5.3.0 becomes available to me
		// $date = date_parse_from_format($stFormatFrom, $stDate);
		// For now I use the function above
		$date = self::dateParseFromFormat($stFormatFrom,$stDate);

		return date($stFormatTo, mktime($date['hour'], $date['minute'], $date['second'], $date['month'],
									  $date['day'], $date['year']));
	}

	# Change encoding
	static function changeEncoding($text, $inputEncoding, $outputEncoding) {
		if ($inputEncoding == $outputEncoding)
			return $text;

		if ($inputEncoding == 'ISO-8859-1' && $outputEncoding == 'UTF-8')
			return utf8_encode($text);

		if ($inputEncoding == 'UTF-8' && $outputEncoding == 'ISO-8859-1')
			return utf8_decode($text);

		if (function_exists('iconv'))
			return iconv($inputEncoding, $outputEncoding, $text);

		if (function_exists('mb_convert_encoding'))
			return mb_convert_encoding($text, $outputEncoding, $inputEncoding);

		return FALSE;
	}

	# If value is set - write it to variable
	static function setIfValNoEmpty(&$var, $val) {
		if ($val != '')
			$var = $val;
	}

	# If variable is not set - write value to variable
	static function setIfVarEmpty(&$var, $val) {
		if ($val == '')
			$val = $var;
	}

	# If value equals zero - empty value
	static function setEmptyIfVarZero(&$var) {
		if (round($var) == 0)
			$var = '';
	}
	
	# If value is empty set it to zero
	static function setZeroIfVarEmpty(&$var) {
		if (empty($var))
			$var = 0;
	}
	
	# Bind values to first array that are present in second (by key)
	static function arrayBind(array $array1, array &$array2, $filterEmpty = false) {
		if (function_exists('array_replace') && !$filterEmpty)
			return array_replace($array1, $array2);

		if (!is_array($array1) || !is_array($array2)) {
			trigger_error(__FUNCTION__ . '(): Argument #' . ($i+1) . ' is not an array', E_USER_WARNING);
			
			return NULL;
		}
		else {
			foreach ($array1 as $key => &$val)
				if (isset($array2[$key])) {
					if ($filterEmpty && empty($array2[$key])) continue;
		
					$array1[$key] = $array2[$key];
				}

			return $array1;
		}
	}
	
	# Makes filename use only alphabetical, numeric ASCII characters, '.' and '_'.
	# German special symbols replace with similar characters
	static function ASCIIFilename($name) {
		$filters = array();
		$filters["ü"] = "u";
		$filters["ä"] = "a";
		$filters["ö"] = "o";
		$filters["Ü"] = "U";
		$filters["Ä"] = "A";
		$filters["Ö"] = "O";
		$filters["ß"] = "ss";

		foreach($filters as $k=>$v)
			$name = str_replace($k, $v, $name);

		$name = preg_replace("/[^a-zA-Z0-9\.]/i", "_" , $name);

		return $name;
	}
	
	# Parse file name and returns different parts of it
	static function parseFileName($fullFileName) {
		# Returns an stdClass object with a following properties:
		#	path		- absolute path to file
		#	basename	- file name with extension
		#	name		- name without extension
		#	extension	- file extension

		$pathinfo = pathinfo($fullFileName);
		
		if ($pathinfo['extension'] != "")
			$name = substr($pathinfo['basename'],
						   0,
						   strlen($pathinfo['basename']) - strlen($pathinfo['extension']) - 1);
		else
			$name = $pathinfo['basename'];
		
		$fileNameParts = new stdClass();
		$fileNameParts->path = $pathinfo['dirname'];
		$fileNameParts->basename = $pathinfo['basename'];
		$fileNameParts->name = $name;
		$fileNameParts->extension = $pathinfo['extension'];
		
			
		return $fileNameParts;
	}
	
	# Get first available filename (without path) if file with given filename already exists
	static function getAvailableFileName($fullFileName, $separator = '-') {
		# input: path + filename
		# output: filename
		
		$parsedWantedName = self::parseFileName($fullFileName);

		$firstAvailableName = $parsedWantedName->name;
		$i = 1;

		while (is_file($parsedWantedName->path.DS.$firstAvailableName.'.'.$parsedWantedName->extension)) {
			$firstAvailableName = $parsedWantedName->name.$separator.$i;
			$i++;
		}
		
		return $firstAvailableName.'.'.$parsedWantedName->extension;
	}
	
	# Remove non-empty dir
	static function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
		
			foreach ($objects as $object)
				if ($object != "." && $object != "..")
					if (filetype($dir."/".$object) == "dir")
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object);

			reset($objects);
			rmdir($dir);
		}
	}
	
	# Delete all files in a folder
	static function cleanDir($dirpath, $whitelist = array()) {
		if(!$dirhandle = opendir($dirpath))
			return;

		while (false !== ($filename = readdir($dirhandle))) 
			if( $filename != "." && $filename != ".." && !in_array($filename, $whitelist)) {
				$filename = $dirpath. "/". $filename;

				unlink($filename);
			}
	}
}

?>
