
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here functions for encryption and decryption
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// Encrypt
function encrypt($encrypt) {
  	$key = "6r9qEJg6";
    srand((double) microtime() * 1000000); //for sake of MCRYPT_RAND
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, 
MCRYPT_MODE_ECB), MCRYPT_RAND);
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt, 
MCRYPT_MODE_ECB, $iv);
    $encode = base64_encode($passcrypt);
  return $encode;
  }

// Decrypt
  function decrypt($decrypt) {
    global $key;
    $key = "6r9qEJg6";
    $decoded = base64_decode($decrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, 
MCRYPT_MODE_ECB), MCRYPT_RAND);
    $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, 
MCRYPT_MODE_ECB, $iv);
  return $decrypted;
}

?>