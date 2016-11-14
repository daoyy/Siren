<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Akina
 */

?>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title itemprop="name"><?php global $page, $paged;
        wp_title('|', true, 'right');
        bloginfo('name');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) echo " | $site_description";
        if ($paged >= 2 || $page >= 2) echo ' | ' . sprintf(__('第 %s 页'), max($paged, $page)); ?>
    </title>
    <META content="MSHTML 6.00.2800.1458" name=GENERATOR>
</head>
<BODY topMargin=20>
<TABLE cellSpacing=0 cellPadding=0 width="100%">
    <TBODY>
    <TR>
        <TD
            style="BACKGROUND: #FB9966; HEIGHT: 1px">&nbsp;</TD>
    </TR>
    </TBODY>
</TABLE>
<p align="center"><img src="<?php bloginfo('template_url'); ?>/images/404.png" width="791" height="430" border="0" usemap="#Map"
                       longdesc="<?php bloginfo('url'); ?>"/>
    <map name="Map" id="Map">
        <area shape="rect" coords="26,256,428,324" href="<?php bloginfo('url'); ?>"/>
    </map>
</p>

<TABLE cellSpacing=0 cellPadding=0 width="100%">
    <TBODY>
    <TR>
        <TD
            style="BACKGROUND: #FB9966; HEIGHT: 1px">&nbsp;</TD>
    </TR>
    </TBODY>
</TABLE>
</body>


