<?
class CustomDoclist extends Doclist {
	
function render() { 
	if ($_GET['mode'] != 'sitetree') { ?>
		<div class="cm-sitetree-menu">
			<a href="?type=container&mode=sitetree">Разделы</a>
		</div>
	<?	parent::render();
	} else { ?>
		<div class="cm-sitetree-menu">
			<a href="?type=container">Меню</a>
		</div>
	
	<?	$this->extra_data_section_types = array();
		$rs = db_mysql_query("SELECT t.id section_type, m.id, m.title_list title FROM meta_table m, section_type t, meta_table2section_type m2t WHERE t.published <> 0 AND m2t.is_in_site_tree <> 0 AND m.id = m2t.meta_table_id AND m2t.section_type_id = t.id AND m.editable <> 0 AND m.id <> 'article' ORDER BY title", $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			$this->extra_data_section_types[$row['section_type']][] = $row;
		}
		mysqli_free_result($rs);
		$this->doc_folder_section_types = array_merge(array_keys($this->extra_data_section_types), array('news', 'doc'));
	
		
		$rs_section = db_mysql_query("SELECT id, title FROM section WHERE section_id IS NULL AND meta_site_id = '" . mysqli_real_escape_string($this->conn, $this->site_id) . "'", $this->conn);
		while ($row = mysqli_fetch_assoc($rs_section)) { //?>
			<div class="cm-container">
				<a href="view.php?type=top_section&id=<?=$row['id']?>" target="content" onclick="window.location.href='doclist.php?type=container&mode=sitetree&view=<?=$row['id']?>#h_section_<?=$row['id']?>';setCurrent(this)" id="section_<?=$row['id']?>"><span><img src="images/icons/bullet_toggle_<?=($row['id']==$g_view or !isset($g_view))?'minus':'plus'?>.png" alt=""></span><?=htmlspecialchars($row['title'])?></a>
			</div>
		<?	// if ($row['id']==$g_view or !isset($g_view)) { ?>
			<div class="cm-sections">
		<? 	
				$this->get_section($row['id']);
		?>
			</div>
		<?	// }
		}
		mysqli_free_result($rs_section);
	}
}
	
