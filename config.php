<?php
// Site URL
$host = $_SERVER['HTTP_HOST'];
if ($host == 'localhost') {
    $dirPath = 'professional_costs/';
    $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$host."/".$dirPath;
    // Database Credentials LOCAL
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PWD', '');
    define('DB', 'professional_costs');
} else {
    $dirPath = 'panel/';
    $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$host."/".$dirPath;
    // Database Credentials LIVE
    define('HOST', 'localhost');
    define('USER', 'tamecare_admin');
    define('PWD', 'f_aPrl2)Fc$D');
    define('DB', 'tamecare_panel');
}

// Global Usage Variables
define('site_url', $url);
define('website_title', 'YOUR TITLE HERE');
