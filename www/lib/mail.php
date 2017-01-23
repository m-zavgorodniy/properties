<?php
//require 'config.php';
require 'mailclass.inc.php';
require "external/csstoinline/css_to_inline_styles.php";

function mail_send($to, $subject, $message, $is_html = false, $file = NULL) {
	global $config;
      
	ob_start(); // suppress output of mailer error messages
	$mailer = new SMTPMailer();
	
	if ($is_html) {
		$mailer->IsHTML(true);

		// convert css to inline styles
		$style_tag_pattern = "/<style[^>]*?>(.*?)<\/style>/si";
		$html = preg_replace($style_tag_pattern, '', $message);
		preg_match_all($style_tag_pattern, $message, $matches);
		$css = implode("\n", $matches[1]);
		
		$cssToInlineStyles = new CSSToInlineStyles();
		$cssToInlineStyles->setHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		$cssToInlineStyles->setCSS($css);
		$message = $cssToInlineStyles->convert();
		
		if ($config['MAIL_CONTENT_EMBED_IMAGES']) {
			// make images inline
			/*
			from http://stackoverflow.com/a/12776782
			
			Google's Bulk Sender Guidelines https://support.google.com/mail/bin/answer.py?hl=en&answer=81126 say that Gmail will automatically show images for senders who have authenticated their domain:
			
			To ensure that Gmail can identify you:
			Use a consistent IP address to send bulk mail.
			Keep valid reverse DNS records for the IP address(es) from which you send mail, pointing to your domain.
			Use the same address in the 'From:' header on every bulk mail you send.
			
			We also recommend publishing an SPF record, and signing with DKIM or DomainKeys. 
			
			By authenticating, inline images you send will be shown automatically. Recipients will not need to click the "Display images below" link.
			
			They offer a page to learn more about email authentication http://support.google.com/mail/bin/answer.py?hl=en&answer=180707.
			*/
	
			preg_match_all('/img.+src=\"?([^\"\s\>]+)/i', $message, $matches);
			$image_matches = $matches[1];
			preg_match_all('/background.+url\(\s*(.+)\s*\)[\s;\}]/i', $message, $matches);
			$image_matches = array_merge($image_matches, $matches[1]);
			foreach ($image_matches as &$image_match) {
				$img_src = trim($image_match, "'\"");
				$img_id = urlencode(str_replace(array('.', '/', '(', ')', "'", '"'), '', $img_src)) . '@' . end(explode('@', $config['MAIL_FROM_EMAIL']));
				$ext = end(explode('.', $img_src));
				switch ($ext) {
					case 'jpg':
					case 'jpeg':
						$img_mime = 'image/jpeg';
						break;
					case 'gif':
						$img_mime = 'image/gif';
						break;
					case 'png':
						$img_mime = 'image/png';
						break;
					case 'bmp':
						$img_mime = 'image/bmp';
						break;
					default:
						$img_mime = 'application/octet-stream';
				}
				// DOCROOT is defined if invoked from CLI script
				// paths starting with '../' come from backoffice, so add '/images/' to DOCROOT just to make such paths working
				$mailer->AddEmbeddedImage((defined('DOCROOT')?DOCROOT . '/images/':'') . $img_src, $img_id, basename($img_src), 'base64', $img_mime);
				$message = preg_replace('/img(.+)src=(\")?' . str_replace('/', '\/', preg_quote($image_match)) . '(\")?/i', "img\\1src=\\2cid:" . $img_id . "\\3", $message);
				$message = preg_replace('/background(.+)url\(\s*' . str_replace('/', '\/', preg_quote($image_match)) . '\s*(\)[\s;\}])/i', "background\\1url(cid:" . $img_id . "\\2", $message);
			}
			unset($img_src);
			$mailer->AltBody = html2txt($message); // not tested
		} else {
			// make paths starting with '/' or '../' absolute ('../' comes from backoffice)
			$message = preg_replace('/img(.+)src=(\")?(\.\.)?\/([^\"\s\>]+)/i', "img\\1src=\\2" . trim($config['MAIL_CONTENT_HTTP_HOST'], "/") . "/\\4", $message);
			$message = preg_replace('/background(.+)url\(\s*(\.\.)?\/(.+)\s*(\)[\s;\}])/i', "background\\1url(" . trim($config['MAIL_CONTENT_HTTP_HOST'], "/") . "/\\3\\4", $message);
		}
	}

	$mailer->Subject = $subject;
	$mailer->Body = $message;
	$mailer->AddAddress($to, $to);

	if (!is_null($file)) {
		if (is_array($file)) {
			$tmp_name = $file['tmp_name'];
			$name = $file['name'];
		} else {
			$tmp_name = $file;
			$name = basename($file);
		}
		if (file_exists($tmp_name)) {
			$mailer->AddAttachment($tmp_name, $name);
		}
	}

	if(!$mailer->Send()) {
		$result = false;
	} else {
		$result = true;
	}
	
	$mailer->ClearAddresses();
	$mailer->ClearAttachments();
	
	if (!$result) {
		$result = ob_get_contents();
	}
	ob_end_clean();
	return $result;
}


function html2txt($document){ // from http://php.net/manual/en/function.strip-tags.php
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript 
    	            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags 
        	        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly 
            	    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
	); 
	$text = preg_replace($search, '', $document); 
	return $text; 
}
?>