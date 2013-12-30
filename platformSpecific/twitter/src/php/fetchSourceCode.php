<?php
// Website address
$webAddress = "www.twitter.com";

//User name 
$userName ="yogeshandyogi";

//protocol 
$protocol = "http" ;

//The final url for fetching the page
$ompletePageAddress="$protocol"."//"."$webAddress"."/"."$userName";

// cURL 

//intializing curl session
$curlHandle = curl_init("$completePageAddress");

//open file in write only mode. 
//Edit file name accordingly.fopen in write mode tries to create the file if not available.
$fileResource = fopen("file1.txt", "w"); //we may need to lock it--> will see that later.

//set curl options
curl_setopt($curlHandle, CURLOPT_FILE, $fileResource);
curl_setopt($curlHandle,CURLOPT_HEADER,0);

//Execute curl
curl_exec($curlHandle);

curl_close($curlHandle);
fclose($fileresource);

//release lock (file1.txt) ( if locked )

?>











