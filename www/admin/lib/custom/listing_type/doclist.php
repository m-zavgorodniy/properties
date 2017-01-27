<?
class CustomDoclist extends Doclist {
	
	function render() { 
		parent::render(); ?>

    <?	// ! hardcode for moscowkey
		if (ADMIN_LOGIN == $_SESSION['admin']) { ?>
		<div class="cm-container">
			<a href="viewlist.php?type=listing_type&id=1&import=1" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=sales_import#h_sales_import';setCurrent(this)" id="sales_import"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Продажа (импорт)</a>
		</div>
		<div class="cm-container">
			<a href="viewlist.php?type=listing_type&id=2&import=1" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=rentals_import#h_rentals_import';setCurrent(this)" id="rentals_import"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Аренда (импорт)</a>
		</div>
    <?	} ?>
<?	}
}
?>

