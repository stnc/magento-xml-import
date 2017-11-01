<?php


ini_set('display_errors', 1);
require_once '../app/Mage.php';
require_once 'func.php';
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

ini_set('display_errors', 1);
//ini_set('max_execution_time', 150000);
$apps = Mage::app('default');

include('uploader.php');

if (isset($_POST['upload'])) {

	$file_size = '2000000';//dosya boyutu
	$allowed_types = 'xml';//izin verilen uzantılar
	$path = 'uploads';//yükleme yapılacak klasor
	$input_names = array();
	$input_names = $_FILES['uploadPic'];
	$Uploader = new stnc_file_upload();
	$Uploader->name_format(false, 'st_', '_nc');
	$Uploader->picture_control_value = true;//resimin gerçek olup olmadığını kontrol eçindir
	$Uploader->uploader_set($input_names, $path, $allowed_types, $file_size);//çalıştırıcı
	$Uploader->result_report(); //rapor hata vss
	$files = $Uploader->uploaded_files[0];


	$myfile = fopen("uploads/" . $files, "r") or die("Unable to open file!");
	$myfilex = fread($myfile, filesize("uploads/" . $files));


	$result = new SimpleXMLElement($myfilex, LIBXML_NOCDATA);

	$randomString = getUniqueCode(15);
//echo trim($result->product[1]->name);

//echo count($result->product);

    /*

echo '<pre>';
print_r($result); die;
*/
	$category_ = array();
	$urunler = array();
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

		if (array_key_exists('category', $row)) {
			//echo 'girer';
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => converting(trim($row->category)),
				'description' => convert_encoding(trim($row->category)),
				'is_active' => 'yes',
				'include_in_menu' => 'yes',
				'meta_description' => convert_encoding(trim($row->category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$root_kategori = (converting($row->category));
		}


		if (array_key_exists('sub2_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . converting($row->sub2_category),
				'description' => convert_encoding(trim($row->sub2_category)),
				'is_active' => 'yes',
				'include_in_menu' => 'yes',
				'meta_description' => convert_encoding(trim($row->sub2_category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub2_category = (converting($row->sub2_category));
		}

		if (array_key_exists('sub3_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . converting($row->sub2_category) . '/' . converting($row->sub3_category),
				'description' => convert_encoding(trim($row->sub3_category)),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => trim($row->sub3_category),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub3_category = (converting($row->sub3_category));
		}

		if (array_key_exists('sub4_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . converting($row->sub2_category) . '/' . converting($row->sub3_category) . '/' . converting($row->sub4_category),
				'description' => convert_encoding(trim($row->sub4_category)),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => convert_encoding(trim($row->sub4_category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub4_category = (converting($row->sub4_category));
		}

		if (array_key_exists('sub5_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . converting($row->sub2_category) . '/' . converting($row->sub3_category) . '/' . converting($row->sub4_category) . '/' . converting($row->sub5_category),
				'description' => convert_encoding(trim($row->sub5_category)),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => convert_encoding(trim($row->sub5_category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub5_category = (converting($row->sub5_category));
		}


		if (array_key_exists('sub6_category', $row)) {
			$category_[] = array(
				'_root' => 'Default Category',
				'_category' => $root_kategori . '/' . converting($row->sub2_category) . '/' . converting($row->sub3_category) . '/' . converting($row->sub4_category) . '/' . converting($row->sub5_category) . '/' . converting($row->sub6_category),
				'description' => convert_encoding(trim($row->sub6_category)),
				'is_active' => 'yes',
				'include_in_menu' => 'no',
				'meta_description' => convert_encoding(trim($row->sub6_category)),
				'available_sort_by' => 'position',
				'default_sort_by' => 'position',
			);
			$sub6_category = (converting($row->sub6_category));
		}


		$root_kategori = str_replace("&amp;", "&", $root_kategori);
		$sub2_category =Kategori_id_ver(trim($row->sub2_category));
		$sub3_category =Kategori_id_ver(trim($row->sub3_category));
		$sub4_category =Kategori_id_ver(trim($row->sub4_category));
		$sub5_category =Kategori_id_ver(trim($row->sub5_category));
		$sub6_category =Kategori_id_ver(trim($row->sub6_category));


		//echo '<pre>';
		$kategori_ = array($root_kategori,$sub1_category, $sub2_category, $sub3_category, $sub4_category, $sub5_category, $sub6_category);
		//print_r($kategori_);
		$linksArray = array_filter($kategori_);
		// print_r($linksArray);
		$linksArray = array_values($linksArray);
		//print_r($linksArray);
		//echo '</pre>';

		$url_key = convert_encoding(make_url(trim($row->name) . "-" . trim($row->reference)));
		$cat_iliski[] = array(
			'_type' => 'simple',
			'_attribute_set' => 'Default',
			'_product_websites' => 'base',
			'sku' => trim($row->reference),
			'_category' => $linksArray,
			'position' => 1

		);




		$urunler[] = array(
			'_type' => 'simple',
			'_attribute_set' => 'Default',
			'_product_websites' => 'base',

			'sku' => trim($row->reference),
			'name' => trim($row->name),
			'price' => trim($row->price),
			//'cost' => trim($row->cost_price),
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
			'_category' => $linksArray,
			'manufacturer' => (trim($row->manufacturer)),
			'enable_googlecheckout' => '1',
			'gift_message_available' => '0',



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



//	$category_=unique_multidim_array($category_, '_category');
/*
	echo '<pre>';
print_r($category_);
	echo '</pre>';
//die;

	echo '<pre>';
	print_r($urunler);
	echo '</pre>';
	//die;
*/
	$time_kat = microtime(true);


	Mage::app('admin', 'store', array('global_ban_use_cache' => true));
	if (Mage::helper('catalog/category_flat')->isEnabled()) {
		Mage::getModel('core/config')->saveConfig('catalog/frontend/flat_catalog_category', 0);
		$switched = true;
	}
	Mage::getConfig()->getOptions()->setData('global_ban_use_cache', false);
	Mage::app()->baseInit(array());
	Mage::getConfig()->loadModules()->loadDb()->saveCache();



	$import = Mage::getModel('fastsimpleimport/import');
	try {
		$import->processCategoryImport($category_);
	} catch (Exception $e) {
		echo '<pre>';
		print_r($import->getErrorMessages());
		echo '</pre>';
	}

	//sleep(5);
	$time_kat = microtime(true);


	$import = Mage::getModel('fastsimpleimport/import');
	try {
		$import->processProductImport($urunler);
	} catch (Exception $e) {
		echo '<pre>';
		print_r($import->getErrorMessages());
		echo '</pre>';
	}


	$import = Mage::getModel('fastsimpleimport/import');
	try {
		$import->processCategoryProductImport($cat_iliski);
	} catch (Exception $e) {
		print_r($import->getErrorMessages());
	}



	echo 'Elapsed time: ' . round(microtime(true) - $time_kat, 2) . 's' . "\n";


	if ($switched) {
		Mage::getModel('core/config')->saveConfig('catalog/frontend/flat_catalog_category', 1);
	}


	fclose($myfile);

}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STNC Magento XML Uploder</title>
    <link href="https://blackrockdigital.github.io/startbootstrap-bare/vendor/bootstrap/css/bootstrap.min.css"
          rel="stylesheet">
    <!-- Bootstrap core CSS -->


    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 54px;
        }

        @media (min-width: 992px) {
            body {
                padding-top: 56px;
            }
        }

    </style>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">STNC Magento XML Uploder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="#">Giriş</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Çıkış</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class="col-md-8">

            <form action="" method="post" enctype="multipart/form-data">
                <input name="uploadPic[]" type="file"/>
                <br>
                <input name="upload" type="submit" value="Upload"/>
            </form>
        </div>
        <div class="col-md-4">
            <img src="img/calisma_.jpg" alt="">
        </div>

    </div>
</div>

<!-- Bootstrap core JavaScript -->

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>


</body>

</html>

