<?php
$handle = curl_init(urldecode($_GET['uri']));
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

/* Get the HTML or whatever is linked in $url. */
$response = curl_exec($handle);
echo "1";
/* Check for 404 (file not found). */
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_setopt($handle, CURLOPT_NOSIGNAL, 1);
curl_setopt($handle, CURLOPT_TIMEOUT_MS, 200);
if($httpCode == 404) {
  /* Handle 404 here. */
  echo "foo";
}
echo "bar";
curl_close($handle);


?>
