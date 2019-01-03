<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
require_once("../mysql.php");
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$file_Sname = strtolower(substr($_FILES['Filedata']['name'], strrpos($_FILES['Filedata']['name'] , ".")+1));
	$file_Full_name=$_POST['activity_id']."_".md5($_FILES['Filedata']['name'].date("YmdGis")).'.'.$file_Sname;
	$targetFile =  str_replace('//','/',$targetPath) . $file_Full_name;
	
	$sql="INSERT INTO `hai_active_activity_file` (`activity_id`,`path`,`fname`,`ftype`)
	VALUES ('".$_POST['activity_id']."','".$upload_path.'/'.$file_Full_name."','".$_FILES['Filedata']['name']."','".$file_Sname."' )";
	mysql_query($sql);
	

	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
		move_uploaded_file($tempFile,$targetFile);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	// } else {
	// 	echo 'Invalid file type.';
	// }
		require_once('../image-resizing.php');
		if($file_Sname=="jpg" || $file_Sname=="png"){
			//這段引用套件image-resizing.php
			$image = new SimpleImage();
  			$image->load($targetFile);
			if($image->getWidth() >= $image->getHeight()){
				$image->resizeToWidth(700);
			}else{
				$image->resizeToHeight(500);
			}
			$image->save($targetFile);
		}
	
}
?>
