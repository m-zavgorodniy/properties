<?
if (!$_GET['ajax_inner']) { ?>
<div class="ajax-window">
    <?= $INNER_CONTENT ?>
</div>
<?
} else {
	echo $INNER_CONTENT;
}
?>