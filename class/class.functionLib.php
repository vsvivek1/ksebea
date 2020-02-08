<?php
/**
 *@version		1.0
 *@name			class.functionLib.php
 *@abstract		FunctionLibrary Class
 *@author		maheep vm
 *@since		15-06-2017
 **/

class FunctionLibrary
{
	static public function getFormattedInputPostString($unformattedInputPostName) //unformattedInputPostName = 'any_name in '$_POST['any_name'] from <input> tag
	{
		$inputValue = '';
		$inputValue = trim(filter_input(INPUT_POST, $unformattedInputPostName , FILTER_SANITIZE_STRING));
		
		if(get_magic_quotes_gpc())
		{
			$inputValue = stripslashes($inputValue);
		}
		
//		$inputValue = mysql_real_escape_string($inputValue);
		$inputValue = strip_tags(pg_escape_string($inputValue));
		
		return $inputValue;		
	}	

	static public function getFormattedString($unformattedString) // unformattedString = $_POST['any_name']
	{
		$inputValue = '';
		$inputValue = trim(filter_var($unformattedString , FILTER_SANITIZE_STRING));
		if(get_magic_quotes_gpc())
		{
			$inputValue = stripslashes($inputValue);
		}
//		$inputValue = mysql_real_escape_string($inputValue);
		$inputValue = strip_tags(pg_escape_string($inputValue));
		
		return $inputValue;		
	}	

	static public function getFormattedMultiArray($unformattedArray) // unformattedString = $_POST['any_name']
	{
		$retArray = array();
		foreach ($unformattedArray as $unformattedKey=>$unformattedValue)
		{
			if(!is_array($unformattedValue))
			{
				$inputValue = '';
				$inputValue = trim(filter_var($unformattedValue , FILTER_SANITIZE_STRING));
				if(get_magic_quotes_gpc())
				{
					$inputValue = stripslashes($inputValue);
				}
//				$inputValue = mysql_real_escape_string($inputValue);
				$inputValue = strip_tags(pg_escape_string($inputValue));
				$retArray[$unformattedKey] = $inputValue;
			}
			else 
			{
				$retArray[$unformattedKey] = self::getFormattedStringsMultiArray($unformattedValue);
			}
		}
		return $retArray;
	}
	
	public function getFormattedMultiArrayMethod($unformattedArray) // unformattedString = $_POST['any_name']
	{
		$retArray = array();
		foreach ($unformattedArray as $unformattedKey=>$unformattedValue)
		{
			if(!is_array($unformattedValue))
			{
				$inputValue = '';
				$inputValue = trim(filter_var($unformattedValue , FILTER_SANITIZE_STRING));
				if(get_magic_quotes_gpc())
				{
					$inputValue = stripslashes($inputValue);
				}
				//				$inputValue = mysql_real_escape_string($inputValue);
				$inputValue = strip_tags(pg_escape_string($inputValue));
				$retArray[$unformattedKey] = $inputValue;
			}
			else
			{
				$retArray[$unformattedKey] = $this->getFormattedMultiArrayMethod($unformattedValue);
			}
		}
		return $retArray;
	}
	
	public function array_column($array, $column)
	{
		$a2 = array();
		array_map(function ($a1) use ($column, &$a2){
			array_push($a2, $a1[$column]);
		}, $array);
		return $a2;
	}
/*	
	static public function array_column($array, $column)
	{
		$a2 = array();
		$cnt = count($array);
		for($i=0; $i<$cnt; $i++)
			$a2[$i] = $array[$i][$column];
		return $a2;
	}
*/	
	static public function getCurrentFinYear($mode=3)
	{
		switch ($mode)
		{
			case 1:					// yyyyxx
				$year1=date("Y");
				$separator = '';
				break;
			case 2:					// yyyy-xx
				$year1=date("Y");
				$separator = '-';
				break;
			case 3:					// yy-xx
				$year1=date("y");
				$separator = '-';
				break;
			default:				// yy-xx
				$year1=date("y");
				$separator = '-';
				break;
		}
		$month=date("m");
		if($month>3)
		{
			$year2 = date("y")+1;
		}
		else 
		{
			$year1 = $year1-1;
			$year2 = date("y");
		}
		return $year1 . $separator . $year2;
	}
	
