<?php
//require_once 'vendor/autoload.php';
require_once '../app/Mage.php';
require_once 'func.php';
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

ini_set('display_errors', 1);
ini_set('max_execution_time', 600);
$apps = Mage::app('default');

$myfile = fopen("magento_xml.xml", "r") or die("Unable to open file!");
$myfilex = fread($myfile, filesize("burak_magento_dene.xml"));


$result = new SimpleXMLElement($myfilex, LIBXML_NOCDATA);


//echo trim($result->product[1]->name);

//echo count($result->product);
$randomString = getUniqueCode(20);
//print_r($result); die;
$category_ = array();
$data = array();
$sub2_category = "";
$sub3_category = "";
$sub4_category = "";
$sub5_category = "";
$sub6_category = "";
$yeni_eklenenen_root_kategori = "";
//print_r($result['value'][0]['value']); die;

//echo count($result['value']); die;
$i = 0;
foreach ($result as $key => $row) {
//echo trim ($row->name);
//echo $key;
	$i++;
	if ($i == 1) {
		if (array_key_exists('category', $row)) {
			//echo 'girer';
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => trim($row->category),
				'description' => convert_encoding(trim($row->category)),
				'is_active' => 'yes',
				'include_in_menu' => 'yes',
				'meta_description' => convert_encoding(trim($row->category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$yeni_eklenenen_root_kategori = trim($row->category);
		}


		if (array_key_exists('sub2_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $yeni_eklenenen_root_kategori . '/' . trim($row->sub2_category),
				'description' => trim($row->sub2_category),
				'is_active' => 'yes',
				'include_in_menu' => 'yes',
				'meta_description' => trim($row->sub2_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub2_category = trim($row->sub2_category);
		}

		if (array_key_exists('sub3_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $yeni_eklenenen_root_kategori . '/' . trim($row->sub3_category),
				'description' => trim($row->sub3_category),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => trim($row->sub3_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub3_category = trim($row->sub3_category);
		}
		if (array_key_exists('sub4_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $yeni_eklenenen_root_kategori . '/' . trim($row->sub4_category),
				'description' => trim($row->sub4_category),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => trim($row->sub4_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub4_category = trim($row->sub4_category);
		}

		if (array_key_exists('sub5_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . trim($row->sub5_category),
				'description' => trim($row->sub5_category),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => trim($row->sub5_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub5_category = trim($row->sub5_category);
		}


		if (array_key_exists('sub6_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . trim($row->sub6_category),
				'description' => trim($row->sub6_category),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => trim($row->sub6_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub6_category = trim($row->sub6_category);
		}

		$root_kategori = str_replace("&amp;", "&", $root_kategori);
		$sub1_category = Kategori_id_ver(str_replace("&amp;", "&", $sub1_category));
		$sub2_category = Kategori_id_ver(str_replace("&amp;", "&", $sub2_category));
		$sub3_category = Kategori_id_ver(str_replace("&amp;", "&", $sub3_category));
		$sub4_category = Kategori_id_ver(str_replace("&amp;", "&", $sub4_category));
		$sub5_category = Kategori_id_ver(str_replace("&amp;", "&", $sub5_category));
		$sub6_category = Kategori_id_ver(str_replace("&amp;", "&", $sub6_category));

		$kategori_ = array($root_kategori, $sub1_category, $sub2_category, $sub3_category, $sub4_category, $sub5_category, $sub6_category);
		$linksArray = array_filter($kategori_);
		//print_r($linksArray);


		$url_key = convert_encoding(make_url(trim($row->name) . "-" . trim($row->reference)));

		$data[] = array(
			'_type' => 'simple',
			'_attribute_set' => 'Default',
			'_product_websites' => 'base',
			'_category' => $linksArray,
			'sku' => trim($row->reference),
			'name' => trim($row->name),
			'price' => trim($row->price),
			'cost' => trim($row->cost_price),
			'description' => convert_encoding(trim($row->description)),
			'short_description' => convert_encoding(trim($row->description)),
			'meta_title' => trim($row->name),
			'meta_description' => '',
			'meta_keyword' => '',
			'status' => 1,
			'visibility' => 4,
			'tax_class_id' => 2,
			'qty' => trim($row->quantity),
			'is_in_stock' => 1,
			'url_key' => $url_key,
			'manufacturer' => convert_encoding(trim($row->manufacturer)),
			'enable_googlecheckout' => '1',
			'gift_message_available' => '0',

			//'thumbnail' => fileNameFind(trim($row->image0)),

			'_media_attribute_id' => 88,
			'_media_image' => array(
				trim($row->image0),
				trim($row->image1),
				trim($row->image2),
				trim($row->image3),

			),
			'_media_target_filename' => array(
				$i . '-' . $randomString . '_image.jpg',
				$i . '-' . $randomString . '_2nrd.jpg',
				$i . '-' . $randomString . '_3nrd.jpg',
				$i . '-' . $randomString . '_4nrd.jpg',

			),
			'_media_lable' => array(
				'Image 0',
				'Image 1',
				'Image 2',
				'Image 3'

			),
			'image' => array(
				$i . '-' . $randomString . '_image.jpg',
				$i . '-' . $randomString . '_2nrd.jpg',
				$i . '-' . $randomString . '_3nrd.jpg',
				$i . '-' . $randomString . '_4nrd.jpg',
			),
			'small_image' => array(
				$i . '-' . $randomString . '_image.jpg',
				$i . '-' . $randomString . '_2nrd.jpg',
				$i . '-' . $randomString . '_3nrd.jpg',
				$i . '-' . $randomString . '_4nrd.jpg',
			),
			'thumbnail' => array(
				$i . '-' . $randomString . '_image.jpg',
				$i . '-' . $randomString . '_2nrd.jpg',
				$i . '-' . $randomString . '_3nrd.jpg',
				$i . '-' . $randomString . '_4nrd.jpg',
			),
		);

	}
}


print_r($data);

$time_kat = microtime(true);


Mage::app('admin', 'store', array('global_ban_use_cache' => true));
if (Mage::helper('catalog/category_flat')->isEnabled()) {
	Mage::getModel('core/config')->saveConfig('catalog/frontend/flat_catalog_category', 0);
	$switched = true;
}
Mage::getConfig()->getOptions()->setData('global_ban_use_cache', false);
Mage::app()->baseInit(array());
Mage::getConfig()->loadModules()->loadDb()->saveCache();


/** @var $import AvS_FastSimpleImport_Model_Import */
$import = Mage::getModel('fastsimpleimport/import');
try {
	$import->processCategoryImport($category_);
} catch (Exception $e) {
	print_r($import->getErrorMessages());
}


$time_kat = microtime(true);

$import = Mage::getModel('fastsimpleimport/import');
try {
	$import->processProductImport($data);
} catch (Exception $e) {
	print_r($import->getErrorMessages());
}


echo 'Elapsed time: ' . round(microtime(true) - $time_kat, 2) . 's' . "\n";


if ($switched) {
	Mage::getModel('core/config')->saveConfig('catalog/frontend/flat_catalog_category', 1);
}


fclose($myfile);