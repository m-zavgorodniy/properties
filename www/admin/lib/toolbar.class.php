<?
class Toolbar {
	function render() {
		if ($this->buttons) { ?>
			<div class="cm-panel">
<?				foreach($this->buttons as $button) {
					$onclick = '';
					if ($button['onclick'])
						$onclick = ' onclick="' . $button['onclick'] . '"';
					else if ($button['edit'])
						$onclick = ' onclick="return openEditWindow(\'' . $button['url'] . '\')"'; ?>
                    
					<a href="<?=$button['url']?>" target="<?=$button['target']?$button['target']:'_blank'?>"<?=$onclick?>>
                    	<img src="<?=$button['icon']?>" alt="" /><?=$button['text']?>
                    </a>
<?				} 
				unset($button); ?>
			</div>
<?		}
	}

	function add_button($url, $icon, $text, $edit = true, $onclick = NULL, $target = NULL) {
		$button['url'] = $url;
		$button['icon'] = $icon;
		$button['text'] = $text;
		$button['edit'] = $edit;
		$button['onclick'] = $onclick;
		$button['target'] = $target;
		$this->buttons[] = $button;
	}
	
	function remove_button($ind) {
		unset($this->buttons[$ind]);
	}
	
	var $buttons;
}
?>