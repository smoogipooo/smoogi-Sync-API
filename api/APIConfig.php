<?php
if (!defined('BASE_PATH')) define('BASE_PATH', dirname(__FILE__));

if (!defined('UPLOAD_PATH')) define('UPLOAD_PATH', BASE_PATH . '/../Store');
if (!defined('UPLOAD_PATH_FILE')) define('UPLOAD_PATH_FILE', UPLOAD_PATH . '/%s');

if (!defined('TEMP_PATH')) define('TEMP_PATH', BASE_PATH . '/../tmp');
if (!defined('TEMP_PATH_FILE')) define('TEMP_PATH_FILE', TEMP_PATH . '/%s');

if (!defined('AWS_KEY')) define('AWS_KEY', '');
if (!defined('AWS_SECRET')) define('AWS_SECRET', '');