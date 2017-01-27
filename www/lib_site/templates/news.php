<div class="body-content-main">
<?	if (isset($_DATA['news']['items'])) {
		if (!$_DATA['news']['is_single']) { ?>
			<h1 class="body-content-main-title"><?=$_SITE['section_title']?></h1>
		<?	foreach ($_DATA['news']['items'] as &$news) { ?>
				<div class="news-item">
					<a href="<?=$_SITE['section_paths']['news']['path']?>?news=<?=$news['id']?>" class="news-item-title">
						<?=$news['title']?>
					</a>
					<div class="news-item-date"><?=text_date_str($news['produced'])?></div>
					<div class="news-item-text"><?=$news['annotation']?></div>
				</div>
		<?	}
			unset($news);
		} else { 
			$news = current($_DATA['news']['items']); ?>
			<article>
				<h1><?=$news['title']?></h1>
				<div class="news-item-date"><?=text_date_str($news['produced'])?></div>
				<div class="<?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>"><?=$news['body']?></div>
			</article>
	<?	}
	} else {
		define('SEO_PAGE_NOINDEX', true); ?>
		<p>
			<?=$__['under_development']?>
		</p>
<?	} ?>
</div>
<?
out_aside();
?>