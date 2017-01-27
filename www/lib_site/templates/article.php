<div class="body-content-main <?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>">
    <article>
    <?	if (isset($_DATA['article']['items'])) { 
			$article = current($_DATA['article']['items']); ?>
			<h1><?=$article['title']?></h1>
			<?=$article['body']?>
    <?	} else {
            define('SEO_PAGE_NOINDEX', true); ?>
            <p>
                <?=$__['under_development']?>
            </p>
    <?	} ?>
    </article>
</div>
<?
out_aside();
?>