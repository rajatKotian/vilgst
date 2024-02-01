<?php
error_reporting(E_ALL);
ini_set('display_errors','on');
if (isset($_SERVER['REMOTE_ADDR'])) echo '<pre>';

$checkips = array(
  '80.140.2.2' => '80.140.*.*',
  '80.141.2.2' => '80.140.*.*',
  '80.140.2.3' => '80.140/16',
  '1.2.3.4' => '1.2.3.0-1.2.255.255',
  '90.35.6.12' => '80.140.0.0-80.140.255.255',
  '80.76.201.37' => '80.76.201.32/27',
  '81.76.201.37' => '80.76.201.32/27',
  '80.76.201.38' => '80.76.201.32/255.255.255.224',
  '80.76.201.39' => '80.76.201.32/255.255.255.*',
  '80.76.201.40' => '80.76.201.64/27',
  '192.168.1.42' => '192.168.3.0/24',
  '128.0.0.0' => '127.0.0.0-129.0.0.0',
);

echo 'Checking : ', print_r($checkips, true);

include 'iprange.php';

foreach ($checkips as $ip => $range) {
  echo '-------------------', "\n";
  $ok = ip_in_range($ip, $range);
  echo $ip, ' in ', $range, ' = ', ($ok ? ' OK' : ' Fail'), "\n";
}

if (isset($_SERVER['REMOTE_ADDR'])) echo '</pre>';
else exit;
echo '<br /><hr>';
show_source(__FILE__);