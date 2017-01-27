	<?	if ($_DATA['banner']) { 
		foreach ($_DATA['banner']['items'] as &$banner) {
			if ('main' == $banner['banner_type_id']) $banners_main[] = $banner;
			else if ('property' == $banner['banner_type_id']) $banners_property[] = $banner;
		}
		unset($banner);
	} ?>
<?  if (isset($banners_main)) { 
        $banner = current($banners_main); ?>
    	<div class="home-promo g-clearfix">
            <div class="home-promo-media">
            <?  if ($banner['video_url']) {
                    if (strpos($banner['video_url'], 'youtube.com')) {
                        $youtube_code = current(explode('&', next(explode('?v=', $banner['video_url']))));
                        $video_embed_url = 'https://www.youtube.com/embed/' . $youtube_code;
                    } else {
                        $video_embed_url = $banner['video_url'];
                    } ?>
                    <iframe width="855" height="361" src="<?=$video_embed_url?>" frameborder="0" allowfullscreen=""></iframe>
            <?  } else { ?>
        			<a<?=$banner['url']?' href="' . $banner['url'] . '"':''?>><img src="<?=$banner['img_src']?>" alt=""></a>
            <?  } ?>
            </div>
            <div class="home-promo-form">
            <?  out_contact_form(); ?>
            </div>
        </div>
<?  } ?>

<?	if (isset($banners_property)) { ?>
    <div class="home-links g-clearfix">
    	<ul>
        <?	foreach ($banners_property  as &$banner) { ?>
        		<li><a href="<?=$banner['url']?>" style="background-image: url('<?=$banner['img_src']?>')"><?=$banner['title']?></a></li>
        <?		 // 5 links on the main page
				if (5 == ++$i) break;
			}
			unset($banner);?>
        </ul>
    </div>
	<div class="g-line"></div>
<?	} ?>

<?  if ($_DATA['listing_main']) { ?>
    <div class="properties-grid g-clearfix">
        <h2><?=$_SITE['settings']['title_best_offers']?></h2>
    <?  $i = 0;
        foreach ($_DATA['listing_main']['items'] as &$listing) {
            out_listing($listing);
            if (0 == (++$i % 3)) { ?>
                </div>
                <div class="g-title">Оставьте заявку</div>
                <?  out_contact_form(); ?>
                <br><br><br><br>
                <div class="properties-grid g-clearfix">
        <?  }
        }
        unset($listing); ?>
    </div>
    <div class="g-line"></div>
<?  } ?>
   
    <div class="home-info g-clearfix">
	    <div class="home-info-left">
        <?	$article = current($_DATA['article']['items']); ?>
        	<h2><?=$article['title']?></h2>
            <div class="home-info-left-text">
                <?=$article['body']?>
           </div>
        </div>
	    <div class="home-info-right home-testimonials">
		<?	if (isset($_DATA['testimonial'])) { 
				$testimonial = current($_DATA['testimonial']['items']);?>
                <h2>Отзывы</h2>
                <div class="home-info-right-text"><?=text_left_cut($testimonial ['body'], 200)?></div>
                <div class="home-info-right-person g-clearfix">
                <?	if ($testimonial ['img_src']) { ?>
                        <div class="home-info-right-person-image" style="background: url('<?=$testimonial['img_src']?>') no-repeat"></div>
                <?	} ?>
                    <div class="home-info-right-person-name"><?=$testimonial['title']?></div>
                    <div class="home-info-right-person-info"><?=$testimonial['annotation']?></div>
                </div>
                <div class="home-info-right-link">
                	<a href="<?=$_SITE['section_paths']['testimonials']['path']?>">Посмотреть отзывы</a>
                </div>
        <?	} ?>
        </div>
    </div>

    <div class="g-line"></div>

<?	if (isset($_DATA['news'])) { ?>
    <div class="home-news g-clearfix">
        <h2>Новости</h2>
	<?	$i = 0;
		foreach ($_DATA['news']['items'] as &$news) { ?>
            <a href="<?=$_SITE['section_paths']['news']['path']?>?news=<?=$news['id']?>" class="home-news-item">
                <span class="home-news-item-date"><?=text_date_str($news['produced'])?></span>
                <span class="home-news-item-title"><?=$news['title']?></span>
            </a>
    <?		 // 3 news on the main page
			if (3 == ++$i) break;
		}
        unset($news); ?>
    </div>

    <div class="home-newsletter">
    	<div class="home-newsletter-box">
            <form action="">
                <input type="text" placeholder="Ваш e-mail"><button type="submit" class="g-button">Подписаться на новости</button>
            </form>
	    </div>
    </div>
<?	} ?>
    
    <div class="home-partners">
    	<h3>Наши партнеры</h3>
    <?  foreach ($_DATA['client']['items'] as &$client) { ?>
            <img src="<?=$client['img_src']?>" alt="<?=$title = htmlspecialchars($client['title'])?>" title="<?=$title?>">
    <?  } ?>
    </div>