	function get_section($section_id, $level = 1, $branch_published = true, $branch_protected = false) {
		$rs_section = db_mysql_query("SELECT s.id, s.title, s.dir, s.published, s.protected, s.section_type_id
			  					FROM section s
			  					WHERE s.section_id = " . $section_id . "
			  					ORDER BY s.sort_num, s.title", $this->conn);
		$is_rows = mysqli_num_rows($rs_section);
		if ($level > SITE_TREE_LEVEL_MAX and $is_rows) { ?>
        	<div class="cm-section-toggle"><a href="#" onclick="toggleSectionFolded('f_section_<?=$section_id?>', this); return false"><img src="images/icons/bullet_toggle_plus.png" alt="" class="cm-toggle"></a></div>
			<div class="cm-section-folded" style="display: none;" id="f_section_<?=$section_id?>">	
<?		}
		while ($row = mysqli_fetch_assoc($rs_section)) {
			
			$really_published = ($row['published'] and $branch_published);
			$really_protected = ($row['protected'] or $branch_protected);
?>
			<div class="cm-section">
            	<div class="cm-section-level cm-section-level<?=$level?>">
            		<a href="view.php?type=section&id=<?=$row['id']?>" target="content" onclick="window.location.hash='h_section_<?=$row['id']?>';setCurrent(this)" id="section_<?=$row['id']?>"><span><img src="images/icons/<?=(in_array($row['section_type_id'], $this->doc_folder_section_types) and !$really_protected)?'folder_page_white':'folder'?><?=$really_protected?'_key':''?><?=$really_published?'':'_grey'?>.png" alt=""></span><?=htmlspecialchars($row['title'])?></a>
                </div>
<?				/*if ($row['section_type_id']=='news' or $row['section_type_id']=='index') {
					$rs_group = db_mysql_query("SELECT f.id, f.name title, f.published
												 FROM news_folder f, news_folder2section nfs
												 WHERE nfs.section_id = " . $row['id'] . "
												 AND f.id = nfs.news_folder_id
												 ORDER BY f.id", $this->conn);
					while ($row_group = mysqli_fetch_assoc($rs_group)) { ?>
	                	<div class="cm-section cm-section-folder">
			            	<a href="view.php?type=news_folder&id=<?=$row_group['id']?>" target="content" onclick="window.location.hash='h_news_folder_<?=$row_group['id']?>';setCurrent(this)" id="news_folder_<?=$row_group['id']?>"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=htmlspecialchars($row_group['title'])?></a>
	                    </div>
<?					}
					mysqli_free_result($rs_group);
				}
				if ($row['section_type_id']=='doc') {
					$rs_group = db_mysql_query("SELECT f.id, f.name title, f.published
												 FROM doc_folder f, doc_folder2section ffs
												 WHERE ffs.section_id = " . $row['id'] . "
												 AND f.id = ffs.doc_folder_id
												 ORDER BY ffs.sort_num, f.id", $this->conn);
					while ($row_group = mysqli_fetch_assoc($rs_group)) { ?>
	                	<div class="cm-section cm-section-folder">
			            	<a href="view.php?type=doc_folder&id=<?=$row_group['id']?>" target="content" onclick="window.location.hash='h_doc_folder_<?=$row_group['id']?>';setCurrent(this)" id="doc_folder_<?=$row_group['id']?>"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=htmlspecialchars($row_group['title'])?></a>
	                    </div>
<?					}
					mysqli_free_result($rs_group);
				}*/
				if (isset($this->extra_data_section_types[$row['section_type_id']])) {
					foreach($this->extra_data_section_types[$row['section_type_id']] as &$meta_table) { 
						if ('news_folder' == $meta_table['id']) {
                            $rs_group = db_mysql_query("SELECT f.id, f.name title, f.published
                                                         FROM news_folder f, news_folder2section nfs
                                                         WHERE nfs.section_id = " . $row['id'] . "
                                                         AND f.id = nfs.news_folder_id
                                                         ORDER BY f.id", $this->conn);
                            while ($row_group = mysqli_fetch_assoc($rs_group)) { ?>
                                <div class="cm-section cm-section-folder">
                                    <a href="viewlist.php?type=news_folder&id=<?=$row_group['id']?>" target="content" onclick="window.location.hash='h_news_folder_<?=$row_group['id']?>';setCurrent(this)" id="news_folder_<?=$row_group['id']?>"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=htmlspecialchars($row_group['title'])?></a>
                                </div>
        <?					}
                            mysqli_free_result($rs_group);
						} else if ('doc_folder' == $meta_table['id']) {
							$rs_group = db_mysql_query("SELECT f.id, f.name title, f.published
														 FROM doc_folder f, doc_folder2section ffs
														 WHERE ffs.section_id = " . $row['id'] . "
														 AND f.id = ffs.doc_folder_id
														 ORDER BY ffs.sort_num, f.id", $this->conn);
							while ($row_group = mysqli_fetch_assoc($rs_group)) { ?>
								<div class="cm-section cm-section-folder">
									<a href="viewlist.php?type=doc_folder&id=<?=$row_group['id']?>" target="content" onclick="window.location.hash='h_doc_folder_<?=$row_group['id']?>';setCurrent(this)" id="doc_folder_<?=$row_group['id']?>"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=htmlspecialchars($row_group['title'])?></a>
								</div>
		<?					}
							mysqli_free_result($rs_group);
						} else if ('banner_folder' == $meta_table['id']) {
							$rs_banner = db_mysql_query("SELECT f.id, f.name title
														 FROM banner_folder f, banner_folder2section bfs
														 WHERE bfs.section_id = " . $row['id'] . "
														 AND f.id = bfs.banner_folder_id
														 ORDER BY f.id", $this->conn);
							while ($row_banner = mysqli_fetch_assoc($rs_banner)) { ?>
								<div class="cm-section cm-section-folder">
									<a href="viewlist.php?type=banner_folder&id=<?=$row_banner['id']?>" target="content" onclick="window.location.hash='h_banner_folder_<?=$row_banner['id']?>';setCurrent(this)" id="banner_folder_<?=$row_banner['id']?>"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=htmlspecialchars($row_banner['title'])?></a>
								</div>
			<?					}
							mysqli_free_result($rs_banner);
						} else { ?>
                        <div class="cm-section cm-section-folder">
                                <a href="list.php?type=<?=$meta_table['id']?>" target="content" onclick="window.location.hash='h_<?=$meta_table['id']?>_folder';setCurrent(this)" id="<?=$meta_table['id']?>_folder"><span><img src="images/icons/page_white_stack.png" alt=""></span><?=$meta_table['title']?></a>
                            </div>
				<?		}
					}
					unset($meta_table); ?>
<?				}
				// use static for branch_published and branch_protected? check it
               	$this->get_section($row['id'], $level+1, $really_published, $really_protected); ?>
            </div>      
<?		}
		if ($level > SITE_TREE_LEVEL_MAX and $is_rows) { ?>
			</div>
<?		}
		mysqli_free_result($rs_section);
	}

var $doc_folder_section_types;
var $extra_data_section_types;

} // class

?>
