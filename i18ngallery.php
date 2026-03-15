<?php
/**
 * Module Name: i18n Galleries
 * Module ID:   i18ngalleries
 * Description: Lists i18n Gallery galleries with links to edit.
 * Version:     1.0
 * Default W:   4
 * Default H:   4
 */

if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Add $i18n_m for i18n lang files in Modules
$i18n_m = dash_module_i18n('i18ngallery');

$uid = 'gal_' . substr(md5(__FILE__), 0, 6);

// Bail gracefully if i18n_gallery is not installed
$galleries = array();
if (defined('GSDATAPATH') && defined('I18N_GALLERY_DIR')) {
    $gdir = GSDATAPATH . I18N_GALLERY_DIR;
    if (is_dir($gdir)) {
        $dh = @opendir($gdir);
        while ($dh && ($filename = readdir($dh))) {
            if (substr($filename, -4) === '.xml') {
                $data = @getXML($gdir . $filename);
                if ($data) {
                    $galleries[] = array(
                        'name'  => (string)$data->name,
                        'title' => (string)$data->title,
                    );
                }
            }
        }
        if ($dh) closedir($dh);
        usort($galleries, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });
    }
}
?>

<style>
#<?php echo $uid ?> .gal-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
#<?php echo $uid ?> .gal-table th {
    text-align: left;
    padding: 5px 8px;
    border-bottom: 2px solid #eee;
    color: #888;
    font-weight: 600;
}
#<?php echo $uid ?> .gal-table td {
    padding: 6px 8px;
    border-bottom: 1px solid #f3f3f3;
    vertical-align: middle;
}
#<?php echo $uid ?> .gal-table tr:last-child td { border-bottom: none; }
#<?php echo $uid ?> .gal-table tr:hover td { background: #fafafa; }
#<?php echo $uid ?> .gal-name {
    font-weight: 500;
    color: #333;
}
#<?php echo $uid ?> .gal-btn {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    text-decoration: none;
    background: #5D61CA;
    color: #fff !important;
    white-space: nowrap;
}
#<?php echo $uid ?> .gal-btn:hover { background: #3C40B8; }
#<?php echo $uid ?> .gal-empty {
    color: #bbb;
    font-style: italic;
    text-align: center;
    padding: 16px;
}
#<?php echo $uid ?> .gal-missing {
    color: #856404;
    background: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 13px;
}
</style>

<div id="<?php echo $uid ?>">
    <h3><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M18.512 10.077c0 .739-.625 1.338-1.396 1.338s-1.395-.6-1.395-1.338s.625-1.337 1.395-1.337s1.396.598 1.396 1.337"/><path fill="currentColor" fill-rule="evenodd" d="M18.036 5.532c-1.06-.136-2.414-.136-4.123-.136h-3.826c-1.71 0-3.064 0-4.123.136c-1.09.141-1.974.437-2.67 1.104c-.696.668-1.005 1.514-1.152 2.56C2 10.21 2 11.508 2 13.147v.1c0 1.639 0 2.937.142 3.953c.147 1.045.456 1.891 1.152 2.558c.696.668 1.58.964 2.67 1.104C7.024 21 8.378 21 10.087 21h3.826c1.71 0 3.064 0 4.123-.137c1.09-.14 1.974-.436 2.67-1.104c.696-.667 1.005-1.513 1.152-2.558c.142-1.016.142-2.314.142-3.953v-.1c0-1.64 0-2.937-.142-3.953c-.147-1.045-.456-1.891-1.152-2.559c-.696-.667-1.58-.963-2.67-1.104M6.15 6.858c-.936.12-1.475.347-1.87.724c-.393.378-.629.894-.755 1.791c-.1.72-.123 1.62-.128 2.796l.47-.395c1.125-.943 2.819-.889 3.875.123l3.99 3.825a1.2 1.2 0 0 0 1.491.124l.278-.187a3.606 3.606 0 0 1 4.34.25l2.407 2.078c.098-.264.173-.58.227-.965c.128-.916.13-2.124.13-3.824s-.002-2.908-.13-3.825c-.126-.897-.362-1.413-.756-1.79c-.393-.378-.933-.604-1.869-.725c-.956-.123-2.216-.125-3.99-.125h-3.72c-1.774 0-3.034.002-3.99.125" clip-rule="evenodd"/><path fill="currentColor" d="M17.086 2.61c-.86-.11-1.954-.11-3.319-.11h-3.09c-1.364 0-2.459 0-3.319.11c-.89.115-1.632.358-2.221.92a2.9 2.9 0 0 0-.724 1.12c.504-.23 1.074-.366 1.714-.45c1.084-.14 2.47-.14 4.22-.14h3.914c1.75 0 3.135 0 4.22.14c.558.073 1.064.186 1.519.366a2.9 2.9 0 0 0-.692-1.035c-.589-.563-1.331-.806-2.222-.92"/></svg> <?php echo $i18n_m('18_lang_Galleries'); ?></h3>

    <?php if (!defined('I18N_GALLERY_DIR')): ?>
        <p class="gal-missing">⚠ <?php echo $i18n_m('18_lang_plugin_not_active'); ?>.</p>
    <?php elseif (empty($galleries)): ?>
        <p class="gal-empty"><?php echo $i18n_m('18_lang_No_galleries'); ?>.</p>
    <?php else: ?>
    <table class="gal-table">
        <tr>
            <th><?php echo $i18n_m('18_lang_Title'); ?></th>
            <th style="text-align:center;"><?php echo $i18n_m('18_lang_Action'); ?></th>
        </tr>
        <?php foreach ($galleries as $gallery):
            $name    = htmlspecialchars($gallery['name']);
            $title   = htmlspecialchars($gallery['title']) ?: $name;
            $editUrl = 'load.php?id=i18n_gallery&edit&name=' . $name;
        ?>
        <tr>
            <td class="gal-name"><?php echo $title; ?></td>
            <td style="text-align:center;">
                <a class="gal-btn" href="<?php echo $editUrl; ?>" title="<?php echo $i18n_m('18_lang_Edit'); ?>"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="18" height="18" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="m22.7 14.3l-1 1l-2-2l1-1c.1-.1.2-.2.4-.2c.1 0 .3.1.4.2l1.3 1.3c.1.2.1.5-.1.7M13 19.9V22h2.1l6.1-6.1l-2-2zm-1.79-4.07l-1.96-2.36L6.5 17h6.62l2.54-2.45l-1.7-2.26zM11 19.9v-.85l.05-.05H5V5h14v6.31l2-1.93V5a2 2 0 0 0-2-2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6z"/></svg></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>