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
		<div class="cm-container">
			<a href="list.php?type=listing&filter=listing.property_type_id%3D1" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=apartments#h_apartments';setCurrent(this)" id="apartments"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Жилая недвижимость</a>
		</div>
		<div class="cm-container">
			<a href="list.php?type=listing&filter=listing.property_type_id%3D2" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=vicinity#h_vicinity';setCurrent(this)" id="vicinity"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Загородная недвижимость</a>
		</div>
		<div class="cm-container">
			<a href="list.php?type=listing&filter=listing.market_type_id%3D2" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=development#h_development';setCurrent(this)" id="development"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Новостройки</a>
		</div>
		<div class="cm-container">
			<a href="list.php?type=listing&filter=listing.property_type_id%3D3" target="content" onclick="window.location.href='doclist.php?type=listing_type&view=commercial#h_commercial';setCurrent(this)" id="commercial "><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Коммерческая недвижимость</a>
		</div>
    <?	} ?>
<?	}
}
?>

