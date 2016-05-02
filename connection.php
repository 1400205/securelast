<?php
define('DB_SERVER', 'ap-cdbr-azure-east-c.cloudapp.net');
define('DB_USERNAME', 'ba3dcb56418003');
define('DB_PASSWORD', '5055d853');
define('DB_DATABASE', 'BJTS');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//function xssafe
function xssafe($data,$encoding='UTF-8'){
    return htmlspecialchars($data,ENT_QUOTES|ENT_HTML401|ENT_HTML401);
}

// function to clean output
function xecho($data){
    echo xssafe($data);
};

//Function to cleanup user input for xss
function xss_cleaner($input_str) {
    $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}


?>
