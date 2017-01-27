<?
class CustomDoclist extends Doclist {
	
	function render() { ?>

<!--		<div class="cm-container">
			<a href="list.php?type=user&filter=new" target="content" onclick="window.location.href='doclist.php?type=users_group&view=h_all_users#h_new_users';setCurrent(this)" id="new_users"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Новые пользователи</a>
		</div> -->
		<div class="cm-container">
			<a href="list.php?type=user" target="content" onclick="window.location.href='doclist.php?type=users_group&view=h_all_users#h_all_users';setCurrent(this)" id="all_users"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span>Все пользователи</a>
		</div>

<?	parent::render();
	}
}
?>

