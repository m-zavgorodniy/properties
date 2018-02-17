<?
define('PROPERTY_SUBTYPE_ID_APT', 2);

class CustomEditor extends Editor {

	function get_init_input() {
		
		parent::get_init_input();
		
		/*
		$listing_type_conditional_fields = array(
			1 => array('market_type_id', 'deal_type_id', 'mortgage_available'),
			2 => array('price_term_id')
		);
		*/

		$listing_type_conditional_fields = array();
		$rs = db_mysql_query("SELECT t2f.listing_type_id, f.field FROM listing_type2meta_table_field t2f, meta_table_field f WHERE f.id = t2f.meta_table_field_id" , $this->conn);
		while ($row = mysqli_fetch_row($rs)) {
			$listing_type_conditional_fields[$row[0]][] = $row[1];
		}
		mysqli_free_result($rs);
		
		foreach ($listing_type_conditional_fields as $listing_type => &$fields) {
			foreach ($fields as &$field) {
				if ($listing_type != $this->init_params['listing_type_id']) {
					$this->remove_record_meta($field);
				}
			}
			unset($field);
		}
		unset($fields);

	}
	
	function validate_input() {
				
		if (parent::validate_input()) {
			// making $this->input_params['title']
			// it used only to make title_seo - the title on the site is generated on the fly
			$title = array();
	
			$rs = db_mysql_query("SELECT title FROM property_subtype WHERE id = " . $this->input_params['property_subtype_id'], $this->conn);
			while ($row = mysqli_fetch_row($rs)) {
				$title['subtype'] = $row[0];
			}
			mysqli_free_result($rs);
	
			$rs = db_mysql_query("SELECT title FROM loc_city WHERE id = " . $this->input_params['loc_city_id'], $this->conn);
			while ($row = mysqli_fetch_row($rs)) {
				$title['city'] = $row[0];
			}
			mysqli_free_result($rs);
	
			$rs = db_mysql_query("SELECT title FROM loc_metro WHERE id = " . $this->input_params['loc_metro_id'], $this->conn);
			while ($row = mysqli_fetch_row($rs)) {
				$title['metro'] = $row[0];
			}
			mysqli_free_result($rs);
			$rs = db_mysql_query("SELECT title FROM loc_street WHERE id = " . $this->input_params['loc_street_id'], $this->conn);
			while ($row = mysqli_fetch_row($rs)) {
				$title['street'] = $row[0];
			}
			mysqli_free_result($rs);
	
			$this->input_params['title'] = (PROPERTY_TYPE_SALE_ID == $this->input_params['listing_type_id']?'Продается':'Сдается') . ' ' .
				(('' !== $this->input_params['bedrooms'] and PROPERTY_SUBTYPE_ID_APT == $this->input_params['property_subtype_id'])?
					(0 === $this->input_params['bedrooms']?'Студия':$this->input_params['bedrooms'] . '-комнатная квартира'):
						mb_strtolower($title['subtype'], 'UTF-8')
				) . ' ' .
				($this->input_params['loc_city_id']?$title['city']:$this->input_params['address']) . ' ' .
				($this->input_params['loc_metro_id']?$title['metro'] . ' ':'') .
				($this->input_params['loc_street_id']?$title['street'] . ' ':'') .
				preg_replace(array("/[\.,].*$/", "/\D/"), '', $this->input_params['price']) . ' руб';
			return true;
		} else {
			return false;
		}
	}	

	function render() {
		
		// hide the picture's fields and the 'featured' fields for non-admins 
		// *looks hardcoded bro ?>
		
        <style>
			a[href='#block2'], a[href='#block2'] + div {display: none;}
	<?	if (ADMIN_LOGIN != $_SESSION['admin']) { ?>
			a[href='#block3'] {display: none;}
    <?	} ?>
        </style>
<?
		parent::render(); ?>


<?		
	}	
}
?>