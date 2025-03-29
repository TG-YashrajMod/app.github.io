<?php
// Get the 'id' parameter from the request
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ID parameter.");
}

$id = $_GET['id'];

// Original M3U8 URL pattern
$sourceUrl = "http://filex.tv:8080/Home329/Sohailhome/{$id}";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sourceUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// Set custom headers
$headers = [
    "User-Agent: OTT Navigator/1.6.7.4 (Linux;Android 11) ExoPlayerLib/2.15.1",
    "Host: filex.tv:8080",
    "Connection: Keep-Alive",
    "Accept-Encoding: gzip"
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute CURL
$response = curl_exec($ch);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

// Check if we got a redirected URL
if ($finalUrl && filter_var($finalUrl, FILTER_VALIDATE_URL)) {
    // Redirect to the final M3U8 stream
    header("Location: $finalUrl");
    exit();
} else {
    die("Failed to fetch stream URL.");
}
?>