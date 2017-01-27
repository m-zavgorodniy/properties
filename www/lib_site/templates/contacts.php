<?
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/lib');

require "mail.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$params = get_post();
	
	if (!$params['name']) $error[1] = 'Не заполнено обязательное поле.';
	
	if (!$params['email']) $error[2] = 'Не заполнено обязательное поле.';
	else if (!valid_email($params['email'])) $error[2] = 'Неправильно указан адрес электронной почты.';

	if (!$params['message']) $error[3] = 'Не заполнено обязательное поле.';

	if (!$error) {
		if ('http://mskkey.ru/contacts/' != $_SERVER['HTTP_REFERER']) {
			$property = $params['property']?$params['property']:$_SERVER['HTTP_REFERER'] ;
		}
		$mail_message = "От: " . $params['name'] . " (" . $params['email'] . ")" . ($property?"\nИнтересует объект: " . $property:'') . "\n\n" . $params['message'];
		$mail_recepients = array('kiragold@ya.ru', 'mx3@mail.ru');
		foreach ($mail_recepients as &$rcpt) {
			if (true !== @mail_send($rcpt, 'Сообщение с сайта mskkey.ru', $mail_message)) {
				$error[0] = 'Непредвиденная ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз чуть позже.';
			}
		}
		unset($rcpt);
 
 		if (!$error) {
			$message = 'Спасибо! Ваше сообщение принято.';
		} else {
			$message = $error[0];
		}
		unset($params); ?>
<?	}
}
?>
<div class="body-content-main <?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>">
	<style>
		.body-content-main p {margin-bottom:  5px !important;}
		.contact-map {margin-top: 2em;}
    </style>
    <article>
        <h1>Контакты</h1>
        <h3>Агентство недвижимости "МСК ключ"</h3>
        <p>Телефон: <span class="detail-order-phone-number"><?=$_SITE['settings']['phone']?></span> &nbsp; <span class="detail-order-phone-number"><?=$_SITE['settings']['phone_mobile']?></span></p>
        <p>Эл. почта: &nbsp;<span id="hm"></span></p>
        <p>Адрес: &nbsp;г. Москва, ул. Профсоюзная, д. 96</p>
    </article>
    <script>
        function initialize() {
            var myLatlng = new google.maps.LatLng(55.647459, 37.528016);
            var mapOptions = {
                center: myLatlng,
                zoom: 16,
                scrollwheel: false
            }
            var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <div class="contact-map">
        <div id="map_canvas"></div>
    </div>
    <div class="contact-form" id="contact_form" >
    <?	if ($message) { ?>
        <h3 class="form-message"><?=$message?></h3>
    <?	} else { ?>
        <div class="g-title">Отправьте нам сообщение</div>
        <form action="#contact_form" method="post" class="form-validate" novalidate>
            <input type="hidden" name="property" value="<?=$_SERVER['HTTP_REFERER']?>">
            <div class="form-field-line">
                <div class="form-field-short">
                    <input type="text" name="name" value="<?=$params['name']?>" placeholder="Ваше имя *" class="form-input-text required<?=$error[1]?' form-input-invalid':''?>">
                </div>
                <div class="form-field-short">
                    <input type="email" name="email" value="<?=$params['email']?>" placeholder="Ваш e-mail *" class="form-input-text required<?=$error[2]?' form-input-invalid':''?>">
                </div>
            </div>
            <textarea name="message" placeholder="Ваше сообщение *" class="form-input-text required<?=$error[3]?' form-input-invalid':''?>"><?=$params['message']?></textarea>
            <button type="submit" value="1" class="form-input-submit g-button">Отправить</button>
        </form>
    <?	} ?>
    </div>
</div>
<?
out_aside();
?>