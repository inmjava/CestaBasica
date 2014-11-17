<?php


/*
 Uploadify v2.1.0
 Release Date: August 24, 2009

 Copyright (c) 2009 Ronnie Garcia, Travis Nickels

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

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// obtendo currentTimeMillis
	list($usec, $sec) = explode(" ", microtime());
    $fileName = ((float)$usec + (float)$sec);
    $fileName  = str_replace(array('.'), '', $fileName);
    $fileName = str_pad($fileName, 12 , "0");
    
    // obtendo extensão
	$extension = strtolower($fileParts['extension']);
	
	// adicionando extensão
	$fileName .= '.' . $extension;
	
	// melhorando a descrição do arquivo
	if(in_array($extension, split('\|','jpg|jpeg|gif|png'))){
		$fileName = 'imagem-' . $fileName;
	}else if(in_array($extension, split('\|','flv'))){
		$fileName = 'video-' . $fileName;
	}
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $fileName;

	$fileTypes  = str_replace('*.','',strtolower($_REQUEST['fileext']));
	$fileTypes  = str_replace(';','|',$fileTypes);
	$typesArray = split('\|',$fileTypes);

	if (in_array(strtolower($fileParts['extension']),$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);

		move_uploaded_file($tempFile,$targetFile);
		echo $fileName;
	} else {
		echo 'Invalid file type.';
	}
}
?>