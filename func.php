<?php
function getUniqueCode($length = "")
{
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}


function Kategori_id_ver($name)
{
	//$name	=str_replace("&amp;", "&", $name)
	$categories = Mage::getResourceModel('catalog/category_collection');
	$categories->addAttributeToFilter('is_active', 1)
		->addAttributeToFilter('name', $name)
		->setCurPage(1)->setPageSize(1)
		->load();

	if ($categories->getFirstItem()) {
		$category = $categories->getFirstItem();
		return $category->getId();
	} else {
		return false;
	}
}

function converting($value)
{
	return str_replace("/", "\/", $value);
}

function unique_multidim_array($array, $key)
{
	$temp_array = array();
	$i = 0;
	$key_array = array();

	foreach ($array as $val) {
		if (!in_array($val[$key], $key_array)) {
			$key_array[$i] = $val[$key];
			$temp_array[$i] = $val;
		}
		$i++;
	}
	return $temp_array;
}

// //////////////////////////////////////////////////////////////////////////////////////////////////////
function tr2en2($str)
{

	$trans = array(
		"Ç" => "C", "ç" => "c",
		"Ğ" => "G", "ğ" => "g",
		"İ" => "I", "ı" => "i",
		"Ş" => "S", "ş" => "s",
		"Ö" => "O", "ö" => "o",
		"Ü" => "U", "ü" => "u",

		"À" => "A", "à" => "a",
		"Á" => "A", "á" => "a",
		"Â" => "A", "â" => "a",
		"Ã" => "A", "ã" => "a",
		"Ä" => "A", "ä" => "a",
		"Å" => "A", "å" => "a",
		"Æ" => "AE", "æ" => "ae",
		"È" => "E", "è" => "e",
		"É" => "E", "é" => "e",
		"Ê" => "E", "ê" => "e",
		"Ì" => "I", "ì" => "i",
		"Í" => "I", "í" => "i",
		"Î" => "I", "î" => "i",
		"Ï" => "I", "ï" => "i",
		"Ñ" => "N", "ñ" => "n",
		"Ò" => "O", "ò" => "o",
		"Ó" => "O", "ó" => "o",
		"Ô" => "O", "ô" => "o",
		"Õ" => "O", "õ" => "o",
		"Ù" => "U", "ù" => "u",
		"Ú" => "U", "ú" => "u",
		"Û" => "U", "û" => "u",
		"Ü" => "U", "ü" => "u",
		"ß" => "B", "ß" => "b",
		"ÿ" => "y",
		"%" => "",
		"?___SID=S" => "",
	);

	$ret = strtr($str, $trans);

	return $ret;

} // function sonu //////////////////////////////////////////////////////////////////////////////////////
/*
$category_ = unique_multidim_array($category_, '_category');*/

// #######################################################################################################
function convert_encoding($text)
{
	/*$text = str_replace("&amp;", "&", $text);
	$text = str_replace("&lt;", "<", $text);
	$text = str_replace("&gt;", ">", $text);
	$text = str_replace("&quot;", '"', $text);*/
	return $text=html_entity_decode($text);
	// return mb_convert_encoding($text, "UTF-8");

} // function sonu #######################################################################################

function fileNameFind($file)
{
	$path_parts = pathinfo($file);
	return $path_parts['basename'];
}

//echo fileNameFind('http://bank.kariha.net/image/products/946/9462/1-64201.jpg');

// #######################################################################################################
function make_url($text)
{

	$text = strtolower(tr2en2($text));

	$trans = array(
		"\t" => "",
		"\n" => "",
		"\r" => "",
		" " => "-",
		"--" => "-",
	);

	$text = strtr($text, $trans);
	$text = strtr($text, $trans);
	$text = strtr($text, $trans);

	return $text;

} // function sonu #######################################################################################