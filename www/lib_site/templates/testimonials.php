<script>
$(function() {
	$(".testimonial-form-control").click(function() {
		$(this).next(".testimonial-form-body").slideToggle();
		return false;
	});
});
</script>
<div class="body-content-main">
    <h1 class="body-content-main-title"><?=$_SITE['section_title']?></h1>
<?	testimonial__out_form(); ?>
    <div class="testimonials">
<?	if (isset($_DATA['testimonial']['items'])) { ?>
    <?	foreach ($_DATA['testimonial']['items'] as &$item) { ?>
            <div class="testimonial g-clearfix">
                <div class="testimonial-body <?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>">
                    <?=$item['body']?>
                </div>
                <div class="testimonial-person">
                <?	if ($item ['img_src']) { ?>
                        <div class="testimonial-person-image" style="background: url('<?=$item['img_src']?>') no-repeat"></div>
                <?	} ?>
                    <div class="testimonial-person-name"><?=$item['title']?></div>
                    <div class="testimonial-person-info"><?=$item['annotation']?></div>
                </div>
            </div>
    <?	}
        unset($item);
    } ?>
    </div>
<?	testimonial__out_form(); ?>
</div>
<?
out_aside();

function testimonial__out_form() {
?>
    <div class="testimonial-form">
        <div class="testimonial-form-control">
            <a href="/contacts/#contact_form">Оставьте свой отзыв!</a> <i class="fa fa-comment-o"></i>
        </div>
        <div class="testimonial-form-body g-clearfix" style="display: none;">
    	<?	out_contact_form($listing['id']); ?>
        </div>
    </div>
<?
}
?>