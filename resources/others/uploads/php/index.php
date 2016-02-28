<?php

/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {
    /* Converts a filename into a randomized file name */

    private function _generateRandomFileName($name) {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        return md5(uniqid(rand(), true)) . '.' . $ext;
    }

    /* Overrides original functionality */

    protected function trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range) {
        $name = parent::trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range);
        return $this->_generateRandomFileName($name);
    }

}

$upload_handler = new CustomUploadHandler();