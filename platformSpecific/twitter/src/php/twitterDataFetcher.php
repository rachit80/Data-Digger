<?php

include 'settingsDetails.php';

$fh = fopen( $tweetFileName, 'w' );

function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}


$oauth = array( 'screen_name' => $screen_name,
                'count' => $count,
                'oauth_consumer_key' => $consumer_key,
                'oauth_nonce' => time(),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_token' => $oauth_access_token,
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0');

$base_info = buildBaseString($url, 'GET', $oauth);

$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);

$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));

$oauth['oauth_signature'] = $oauth_signature;

// Make Requests
$header = array(buildAuthorizationHeader($oauth), 'Expect:');

$options = array( CURLOPT_HTTPHEADER => $header,
                  CURLOPT_HEADER => false,
                  CURLOPT_URL => $url."?screen_name=$screen_name"."&"."count=$count",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_SSL_VERIFYPEER => false);
                  

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$i=0; 
    
foreach ($jsonIterator as $key => $val) {
    if($key === 'text')  {
       fwrite($fh,$val);
       fwrite($fh,"\n\n");
       $i = $i+1;
    
    }
}

fwrite($fh,"total");
fwrite($fh, $i);

?>