<?
$config['DEBUG_ENABLED'] = false;

// properties
$config['DEFAULT_COUNTRY_ID'] = 1; // Russia
$config['DEFAULT_REGION_ID'] = 1; // Moscow Region
$config['DEFAULT_CITY_ID'] = 1; // Moscow City

$config['DIRECTION_ID_PARAMS'] = array(
	1 => array('city' => $config['DEFAULT_CITY_ID']), // Moscow City
	2 => array('region' => $config['DEFAULT_REGION_ID'], 'suburbs' => 1), // Moscow Vicinity
	3 => array('region' => $config['DEFAULT_REGION_ID'], 'city_exclude' => $config['DEFAULT_CITY_ID']), // Moscow Region
	4 => array('country' => $config['DEFAULT_COUNTRY_ID'], 'region_exclude' => $config['DEFAULT_REGION_ID']), // Russia
	5 => array('country_exclude' => $config['DEFAULT_COUNTRY_ID']) // Abroad Russia
);

$config['ACTUAL_LISTING_STATUS_ID'] = 1; // listing with such status is shown on the site

$config['APARTMENT_TYPE_ID'] = 1; // property type: apartment or room
$config['APARTMENT_SUBTYPE_ID'] = 2; // property subtype: self-contained apartment, not a room in apartment
$config['ROOM_SUBTYPE_ID'] = 1; // property subtype: a room in apartment

$config['HOUSE_TYPE_ID'] = 2; // property type: house, townhouse or land plot
$config['PART_OF_HOUSE_SUBTYPE_ID'] = 6; // property subtype: part of a house
$config['LAND_PLOT_SUBTYPE_ID'] = 8; // property subtype: land plot

$config['COMMERCIAL_TYPE_ID'] = 3; // property type: commercial

$config['PROPERTY_TYPE_SALE_ID'] = 1;

// templates

?>