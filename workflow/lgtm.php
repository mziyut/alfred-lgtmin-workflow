<?php
require_once('workflows.php');
$wf = new Workflows();

# GET LGTM JSON
$url = "http://www.lgtm.in/g";
$opts = array(
    'http'=>array(
        'method' => "GET",
        'header' => "Accept:application/json, text/javascript"
    )
);
$context = stream_context_create($opts);
$json = json_decode(file_get_contents($url, false, $context));

# Markdown's image syntax
$wf->result(
    time(),
    "![{$json->imageUrl}]({$json->imageUrl})",
    "Copy Markdown's syntax to Clipboard",
    "Good:{$json->likes}  Bad:{$json->dislikes}",
    $image_path
);

# Raw image url
$wf->result(
    time(),
    $json->imageUrl,
    "Copy raw image url to Clipboard",
    "Good:{$json->likes}  Bad:{$json->dislikes}",
    $image_path
);
echo $wf->toxml();

# Create Icon
$image_data = file_get_contents($image_url);
file_put_contents($image_path, $image_data);
?>
