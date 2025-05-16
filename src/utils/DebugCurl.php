<?php
function debugCurl($url, $headers, $payload, $response)
{
    echo "<pre>";
    echo "🔵 URL:\n" . htmlspecialchars($url) . "\n\n";
    echo "🟡 Headers:\n" . htmlspecialchars(print_r($headers, true)) . "\n\n";
    echo "🟢 Payload:\n" . htmlspecialchars(print_r($payload, true)) . "\n\n";
    echo "🔴 Response:\n" . htmlspecialchars($response) . "\n";
    echo "</pre>";
}

