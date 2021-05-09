<?php
namespace common\models;

class ConvertNumberMalay
{
	
	
	public static function convertNumber($number, $currency = true)
	{
		$number = (string)$number;
		$pos = strpos($number, '.'); 
		if($pos === false){
			$number = $number . ".0";
		}


		list($integer, $fraction) = explode(".", $number);

		$output = "";

		if ($integer{0} == "-")
		{
			$output = "negatif ";
			$integer    = ltrim($integer, "-");
		}
		else if ($integer{0} == "+")
		{
			$output = "positif ";
			$integer    = ltrim($integer, "+");
		}

		if ($integer{0} == "0")
		{
			$output .= "kosong";
		}
		else
		{
			$integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
			$group   = rtrim(chunk_split($integer, 3, " "), " ");
			$groups  = explode(" ", $group);

			$groups2 = array();
			foreach ($groups as $g)
			{
				$groups2[] = self::convertThreeDigit($g{0}, $g{1}, $g{2});
			}

			for ($z = 0; $z < count($groups2); $z++)
			{
				if ($groups2[$z] != "")
				{
					$output .= $groups2[$z] . self::convertGroup(11 - $z) . (
							$z < 11
							&& !array_search('', array_slice($groups2, $z + 1, -1))
							&& $groups2[11] != ''
							&& $groups[11]{0} == '0'
								? " "
								: ", "
						);
				}
			}

			$output = rtrim($output, ", ");
		}

		if ($fraction > 0)
		{
			if($currency){
				
				$output .= ", ";
				if($fraction{0} == 0){
					$output .= " " . self::convertDigit($fraction{1});
				}else{
					$output .= " " . self::convertTwoDigit($fraction{0}, $fraction{1});
				}
				
				$output .= " sen";
			}else{
				$output .= " perpuluhan";
				for ($i = 0; $i < strlen($fraction); $i++)
				{
					$output .= " " . self::convertDigit($fraction{$i});
				}
			}
			
		}

		return $output;
	}

	private static function convertGroup($index)
	{
		switch ($index)
		{
			case 11:
				return " decillion";
			case 10:
				return " nonillion";
			case 9:
				return " octillion";
			case 8:
				return " septillion";
			case 7:
				return " sextillion";
			case 6:
				return " quintrillion";
			case 5:
				return " quadrillion";
			case 4:
				return " trillion";
			case 3:
				return " bilion";
			case 2:
				return " juta";
			case 1:
				return " ribu";
			case 0:
				return "";
		}
	}

	private static function convertThreeDigit($digit1, $digit2, $digit3)
	{
		$buffer = "";

		if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
		{
			return "";
		}

		if ($digit1 != "0")
		{
			$buffer .= self::convertDigit($digit1) . " ratus";
			if ($digit2 != "0" || $digit3 != "0")
			{
				$buffer .= " ";
			}
		}

		if ($digit2 != "0")
		{
			$buffer .= self::convertTwoDigit($digit2, $digit3);
		}
		else if ($digit3 != "0")
		{
			$buffer .= self::convertDigit($digit3);
		}

		return $buffer;
	}

	private static function convertTwoDigit($digit1, $digit2)
	{
		if ($digit2 == "0")
		{
			switch ($digit1)
			{
				case "1":
					return "sepuluh";
				case "2":
					return "dua puluh";
				case "3":
					return "tiga puluh";
				case "4":
					return "empat puluh";
				case "5":
					return "lima puluh";
				case "6":
					return "enam puluh";
				case "7":
					return "tujuh puluh";
				case "8":
					return "lapan puluh";
				case "9":
					return "sembilan puluh";
			}
		} else if ($digit1 == "1")
		{
			switch ($digit2)
			{
				case "1":
					return "sebelas";
				case "2":
					return "dua belas";
				case "3":
					return "tiga belas";
				case "4":
					return "empat belas";
				case "5":
					return "lima belas";
				case "6":
					return "enam belas";
				case "7":
					return "tujuh belas";
				case "8":
					return "lapan belas";
				case "9":
					return "sembilan belas";
			}
		} else
		{
			$temp = self::convertDigit($digit2);
			switch ($digit1)
			{
				case "2":
					return "dua puluh $temp";
				case "3":
					return "tiga puluh $temp";
				case "4":
					return "empat puluh $temp";
				case "5":
					return "lima puluh $temp";
				case "6":
					return "enam puluh $temp";
				case "7":
					return "tujuh puluh $temp";
				case "8":
					return "lapan puluh $temp";
				case "9":
					return "sembilan puluh $temp";
			}
		}
	}

	private static function convertDigit($digit)
	{
		switch ($digit)
		{
			case "0":
				return "kosong";
			case "1":
				return "satu";
			case "2":
				return "dua";
			case "3":
				return "tiga";
			case "4":
				return "empat";
			case "5":
				return "lima";
			case "6":
				return "enam";
			case "7":
				return "tujuh";
			case "8":
				return "lapan";
			case "9":
				return "sembilan";
		}
	}
	
	
}

