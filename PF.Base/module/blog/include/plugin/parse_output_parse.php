<?php

$aBlog = Phpfox::getLib('template')->getVar('aItem');
$iBlogId = isset($aBlog['blog_id']) ? $aBlog['blog_id'] : 0;
if (Phpfox::getLib('database')->tableExists('phpfox_blog_importer'))
{
    $bIsInstalledBlogImport = true;
}
else
{
    $bIsInstalledBlogImport = false;
}
$override = '';
if ($iBlogId && $bIsInstalledBlogImport)
{
    $aVals = Phpfox::getService('blog.import')->getImportedBlogId();
    foreach ($aVals as $value)
    {
        if ($value['blog_id'] == $iBlogId)
        {
            $override = 'yn_blog_importer_parse';
            break;
        }
    }
}


if (!function_exists('yn_blog_importer_parse'))
{

    function yn_blog_importer_parse($sText)
    {
        $sText = Phpfox::getLib('parse.input')->fixHtml($sText);
        $sText = Phpfox::getLib('parse.output')->parseUrls($sText);
        if (Phpfox::getParam('tag.enable_hashtag_support'))
        {
            $sText = Phpfox::getLib('parse.output')->replaceHashTags($sText);
        }
        $sText = str_replace("\n\r\n\r", "", $sText);
        $sText = str_replace("\n\r", "", $sText);
        $sText = str_replace("\n", "<div class=\"newline\"></div>", $sText);
        return $sText;
    }

}

