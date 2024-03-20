<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=welcome'));
    exit();
}
$wo['reels']['id']         = 0;
if (!empty($_GET['create-reels'])) {
    $_GET['create-reels'] = Wo_Secure($_GET['create-reels']);
    $album         = Wo_PostData($_GET['create-reels']);
    if (!empty($album)) {
        $wo['reels']['id']         = $album['post_id'];
    }
}
$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'create_reels';
$wo['title']       = $wo['lang']['my_reels'] . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('reels/create');
