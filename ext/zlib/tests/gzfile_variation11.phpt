--TEST--
Test function gzfile() by substituting argument 2 with float values.
--SKIPIF--
<?php
if (!extension_loaded('zlib')) die ('skip zlib extension not available in this build');
if (PHP_INT_SIZE != 8) die('skip 64-bit only');
?>
--FILE--
<?php


$filename = dirname(__FILE__)."/004.txt.gz";


$variation = array(
  'float 10.5' => 10.5,
  'float -10.5' => -10.5,
  'float 12.3456789000e10' => 12.3456789000e10,
  'float -12.3456789000e10' => -12.3456789000e10,
  'float .5' => .5,
  );


foreach ( $variation as $var ) {
  var_dump(gzfile( $filename, $var  ) );
}
?>
===DONE===
--EXPECT--
array(6) {
  [0]=>
  string(36) "When you're taught through feelings
"
  [1]=>
  string(26) "Destiny flying high above
"
  [2]=>
  string(38) "all I know is that you can realize it
"
  [3]=>
  string(18) "Destiny who cares
"
  [4]=>
  string(19) "as it turns around
"
  [5]=>
  string(39) "and I know that it descends down on me
"
}
array(6) {
  [0]=>
  string(36) "When you're taught through feelings
"
  [1]=>
  string(26) "Destiny flying high above
"
  [2]=>
  string(38) "all I know is that you can realize it
"
  [3]=>
  string(18) "Destiny who cares
"
  [4]=>
  string(19) "as it turns around
"
  [5]=>
  string(39) "and I know that it descends down on me
"
}
array(6) {
  [0]=>
  string(36) "When you're taught through feelings
"
  [1]=>
  string(26) "Destiny flying high above
"
  [2]=>
  string(38) "all I know is that you can realize it
"
  [3]=>
  string(18) "Destiny who cares
"
  [4]=>
  string(19) "as it turns around
"
  [5]=>
  string(39) "and I know that it descends down on me
"
}
array(6) {
  [0]=>
  string(36) "When you're taught through feelings
"
  [1]=>
  string(26) "Destiny flying high above
"
  [2]=>
  string(38) "all I know is that you can realize it
"
  [3]=>
  string(18) "Destiny who cares
"
  [4]=>
  string(19) "as it turns around
"
  [5]=>
  string(39) "and I know that it descends down on me
"
}
array(6) {
  [0]=>
  string(36) "When you're taught through feelings
"
  [1]=>
  string(26) "Destiny flying high above
"
  [2]=>
  string(38) "all I know is that you can realize it
"
  [3]=>
  string(18) "Destiny who cares
"
  [4]=>
  string(19) "as it turns around
"
  [5]=>
  string(39) "and I know that it descends down on me
"
}
===DONE===
