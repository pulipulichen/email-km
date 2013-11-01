<?php

/**
  * SAVR 10/20/06 : force file download over SSL for IE
  * BIP  09/17/07 : inserted and tested for ProjectPier 
  * Was:
  * function download_contents($content, $type, $name, $size, $force_download = false) {
  */
  function download_contents($content, $type, $name) {
    $chunksize = 1*(1024*1024); // how many bytes per chunk
    $buffer = '';
    $handle = fopen($content, 'rb');
    
    $size = filesize($content);
    //echo $size;
    download_headers($name, $type, $size);
    
    if ($handle === false) {
      return false;
    }
    while (!feof($handle)) {
      $buffer = fread($handle, $chunksize);
      print $buffer;
      flush();
      ob_flush();
    }
    return fclose($handle);
  } // download_contents

  /**
  * function download_headers($type, $name, $size, $force_download = false)
  */
  function download_headers($name, $type, $size, $force_download = true) {
    if ($force_download) {
      /** SAVR 10/20/06
      * Was:
      * header("Cache-Control: public");
      */
      header("Cache-Control: public, must-revalidate");
      if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE") == false) {
            header("Pragma: hack");
      }
      else {
          header('Pragma: public');
      }
    } else {
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE") == false) {
            header("Pragma: no-cache");
      }
      else {
          header('Pragma: public');
      }
    } // if
    header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Content-Type: $type");
    header("Content-Length: $size");
    // Prepare disposition
    $disposition = $force_download ? 'attachment' : 'inline';
    // http://www.ietf.org/rfc/rfc2183.txt
    $download_name = strtr($name, " ()<>@,;:\\/[]?=*%'\"", '--------------------');
    //$download_name = normalize($download_name);
    // Generate the server headers
    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        $download_name = iconv('utf-8', 'big5', $download_name);
        header('Pragma: public');
    }
    header("Content-Disposition: $disposition; filename=\"$download_name\"");
    //header("Content-Disposition: $disposition; filename=$download_name");
    header("Content-Transfer-Encoding: binary");
  }

$content = $_GET["file"];
$content = str_replace("/", DIRECTORY_SEPARATOR, $content);
$content = DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $content;
$filepath = __FILE__;
$separator = DIRECTORY_SEPARATOR;
$filepath = substr(__FILE__, 0, strrpos(__FILE__, DIRECTORY_SEPARATOR));
$filepath = $filepath . $content;

$type = "application/octet-stream";
$name = $_GET["name"];
$name = urldecode($name);

download_contents($filepath, $type, $name);
?>