	public static function int_to_words($x)
	{
		$x = round($x,0);
		$nwords = array(	"Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven",
				"Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
				"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
				"Nineteen", "Twenty", 30 => "Thirty", 40 => "Forty",
				50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eighty",
				90 => "Ninety" );
		if(!is_numeric($x))
		{
			$w = 'Can not convert invalid number to word!';
		}
		else{
			if($x < 0)
			{
				$w = 'Minus ';
				$x = -$x;
			}else{
				$w = '';
			}
			if($x < 21)
			{
				$w .= $nwords[$x];
			}else if($x < 100)
			{
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0)
				{
					$w .= ' '. $nwords[$r];
				}
			} else if($x < 1000)
			{
				$w .= $nwords[floor($x/100)] .' hundred';
				$r = fmod($x, 100);
				if($r > 0)
				{
					$w .= ' and '. self::int_to_words($r);
				}
			} else if($x < 100000)
			{
				$w .= self::int_to_words(floor($x/1000)) .' thousand';
				$r = fmod($x, 1000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$w .= 'and ';
					}
					$w .= self::int_to_words($r);
				}
			} else {
				$w .= self::int_to_words(floor($x/100000)) .' lakh';
				$r = fmod($x, 100000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$word .= 'and ';
					}
					$w .= self::int_to_words($r);
				}
			}
		}
		return $w;
	}
	
	public static function getRandomString($length, $numberOnly=false)
	{
		if($numberOnly)
			$applicableChars = '123456789'; // Initializing PHP variable with string
		else 
			$applicableChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; // Initializing PHP variable with string
					
		if($length>20)
			$length=20;
		if($length<1)
			$length=1;
		$string = substr(str_shuffle($applicableChars), 0, $length); // Getting first 6 word after shuffle.
		return $string;
	}
	
	public function convertDateTimeStringToSqlTimestamp($dateTime,$format='d/m/Y - G:i')
	{
		$d = DateTime::createFromFormat($format, $dateTime);
		if($d && $d->format($format) == $dateTime)
		{
			return $d->format('Y-m-d G:i:s');
		}
		else
			return null;
	}

	public function getYearMonthFromDateTime($dateTime,$format='Y-m-d G:i:s')
	{
		$d = DateTime::createFromFormat($format, $dateTime);
		if($d && $d->format($format) === $dateTime)
		{
			return date($d->format('Ym'));
		}
		else
			return null;
	}
	
	public static function differenceDateTime($fromDateTime,$toDateTime,$format='d/m/Y - G:i')
	{
		$d1Ok = false;
		$d2Ok = false;
		$retVal = 0;
		$d1 = DateTime::createFromFormat($format, $fromDateTime);
		if($d1 && $d1->format($format) === $fromDateTime)
		{
			$d1Ok = date($d1->format('Y-m-d G:i:s'));
		}
		$d2 = DateTime::createFromFormat($format, $toDateTime);
		if($d2 && $d2->format($format) === $toDateTime)
		{
			$d2Ok = date($d2->format('Y-m-d G:i:s'));
		}
		if($d1Ok && $d2Ok)
		{
			$retVal = strtotime($d2Ok) - strtotime($d1Ok);
		}
		return $retVal;
	}
	
	public static function objectToArray($data)
	{
		if(is_array($data) || is_object($data))
		{
			$result = array();
			 
			foreach($data as $key => $value) {
				$result[$key] = $this->object_to_array($value);
			}
			 
			return $result;
		}
		 
		return $data;
	}
	
}
?>