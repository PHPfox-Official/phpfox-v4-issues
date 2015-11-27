<?php ?>

<script type="text/javascript">
<?php
$check = Phpfox::getService('blog.import')->chekUserParam();
if (count($check)):
    if (!Phpfox::getUserParam('blog.can_import_blog')):
        ?>
            $("#section_menu").find('ul li a[href$="blog/import"]').eq(0).css('display', 'none');
            $("#section_menu").find('ul li a[href$="blog/import/"]').eq(0).css('display', 'none');
    <?php endif; ?>
    <?php if (!Phpfox::getUserParam('blog.can_export_blog')): ?>
            $("#section_menu").find('ul li a[href$="blog/export"]').eq(0).css('display', 'none');
            $("#section_menu").find('ul li a[href$="blog/export/"]').eq(0).css('display', 'none');
    <?php endif;
endif; ?>
</script>