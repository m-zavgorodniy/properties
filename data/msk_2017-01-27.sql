-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2017 at 07:11 AM
-- Server version: 5.5.8-CoreSeek
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moscowkey`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

CREATE TABLE `amenity` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `property_type_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amenity`
--

INSERT INTO `amenity` (`id`, `property_type_id`, `title`, `title_en`, `sort_num`, `published`) VALUES
(1, 0, 'Высокие потолки', '', 10, 0),
(2, 0, 'Евроремонт', '', 10, 0),
(3, 0, 'Городской телефон', '', 10, 0),
(4, 0, 'Сигнализация', '', 10, 0),
(5, 0, 'Грузовой лифт', '', 10, 0),
(6, 0, 'Охраняемая территория', '', 10, 0),
(7, 0, 'Детская площадка', '', 10, 0),
(8, 0, 'Машиноместо', '', 10, 0),
(9, 0, 'Развитая инфраструктура', '', 10, 0),
(11, 0, 'После ремонта', '', 10, 0),
(12, 0, 'Рядом с метро', '', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `amenity2listing`
--

CREATE TABLE `amenity2listing` (
  `id` int(10) UNSIGNED NOT NULL,
  `amenity_id` smallint(5) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amenity2listing`
--

INSERT INTO `amenity2listing` (`id`, `amenity_id`, `listing_id`) VALUES
(3, 1, 1),
(4, 3, 1),
(5, 5, 1),
(6, 7, 1),
(7, 2, 1),
(8, 8, 1),
(9, 6, 1),
(10, 9, 1),
(11, 4, 1),
(14, 6, 4),
(21, 8, 5),
(22, 11, 5),
(23, 6, 3),
(24, 6, 2),
(25, 3, 6),
(26, 11, 6),
(27, 9, 6),
(28, 8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `meta_site_lang_id` varchar(40) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `section_id` int(11) NOT NULL,
  `article_type_id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `body` text,
  `body_en` text,
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `meta_site_lang_id`, `meta_site_id`, `section_id`, `article_type_id`, `title`, `title_en`, `body`, `body_en`, `sort_num`, `published`) VALUES
(1, '', '', 2, '', 'Наши услуги', '', '<p>Наши цены на вашей стороне - ведь мы заинтересованы в том, чтобы именно у нас вы нашли подходящее вам предложение.</p>\r\n<p>Список наших объектов недвижимости включает в себя самые новые предложения и постоянно обновляется. Вы всегда можете обратиться к нам за советом или консультацией.</p>\r\n<p>Вы выбираете - все остальное делаем мы!</p>', NULL, 10, 1),
(2, '', '', 15, '', 'Услуга 1', '', 'Описание услуги 1', NULL, 10, 1),
(3, '', '', 17, '', 'Услуга 2', '', 'Описание услуги 2', NULL, 10, 1),
(4, '', '', 18, '', 'Услуга 3', '', 'Описание услуги 3', NULL, 10, 1),
(5, '', '', 13, '', 'Агентство недвижимости МСК Ключ', '', 'Текст об агентстве', NULL, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `article_type`
--

CREATE TABLE `article_type` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `sort_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_type`
--

INSERT INTO `article_type` (`id`, `meta_site_id`, `name`, `sort_num`) VALUES
('', '', 'Основная статья раздела', 10);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `banner_type_id` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `body` text,
  `body_en` text,
  `img_src` varchar(255) DEFAULT NULL,
  `img_src_en` varchar(255) DEFAULT NULL,
  `flash_src` varchar(255) DEFAULT NULL,
  `flash_src_en` varchar(255) DEFAULT NULL,
  `img_src_big` varchar(255) DEFAULT NULL,
  `img_src_big_en` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT NULL,
  `url_title_en` varchar(255) DEFAULT NULL,
  `bg_color` varchar(16) DEFAULT NULL,
  `color_scheme_id` varchar(16) NOT NULL DEFAULT '',
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `banner_type_id`, `title`, `title_en`, `body`, `body_en`, `img_src`, `img_src_en`, `flash_src`, `flash_src_en`, `img_src_big`, `img_src_big_en`, `video_url`, `url`, `url_title`, `url_title_en`, `bg_color`, `color_scheme_id`, `sort_num`, `published`) VALUES
(1, 'property', 'Жилая недвижимость', '', NULL, NULL, '/images/icon_property.gif', NULL, NULL, NULL, NULL, NULL, NULL, '/property/search/?status=1&type=1', NULL, NULL, NULL, '', 10, 1),
(2, 'property', 'Загородная недвижимость', '', NULL, NULL, '/images/icon_house.gif', NULL, NULL, NULL, NULL, NULL, NULL, '/property/search/?status=1&type=2', NULL, NULL, NULL, '', 20, 1),
(3, 'property', 'Аренда', '', NULL, NULL, '/images/icon_rent.gif', NULL, NULL, NULL, NULL, NULL, NULL, '#', NULL, NULL, NULL, '', 30, 0),
(4, 'property', 'Коммерческая недвижимость', '', NULL, NULL, '/images/icon_comm.gif', NULL, NULL, NULL, NULL, NULL, NULL, '/property/search/?status=1&type=3', NULL, NULL, NULL, '', 40, 1),
(5, 'property', 'Зарубежная недвижимость', '', NULL, NULL, '/images/icon_abroad.gif', NULL, NULL, NULL, NULL, NULL, NULL, '/property/search/?status=1&type=1&direction=5&country_exclude=1', NULL, NULL, NULL, '', 60, 1),
(6, 'main', 'Образец', '', NULL, NULL, '/uploads/images/banners/sample.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, 1),
(7, 'property', 'Новостройки', '', NULL, NULL, '/images/icon_new_build.gif', NULL, NULL, NULL, NULL, NULL, NULL, '/property/search/?market_type=2&status=1&type=1', NULL, NULL, NULL, '', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner2section`
--

CREATE TABLE `banner2section` (
  `id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `sort_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banner_type`
--

CREATE TABLE `banner_type` (
  `id` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `w` int(4) NOT NULL,
  `h` int(4) NOT NULL,
  `sort_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner_type`
--

INSERT INTO `banner_type` (`id`, `name`, `w`, `h`, `sort_num`) VALUES
('main', 'На главной странице', 960, 300, 0),
('property', 'Направления недвижимости', 38, 38, 0);

-- --------------------------------------------------------

--
-- Table structure for table `banner_type2section`
--

CREATE TABLE `banner_type2section` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `banner_type_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `building_type`
--

CREATE TABLE `building_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `building_type`
--

INSERT INTO `building_type` (`id`, `title`, `sort_num`, `published`) VALUES
(1, 'Панельный', 10, 1),
(2, '«Сталинский»', 20, 1),
(3, 'Кирпичный', 30, 1),
(4, 'Монолитный', 40, 1),
(5, 'Кирпично-монолитный', 50, 1),
(6, 'Блочный', 60, 1),
(7, 'Деревянный', 70, 1),
(8, 'Щитовой', 80, 1);

-- --------------------------------------------------------

--
-- Table structure for table `color_scheme`
--

CREATE TABLE `color_scheme` (
  `id` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `color_scheme`
--

INSERT INTO `color_scheme` (`id`, `name`) VALUES
('', 'По умолчанию');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `img_src` varchar(255) NOT NULL DEFAULT '',
  `web` varchar(255) DEFAULT NULL,
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `title`, `title_en`, `img_src`, `web`, `sort_num`, `published`) VALUES
(1, 'Банк «Дельта Кредит»', '', '/uploads/images/partners/delta_credit.jpg', NULL, 10, 1),
(2, 'Издательский центр «Мир и Дом»', '', '/uploads/images/partners/mir_dom.gif', NULL, 20, 1),
(3, 'ПАО Сбербанк', '', '/uploads/images/partners/sb.png', NULL, 30, 1),
(4, 'АКБ «ЕНИСЕЙ» (ПАО)', '', '/uploads/images/partners/enisey.png', NULL, 40, 1),
(5, 'Банк ВТБ 24(ПАО)', '', '/uploads/images/partners/vtb24.png', NULL, 50, 1),
(6, '"Газпромбанк" (АО)', '', '/uploads/images/partners/gazprom.png', NULL, 60, 1),
(7, 'АО «Россельхозбанк»', '', '/uploads/images/partners/rosselhoz.png', NULL, 70, 1),
(8, 'ПАО "ТРАНСКАПИТАЛБАНК"', '', '/uploads/images/partners/transkapital.png', NULL, 80, 1),
(9, 'ПАО "Промсвязьбанк"', '', '/uploads/images/partners/promsvyaz.png', NULL, 90, 1),
(10, 'ПАО «Ханты-Мансийский банк Открытие»', '', '/uploads/images/partners/otkrytie.png', NULL, 100, 1),
(11, 'АО"АЛЬФА-БАНК"', '', '/uploads/images/partners/alfa.png', NULL, 110, 1);

-- --------------------------------------------------------

--
-- Table structure for table `container`
--

CREATE TABLE `container` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `sort_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `container`
--

INSERT INTO `container` (`id`, `meta_site_id`, `name`, `sort_num`) VALUES
('main', '', 'Главное меню', 10);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `rate` float NOT NULL DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `title`, `title_en`, `rate`, `sort_num`) VALUES
('', 'руб.', 'rub', 1, 10),
('eur', '€', '€', 60.87, 30),
('usd', '$', '$', 53.37, 20);

-- --------------------------------------------------------

--
-- Table structure for table `deal_type`
--

CREATE TABLE `deal_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deal_type`
--

INSERT INTO `deal_type` (`id`, `title`, `title_en`, `sort_num`) VALUES
(1, 'Свободная продажа', '', 10),
(2, 'Альтернатива', '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `doc`
--

CREATE TABLE `doc` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `doc_folder_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `annotation` text,
  `annotation_en` text,
  `doc_src` varchar(255) NOT NULL DEFAULT '',
  `img_src` varchar(255) DEFAULT NULL,
  `sort_num` int(5) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doc_folder`
--

CREATE TABLE `doc_folder` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doc_folder2section`
--

CREATE TABLE `doc_folder2section` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL DEFAULT '0',
  `doc_folder_id` int(11) NOT NULL DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE `listing` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_type_id` smallint(5) UNSIGNED NOT NULL,
  `property_type_id` smallint(5) UNSIGNED NOT NULL,
  `property_subtype_id` smallint(5) UNSIGNED NOT NULL,
  `loc_country_id` smallint(5) UNSIGNED NOT NULL,
  `loc_region_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_city_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_city_district_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_street_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_project_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_road_id` smallint(5) UNSIGNED DEFAULT NULL,
  `loc_metro_id` smallint(5) UNSIGNED DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `address_en` varchar(255) NOT NULL DEFAULT '',
  `price` int(11) UNSIGNED NOT NULL,
  `currency_id` varchar(16) NOT NULL DEFAULT '',
  `price_term_id` tinyint(1) UNSIGNED DEFAULT NULL,
  `area_total` decimal(11,1) UNSIGNED DEFAULT NULL,
  `img_src` varchar(300) DEFAULT NULL,
  `img_src_thumb` varchar(300) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `body` text,
  `body_en` text,
  `map_latlng` varchar(40) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `listing_status_id` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `featured` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `featured_sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `rating` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `produced` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bedrooms` tinyint(2) UNSIGNED DEFAULT NULL,
  `bathrooms` tinyint(2) UNSIGNED DEFAULT NULL,
  `bathrooms_details` varchar(40) DEFAULT NULL,
  `guest_toilet` tinyint(1) UNSIGNED DEFAULT NULL,
  `area_living` decimal(11,1) UNSIGNED DEFAULT NULL,
  `area_room_details` varchar(40) DEFAULT NULL,
  `area_kitchen` decimal(11,1) UNSIGNED DEFAULT NULL,
  `area_plot` decimal(11,1) UNSIGNED DEFAULT NULL,
  `floor_number` smallint(5) UNSIGNED DEFAULT NULL,
  `floor_count` smallint(5) UNSIGNED DEFAULT NULL,
  `building_type_id` smallint(5) UNSIGNED DEFAULT NULL,
  `lift_details` varchar(40) DEFAULT NULL,
  `balcony_details` varchar(40) DEFAULT NULL,
  `windows_view` varchar(40) DEFAULT NULL,
  `metro_distance_walking` smallint(5) UNSIGNED DEFAULT NULL,
  `metro_distance_transport` smallint(5) UNSIGNED DEFAULT NULL,
  `city_distance` smallint(5) UNSIGNED DEFAULT NULL,
  `market_type_id` smallint(5) UNSIGNED DEFAULT NULL,
  `deal_type_id` smallint(5) UNSIGNED DEFAULT NULL,
  `mortgage_available` tinyint(1) UNSIGNED DEFAULT NULL,
  `title_seo` varchar(255) DEFAULT NULL,
  `agent_source` varchar(40) DEFAULT NULL,
  `agent_ref_no` varchar(40) DEFAULT NULL,
  `agent_ref_url` varchar(255) DEFAULT NULL,
  `agent_id` varchar(40) DEFAULT NULL,
  `agent_name` varchar(40) DEFAULT NULL,
  `agent_phone` varchar(40) DEFAULT NULL,
  `agent_email` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing`
--

INSERT INTO `listing` (`id`, `listing_type_id`, `property_type_id`, `property_subtype_id`, `loc_country_id`, `loc_region_id`, `loc_city_id`, `loc_city_district_id`, `loc_street_id`, `loc_project_id`, `loc_road_id`, `loc_metro_id`, `address`, `address_en`, `price`, `currency_id`, `price_term_id`, `area_total`, `img_src`, `img_src_thumb`, `title`, `title_en`, `body`, `body_en`, `map_latlng`, `contact_phone`, `contact_email`, `user_id`, `listing_status_id`, `featured`, `featured_sort_num`, `rating`, `produced`, `created`, `updated`, `bedrooms`, `bathrooms`, `bathrooms_details`, `guest_toilet`, `area_living`, `area_room_details`, `area_kitchen`, `area_plot`, `floor_number`, `floor_count`, `building_type_id`, `lift_details`, `balcony_details`, `windows_view`, `metro_distance_walking`, `metro_distance_transport`, `city_distance`, `market_type_id`, `deal_type_id`, `mortgage_available`, `title_seo`, `agent_source`, `agent_ref_no`, `agent_ref_url`, `agent_id`, `agent_name`, `agent_phone`, `agent_email`) VALUES
(1, 1, 1, 2, 1, 1, 1, 8, 2, NULL, NULL, 17, 'д.34', '', 27000000, '', NULL, '114.0', '/uploads/images/properties/2015/03/1/.resize/1.450x300.jpg', '/uploads/images/properties/2015/03/1/.resize/1.70x70.jpg', 'Квартира на Мичуринском проспекте, д. 34. Москва, рядом с метро Университет', NULL, '<h3>Дом бизнес-класса разной этажности, собственность недвижимости более 3-х лет. Лучшее предложение квартиры в ЖК Липовая аллея. Мичуринский проспект 34. Прямая продажа, юридически и физически свободна.</h3>\r\n<p>Трехкомнатная квартира с классическим евроремонтом, без перепланировок, кухня с итальянской комплектацией, мебель. Потолок 3м. Сигнализация Гольфстрим. Уникальный двор с ланшафтным дизайном и архитектурным стилем, 3 га с детской и спортивной площадкой, пруд с золотыми рыбками, водопад, фонтан. Огороженная охраняемая территория, гостевая парковка.</p>\r\n<p>Квартира рядом с метро Университет. Метро Раменки в 2014г - в 100 м. Подземный паркинг с шиномонтажем и мойкой. В доме - магазины, салон красоты, медицинский и детский центр, рядом сады и школы. Удобный подъезд. Самая недорогая цена. Полная сумма в договоре купли-продажи. Документы готовы к сделке.</p>', NULL, '55.698597,37.4985969', NULL, NULL, 1, 1, 1, 40, 0, '2015-02-25 00:00:00', '2015-02-24 00:00:00', '2015-05-26 10:43:32', 3, NULL, '1 раздельный + 1 совмещенный', NULL, '65.0', '25,7 + 20,3 + 19,1', '15.0', NULL, 2, 24, 5, NULL, 'Лоджия', '6', NULL, NULL, NULL, 1, 1, 1, 'kvartira-na-michurinskom-prospekte-d-34-moskva-ryadom-s-metro-universitet', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 5, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, 'Одинцовский район, Назарьевский с.о., деревня Солослово, Горки-2', '', 1250000, 'usd', NULL, '380.0', '/uploads/images/properties/2015/03/2/.resize/20.450x300.jpg', '/uploads/images/properties/2015/03/2/.resize/20.70x70.jpg', 'Дом на Рублевке в Одинцовском районе. Деревня Солослово, Горки 2', NULL, '<h3>Рублёво-Успенское шоссе, 17 км от МКАД. Элитный дом на Рублевке.</h3>\r\n<p>Продается большой 4-х уровневый меблированный новый коттедж 380 кв. м. и дом 65 кв. м., ИЖС, на участке 20 соток с ландшафтным дизайном, где произрастает 300 видов деревьев (липы, сосны, голубые ели, кедры, лиственницы). Все коммуникации заведены и подключены. Дом отапливается газом. Мощность электричества 15 кВт (возможно увеличение).</p>\r\n<p>Уникальное и красивое место. Асфальтированный проезд до самого дома. Бассейн 5х3, сауна. Очистные сооружения Топаз. Охрана, видеодомофон. Возможна ипотека. Это идеальное предложение по стоимости дома на Рублевке.</p>', NULL, NULL, '+7 917 514-5044', NULL, 1, 1, 1, 10, 0, '2015-02-25 00:00:00', '2015-02-24 00:00:00', '2015-03-18 16:44:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20.0', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, 17, NULL, NULL, 1, 'dom-na-rublevke-v-odintsovskom-rayone-derevnya-soloslovo-gorki-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 2, 5, 1, 1, 2, NULL, NULL, NULL, 2, NULL, 'Одинцовский район, деревня Петелино', '', 8500000, '', NULL, '250.0', '/uploads/images/properties/2015/03/3/.resize/4.450x300.jpg', '/uploads/images/properties/2015/03/3/.resize/4.70x70.jpg', 'Дом в Петелино в Одинцовском районе Московской области', NULL, '<h3>Минское шоссе, 32 км от МКАД. Лучшая недвижимость под ключ в Московской области.</h3>\r\n<p>Продажа жилья в Одинцовском районе. Загородняя недвижимость для круглогодичного проживания  250 кв.м. в охраняемом с/т. 1 этаж: каминный зал, бильярдная, кухня, спортзал, с/узел, сауна с купелью. 2 этаж: 3 спальни (20+16+15), комната отдыха, с/узел с ванной, лоджия. Полы с подогревом.</p>\r\n<p>На 2-ом этаже расположен Бразильский сад: терраса летняя 56 кв.м. Стеклопакеты, электронное управление температурным режимом, круглогодичный подъезд. Итальянский дворик (50 кв. м) с барбекю. Крытый бассейн 50 кв. м.</p>\r\n<p>Участок 14 соток с лесными деревьями, собственным прудом для рыбалки и купания 13х6м, беседкой, тиром (ночным), фонтаном, детской и волейбольной площадкой. Художественное вечернее освещение.</p>\r\n<p>Коммуникации: электричество – 40 кВт(3х фазный счетчик), водоснабжение - инд. скважина 100 метров,  водонагреватели 2шт. на 200л каждый. Канализация - септик.</p>\r\n<p>В собственности с 2005 года. В доме светло и тепло. Лучшая цена дома в Одинцовском районе.</p>', NULL, NULL, '+7 917 514-5044', NULL, 1, 1, 1, 30, 0, '2015-03-10 00:00:00', '0000-00-00 00:00:00', '2015-06-17 11:54:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14.0', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'dom-v-petelino-odintsovskom-rayone-moskovskoy-oblasti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 2, 5, 1, 1, 1, 9, 1, NULL, NULL, 21, 'дом 27, корп. 21', '', 295000000, '', NULL, '1000.0', '/uploads/images/properties/2015/03/4/.resize/01.450x300.jpg', '/uploads/images/properties/2015/03/4/.resize/01.70x70.jpg', 'Дом на Куркинском шоссе рядом с метро Планерная', NULL, '<h3>Дом 1000 кв. м + собственный спортивный комплекс + спа центр 250 кв. м. Предлагаем купить элитный дом с зимним садом. Недвижимость вашей мечты</h3>\r\n<p>Участок 42 сот в частной собственности. Меблирован, центральные коммуникации, отдельный въезд, кухня-столовая + гостиная, 6 спален, кабинет, библиотека, мансарда с балконом, 5 с/у.\r\n<p>Зимний сад, бассейн, сауна, кинозал, холл, прачечный комплекс, дизельная станция. Приточно-вытяжная система кондиционирования, теплые полы, встроенный пылесос. Ремонт 2012 года. Летняя кухня. Охрана, 2 м/м в гараже, гостевая автостоянка. Фруктовый сад, пруд, артезианская скважина.</p>', NULL, '55.88512029172457, 37.38745093345642', '+7 917 514-5044', NULL, 1, 1, 1, 20, 0, '2015-03-10 00:00:00', '0000-00-00 00:00:00', '2015-05-26 10:43:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '42.0', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'dom-na-kurkinskom-shosse-ryadom-s-metro-planernaya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 1, 2, 2, NULL, 4, NULL, NULL, NULL, NULL, NULL, 'Budapest 14', '', 5300000, '', NULL, '63.0', '/uploads/images/properties/2015/03/5/.resize/01.450x300.jpg', '/uploads/images/properties/2015/03/5/.resize/01.70x70.jpg', 'Продается трехкомнатная квартира в Будапеште', NULL, '<h3>Квартира для бизнеса и отдыха, до метро «Ors veser tere» 3  мин пешком.</h3>\r\n<p>Зеленый район Budapest 14. После ремонта. Магазины АБС парикмахерские, салоны. Рядом торговые центры – Arkad, Obi, Ikea, Tesco, Kaizer. Оформлено на действующую 18-ти летнюю фирму (с полной бухгалтерией), что даёт возможность получить кредит в Венгрии и Европе. Бухгалтер  и адвокат  русскоговорящие.</p>', NULL, NULL, '+7 499 743-0307', NULL, 1, 1, 1, 50, 0, '2015-03-10 00:00:00', '0000-00-00 00:00:00', '2015-03-18 16:43:26', 3, NULL, NULL, NULL, '58.0', NULL, NULL, NULL, 5, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'prodaetsya-trehkomnatnaya-kvartira-v-budapeshte', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 1, 2, 1, 2, 5, NULL, NULL, NULL, NULL, NULL, 'ул. Гурьянова, д. 29', '', 3000000, '', NULL, '60.0', '/uploads/images/properties/2015/03/6/.resize/01.450x300.jpg', '/uploads/images/properties/2015/03/6/.resize/01.70x70.jpg', 'Продается двухкомнатная квартира в Калуге', NULL, '<p>Удобная квартира с собственным отдельным входом после  капитального ремонта: проводка, сантехника, автономное газовое отопление, тёплые полы, видеонаблюдение. Санузел и комнаты раздельные, лоджия застеклённая 5 кв. м, окна - пластик, решётки. Этаж высокий. Рядом машиноместо, вся инфраструктура: школа, детсад, остановка, магазины, Дом культуры. Возможно использовать в коммерческих целях и сделать второй отдельный вход.</p>', NULL, '54.566962,36.235306', '+7 917 514-5044', NULL, 1, 1, 1, 60, 0, '2015-03-10 00:00:00', '0000-00-00 00:00:00', '2015-04-19 10:47:50', 2, NULL, 'Раздельный', NULL, '25.0', '15 + 10', '11.0', NULL, 1, 2, 3, NULL, 'Лоджия', '6', NULL, NULL, NULL, 1, 1, 1, 'prodaetsya-dvuhkomnatnaya-kvartira-v-kaluge', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 1, 2, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, 'МК "Западный" корп. 28', '', 3730000, '', NULL, '111.2', NULL, NULL, '2-комнатная квартира в Домодедово', NULL, 'Комната 21,9 с эркером. Холл 6,5 кв м, отличный вид на лесной массив. Завершение строительства I квартал 2015 года, заселение - III квартал 2015 года.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-12 00:00:00', '0000-00-00 00:00:00', '2015-07-29 14:19:00', 2, NULL, NULL, NULL, '32.7', '21.9+10.8', '8.1', NULL, 13, 17, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, '2-komnatnaya-kvartira-v-domodedovo', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 1, 2, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, 'МК Первомайский корп.3', '', 3000000, '', NULL, '89.0', NULL, NULL, '3-комнатная квартира в Павловском Посаде', NULL, 'Осталась ЕДИНСТВЕННАЯ квартира в доме!!! Квартира с полным ремонтом. Заселение –\r\nII квартал 2015 года. В квартире кладовая или гардеробная, распашонка. Холл 7 кв м.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 09:28:21', 3, NULL, NULL, NULL, '60.8', '27,5+20,31+13,03', '12.0', NULL, 17, 17, 1, NULL, 'Заст. Лоджия', NULL, NULL, NULL, NULL, 2, NULL, 0, '3-komnatnaya-kvartira-v-pavlovskom-posade', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 1, 2, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, 'ул.  1 го Мая 1-й Пер 1 го Мая,  корп. 4', '', 3380000, '', NULL, '89.0', NULL, NULL, '3-комнатная квартира в Павловском Посаде', NULL, 'Дом закончен, Кладовая или гардеробная присутствуют, на две стороны окна. Чудесный вид! Машиноместо для Вашего автомобиля. Холл 7 кв м.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 09:33:10', 3, NULL, NULL, NULL, '60.8', '27,5+20,31+13,03', '12.0', NULL, 14, 17, 1, NULL, 'Заст. Лоджия', NULL, NULL, NULL, NULL, 2, NULL, 0, '9-3-komnatnaya-kvartira-v-pavlovskom-posade', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 1, 2, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, 'ул.  1 го Мая 1-й Пер 1 го Мая,  корп. 4', '', 2500000, '', NULL, '61.6', NULL, NULL, '2-комнатная квартира в Павловском Посаде', NULL, 'Дом закончен, Кладовая или гардеробная присутствуют, на две стороны окна. Чудесный вид! Машиноместо для Вашего автомобиля имеется. Холл 7 кв. м. Вся городская инфраструктура.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 09:36:52', 2, NULL, NULL, NULL, '33.3', '20,31+12,03', '11.9', NULL, 15, 17, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, '2-komnatnaya-kvartira-v-pavlovskom-posade', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 1, 2, 1, 1, 13, NULL, NULL, NULL, NULL, NULL, 'ул. Чехова, Корп. 16', '', 2382000, '', NULL, '61.8', NULL, NULL, '2-комнатная квартира в г. Старая Купавна', NULL, 'Окна на две стороны. Балкон  4 кв м застеклён. Имеется гардеробная комната. Сейчас строятся верхние этажи, сдача дома во II-ом  квартале 2015 года. Вся городская инфраструктура, спортивный комплекс с бассейном.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 09:42:07', 2, NULL, NULL, NULL, '29.1', '16,9+12,23', '11.7', NULL, 14, 17, 1, NULL, 'Балкон 4 кв м застеклён', '5', NULL, NULL, NULL, 2, NULL, 0, '2-komnatnaya-kvartira-v-g-staraya-kupavna', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 1, 2, 1, 1, 14, NULL, NULL, NULL, NULL, NULL, 'р-н Восточный, микрорайон 2,3 корп. 10', '', 1370000, '', NULL, '25.7', NULL, NULL, 'Квартира-студия в Звенигороде', NULL, 'Русская Швейцария для ВАС!!! Есть квартиры разной площади. МКР"Восточный-2,3", корп. 10. Квартира-студия! В шаговой доступности от ВАС: собственная школа, ясли-сад, дворец спорта "Звезда" (с 25-метровым бассейном, тренажерным и фехтовальным залами), академия дзюдо. Всего в 700 метрах расположен оборудованный горнолыжный спуск с подъемником. Рядом Собор Александра Невского и Звенигородский кремль, а в 500 метрах от дома находится особо охраняемая природная территория - памятник природы "Мозжинский овраг". Есть городской пляж.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 09:52:48', 0, NULL, NULL, NULL, '17.7', NULL, NULL, NULL, 15, 17, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, '1-komnatnaya-kvartira-studiya-v-zvenigorode', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 1, 2, 1, 1, 14, NULL, NULL, NULL, NULL, NULL, 'р-н Восточный, микрорайон 2,3 корп. 15', '', 2600000, '', NULL, '25.7', NULL, NULL, '2-комнатная квартира в Звенигороде', NULL, 'Русская Швейцария для ВАС!!! Есть квартиры разной площади. МКР"Восточный-2,3", корп. 10. Квартира-студия! В шаговой доступности от ВАС: собственная школа, ясли-сад, дворец спорта "Звезда" (с 25-метровым бассейном, тренажерным и фехтовальным залами), академия дзюдо. Всего в 700 метрах расположен оборудованный горнолыжный спуск с подъемником. Рядом Собор Александра Невского и Звенигородский кремль, а в 500 метрах от дома находится особо охраняемая природная территория - памятник природы "Мозжинский овраг". Есть городской пляж.', NULL, NULL, '+7 915 131-74-23', NULL, 1, 1, 0, 10, 0, '2015-06-18 00:00:00', '0000-00-00 00:00:00', '2015-06-18 10:03:32', 2, NULL, NULL, NULL, '17.7', NULL, NULL, NULL, 15, 17, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, '2-komnatnaya-kvartira-v-zvenigorode', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 1, 5, 1, NULL, 1, NULL, 14, NULL, NULL, NULL, 'wewe', '', 2321312, '', NULL, '111.0', NULL, NULL, 'Продается дом, Москва, 2 321 312 руб.', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 0, 10, 0, '2015-07-15 00:00:00', '0000-00-00 00:00:00', '2015-07-27 17:28:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'vbvbvb', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 1, 2, 1, 1, 1, NULL, NULL, NULL, NULL, 558, '', '', 11123, '', NULL, '323.0', '/uploads/images/properties/2016/09/18/.resize/kvartira-moskva-ulica-vvedenskogo-156425911-1.450x300.jpg', '/uploads/images/properties/2016/09/18/.resize/kvartira-moskva-ulica-vvedenskogo-156425911-1.70x70.jpg', 'Продается квартира Москва Алтуфьево 11123 руб', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 10, 0, '2015-07-29 00:00:00', '0000-00-00 00:00:00', '2016-09-02 23:06:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'prodaetsya-kvartira-moskva-altufevo-11123-rub', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `listing_image`
--

CREATE TABLE `listing_image` (
  `id` int(11) UNSIGNED NOT NULL,
  `meta_table_id` varchar(40) NOT NULL,
  `listing_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `img_src` varchar(255) NOT NULL,
  `img_src_thumb` varchar(255) DEFAULT NULL,
  `img_src_original` varchar(255) DEFAULT NULL,
  `sort_num` int(5) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing_image`
--

INSERT INTO `listing_image` (`id`, `meta_table_id`, `listing_id`, `title`, `title_en`, `img_src`, `img_src_thumb`, `img_src_original`, `sort_num`, `published`) VALUES
(1, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/20.jpg', '/uploads/images/properties/2015/03/2/20_tn.jpg', '/uploads/images/properties/2015/03/2/20.jpg', 10, 1),
(2, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/22.jpg', '/uploads/images/properties/2015/03/2/22_tn.jpg', '/uploads/images/properties/2015/03/2/22.jpg', 20, 1),
(3, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/23.jpg', '/uploads/images/properties/2015/03/2/23_tn.jpg', '/uploads/images/properties/2015/03/2/23.jpg', 30, 1),
(4, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/24.jpg', '/uploads/images/properties/2015/03/2/24_tn.jpg', '/uploads/images/properties/2015/03/2/24.jpg', 40, 1),
(5, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/12.jpg', '/uploads/images/properties/2015/03/2/12_tn.jpg', '/uploads/images/properties/2015/03/2/12.jpg', 50, 1),
(6, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/17.jpg', '/uploads/images/properties/2015/03/2/17_tn.jpg', '/uploads/images/properties/2015/03/2/17.jpg', 60, 1),
(7, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/1.jpg', '/uploads/images/properties/2015/03/2/1_tn.jpg', '/uploads/images/properties/2015/03/2/1.jpg', 70, 1),
(8, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/2.jpg', '/uploads/images/properties/2015/03/2/2_tn.jpg', '/uploads/images/properties/2015/03/2/2.jpg', 80, 1),
(9, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/3.jpg', '/uploads/images/properties/2015/03/2/3_tn.jpg', '/uploads/images/properties/2015/03/2/3.jpg', 90, 1),
(10, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/4.jpg', '/uploads/images/properties/2015/03/2/4_tn.jpg', '/uploads/images/properties/2015/03/2/4.jpg', 100, 1),
(11, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/5.jpg', '/uploads/images/properties/2015/03/2/5_tn.jpg', '/uploads/images/properties/2015/03/2/5.jpg', 110, 1),
(12, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/6.jpg', '/uploads/images/properties/2015/03/2/6_tn.jpg', '/uploads/images/properties/2015/03/2/6.jpg', 120, 1),
(13, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/7.jpg', '/uploads/images/properties/2015/03/2/7_tn.jpg', '/uploads/images/properties/2015/03/2/7.jpg', 130, 1),
(14, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/8.jpg', '/uploads/images/properties/2015/03/2/8_tn.jpg', '/uploads/images/properties/2015/03/2/8.jpg', 140, 1),
(15, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/9.jpg', '/uploads/images/properties/2015/03/2/9_tn.jpg', '/uploads/images/properties/2015/03/2/9.jpg', 150, 1),
(16, 'listing_image', 2, NULL, NULL, '/uploads/images/properties/2015/03/2/10.jpg', '/uploads/images/properties/2015/03/2/10_tn.jpg', '/uploads/images/properties/2015/03/2/10.jpg', 160, 1),
(17, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/1.jpg', '/uploads/images/properties/2015/03/1/1_tn.jpg', '/uploads/images/properties/2015/03/1/1.jpg', 10, 1),
(18, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/2.jpg', '/uploads/images/properties/2015/03/1/2_tn.jpg', '/uploads/images/properties/2015/03/1/2.jpg', 20, 1),
(19, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/3.jpg', '/uploads/images/properties/2015/03/1/3_tn.jpg', '/uploads/images/properties/2015/03/1/3.jpg', 30, 1),
(20, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/4.jpg', '/uploads/images/properties/2015/03/1/4_tn.jpg', '/uploads/images/properties/2015/03/1/4.jpg', 40, 1),
(21, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/5.jpg', '/uploads/images/properties/2015/03/1/5_tn.jpg', '/uploads/images/properties/2015/03/1/5.jpg', 50, 1),
(22, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/6.jpg', '/uploads/images/properties/2015/03/1/6_tn.jpg', '/uploads/images/properties/2015/03/1/6.jpg', 60, 1),
(23, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/7.jpg', '/uploads/images/properties/2015/03/1/7_tn.jpg', '/uploads/images/properties/2015/03/1/7.jpg', 70, 1),
(24, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/8.jpg', '/uploads/images/properties/2015/03/1/8_tn.jpg', '/uploads/images/properties/2015/03/1/8.jpg', 80, 1),
(25, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/9.jpg', '/uploads/images/properties/2015/03/1/9_tn.jpg', '/uploads/images/properties/2015/03/1/9.jpg', 90, 1),
(26, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/10.jpg', '/uploads/images/properties/2015/03/1/10_tn.jpg', '/uploads/images/properties/2015/03/1/10.jpg', 100, 1),
(27, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/11.jpg', '/uploads/images/properties/2015/03/1/11_tn.jpg', '/uploads/images/properties/2015/03/1/11.jpg', 110, 1),
(28, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/12.jpg', '/uploads/images/properties/2015/03/1/12_tn.jpg', '/uploads/images/properties/2015/03/1/12.jpg', 120, 1),
(29, 'listing_image', 1, NULL, NULL, '/uploads/images/properties/2015/03/1/13.jpg', '/uploads/images/properties/2015/03/1/13_tn.jpg', '/uploads/images/properties/2015/03/1/13.jpg', 130, 1),
(30, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/4.jpg', '/uploads/images/properties/2015/03/3/4_tn.jpg', '/uploads/images/properties/2015/03/3/4.jpg', 10, 1),
(31, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/5.jpg', '/uploads/images/properties/2015/03/3/5_tn.jpg', '/uploads/images/properties/2015/03/3/5.jpg', 20, 1),
(32, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/6.jpg', '/uploads/images/properties/2015/03/3/6_tn.jpg', '/uploads/images/properties/2015/03/3/6.jpg', 30, 1),
(33, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/7.jpg', '/uploads/images/properties/2015/03/3/7_tn.jpg', '/uploads/images/properties/2015/03/3/7.jpg', 40, 1),
(34, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/1.jpg', '/uploads/images/properties/2015/03/3/1_tn.jpg', '/uploads/images/properties/2015/03/3/1.jpg', 50, 1),
(35, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/2.jpg', '/uploads/images/properties/2015/03/3/2_tn.jpg', '/uploads/images/properties/2015/03/3/2.jpg', 60, 1),
(36, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/3.jpg', '/uploads/images/properties/2015/03/3/3_tn.jpg', '/uploads/images/properties/2015/03/3/3.jpg', 70, 1),
(37, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/9.jpg', '/uploads/images/properties/2015/03/3/9_tn.jpg', '/uploads/images/properties/2015/03/3/9.jpg', 80, 1),
(38, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/8.jpg', '/uploads/images/properties/2015/03/3/8_tn.jpg', '/uploads/images/properties/2015/03/3/8.jpg', 90, 1),
(39, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/10.jpg', '/uploads/images/properties/2015/03/3/10_tn.jpg', '/uploads/images/properties/2015/03/3/10.jpg', 100, 1),
(40, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/11.jpg', '/uploads/images/properties/2015/03/3/11_tn.jpg', '/uploads/images/properties/2015/03/3/11.jpg', 110, 1),
(41, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/12.jpg', '/uploads/images/properties/2015/03/3/12_tn.jpg', '/uploads/images/properties/2015/03/3/12.jpg', 120, 1),
(42, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/13.jpg', '/uploads/images/properties/2015/03/3/13_tn.jpg', '/uploads/images/properties/2015/03/3/13.jpg', 130, 1),
(43, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/14.jpg', '/uploads/images/properties/2015/03/3/14_tn.jpg', '/uploads/images/properties/2015/03/3/14.jpg', 140, 1),
(44, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/15.jpg', '/uploads/images/properties/2015/03/3/15_tn.jpg', '/uploads/images/properties/2015/03/3/15.jpg', 150, 1),
(45, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/16.jpg', '/uploads/images/properties/2015/03/3/16_tn.jpg', '/uploads/images/properties/2015/03/3/16.jpg', 160, 1),
(46, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/17.jpg', '/uploads/images/properties/2015/03/3/17_tn.jpg', '/uploads/images/properties/2015/03/3/17.jpg', 170, 1),
(47, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/18.jpg', '/uploads/images/properties/2015/03/3/18_tn.jpg', '/uploads/images/properties/2015/03/3/18.jpg', 180, 1),
(48, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/19.jpg', '/uploads/images/properties/2015/03/3/19_tn.jpg', '/uploads/images/properties/2015/03/3/19.jpg', 190, 1),
(49, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/20.jpg', '/uploads/images/properties/2015/03/3/20_tn.jpg', '/uploads/images/properties/2015/03/3/20.jpg', 200, 1),
(50, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/21.jpg', '/uploads/images/properties/2015/03/3/21_tn.jpg', '/uploads/images/properties/2015/03/3/21.jpg', 210, 1),
(51, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/22.jpg', '/uploads/images/properties/2015/03/3/22_tn.jpg', '/uploads/images/properties/2015/03/3/22.jpg', 220, 1),
(52, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/23.jpg', '/uploads/images/properties/2015/03/3/23_tn.jpg', '/uploads/images/properties/2015/03/3/23.jpg', 230, 1),
(53, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/24.jpg', '/uploads/images/properties/2015/03/3/24_tn.jpg', '/uploads/images/properties/2015/03/3/24.jpg', 240, 1),
(54, 'listing_image', 3, NULL, NULL, '/uploads/images/properties/2015/03/3/25.jpg', '/uploads/images/properties/2015/03/3/25_tn.jpg', '/uploads/images/properties/2015/03/3/25.jpg', 250, 1),
(55, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/01.jpg', '/uploads/images/properties/2015/03/4/01_tn.jpg', '/uploads/images/properties/2015/03/4/01.jpg', 10, 1),
(56, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/02.jpg', '/uploads/images/properties/2015/03/4/02_tn.jpg', '/uploads/images/properties/2015/03/4/02.jpg', 20, 1),
(57, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/03.jpg', '/uploads/images/properties/2015/03/4/03_tn.jpg', '/uploads/images/properties/2015/03/4/03.jpg', 30, 1),
(58, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/05.jpg', '/uploads/images/properties/2015/03/4/05_tn.jpg', '/uploads/images/properties/2015/03/4/05.jpg', 40, 1),
(59, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/06.jpg', '/uploads/images/properties/2015/03/4/06_tn.jpg', '/uploads/images/properties/2015/03/4/06.jpg', 50, 1),
(60, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/07.jpg', '/uploads/images/properties/2015/03/4/07_tn.jpg', '/uploads/images/properties/2015/03/4/07.jpg', 60, 1),
(61, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/08.jpg', '/uploads/images/properties/2015/03/4/08_tn.jpg', '/uploads/images/properties/2015/03/4/08.jpg', 70, 1),
(62, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/10.jpg', '/uploads/images/properties/2015/03/4/10_tn.jpg', '/uploads/images/properties/2015/03/4/10.jpg', 80, 1),
(63, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/11.jpg', '/uploads/images/properties/2015/03/4/11_tn.jpg', '/uploads/images/properties/2015/03/4/11.jpg', 90, 1),
(64, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/12.jpg', '/uploads/images/properties/2015/03/4/12_tn.jpg', '/uploads/images/properties/2015/03/4/12.jpg', 100, 1),
(65, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/13.jpg', '/uploads/images/properties/2015/03/4/13_tn.jpg', '/uploads/images/properties/2015/03/4/13.jpg', 110, 1),
(66, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/14.jpg', '/uploads/images/properties/2015/03/4/14_tn.jpg', '/uploads/images/properties/2015/03/4/14.jpg', 120, 1),
(67, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/15.jpg', '/uploads/images/properties/2015/03/4/15_tn.jpg', '/uploads/images/properties/2015/03/4/15.jpg', 130, 1),
(68, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/16.jpg', '/uploads/images/properties/2015/03/4/16_tn.jpg', '/uploads/images/properties/2015/03/4/16.jpg', 140, 1),
(69, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/17.jpg', '/uploads/images/properties/2015/03/4/17_tn.jpg', '/uploads/images/properties/2015/03/4/17.jpg', 150, 1),
(70, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/18.jpg', '/uploads/images/properties/2015/03/4/18_tn.jpg', '/uploads/images/properties/2015/03/4/18.jpg', 160, 1),
(71, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/19.jpg', '/uploads/images/properties/2015/03/4/19_tn.jpg', '/uploads/images/properties/2015/03/4/19.jpg', 170, 1),
(72, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/20.jpg', '/uploads/images/properties/2015/03/4/20_tn.jpg', '/uploads/images/properties/2015/03/4/20.jpg', 180, 1),
(73, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/21.jpg', '/uploads/images/properties/2015/03/4/21_tn.jpg', '/uploads/images/properties/2015/03/4/21.jpg', 190, 1),
(74, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/22.jpg', '/uploads/images/properties/2015/03/4/22_tn.jpg', '/uploads/images/properties/2015/03/4/22.jpg', 200, 1),
(75, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/23.jpg', '/uploads/images/properties/2015/03/4/23_tn.jpg', '/uploads/images/properties/2015/03/4/23.jpg', 210, 1),
(76, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/24.jpg', '/uploads/images/properties/2015/03/4/24_tn.jpg', '/uploads/images/properties/2015/03/4/24.jpg', 220, 1),
(77, 'listing_image', 4, NULL, NULL, '/uploads/images/properties/2015/03/4/25.jpg', '/uploads/images/properties/2015/03/4/25_tn.jpg', '/uploads/images/properties/2015/03/4/25.jpg', 230, 1),
(78, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/01.jpg', '/uploads/images/properties/2015/03/5/01_tn.jpg', '/uploads/images/properties/2015/03/5/01.jpg', 10, 1),
(79, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/02.jpg', '/uploads/images/properties/2015/03/5/02_tn.jpg', '/uploads/images/properties/2015/03/5/02.jpg', 20, 1),
(80, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/03.jpg', '/uploads/images/properties/2015/03/5/03_tn.jpg', '/uploads/images/properties/2015/03/5/03.jpg', 30, 1),
(81, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/04.jpg', '/uploads/images/properties/2015/03/5/04_tn.jpg', '/uploads/images/properties/2015/03/5/04.jpg', 40, 1),
(82, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/05.jpg', '/uploads/images/properties/2015/03/5/05_tn.jpg', '/uploads/images/properties/2015/03/5/05.jpg', 50, 1),
(83, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/06.jpg', '/uploads/images/properties/2015/03/5/06_tn.jpg', '/uploads/images/properties/2015/03/5/06.jpg', 60, 1),
(84, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/07.jpg', '/uploads/images/properties/2015/03/5/07_tn.jpg', '/uploads/images/properties/2015/03/5/07.jpg', 70, 1),
(85, 'listing_image', 5, NULL, NULL, '/uploads/images/properties/2015/03/5/08.jpg', '/uploads/images/properties/2015/03/5/08_tn.jpg', '/uploads/images/properties/2015/03/5/08.jpg', 80, 1),
(86, 'listing_image', 6, NULL, NULL, '/uploads/images/properties/2015/03/6/01.jpg', '/uploads/images/properties/2015/03/6/01_tn.jpg', '/uploads/images/properties/2015/03/6/01.jpg', 10, 1),
(87, 'listing_image', 6, NULL, NULL, '/uploads/images/properties/2015/03/6/02.jpg', '/uploads/images/properties/2015/03/6/02_tn.jpg', '/uploads/images/properties/2015/03/6/02.jpg', 20, 1),
(88, 'listing_image', 6, NULL, NULL, '/uploads/images/properties/2015/03/6/03.jpg', '/uploads/images/properties/2015/03/6/03_tn.jpg', '/uploads/images/properties/2015/03/6/03.jpg', 30, 1),
(89, 'listing_image', 6, NULL, NULL, '/uploads/images/properties/2015/03/6/04.jpg', '/uploads/images/properties/2015/03/6/04_tn.jpg', '/uploads/images/properties/2015/03/6/04.jpg', 40, 1),
(90, 'listing_image', 6, NULL, NULL, '/uploads/images/properties/2015/03/6/05.jpg', '/uploads/images/properties/2015/03/6/05_tn.jpg', '/uploads/images/properties/2015/03/6/05.jpg', 50, 1),
(91, 'listing_image', 18, NULL, NULL, '/uploads/images/properties/2016/09/18/.resize/kvartira-moskva-ulica-vvedenskogo-156425911-1.376x566.jpg', '/uploads/images/properties/2016/09/18/.resize/kvartira-moskva-ulica-vvedenskogo-156425911-1.173x115.jpg', '/uploads/images/properties/2016/09/18/kvartira-moskva-ulica-vvedenskogo-156425911-1.jpg', 10, 1),
(92, 'listing_plan', 18, NULL, NULL, '', '/uploads/images/plan/.resize/3_Razmeshenie_obekta_JK_Pervomaiskii.173x115.jpg', '/uploads/images/plan/3_Razmeshenie_obekta_JK_Pervomaiskii.jpg', 10, 1),
(93, 'listing_plan', 18, NULL, NULL, '', '/uploads/images/plan/.resize/PLANIROVKA_ETAJA.173x115.jpg', '/uploads/images/plan/PLANIROVKA_ETAJA.jpg', 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `listing_status`
--

CREATE TABLE `listing_status` (
  `id` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing_status`
--

INSERT INTO `listing_status` (`id`, `title`, `sort_num`) VALUES
(0, 'Новое', 10),
(1, 'На сайте', 20),
(255, 'Удалено', 30);

-- --------------------------------------------------------

--
-- Table structure for table `listing_type`
--

CREATE TABLE `listing_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing_type`
--

INSERT INTO `listing_type` (`id`, `title`, `title_en`, `sort_num`, `title_seo`) VALUES
(1, 'Продажа', 'Sale', 10, 'prodazha'),
(2, 'Аренда', 'Rent', 20, 'arenda');

-- --------------------------------------------------------

--
-- Table structure for table `listing_type2meta_table_field`
--

CREATE TABLE `listing_type2meta_table_field` (
  `listing_type_id` smallint(5) UNSIGNED NOT NULL,
  `meta_table_field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing_type2meta_table_field`
--

INSERT INTO `listing_type2meta_table_field` (`listing_type_id`, `meta_table_field_id`) VALUES
(1, 3838),
(1, 3839),
(1, 3840),
(2, 3853);

-- --------------------------------------------------------

--
-- Table structure for table `listing_video`
--

CREATE TABLE `listing_video` (
  `id` int(11) UNSIGNED NOT NULL,
  `listing_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `video_url` varchar(300) DEFAULT NULL,
  `video_src_mp4` varchar(255) DEFAULT NULL,
  `video_src_webm` varchar(255) DEFAULT NULL,
  `poster_img_src` varchar(255) DEFAULT NULL,
  `poster_img_src_thumb` varchar(255) DEFAULT NULL,
  `poster_img_src_original` varchar(255) DEFAULT NULL,
  `w` int(4) DEFAULT NULL,
  `h` int(4) DEFAULT NULL,
  `sort_num` int(5) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listing_video`
--

INSERT INTO `listing_video` (`id`, `listing_id`, `title`, `title_en`, `video_url`, `video_src_mp4`, `video_src_webm`, `poster_img_src`, `poster_img_src_thumb`, `poster_img_src_original`, `w`, `h`, `sort_num`, `published`) VALUES
(2, 2, NULL, NULL, NULL, '/uploads/videos/domik.mp4', '/uploads/videos/domik.webm', '/uploads/images/properties/2015/03/2/17.jpg', '/uploads/images/properties/2015/03/2/17_tn.jpg', '/uploads/images/properties/2015/03/2/17.jpg', NULL, NULL, 10, 1),
(3, 4, NULL, NULL, 'http://109.248.245.100:555/FYe8cVHx?container=mjpeg&stream=main', NULL, NULL, NULL, NULL, NULL, 800, 600, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_city`
--

CREATE TABLE `loc_city` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_country_id` smallint(5) UNSIGNED NOT NULL,
  `loc_region_id` smallint(5) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `is_region_center` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `is_suburb` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cian_id` int(10) UNSIGNED DEFAULT NULL,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_city`
--

INSERT INTO `loc_city` (`id`, `loc_country_id`, `loc_region_id`, `title`, `title_en`, `is_region_center`, `is_suburb`, `sort_num`, `published`, `cian_id`, `title_seo`) VALUES
(1, 1, 1, 'Москва', 'Moscow', 1, 0, 1, 1, 1, 'moskva'),
(2, 1, 1, 'Петелино', 'Petelino', 0, 1, 10, 1, 5339, 'petelino'),
(3, 1, 1, 'Химки', 'Khimki', 0, 1, 10, 1, 77, 'himki'),
(4, 2, NULL, 'Будапешт', 'Budapest', 1, 0, 10, 1, NULL, 'budapesht'),
(5, 1, 2, 'Калуга', 'Kaluga', 1, 0, 10, 1, 11500, 'kaluga'),
(6, 1, 1, 'Домодедово', '', 0, 1, 10, 1, NULL, 'domodedovo'),
(7, 1, 1, 'Павловский  Посад', '', 0, 1, 10, 1, NULL, 'pavlovskiy-posad'),
(13, 1, 1, 'Старая Купавна', '', 0, 1, 10, 1, NULL, 'staraya-kupavna'),
(14, 1, 1, 'Звенигород', '', 0, 1, 10, 1, NULL, 'zvenigorod');

-- --------------------------------------------------------

--
-- Table structure for table `loc_city_district`
--

CREATE TABLE `loc_city_district` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_city_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_city_district`
--

INSERT INTO `loc_city_district` (`id`, `loc_city_id`, `title`, `title_en`, `sort_num`, `published`) VALUES
(1, 1, 'ЦАО', '', 10, 1),
(2, 1, 'САО', '', 30, 1),
(3, 1, 'СВАО', '', 40, 1),
(4, 1, 'ВАО', '', 50, 1),
(5, 1, 'ЮВАО', '', 60, 1),
(6, 1, 'ЮАО', '', 70, 1),
(7, 1, 'ЮЗАО', '', 80, 1),
(8, 1, 'ЗАО', '', 90, 1),
(9, 1, 'СЗАО', '', 20, 1),
(10, 1, 'Зеленоград', '', 100, 1),
(11, 1, 'НМАО', '', 110, 1),
(12, 1, 'ТАО', '', 130, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_country`
--

CREATE TABLE `loc_country` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_country`
--

INSERT INTO `loc_country` (`id`, `title`, `title_en`, `sort_num`, `published`, `title_seo`) VALUES
(1, 'Россия', '', 1, 1, 'rossiya'),
(2, 'Венгрия', '', 10, 1, 'vengriya');

-- --------------------------------------------------------

--
-- Table structure for table `loc_direction`
--

CREATE TABLE `loc_direction` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_direction`
--

INSERT INTO `loc_direction` (`id`, `title`, `title_en`, `sort_num`, `published`, `title_seo`) VALUES
(1, 'Москва и Новая Москва', 'Moscow and New Moscow', 10, 1, 'moskva-i-novaya'),
(2, 'Ближайшее Подмосквье', 'Moscow Vicinity', 20, 1, 'blizhayshee-podmoskve'),
(3, 'Московская область', 'Moscow Region', 30, 1, 'moskovskaya-oblast'),
(4, 'По всей России', 'All Over Russia', 40, 1, 'po-vsey-rossii'),
(5, 'За рубежом', 'Abroad Russia', 50, 1, 'za-rubezhom');

-- --------------------------------------------------------

--
-- Table structure for table `loc_metro`
--

CREATE TABLE `loc_metro` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_city_id` smallint(5) UNSIGNED NOT NULL,
  `loc_metro_line_id` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cian_id` int(11) UNSIGNED DEFAULT NULL,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_metro`
--

INSERT INTO `loc_metro` (`id`, `loc_city_id`, `loc_metro_line_id`, `title`, `title_en`, `sort_num`, `published`, `cian_id`, `title_seo`) VALUES
(1, 1, '1', 'Бульвар Рокоссовского', 'Bulvar Rokossovskogo', 10, 1, 40, 'bulvar-rokossovskogo'),
(2, 1, '1', 'Черкизовская', 'Cherkizovskaya', 20, 1, 39, 'cherkizovskaya'),
(3, 1, '1', 'Преображенская площадь', 'Preobrazhenskaya Ploshchad', 30, 1, 38, 'preobrazhenskaya-ploschad'),
(4, 1, '1', 'Сокольники', 'Sokolniki', 40, 1, 37, 'sokolniki'),
(5, 1, '1', 'Красносельская', 'Krasnoselskaya', 50, 1, 36, 'krasnoselskaya'),
(6, 1, '1,5', 'Комсомольская', 'Komsomolskaya', 60, 1, 35, 'komsomolskaya'),
(7, 1, '1', 'Красные ворота', 'Krasnye Vorota', 70, 1, 34, 'krasnye-vorota'),
(8, 1, '1', 'Чистые пруды', 'Chistye Prudy', 80, 1, 33, 'chistye-prudy'),
(9, 1, '1', 'Лубянка', 'Lubyanka', 90, 1, 32, 'lubyanka'),
(10, 1, '1', 'Охотный ряд', 'Okhotny Ryad', 100, 1, 31, 'ohotnyy-ryad'),
(11, 1, '1', 'Библиотека имени Ленина', 'Biblioteka Imeni Lenina', 110, 1, 30, 'biblioteka-imeni-lenina'),
(12, 1, '1', 'Кропоткинская', 'Kropotkinskaya', 120, 1, 29, 'kropotkinskaya'),
(13, 1, '1,5', 'Парк культуры', 'Park Kultury', 130, 1, 28, 'park-kultury'),
(14, 1, '1', 'Фрунзенская', 'Frunzenskaya', 140, 1, 27, 'frunzenskaya'),
(15, 1, '1', 'Спортивная', 'Sportivnaya', 150, 1, 26, 'sportivnaya'),
(16, 1, '1', 'Воробьёвы горы', 'Vorobyovy Gory', 160, 1, 157, 'vorobevy-gory'),
(17, 1, '1', 'Университет', 'Universitet', 170, 1, 25, 'universitet'),
(18, 1, '1', 'Проспект Вернадского', 'Prospekt Vernadskogo', 180, 1, 24, 'prospekt-vernadskogo'),
(19, 1, '1', 'Юго-Западная', 'Yugo-Zapadnaya', 190, 1, 23, 'yugo-zapadnaya'),
(20, 1, '1', 'Тропарёво', 'Troparyovo', 200, 1, 225, 'troparevo'),
(21, 1, '7', 'Планерная', 'Planernaya', 10, 1, 63, 'planernaya'),
(434, 1, '2', 'Речной вокзал', 'Rechnoy Vokzal', 10, 1, 1, 'rechnoy-vokzal'),
(435, 1, '2', 'Водный стадион', 'Vodny Stadion', 20, 1, 2, 'vodnyy-stadion'),
(436, 1, '2', 'Войковская', 'Voykovskaya', 30, 1, 3, 'voykovskaya'),
(437, 1, '2', 'Сокол', 'Sokol', 40, 1, 4, 'sokol'),
(438, 1, '2', 'Аэропорт', 'Aeroport', 50, 1, 5, 'aeroport'),
(439, 1, '2', 'Динамо', 'Dinamo', 60, 1, 6, 'dinamo'),
(440, 1, '2,5', 'Белорусская', 'Belorusskaya', 70, 1, 7, 'belorusskaya'),
(441, 1, '2', 'Маяковская', 'Mayakovskaya', 80, 1, 8, 'mayakovskaya'),
(442, 1, '2', 'Тверская', 'Tverskaya', 90, 1, 9, 'tverskaya'),
(443, 1, '2', 'Театральная', 'Teatralnaya', 100, 1, 10, 'teatralnaya'),
(444, 1, '2', 'Новокузнецкая', 'Novokuznetskaya', 110, 1, 11, 'novokuznetskaya'),
(445, 1, '2,5', 'Павелецкая', 'Paveletskaya', 120, 1, 12, 'paveletskaya'),
(446, 1, '2', 'Автозаводская', 'Avtozavodskaya', 130, 1, 13, 'avtozavodskaya'),
(447, 1, '2', 'Коломенская', 'Kolomenskaya', 140, 1, 14, 'kolomenskaya'),
(448, 1, '2,11', 'Каширская', 'Kashirskaya', 150, 1, 15, 'kashirskaya'),
(449, 1, '2', 'Кантемировская', 'Kantemirovskaya', 160, 1, 18, 'kantemirovskaya'),
(450, 1, '2', 'Царицыно', 'Tsaritsyno', 170, 1, 19, 'tsaritsyno'),
(451, 1, '2', 'Орехово', 'Orekhovo', 180, 1, 20, 'orehovo'),
(452, 1, '2', 'Домодедовская', 'Domodedovskaya', 190, 1, 21, 'domodedovskaya'),
(453, 1, '2', 'Красногвардейская', 'Krasnogvardeyskaya', 200, 1, 22, 'krasnogvardeyskaya'),
(454, 1, '2', 'Алма-Атинская', 'Alma-Atinskaya', 210, 1, 213, 'alma-atinskaya'),
(455, 1, '3', 'Пятницкое шоссе', 'Pyatnitskoye Shosse', 10, 1, 214, 'pyatnitskoe-shosse'),
(456, 1, '3', 'Митино', 'Mitino', 20, 1, 196, 'mitino'),
(457, 1, '3', 'Волоколамская', 'Volokolamskaya', 30, 1, 203, 'volokolamskaya'),
(458, 1, '3', 'Мякинино', 'Myakinino', 40, 1, 202, 'myakinino'),
(459, 1, '3', 'Строгино', 'Strogino', 50, 1, 200, 'strogino'),
(460, 1, '3', 'Крылатское', 'Krylatskoye', 60, 1, 62, 'krylatskoe'),
(461, 1, '3', 'Молодёжная', 'Molodyozhnaya', 70, 1, 61, 'molodezhnaya'),
(462, 1, '3,4', 'Кунцевская', 'Kuntsevskaya', 10, 1, 60, 'kuntsevskaya'),
(463, 1, '3', 'Славянский бульвар', 'Slavyansky Bulvar', 90, 1, 201, 'slavyanskiy-bulvar'),
(464, 1, '3,8', 'Парк Победы', 'Park Pobedy', 100, 1, 165, 'park-pobedy'),
(465, 1, '3,4,5', 'Киевская', 'Kiyevskaya', 100, 1, 52, 'kievskaya'),
(466, 1, '3,4', 'Смоленская', 'Smolenskaya', 110, 1, 51, 'smolenskaya'),
(467, 1, '3,4', 'Арбатская', 'Arbatskaya', 120, 1, 50, 'arbatskaya'),
(468, 1, '3', 'Площадь Революции', 'Ploshchad Revolyutsii', 140, 1, 49, 'ploschad-revolyutsii'),
(469, 1, '3,5', 'Курская', 'Kurskaya', 150, 1, 48, 'kurskaya'),
(470, 1, '3', 'Бауманская', 'Baumanskaya', 160, 1, 47, 'baumanskaya'),
(471, 1, '3', 'Электрозаводская', 'Elektrozavodskaya', 170, 1, 46, 'elektrozavodskaya'),
(472, 1, '3', 'Семёновская', 'Semyonovskaya', 180, 1, 45, 'semenovskaya'),
(473, 1, '3', 'Партизанская', 'Partizanskaya', 190, 1, 44, 'partizanskaya'),
(474, 1, '3', 'Измайловская', 'Izmaylovskaya', 200, 1, 43, 'izmaylovskaya'),
(475, 1, '3', 'Первомайская', 'Pervomayskaya', 210, 1, 42, 'pervomayskaya'),
(476, 1, '3', 'Щёлковская', 'Shchyolkovskaya', 220, 1, 41, 'schelkovskaya'),
(478, 1, '4', 'Пионерская', 'Pionerskaya', 20, 1, 59, 'pionerskaya'),
(479, 1, '4', 'Филёвский парк', 'Filyovsky Park', 30, 1, 58, 'filevskiy-park'),
(480, 1, '4', 'Багратионовская', 'Bagrationovskaya', 40, 1, 57, 'bagrationovskaya'),
(481, 1, '4', 'Фили', 'Fili', 50, 1, 56, 'fili'),
(482, 1, '4', 'Кутузовская', 'Kutuzovskaya', 60, 1, 55, 'kutuzovskaya'),
(483, 1, '4', 'Студенческая', 'Studencheskaya', 70, 1, 54, 'studencheskaya'),
(484, 1, '4', 'Международная', 'Mezhdunarodnaya', 80, 1, 197, 'mezhdunarodnaya'),
(485, 1, '4', 'Выставочная', 'Vystavochnaya', 90, 1, 198, 'vystavochnaya'),
(489, 1, '4', 'Александровский сад', 'Aleksandrovsky Sad', 130, 1, 53, 'aleksandrovskiy-sad'),
(491, 1, '5', 'Краснопресненская', 'Krasnopresnenskaya', 20, 1, 133, 'krasnopresnenskaya'),
(493, 1, '5', 'Новослободская', 'Novoslobodskaya', 40, 1, 134, 'novoslobodskaya'),
(494, 1, '5,6', 'Проспект Мира', 'Prospekt Mira', 50, 1, 136, 'prospekt-mira'),
(497, 1, '5,7', 'Таганская', 'Taganskaya', 80, 1, 75, 'taganskaya'),
(499, 1, '5', 'Добрынинская', 'Dobryninskaya', 100, 1, 132, 'dobryninskaya'),
(500, 1, '5,6', 'Октябрьская', 'Oktyabrskaya', 110, 1, 100, 'oktyabrskaya'),
(502, 1, '6', 'Медведково', 'Medvedkovo', 10, 1, 110, 'medvedkovo'),
(503, 1, '6', 'Бабушкинская', 'Babushkinskaya', 20, 1, 109, 'babushkinskaya'),
(504, 1, '6', 'Свиблово', 'Sviblovo', 30, 1, 108, 'sviblovo'),
(505, 1, '6', 'Ботанический сад', 'Botanichesky Sad', 40, 1, 107, 'botanicheskiy-sad'),
(506, 1, '6', 'ВДНХ', 'VDNKh', 50, 1, 106, 'vdnh'),
(507, 1, '6', 'Алексеевская', 'Alekseyevskaya', 60, 1, 105, 'alekseevskaya'),
(508, 1, '6', 'Рижская', 'Rizhskaya', 70, 1, 104, 'rizhskaya'),
(510, 1, '6', 'Сухаревская', 'Sukharevskaya', 90, 1, 102, 'suharevskaya'),
(511, 1, '6', 'Тургеневская', 'Turgenevskaya', 100, 1, 103, 'turgenevskaya'),
(512, 1, '6,7', 'Китай-город', 'Kitay-gorod', 110, 1, 74, 'kitay-gorod'),
(513, 1, '6,8', 'Третьяковская', 'Tretyakovskaya', 120, 1, 88, 'tretyakovskaya'),
(515, 1, '6', 'Шаболовская', 'Shabolovskaya', 140, 1, 99, 'shabolovskaya'),
(516, 1, '6', 'Ленинский проспект', 'Leninsky Prospekt', 150, 1, 98, 'leninskiy-prospekt'),
(517, 1, '6', 'Академическая', 'Akademicheskaya', 160, 1, 97, 'akademicheskaya'),
(518, 1, '6', 'Профсоюзная', 'Profsoyuznaya', 170, 1, 96, 'profsoyuznaya'),
(519, 1, '6', 'Новые Черёмушки', 'Novye Cheryomushki', 180, 1, 95, 'novye-cheremushki'),
(520, 1, '6', 'Калужская', 'Kaluzhskaya', 190, 1, 94, 'kaluzhskaya'),
(521, 1, '6', 'Беляево', 'Belyayevo', 200, 1, 93, 'belyaevo'),
(522, 1, '6', 'Коньково', 'Konkovo', 210, 1, 92, 'konkovo'),
(523, 1, '6', 'Тёплый Стан', 'Tyoply Stan', 220, 1, 91, 'teplyy-stan'),
(524, 1, '6', 'Ясенево', 'Yasenevo', 230, 1, 90, 'yasenevo'),
(525, 1, '6', 'Новоясеневская', 'Novoyasenevskaya', 240, 1, 89, 'novoyasenevskaya'),
(527, 1, '7', 'Сходненская', 'Skhodnenskaya', 20, 1, 64, 'shodnenskaya'),
(528, 1, '7', 'Тушинская', 'Tushinskaya', 30, 1, 65, 'tushinskaya'),
(529, 1, '7', 'Спартак', 'Spartak', 40, 1, 224, 'spartak'),
(530, 1, '7', 'Щукинская', 'Shchukinskaya', 50, 1, 66, 'schukinskaya'),
(531, 1, '7', 'Октябрьское поле', 'Oktyabrskoye Pole', 60, 1, 67, 'oktyabrskoe-pole'),
(532, 1, '7', 'Полежаевская', 'Polezhayevskaya', 70, 1, 68, 'polezhaevskaya'),
(533, 1, '7', 'Беговая', 'Begovaya', 80, 1, 69, 'begovaya'),
(534, 1, '7', 'Улица 1905 года', 'Ulitsa 1905 Goda', 90, 1, 70, 'ulitsa-1905-goda'),
(535, 1, '7', 'Баррикадная', 'Barrikadnaya', 100, 1, 71, 'barrikadnaya'),
(536, 1, '7', 'Пушкинская', 'Pushkinskaya', 110, 1, 72, 'pushkinskaya'),
(537, 1, '7', 'Кузнецкий мост', 'Kuznetsky Most', 120, 1, 73, 'kuznetskiy-most'),
(540, 1, '7', 'Пролетарская', 'Proletarskaya', 150, 1, 76, 'proletarskaya'),
(541, 1, '7', 'Волгоградский проспект', 'Volgogradsky Prospekt', 160, 1, 77, 'volgogradskiy-prospekt'),
(542, 1, '7', 'Текстильщики', 'Tekstilshchiki', 170, 1, 78, 'tekstilschiki'),
(543, 1, '7', 'Кузьминки', 'Kuzminki', 180, 1, 79, 'kuzminki'),
(544, 1, '7', 'Рязанский проспект', 'Ryazansky Prospekt', 190, 1, 80, 'ryazanskiy-prospekt'),
(545, 1, '7', 'Выхино', 'Vykhino', 200, 1, 81, 'vyhino'),
(546, 1, '7', 'Лермонтовский проспект', 'Lermontovsky Prospekt', 210, 1, 215, 'lermontovskiy-prospekt'),
(547, 1, '7', 'Жулебино', 'Zhulebino', 220, 1, 216, 'zhulebino'),
(549, 1, '8', 'Деловой центр', 'Delovoy Tsentr', 20, 1, 217, 'delovoy-tsentr'),
(551, 1, '8', 'Марксистская', 'Marksistskaya', 40, 1, 87, 'marksistskaya'),
(552, 1, '8', 'Площадь Ильича', 'Ploshchad Ilyicha', 50, 1, 86, 'ploschad-ilicha'),
(553, 1, '8', 'Авиамоторная', 'Aviamotornaya', 60, 1, 85, 'aviamotornaya'),
(554, 1, '8', 'Шоссе Энтузиастов', 'Shosse Entuziastov', 70, 1, 84, 'shosse-entuziastov'),
(555, 1, '8', 'Перово', 'Perovo', 80, 1, 83, 'perovo'),
(556, 1, '8', 'Новогиреево', 'Novogireyevo', 90, 1, 82, 'novogireevo'),
(557, 1, '8', 'Новокосино', 'Novokosino', 100, 1, 210, 'novokosino'),
(558, 1, '9', 'Алтуфьево', 'Altufyevo', 10, 1, 135, 'altufevo'),
(559, 1, '9', 'Бибирево', 'Bibirevo', 20, 1, 131, 'bibirevo'),
(560, 1, '9', 'Отрадное', 'Otradnoye', 30, 1, 111, 'otradnoe'),
(561, 1, '9', 'Владыкино', 'Vladykino', 40, 1, 112, 'vladykino'),
(562, 1, '9', 'Петровско-Разумовская', 'Petrovsko-Razumovskaya', 50, 1, 113, 'petrovsko-razumovskaya'),
(563, 1, '9', 'Тимирязевская', 'Timiryazevskaya', 60, 1, 114, 'timiryazevskaya'),
(564, 1, '9', 'Дмитровская', 'Dmitrovskaya', 70, 1, 115, 'dmitrovskaya'),
(565, 1, '9', 'Савёловская', 'Savyolovskaya', 80, 1, 116, 'savelovskaya'),
(566, 1, '9', 'Менделеевская', 'Mendeleyevskaya', 90, 1, 117, 'mendeleevskaya'),
(567, 1, '9', 'Цветной бульвар', 'Tsvetnoy Bulvar', 100, 1, 118, 'tsvetnoy-bulvar'),
(568, 1, '9', 'Чеховская', 'Chekhovskaya', 110, 1, 119, 'chehovskaya'),
(569, 1, '9', 'Боровицкая', 'Borovitskaya', 120, 1, 120, 'borovitskaya'),
(570, 1, '9', 'Полянка', 'Polyanka', 130, 1, 121, 'polyanka'),
(571, 1, '9', 'Серпуховская', 'Serpukhovskaya', 140, 1, 122, 'serpuhovskaya'),
(572, 1, '9', 'Тульская', 'Tulskaya', 150, 1, 123, 'tulskaya'),
(573, 1, '9', 'Нагатинская', 'Nagatinskaya', 160, 1, 124, 'nagatinskaya'),
(574, 1, '9', 'Нагорная', 'Nagornaya', 170, 1, 125, 'nagornaya'),
(575, 1, '9', 'Нахимовский проспект', 'Nakhimovsky Prospekt', 180, 1, 126, 'nahimovskiy-prospekt'),
(576, 1, '9', 'Севастопольская', 'Sevastopolskaya', 190, 1, 127, 'sevastopolskaya'),
(577, 1, '9', 'Чертановская', 'Chertanovskaya', 200, 1, 128, 'chertanovskaya'),
(578, 1, '9', 'Южная', 'Yuzhnaya', 210, 1, 129, 'yuzhnaya'),
(579, 1, '9', 'Пражская', 'Prazhskaya', 220, 1, 130, 'prazhskaya'),
(580, 1, '9', 'Улица академика Янгеля', 'Ulitsa Akademika Yangelya', 230, 1, 155, 'ulitsa-akademika-yangelya'),
(581, 1, '9', 'Аннино', 'Annino', 240, 1, 156, 'annino'),
(582, 1, '9', 'Бульвар Дмитрия Донского', 'Bulvar Dmitriya Donskogo', 250, 1, 164, 'bulvar-dmitriya-donskogo'),
(583, 1, '10', 'Марьина Роща', 'Maryina Roshcha', 10, 1, 204, 'marina-roscha'),
(584, 1, '10', 'Достоевская', 'Dostoyevskaya', 20, 1, 205, 'dostoevskaya'),
(585, 1, '10', 'Трубная', 'Trubnaya', 30, 1, 199, 'trubnaya'),
(586, 1, '10', 'Сретенский бульвар', 'Sretensky Bulvar', 40, 1, 206, 'sretenskiy-bulvar'),
(587, 1, '10', 'Чкаловская', 'Chkalovskaya', 50, 1, 137, 'chkalovskaya'),
(588, 1, '10', 'Римская', 'Rimskaya', 60, 1, 138, 'rimskaya'),
(589, 1, '10', 'Крестьянская застава', 'Krestyanskaya Zastava', 70, 1, 139, 'krestyanskaya-zastava'),
(590, 1, '10', 'Дубровка', 'Dubrovka', 80, 1, 140, 'dubrovka'),
(591, 1, '10', 'Кожуховская', 'Kozhukhovskaya', 90, 1, 144, 'kozhuhovskaya'),
(592, 1, '10', 'Печатники', 'Pechatniki', 100, 1, 141, 'pechatniki'),
(593, 1, '10', 'Волжская', 'Volzhskaya', 110, 1, 142, 'volzhskaya'),
(594, 1, '10', 'Люблино', 'Lyublino', 120, 1, 143, 'lyublino'),
(595, 1, '10', 'Братиславская', 'Bratislavskaya', 130, 1, 145, 'bratislavskaya'),
(596, 1, '10', 'Марьино', 'Maryino', 140, 1, 146, 'marino'),
(597, 1, '10', 'Борисово', 'Borisovo', 150, 1, 207, 'borisovo'),
(598, 1, '10', 'Шипиловская', 'Shipilovskaya', 160, 1, 208, 'shipilovskaya'),
(599, 1, '10', 'Зябликово', 'Zyablikovo', 170, 1, 209, 'zyablikovo'),
(601, 1, '11', 'Варшавская', 'Varshavskaya', 20, 1, 16, 'varshavskaya'),
(602, 1, '11', 'Каховская', 'Kakhovskaya', 30, 1, 17, 'kahovskaya'),
(603, 1, '12', 'Битцевский парк', 'Bittsevsky Park', 10, 1, 222, 'bittsevskiy-park'),
(604, 1, '12', 'Лесопарковая', 'Lesoparkovaya', 20, 1, 223, 'lesoparkovaya'),
(605, 1, '12', 'Улица Старокачаловская', 'Ulitsa Starokachalovskaya', 30, 1, 212, 'ulitsa-starokachalovskaya'),
(606, 1, '12', 'Улица Скобелевская', 'Ulitsa Skobelevskaya', 40, 1, 192, 'ulitsa-skobelevskaya'),
(607, 1, '12', 'Бульвар Адмирала Ушакова', 'Bulvar Admirala Ushakova', 50, 1, 193, 'bulvar-admirala-ushakova'),
(608, 1, '12', 'Улица Горчакова', 'Ulitsa Gorchakova', 60, 1, 194, 'ulitsa-gorchakova'),
(609, 1, '12', 'Бунинская аллея', 'Buninskaya Alleya', 70, 1, 195, 'buninskaya-alleya');

-- --------------------------------------------------------

--
-- Table structure for table `loc_metro_line`
--

CREATE TABLE `loc_metro_line` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_city_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(40) DEFAULT NULL,
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_metro_line`
--

INSERT INTO `loc_metro_line` (`id`, `loc_city_id`, `title`, `title_en`, `color`, `sort_num`, `published`) VALUES
(1, 1, 'Сокольническая', 'Sokolnicheskaya', '#ed1b35', 10, 1),
(2, 1, 'Замоскворецкая', 'Zamoskvoretskaya', '#44b85c', 20, 1),
(3, 1, 'Арбатско-Покровская', 'Arbatsko-Pokrovskaya', '#0078bf', 30, 1),
(4, 1, 'Филёвская', 'Filyovskaya', '#19c1f3', 40, 1),
(5, 1, 'Кольцевая', 'Koltsevaya', '#894e35', 50, 1),
(6, 1, 'Калужско-Рижская', 'Kaluzhsko-Rizhskaya', '#f58631', 60, 1),
(7, 1, 'Таганско-Краснопресненская', 'Tagansko-Krasnopresnenskaya', '#8e479c', 70, 1),
(8, 1, 'Калининско-Солнцевская', 'Kalininsko-Solntsevskaya', '#ffcb31', 80, 1),
(9, 1, 'Серпуховско-Тимирязевская', 'Serpukhovsko-Timiryazevskaya', '#a1a2a3', 90, 1),
(10, 1, 'Люблинско-Дмитровская', 'Lyublinsko-Dmitrovskaya', '#b3d445', 100, 1),
(11, 1, 'Каховская', 'Kakhovskaya', '#79cdcd', 110, 1),
(12, 1, 'Бутовская', 'Butovskaya', '#acbfe1', 120, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_project`
--

CREATE TABLE `loc_project` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_city_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_project`
--

INSERT INTO `loc_project` (`id`, `loc_city_id`, `title`, `title_en`, `sort_num`, `published`) VALUES
(1, 1, 'Новое Бутово', '', 0, 1),
(2, 1, 'Донской Олимп', '', 0, 1),
(3, 1, 'Балаклавский просп., к.2 АБВ', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_region`
--

CREATE TABLE `loc_region` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_country_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL,
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cian_id` int(11) UNSIGNED DEFAULT NULL,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_region`
--

INSERT INTO `loc_region` (`id`, `loc_country_id`, `title`, `title_en`, `sort_num`, `published`, `cian_id`, `title_seo`) VALUES
(1, 1, 'Московская область', 'Moscow Region', 1, 1, 1, 'moskovskaya-oblast'),
(2, 1, 'Калужская область', 'Kaluga Region', 10, 1, 4, 'kaluzhskaya-oblast');

-- --------------------------------------------------------

--
-- Table structure for table `loc_road`
--

CREATE TABLE `loc_road` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_region_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cian_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_road`
--

INSERT INTO `loc_road` (`id`, `loc_region_id`, `title`, `title_en`, `sort_num`, `published`, `cian_id`) VALUES
(1, 1, 'Рублёво-Успенское шоссе', '', 10, 1, 275),
(2, 1, 'Минское шоссе', '', 10, 1, 264),
(3, 1, 'Алтуфьевское шоссе', '', 10, 1, 281),
(4, 1, 'Боровское шоссе', '', 10, 1, 282),
(5, 1, 'Быковское шоссе', '', 10, 1, 283),
(6, 1, 'Варшавское шоссе', '', 10, 1, 284),
(7, 1, 'Волоколамское шоссе', '', 10, 1, 285),
(8, 1, 'Горьковское шоссе', '', 10, 1, 286),
(9, 1, 'Дмитровское шоссе', '', 10, 1, 256),
(10, 1, 'Егорьевское шоссе', '', 10, 1, 257),
(11, 1, 'Ильинское шоссе', '', 10, 1, 258),
(12, 1, 'Калужское шоссе', '', 10, 1, 259),
(13, 1, 'Каширское шоссе', '', 10, 1, 260),
(14, 1, 'Киевское шоссе', '', 10, 1, 261),
(15, 1, 'Куркинское шоссе', '', 10, 1, 262),
(16, 1, 'Ленинградское шоссе', '', 10, 1, 263),
(17, 1, 'Машкинское шоссе', '', 10, 1, 288),
(18, 1, 'Можайское шоссе', '', 10, 1, 265),
(19, 1, 'Новокаширское шоссе', '', 10, 1, 266),
(20, 1, 'Новорижское шоссе', '', 10, 1, 267),
(21, 1, 'Новорязанское шоссе', '', 10, 1, 268),
(22, 1, 'Новосходненское шоссе', '', 10, 1, 269),
(23, 1, 'Носовихинское шоссе', '', 10, 1, 270),
(24, 1, 'Осташковское шоссе', '', 10, 1, 271),
(25, 1, 'Подушкинское шоссе', '', 10, 1, 272),
(26, 1, 'Пятницкое шоссе', '', 10, 1, 273),
(27, 1, 'Рогачевское шоссе', '', 10, 1, 274),
(28, 1, 'Рублевское шоссе', '', 10, 1, 290),
(29, 1, 'Рязанское шоссе', '', 10, 1, 287),
(30, 1, 'Симферопольское шоссе', '', 10, 1, 276),
(31, 1, 'Сколковское шоссе', '', 10, 1, 277),
(32, 1, 'Щелковское шоссе', '', 10, 1, 279),
(33, 1, 'Ярославское шоссе', '', 10, 1, 280);

-- --------------------------------------------------------

--
-- Table structure for table `loc_street`
--

CREATE TABLE `loc_street` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `loc_city_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cian_id` int(11) UNSIGNED DEFAULT NULL,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loc_street`
--

INSERT INTO `loc_street` (`id`, `loc_city_id`, `title`, `title_en`, `sort_num`, `published`, `cian_id`, `title_seo`) VALUES
(1, 1, 'Куркинское шоссе', '', 10, 1, 16191, 'kurkinskoe-shosse'),
(2, 1, 'Мичуринский проспект', '', 10, 1, 1417, 'michurinskiy-prospekt'),
(3, 1, 'Касимовская улица', '', 10, 1, 955, 'kasimovskaya-ulitsa'),
(4, 1, 'Рязанский проспект', '', 10, 1, 267, 'ryazanskiy-prospekt'),
(5, 1, 'Булатниковская улица', '', 10, 1, 630, 'bulatnikovskaya-ulitsa'),
(6, 1, 'Харьковский проезд', '', 10, 1, 332, 'harkovskiy-proezd'),
(7, 1, 'улица Бусиновская Горка', '', 10, 1, 634, 'ulitsa-businovskaya-gorka'),
(8, 1, 'Липецкая улица', '', 10, 1, 1115, 'lipetskaya-ulitsa'),
(9, 1, 'Большой Купавенский проезд', '', 10, 1, 154, 'bolshoy-kupavenskiy-proezd'),
(10, 1, 'Загорьевская улица', '', 10, 1, 865, 'zagorevskaya-ulitsa'),
(11, 1, 'Востряковский проезд', '', 10, 1, 48, 'vostryakovskiy-proezd'),
(12, 1, 'улица Маршала Федоренко', '', 10, 1, 1808, 'ulitsa-marshala-fedorenko'),
(13, 1, 'Сахалинская улица', '', 10, 1, 1607, 'sahalinskaya-ulitsa'),
(14, 1, '1-й Лихачевский переулок', '', 10, 1, 2226, '1-y-lihachevskiy-pereulok'),
(15, 1, 'Сиреневый бульвар', '', 10, 1, 427, 'sirenevyy-bulvar'),
(16, 1, '5-я улица Соколиной Горы', '', 10, 1, 1656, '5-ya-ulitsa-sokolinoy-gory'),
(17, 1, '6-я Радиальная улица', '', 10, 1, 1530, '6-ya-radialnaya-ulitsa'),
(18, 1, 'Алтуфьевское шоссе', '', 10, 1, 2698, 'altufevskoe-shosse'),
(19, 1, 'Коломенская улица', '', 10, 1, 993, 'kolomenskaya-ulitsa'),
(20, 1, 'улица Софьи Ковалевской', '', 10, 1, 1673, 'ulitsa-sofi-kovalevskoy'),
(43, 1, 'улица Барышевская Роща', '', 10, 1, 99514, 'ulitsa-baryshevskaya-roscha'),
(44, 1, 'Красноярская улица', '', 10, 1, 1051, 'krasnoyarskaya-ulitsa'),
(45, 1, 'Хабаровская улица', '', 10, 1, 1836, 'habarovskaya-ulitsa'),
(46, 1, 'улица Фитаревская', '', 10, 1, 3139684, 'ulitsa-fitarevskaya'),
(48, 1, '16-я Парковая улица', '', 10, 1, 1402, '16-ya-parkovaya-ulitsa'),
(49, 1, 'Анадырский проезд', '', 10, 1, 7, 'anadyrskiy-proezd'),
(50, 1, 'Краснополянская улица', '', 10, 1, 2934, 'krasnopolyanskaya-ulitsa'),
(51, 1, 'Вяземская улица', '', 10, 1, 722, 'vyazemskaya-ulitsa'),
(52, 1, 'Стрельбищенский переулок', '', 10, 1, 2467, 'strelbischenskiy-pereulok'),
(53, 1, 'Попутная улица', '', 10, 1, 1480, 'poputnaya-ulitsa'),
(54, 1, 'Святоозерская улица', '', 10, 1, 3772, 'svyatoozerskaya-ulitsa'),
(55, 1, 'Кунцевская улица', '', 10, 1, 1076, 'kuntsevskaya-ulitsa'),
(56, 1, 'Варшавское шоссе', '', 10, 1, 2704, 'varshavskoe-shosse'),
(57, 1, 'улица Головачева', '', 10, 1, 749, 'ulitsa-golovacheva'),
(58, 1, 'Веерная улица', '', 10, 1, 656, 'veernaya-ulitsa'),
(59, 1, 'Дубнинская улица', '', 10, 1, 829, 'dubninskaya-ulitsa'),
(60, 1, 'Беловежская улица', '', 10, 1, 578, 'belovezhskaya-ulitsa'),
(61, 1, 'улица Академика Скрябина', '', 10, 1, 1645, 'ulitsa-akademika-skryabina'),
(62, 1, '3-я Карачаровская улица', '', 10, 1, 947, '3-ya-karacharovskaya-ulitsa'),
(63, 1, 'шоссе Шелковское', '', 10, 1, 3411400, 'shosse-shelkovskoe'),
(64, 1, 'Лебедянская улица', '', 10, 1, 1093, 'lebedyanskaya-ulitsa'),
(65, 1, 'Саянская улица', '', 10, 1, 1608, 'sayanskaya-ulitsa'),
(66, 1, 'Бронницкая улица', '', 10, 1, 625, 'bronnitskaya-ulitsa'),
(67, 1, 'Мосфильмовская улица', '', 10, 1, 1238, 'mosfilmovskaya-ulitsa'),
(68, 1, 'Псковская улица', '', 10, 1, 1514, 'pskovskaya-ulitsa'),
(69, 1, 'улица Николо-Хованская', '', 10, 1, 3134722, 'ulitsa-nikolo-hovanskaya'),
(70, 1, 'Полярная улица', '', 10, 1, 1478, 'polyarnaya-ulitsa'),
(71, 1, 'улица 50 лет Октября', '', 10, 1, 29695, 'ulitsa-50-let-oktyabrya'),
(72, 1, 'Нижняя Первомайская улица', '', 10, 1, 1422, 'nizhnyaya-pervomayskaya-ulitsa'),
(73, 1, 'Педагогическая улица', '', 10, 1, 1416, 'pedagogicheskaya-ulitsa'),
(74, 1, '15-я Парковая улица', '', 10, 1, 1401, '15-ya-parkovaya-ulitsa'),
(75, 1, 'улица Демин луг', '', 10, 1, 3492934, 'ulitsa-demin-lug'),
(76, 1, 'Туристская улица', '', 10, 1, 1779, 'turistskaya-ulitsa'),
(77, 1, 'улица Липовый Парк', '', 10, 1, 3114682, 'ulitsa-lipovyy-park'),
(78, 1, 'Боровское шоссе', '', 10, 1, 3049, 'borovskoe-shosse'),
(79, 1, 'улица Недорубова', '', 10, 1, 3054568, 'ulitsa-nedorubova'),
(80, 1, 'Михалковская улица', '', 10, 1, 1216, 'mihalkovskaya-ulitsa'),
(81, 1, 'шоссе Энтузиастов', '', 10, 1, 2743, 'shosse-entuziastov'),
(82, 1, 'Путевой проезд', '', 10, 1, 255, 'putevoy-proezd'),
(83, 1, 'Алтайская улица', '', 10, 1, 517, 'altayskaya-ulitsa'),
(84, 1, 'улица Наташи Ковшовой', '', 10, 1, 1267, 'ulitsa-natashi-kovshovoy'),
(85, 1, 'улица Льва Яшина', '', 10, 1, 108544, 'ulitsa-lva-yashina'),
(86, 1, 'улица Кубинка', '', 10, 1, 1069, 'ulitsa-kubinka'),
(87, 1, 'Уссурийская улица', '', 10, 1, 1798, 'ussuriyskaya-ulitsa'),
(88, 1, 'Байкальская улица', '', 10, 1, 552, 'baykalskaya-ulitsa'),
(89, 1, 'Ангарская улица', '', 10, 1, 522, 'angarskaya-ulitsa'),
(90, 1, 'улица Черное Озеро', '', 10, 1, 1875, 'ulitsa-chernoe-ozero'),
(91, 1, 'Открытое шоссе', '', 10, 1, 2726, 'otkrytoe-shosse'),
(92, 1, 'проспект Мира', '', 10, 1, 2800, 'prospekt-mira'),
(93, 1, 'Ростокинская улица', '', 10, 1, 1562, 'rostokinskaya-ulitsa'),
(94, 1, 'Дмитровское шоссе', '', 10, 1, 130, 'dmitrovskoe-shosse'),
(95, 1, 'Элеваторная улица', '', 10, 1, 1921, 'elevatornaya-ulitsa'),
(96, 1, 'улица Чечулина', '', 10, 1, 1881, 'ulitsa-chechulina'),
(97, 1, 'Пятницкое шоссе', '', 10, 1, 2732, 'pyatnitskoe-shosse'),
(98, 1, 'Весенняя улица', '', 10, 1, 672, 'vesennyaya-ulitsa'),
(99, 1, 'Михневская улица', '', 10, 1, 1218, 'mihnevskaya-ulitsa'),
(100, 1, 'Базовская улица', '', 10, 1, 551, 'bazovskaya-ulitsa'),
(101, 1, '1-я Магистральная улица', '', 10, 1, 1146, '1-ya-magistralnaya-ulitsa'),
(102, 1, 'улица Лавочкина', '', 10, 1, 1086, 'ulitsa-lavochkina'),
(103, 1, 'Солнечногорская улица', '', 10, 1, 1668, 'solnechnogorskaya-ulitsa'),
(104, 1, 'Лобненская улица', '', 10, 1, 1122, 'lobnenskaya-ulitsa'),
(105, 1, 'Донбасская улица', '', 10, 1, 817, 'donbasskaya-ulitsa'),
(106, 1, 'Дачная улица', '', 10, 1, 19130, 'dachnaya-ulitsa'),
(107, 1, 'Салтыковская улица', '', 10, 1, 1595, 'saltykovskaya-ulitsa'),
(108, 1, 'улица Мневники', '', 10, 1, 1221, 'ulitsa-mnevniki'),
(109, 1, 'улица 800-летия Москвы', '', 10, 1, 3203, 'ulitsa-800-letiya-moskvy'),
(110, 1, 'Новорублевская улица', '', 10, 1, 35085, 'novorublevskaya-ulitsa'),
(111, 1, 'Зарайская улица', '', 10, 1, 869, 'zarayskaya-ulitsa'),
(112, 1, '3-я Курьяновская улица', '', 10, 1, 776, '3-ya-kuryanovskaya-ulitsa'),
(113, 1, 'Флотская улица', '', 10, 1, 1820, 'flotskaya-ulitsa'),
(114, 1, 'Чечерский проезд', '', 10, 1, 4591, 'checherskiy-proezd'),
(115, 1, '3-й Новомихалковский проезд', '', 10, 1, 210, '3-y-novomihalkovskiy-proezd'),
(116, 1, 'улица Авиаторов', '', 10, 1, 501, 'ulitsa-aviatorov'),
(117, 1, '1-я Мелитопольская улица', '', 10, 1, 1194, '1-ya-melitopolskaya-ulitsa'),
(118, 1, 'улица Красного Маяка', '', 10, 1, 3493, 'ulitsa-krasnogo-mayaka'),
(119, 1, 'улица Николая Химушина', '', 10, 1, 1285, 'ulitsa-nikolaya-himushina'),
(120, 1, 'Коровинское шоссе', '', 10, 1, 2717, 'korovinskoe-shosse'),
(121, 1, '1-й Капотнинский проезд', '', 10, 1, 3083, '1-y-kapotninskiy-proezd'),
(122, 1, 'улица Ухтомского Ополчения', '', 10, 1, 35786, 'ulitsa-uhtomskogo-opolcheniya'),
(123, 1, 'Онежская улица', '', 10, 1, 1354, 'onezhskaya-ulitsa'),
(124, 1, 'Бирюлевская улица', '', 10, 1, 592, 'biryulevskaya-ulitsa'),
(125, 1, 'Волгоградский проспект', '', 10, 1, 2771, 'volgogradskiy-prospekt'),
(126, 1, 'Коптевский бульвар', '', 10, 1, 412, 'koptevskiy-bulvar'),
(127, 1, 'Реутовская улица', '', 10, 1, 1547, 'reutovskaya-ulitsa'),
(129, 1, '2-я Вольская улица', '', 10, 1, 98384, '2-ya-volskaya-ulitsa'),
(130, 1, 'улица Металлургов', '', 10, 1, 1202, 'ulitsa-metallurgov'),
(131, 1, 'Окружная улица', '', 10, 1, 1344, 'okruzhnaya-ulitsa'),
(132, 1, 'Матвеевская улица', '', 10, 1, 1181, 'matveevskaya-ulitsa'),
(133, 1, 'Ташкентская улица', '', 10, 1, 1744, 'tashkentskaya-ulitsa'),
(134, 1, 'улица Саморы Машела', '', 10, 1, 1602, 'ulitsa-samory-mashela'),
(135, 1, 'проспект Защитников Москвы', '', 10, 1, 41764, 'prospekt-zaschitnikov-moskvy'),
(136, 1, 'Рождественская улица', '', 10, 1, 40584, 'rozhdestvenskaya-ulitsa'),
(137, 1, 'Большая Академическая улица', '', 10, 1, 18208, 'bolshaya-akademicheskaya-ulitsa'),
(138, 1, 'улица Полбина', '', 10, 1, 1468, 'ulitsa-polbina'),
(139, 1, 'Новорязанское шоссе', '', 10, 1, 36043, 'novoryazanskoe-shosse'),
(140, 1, 'Борисовский проезд', '', 10, 1, 23, 'borisovskiy-proezd'),
(141, 1, 'улица Каховка', '', 10, 1, 960, 'ulitsa-kahovka'),
(142, 1, 'Наримановская улица', '', 10, 1, 1262, 'narimanovskaya-ulitsa'),
(143, 1, 'Батюнинская улица', '', 10, 1, 565, 'batyuninskaya-ulitsa'),
(144, 1, 'Шоссейная улица', '', 10, 1, 26436, 'shosseynaya-ulitsa'),
(145, 1, 'Сумской проезд', '', 10, 1, 310, 'sumskoy-proezd'),
(146, 1, 'улица Толбухина', '', 10, 1, 1766, 'ulitsa-tolbuhina'),
(147, 1, 'Щелковское шоссе', '', 10, 1, 2742, 'schelkovskoe-shosse'),
(148, 1, 'Яхромская улица', '', 10, 1, 1953, 'yahromskaya-ulitsa'),
(149, 1, 'Лаврушинский переулок', '', 10, 1, 2215, 'lavrushinskiy-pereulok'),
(150, 1, 'аллея Жемчуговой', '', 10, 1, 374, 'alleya-zhemchugovoy'),
(151, 1, 'улица Михайлова', '', 10, 1, 1215, 'ulitsa-mihaylova'),
(152, 1, 'Севастопольский проспект', '', 10, 1, 2810, 'sevastopolskiy-prospekt'),
(153, 1, 'проезд Рублевский', '', 10, 1, 3140782, 'proezd-rublevskiy'),
(154, 1, 'Инициативная улица', '', 10, 1, 915, 'initsiativnaya-ulitsa'),
(155, 1, 'Коптевская улица', '', 10, 1, 1012, 'koptevskaya-ulitsa'),
(156, 1, 'улица Академика Семенова', '', 10, 1, 29815, 'ulitsa-akademika-semenova'),
(157, 1, 'улица Плющева', '', 10, 1, 1453, 'ulitsa-plyuscheva'),
(158, 1, 'улица Липчанского', '', 10, 1, 104656, 'ulitsa-lipchanskogo'),
(159, 1, 'Зеленоградская улица', '', 10, 1, 881, 'zelenogradskaya-ulitsa'),
(160, 1, 'Подольская улица', '', 10, 1, 1459, 'podolskaya-ulitsa'),
(161, 1, 'улица Сталеваров', '', 10, 1, 1679, 'ulitsa-stalevarov'),
(162, 1, 'Самаркандский бульвар', '', 10, 1, 424, 'samarkandskiy-bulvar'),
(163, 1, 'Озерная улица', '', 10, 1, 1342, 'ozernaya-ulitsa'),
(164, 1, 'Загородное шоссе', '', 10, 1, 3125, 'zagorodnoe-shosse'),
(165, 1, 'Лухмановская улица', '', 10, 1, 3774, 'luhmanovskaya-ulitsa'),
(166, 1, 'Стартовая улица', '', 10, 1, 1699, 'startovaya-ulitsa'),
(167, 1, 'улица Маршала Неделина', '', 10, 1, 1271, 'ulitsa-marshala-nedelina'),
(168, 1, 'улица Дыбенко', '', 10, 1, 839, 'ulitsa-dybenko'),
(169, 1, 'Бескудниковский бульвар', '', 10, 1, 3200, 'beskudnikovskiy-bulvar'),
(170, 1, 'Вешняковская улица', '', 10, 1, 677, 'veshnyakovskaya-ulitsa'),
(171, 1, '9-я Северная линия', '', 10, 1, 29784, '9-ya-severnaya-liniya'),
(172, 1, 'Загорьевский проезд', '', 10, 1, 3130, 'zagorevskiy-proezd'),
(173, 1, 'проезд Черского', '', 10, 1, 345, 'proezd-cherskogo'),
(174, 1, 'улица Дмитриевского', '', 10, 1, 3773, 'ulitsa-dmitrievskogo'),
(175, 1, 'Поречная улица', '', 10, 1, 4545, 'porechnaya-ulitsa'),
(176, 1, 'улица Бориса Жигуленкова', '', 10, 1, 609, 'ulitsa-borisa-zhigulenkova'),
(177, 1, 'Аминьевское шоссе', '', 10, 1, 1720, 'aminevskoe-shosse'),
(178, 1, 'проезд Кадомцева', '', 10, 1, 3081, 'proezd-kadomtseva'),
(179, 1, 'проспект Буденного', '', 10, 1, 2784, 'prospekt-budennogo'),
(180, 1, 'Новопетровская улица', '', 10, 1, 1317, 'novopetrovskaya-ulitsa'),
(181, 1, 'Очаковское шоссе', '', 10, 1, 2727, 'ochakovskoe-shosse'),
(182, 1, 'Курганская улица', '', 10, 1, 3356, 'kurganskaya-ulitsa'),
(184, 1, 'Нагатинская набережная', '', 10, 1, 2624, 'nagatinskaya-naberezhnaya'),
(185, 1, 'Будайский проезд', '', 10, 1, 29, 'budayskiy-proezd'),
(186, 1, 'Донецкая улица', '', 10, 1, 818, 'donetskaya-ulitsa'),
(187, 1, 'Старонародная улица', '', 10, 1, 8172, 'staronarodnaya-ulitsa'),
(188, 1, 'улица Генерала Глаголева', '', 10, 1, 744, 'ulitsa-generala-glagoleva'),
(189, 1, 'Живописная улица', '', 10, 1, 857, 'zhivopisnaya-ulitsa'),
(190, 1, 'Клязьминская улица', '', 10, 1, 981, 'klyazminskaya-ulitsa'),
(191, 1, 'Покровская улица', '', 10, 1, 41293, 'pokrovskaya-ulitsa'),
(192, 1, 'Новосибирская улица', '', 10, 1, 1326, 'novosibirskaya-ulitsa'),
(193, 1, 'Федоскинская улица', '', 10, 1, 1809, 'fedoskinskaya-ulitsa'),
(194, 1, '1-й Очаковский переулок', '', 10, 1, 2336, '1-y-ochakovskiy-pereulok'),
(195, 1, 'улица Маршала Тухачевского', '', 10, 1, 1780, 'ulitsa-marshala-tuhachevskogo'),
(196, 1, 'бульвар Генерала Карбышева', '', 10, 1, 409, 'bulvar-generala-karbysheva'),
(197, 1, 'улица Ляпидевского', '', 10, 1, 1143, 'ulitsa-lyapidevskogo'),
(198, 1, 'проспект Маршала Жукова', '', 10, 1, 2789, 'prospekt-marshala-zhukova'),
(199, 1, 'улица Молостовых', '', 10, 1, 1230, 'ulitsa-molostovyh'),
(200, 1, 'улица Генерала Белобородова', '', 10, 1, 5815, 'ulitsa-generala-beloborodova'),
(201, 1, 'улица Малая Набережная', '', 10, 1, 3265732, 'ulitsa-malaya-naberezhnaya'),
(202, 1, 'улица Маршала Кожедуба', '', 10, 1, 3567, 'ulitsa-marshala-kozheduba'),
(203, 1, 'улица Кухмистерова', '', 10, 1, 1085, 'ulitsa-kuhmisterova'),
(204, 1, 'Мастеровая улица', '', 10, 1, 1180, 'masterovaya-ulitsa'),
(205, 1, 'улица Верхние Поля', '', 10, 1, 667, 'ulitsa-verhnie-polya'),
(206, 1, 'улица Корнейчука', '', 10, 1, 1014, 'ulitsa-korneychuka'),
(207, 1, 'улица Героев Панфиловцев', '', 10, 1, 738, 'ulitsa-geroev-panfilovtsev'),
(208, 1, 'Белореченская улица', '', 10, 1, 583, 'belorechenskaya-ulitsa'),
(209, 1, 'Кронштадтский бульвар', '', 10, 1, 414, 'kronshtadtskiy-bulvar'),
(210, 1, 'Тимирязевская улица', '', 10, 1, 1755, 'timiryazevskaya-ulitsa'),
(211, 1, 'Челюскинская улица', '', 10, 1, 1864, 'chelyuskinskaya-ulitsa'),
(212, 1, 'улица Маресьева', '', 10, 1, 3133636, 'ulitsa-mareseva'),
(213, 1, 'Свободный проспект', '', 10, 1, 2809, 'svobodnyy-prospekt'),
(214, 1, 'Медынская улица', '', 10, 1, 1191, 'medynskaya-ulitsa'),
(215, 1, 'Большая Марфинская улица', '', 10, 1, 1171, 'bolshaya-marfinskaya-ulitsa'),
(216, 1, 'Нижегородская улица', '', 10, 1, 1279, 'nizhegorodskaya-ulitsa'),
(217, 1, '2-я Мелитопольская улица', '', 10, 1, 1195, '2-ya-melitopolskaya-ulitsa'),
(218, 1, 'Петрозаводская улица', '', 10, 1, 1436, 'petrozavodskaya-ulitsa'),
(219, 1, 'Ясный проезд', '', 10, 1, 367, 'yasnyy-proezd'),
(220, 1, 'Будайская улица', '', 10, 1, 628, 'budayskaya-ulitsa'),
(221, 1, 'Дегунинская улица', '', 10, 1, 788, 'deguninskaya-ulitsa'),
(222, 1, 'Челябинская улица', '', 10, 1, 1865, 'chelyabinskaya-ulitsa'),
(223, 1, 'Палехская улица', '', 10, 1, 1386, 'palehskaya-ulitsa'),
(224, 1, 'улица Бутлерова', '', 10, 1, 635, 'ulitsa-butlerova'),
(225, 1, 'улица Плеханова', '', 10, 1, 1451, 'ulitsa-plehanova'),
(226, 1, 'Автомоторная улица', '', 10, 1, 504, 'avtomotornaya-ulitsa'),
(227, 1, 'улица Коненкова', '', 10, 1, 1004, 'ulitsa-konenkova'),
(228, 1, 'Чертановская улица', '', 10, 1, 1878, 'chertanovskaya-ulitsa'),
(229, 1, 'Ягодная улица', '', 10, 1, 1937, 'yagodnaya-ulitsa'),
(230, 1, 'Коломенская набережная', '', 10, 1, 2608, 'kolomenskaya-naberezhnaya'),
(231, 1, 'Тайнинская улица', '', 10, 1, 1732, 'tayninskaya-ulitsa'),
(232, 1, 'Каширское шоссе', '', 10, 1, 3095, 'kashirskoe-shosse'),
(233, 1, 'улица Бочкова', '', 10, 1, 617, 'ulitsa-bochkova'),
(234, 1, 'Малая Калитниковская улица', '', 10, 1, 935, 'malaya-kalitnikovskaya-ulitsa'),
(235, 1, 'улица Главмосстроя', '', 10, 1, 450, 'ulitsa-glavmosstroya'),
(236, 1, 'Перовское шоссе', '', 10, 1, 2729, 'perovskoe-shosse'),
(237, 1, 'Магнитогорская улица', '', 10, 1, 1151, 'magnitogorskaya-ulitsa'),
(238, 1, 'Барвихинская улица', '', 10, 1, 559, 'barvihinskaya-ulitsa'),
(239, 1, 'Игральная улица', '', 10, 1, 900, 'igralnaya-ulitsa'),
(240, 1, 'Камчатская улица', '', 10, 1, 942, 'kamchatskaya-ulitsa'),
(241, 1, 'улица Паршина', '', 10, 1, 1413, 'ulitsa-parshina'),
(242, 1, 'Лодочная улица', '', 10, 1, 1123, 'lodochnaya-ulitsa'),
(243, 1, 'улица Демьяна Бедного', '', 10, 1, 793, 'ulitsa-demyana-bednogo'),
(244, 1, 'улица Академика Виноградова', '', 10, 1, 685, 'ulitsa-akademika-vinogradova'),
(245, 1, 'Кременчугская улица', '', 10, 1, 1054, 'kremenchugskaya-ulitsa'),
(246, 1, '2-й Сетуньский проезд', '', 10, 1, 283, '2-y-setunskiy-proezd'),
(247, 1, 'улица Молодцова', '', 10, 1, 1229, 'ulitsa-molodtsova'),
(248, 1, 'Солнцевский проспект', '', 10, 1, 2811, 'solntsevskiy-prospekt'),
(249, 1, 'Заповедная улица', '', 10, 1, 867, 'zapovednaya-ulitsa'),
(250, 1, 'бульвар Матроса Железняка', '', 10, 1, 404, 'bulvar-matrosa-zheleznyaka'),
(251, 1, 'улица Богданова', '', 10, 1, 598, 'ulitsa-bogdanova'),
(252, 1, 'Фестивальная улица', '', 10, 1, 1815, 'festivalnaya-ulitsa'),
(253, 1, 'улица Пырьева', '', 10, 1, 1522, 'ulitsa-pyreva'),
(254, 1, 'улица Мичуринский проспект.Олимпийская деревня', '', 10, 1, 3408664, 'ulitsa-michurinskiy-prospektolimpiyskaya-derevnya'),
(255, 1, 'улица Бажова', '', 10, 1, 550, 'ulitsa-bazhova'),
(256, 1, 'Нагорный бульвар', '', 10, 1, 417, 'nagornyy-bulvar'),
(257, 1, 'улица Багрицкого', '', 10, 1, 548, 'ulitsa-bagritskogo'),
(258, 1, 'улица Инессы Арманд', '', 10, 1, 913, 'ulitsa-inessy-armand'),
(259, 1, 'улица Садовники', '', 10, 1, 2774, 'ulitsa-sadovniki'),
(260, 1, 'Нежинская улица', '', 10, 1, 1273, 'nezhinskaya-ulitsa'),
(261, 1, 'Булатниковский проезд', '', 10, 1, 30, 'bulatnikovskiy-proezd'),
(262, 1, 'улица Горбунова', '', 10, 1, 753, 'ulitsa-gorbunova'),
(263, 1, 'Уваровский переулок', '', 10, 1, 1418, 'uvarovskiy-pereulok'),
(264, 1, 'Ферганский проезд', '', 10, 1, 330, 'ferganskiy-proezd'),
(265, 1, 'Норильская улица', '', 10, 1, 1334, 'norilskaya-ulitsa'),
(266, 1, 'Большая Очаковская улица', '', 10, 1, 1378, 'bolshaya-ochakovskaya-ulitsa'),
(267, 1, 'проезд Карамзина', '', 10, 1, 3085, 'proezd-karamzina'),
(268, 1, 'улица Речников', '', 10, 1, 1548, 'ulitsa-rechnikov'),
(269, 1, 'улица Академика Бакулева', '', 10, 1, 554, 'ulitsa-akademika-bakuleva'),
(270, 1, 'Мининский переулок', '', 10, 1, 2257, 'mininskiy-pereulok'),
(271, 1, 'Балаклавский проспект', '', 10, 1, 2783, 'balaklavskiy-prospekt'),
(272, 1, 'Ярославское шоссе', '', 10, 1, 2744, 'yaroslavskoe-shosse'),
(273, 1, 'улица Лихоборские Бугры', '', 10, 1, 1118, 'ulitsa-lihoborskie-bugry'),
(274, 1, 'Мукомольный проезд', '', 10, 1, 191, 'mukomolnyy-proezd'),
(275, 1, 'Изумрудная улица', '', 10, 1, 907, 'izumrudnaya-ulitsa'),
(276, 1, 'Большая Калитниковская улица', '', 10, 1, 934, 'bolshaya-kalitnikovskaya-ulitsa'),
(277, 1, 'Окская улица', '', 10, 1, 1345, 'okskaya-ulitsa'),
(278, 1, 'Бескудниковский проезд', '', 10, 1, 4597, 'beskudnikovskiy-proezd'),
(279, 1, 'Ставропольский проезд', '', 10, 1, 14423, 'stavropolskiy-proezd'),
(280, 1, 'Витебская улица', '', 10, 1, 687, 'vitebskaya-ulitsa'),
(281, 1, 'Челобитьевское шоссе', '', 10, 1, 3540, 'chelobitevskoe-shosse'),
(282, 1, 'улица Рудневка', '', 10, 1, 3775, 'ulitsa-rudnevka'),
(283, 1, 'Рябиновая улица', '', 10, 1, 1578, 'ryabinovaya-ulitsa'),
(284, 1, 'Болотниковская улица', '', 10, 1, 605, 'bolotnikovskaya-ulitsa'),
(285, 1, 'Дорожная улица', '', 10, 1, 823, 'dorozhnaya-ulitsa'),
(286, 1, 'Рублевское шоссе', '', 10, 1, 2733, 'rublevskoe-shosse'),
(287, 1, 'Нагорная улица', '', 10, 1, 1256, 'nagornaya-ulitsa'),
(288, 1, 'Подъемная улица', '', 10, 1, 1462, 'podemnaya-ulitsa'),
(289, 1, 'Карамышевская набережная', '', 10, 1, 2607, 'karamyshevskaya-naberezhnaya'),
(290, 1, '2-й Очаковский переулок', '', 10, 1, 2337, '2-y-ochakovskiy-pereulok'),
(291, 1, 'Ландышевая улица', '', 10, 1, 3778, 'landyshevaya-ulitsa'),
(292, 1, 'Большая Черемушкинская улица', '', 10, 1, 1866, 'bolshaya-cheremushkinskaya-ulitsa'),
(293, 1, 'улица Дмитрия Ульянова', '', 10, 1, 802, 'ulitsa-dmitriya-ulyanova'),
(294, 1, 'Прибрежный проезд', '', 10, 1, 250, 'pribrezhnyy-proezd'),
(295, 1, 'Верейская улица', '', 10, 1, 661, 'vereyskaya-ulitsa'),
(296, 1, '2-й Мосфильмовский переулок', '', 10, 1, 2275, '2-y-mosfilmovskiy-pereulok'),
(297, 1, 'улица Заречная', '', 10, 1, 65051, 'ulitsa-zarechnaya'),
(298, 1, 'Волынская улица', '', 10, 1, 705, 'volynskaya-ulitsa'),
(299, 1, 'улица Олений Вал', '', 10, 1, 1349, 'ulitsa-oleniy-val'),
(300, 1, 'Керамический проезд', '', 10, 1, 3078, 'keramicheskiy-proezd'),
(301, 1, 'Перовская улица', '', 10, 1, 1432, 'perovskaya-ulitsa'),
(302, 1, 'улица Кутузова', '', 10, 1, 1083, 'ulitsa-kutuzova'),
(303, 1, 'Херсонская улица', '', 10, 1, 1842, 'hersonskaya-ulitsa'),
(304, 1, 'Учинская улица', '', 10, 1, 1803, 'uchinskaya-ulitsa'),
(305, 1, 'Новокосинская улица', '', 10, 1, 1303, 'novokosinskaya-ulitsa'),
(306, 1, 'улица Бориса Галушкина', '', 10, 1, 608, 'ulitsa-borisa-galushkina'),
(307, 1, '8-я улица Соколиной Горы', '', 10, 1, 1657, '8-ya-ulitsa-sokolinoy-gory'),
(308, 1, 'улица Марьинский Парк', '', 10, 1, 10020, 'ulitsa-marinskiy-park'),
(309, 1, 'Сколковское шоссе', '', 10, 1, 2734, 'skolkovskoe-shosse'),
(310, 1, '1-я Напрудная улица', '', 10, 1, 1259, '1-ya-naprudnaya-ulitsa'),
(311, 1, 'улица Маршала Баграмяна', '', 10, 1, 26322, 'ulitsa-marshala-bagramyana'),
(312, 1, 'Шарикоподшипниковская улица', '', 10, 1, 1893, 'sharikopodshipnikovskaya-ulitsa'),
(313, 1, 'Карельский бульвар', '', 10, 1, 410, 'karelskiy-bulvar'),
(314, 1, 'улица Довженко', '', 10, 1, 809, 'ulitsa-dovzhenko'),
(315, 1, '3-й Павелецкий проезд', '', 10, 1, 228, '3-y-paveletskiy-proezd'),
(316, 1, 'Луховицкая улица', '', 10, 1, 1135, 'luhovitskaya-ulitsa'),
(317, 1, 'улица Щорса', '', 10, 1, 1917, 'ulitsa-schorsa'),
(318, 1, 'Гжатская улица', '', 10, 1, 740, 'gzhatskaya-ulitsa'),
(319, 1, 'улица Лобачевского', '', 10, 1, 1120, 'ulitsa-lobachevskogo'),
(320, 1, 'улица Старый Гай', '', 10, 1, 1700, 'ulitsa-staryy-gay'),
(321, 1, 'Люблинская улица', '', 10, 1, 1141, 'lyublinskaya-ulitsa'),
(322, 1, 'Белозерская улица', '', 10, 1, 581, 'belozerskaya-ulitsa'),
(323, 1, 'Холмогорская улица', '', 10, 1, 1847, 'holmogorskaya-ulitsa'),
(324, 1, 'Магаданская улица', '', 10, 1, 1145, 'magadanskaya-ulitsa'),
(325, 1, 'улица Вешних Вод', '', 10, 1, 676, 'ulitsa-veshnih-vod'),
(326, 1, 'улица Столетова', '', 10, 1, 1706, 'ulitsa-stoletova'),
(327, 1, 'улица Кашенкин Луг', '', 10, 1, 963, 'ulitsa-kashenkin-lug'),
(328, 1, 'улица Амундсена', '', 10, 1, 519, 'ulitsa-amundsena'),
(329, 1, 'улица Народного Ополчения', '', 10, 1, 1265, 'ulitsa-narodnogo-opolcheniya'),
(330, 1, 'улица Вилиса Лациса', '', 10, 1, 680, 'ulitsa-vilisa-latsisa'),
(331, 1, 'Ленинский проспект', '', 10, 1, 2795, 'leninskiy-prospekt'),
(332, 1, 'улица Федора Полетаева', '', 10, 1, 1807, 'ulitsa-fedora-poletaeva'),
(333, 1, 'улица Шеногина', '', 10, 1, 1896, 'ulitsa-shenogina'),
(334, 1, 'Днепропетровская улица', '', 10, 1, 803, 'dnepropetrovskaya-ulitsa'),
(335, 1, 'улица Островитянова', '', 10, 1, 1368, 'ulitsa-ostrovityanova'),
(336, 1, 'Минусинская улица', '', 10, 1, 1210, 'minusinskaya-ulitsa'),
(337, 1, 'Краснобогатырская улица', '', 10, 1, 1037, 'krasnobogatyrskaya-ulitsa'),
(338, 1, 'улица Обручева', '', 10, 1, 1337, 'ulitsa-obrucheva'),
(339, 1, 'Новая улица', '', 10, 1, 1289, 'novaya-ulitsa'),
(340, 1, 'Малахитовая улица', '', 10, 1, 1157, 'malahitovaya-ulitsa'),
(341, 1, 'Литовский бульвар', '', 10, 1, 416, 'litovskiy-bulvar'),
(342, 1, 'Миллионная улица', '', 10, 1, 1207, 'millionnaya-ulitsa'),
(343, 1, 'Илимская улица', '', 10, 1, 910, 'ilimskaya-ulitsa'),
(344, 1, 'Ясеневая улица', '', 10, 1, 1949, 'yasenevaya-ulitsa'),
(345, 1, 'Селигерская улица', '', 10, 1, 1617, 'seligerskaya-ulitsa'),
(346, 1, 'улица Академика Варги', '', 10, 1, 648, 'ulitsa-akademika-vargi'),
(347, 1, 'улица Кулакова', '', 10, 1, 1074, 'ulitsa-kulakova'),
(348, 1, 'Филевский бульвар', '', 10, 1, 437, 'filevskiy-bulvar'),
(349, 1, 'улица Пудовкина', '', 10, 1, 1517, 'ulitsa-pudovkina'),
(350, 1, 'улица Василия Петушкова', '', 10, 1, 651, 'ulitsa-vasiliya-petushkova'),
(351, 1, 'Батайский проезд', '', 10, 1, 14, 'batayskiy-proezd'),
(352, 1, 'Винницкая улица', '', 10, 1, 684, 'vinnitskaya-ulitsa'),
(353, 1, 'улица Соловьиная Роща', '', 10, 1, 3621, 'ulitsa-solovinaya-roscha'),
(354, 1, 'Смирновская улица', '', 10, 1, 1646, 'smirnovskaya-ulitsa'),
(355, 1, 'улица Теплый Стан', '', 10, 1, 1753, 'ulitsa-teplyy-stan'),
(356, 1, 'Соколово-Мещерская улица', '', 10, 1, 10022, 'sokolovo-mescherskaya-ulitsa'),
(357, 1, 'улица Дружбы', '', 10, 1, 18361, 'ulitsa-druzhby');

-- --------------------------------------------------------

--
-- Table structure for table `market_type`
--

CREATE TABLE `market_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `market_type`
--

INSERT INTO `market_type` (`id`, `title`, `title_en`, `sort_num`, `title_seo`) VALUES
(1, 'Вторичная недвижимость', '', 10, 'vtorichnaya-nedvizhimost'),
(2, 'Новостройка', '', 20, 'novostroyka');

-- --------------------------------------------------------

--
-- Table structure for table `meta_site`
--

CREATE TABLE `meta_site` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT '',
  `path_files` varchar(255) DEFAULT NULL,
  `own_domain` int(1) NOT NULL DEFAULT '0',
  `domain` varchar(255) DEFAULT NULL,
  `lang_title` varchar(255) NOT NULL DEFAULT '',
  `locale` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_site`
--

INSERT INTO `meta_site` (`id`, `title`, `path`, `path_files`, `own_domain`, `domain`, `lang_title`, `locale`) VALUES
('', 'Деловой', '', NULL, 1, NULL, 'Рус', 'ru_RU');

-- --------------------------------------------------------

--
-- Table structure for table `meta_site_lang`
--

CREATE TABLE `meta_site_lang` (
  `id` varchar(2) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `locale` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `meta_table`
--

CREATE TABLE `meta_table` (
  `id` varchar(40) NOT NULL,
  `table_name` varchar(40) DEFAULT NULL,
  `depends_on_site` int(1) NOT NULL DEFAULT '0',
  `filter_data_by_meta_table` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `sortable` int(1) NOT NULL DEFAULT '0',
  `editable` int(1) NOT NULL DEFAULT '0',
  `deletable` int(1) NOT NULL DEFAULT '0',
  `searchable` int(1) NOT NULL DEFAULT '0',
  `multi_lang` int(1) NOT NULL DEFAULT '0',
  `is_in_site_tree` int(1) NOT NULL DEFAULT '0',
  `is_in_extras` int(1) NOT NULL DEFAULT '0',
  `is_many2many` int(1) NOT NULL DEFAULT '0',
  `sql_filter` varchar(255) DEFAULT NULL,
  `title_list` varchar(255) DEFAULT NULL,
  `title_addnew` varchar(255) DEFAULT NULL,
  `title_in_delete_confirm` varchar(255) DEFAULT NULL,
  `is_system` int(1) NOT NULL DEFAULT '0',
  `frontend_passthrough` int(1) NOT NULL DEFAULT '0',
  `frontend_onpage_num` int(3) DEFAULT NULL,
  `frontend_act_param_name` varchar(40) DEFAULT NULL,
  `frontend_id_param_name` varchar(40) DEFAULT NULL,
  `frontend_on_all_pages` int(1) NOT NULL DEFAULT '0',
  `frontend_sql_filter` varchar(4000) DEFAULT NULL,
  `frontend_sql_order` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table`
--

INSERT INTO `meta_table` (`id`, `table_name`, `depends_on_site`, `filter_data_by_meta_table`, `title`, `sortable`, `editable`, `deletable`, `searchable`, `multi_lang`, `is_in_site_tree`, `is_in_extras`, `is_many2many`, `sql_filter`, `title_list`, `title_addnew`, `title_in_delete_confirm`, `is_system`, `frontend_passthrough`, `frontend_onpage_num`, `frontend_act_param_name`, `frontend_id_param_name`, `frontend_on_all_pages`, `frontend_sql_filter`, `frontend_sql_order`) VALUES
('amenity', 'amenity', 0, 0, 'Преимущество объекта', 0, 1, 1, 0, 0, 0, 1, 0, NULL, 'Преимущества объектов', 'Новое преимущество', 'преимущество', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('amenity2listing', 'amenity2listing', 0, 0, 'Связь преимущества с объявлением', 0, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('article', 'article', 1, 0, 'Статья', 1, 1, 1, 0, 1, 0, 0, 0, NULL, NULL, NULL, 'статью', 1, 1, NULL, NULL, NULL, 1, 'article.published', NULL),
('article_type', 'article_type', 0, 0, 'Тип статьи', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Типы статей', 'Новый тип статьи', NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('banner', 'banner', 0, 0, 'Баннер', 1, 1, 1, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, 'banner.published', NULL),
('banner_type', 'banner_type', 0, 0, 'Тип баннера', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Типы баннеров', 'Новый тип баннера', NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('building_type', 'building_type', 0, 0, 'Тип здания', 1, 1, 1, 0, 0, 0, 1, 0, NULL, 'Типы зданий', 'Новый тип', 'тип здания', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('client', 'company', 0, 0, 'Партнер', 1, 1, 1, 0, 0, 0, 1, 0, NULL, 'Партнеры', 'Новая компания', 'компанию', 0, 1, NULL, NULL, NULL, 0, 'company.published', NULL),
('color_scheme', 'color_scheme', 0, 0, 'Цветовая схема', 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('container', 'container', 0, 0, 'Меню', 1, 1, 1, 0, 0, 1, 0, 0, NULL, 'Меню', 'Новое меню', NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('currency', 'currency', 0, 0, 'Валюта', 0, 1, 1, 0, 0, 0, 1, 0, NULL, 'Валюты', 'Новая валюта', 'валюту', 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
('deal_type', 'deal_type', 0, 0, 'Тип сделки', 1, 1, 1, 0, 0, 0, 1, 0, NULL, 'Типы сделок', 'Новый тип', 'тип сделки', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('doc', 'doc', 1, 0, 'Документ', 1, 1, 1, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, 'doc.published', NULL),
('doc_folder', 'doc_folder', 1, 0, 'Группа документов', 0, 1, 1, 0, 0, 1, 0, 0, NULL, 'Группы документов', 'Новая группа документов', 'группу документов', 1, 1, NULL, NULL, NULL, 0, 'doc_folder.published', NULL),
('doc_folder2section', 'doc_folder2section', 0, 0, 'Связь группы документов с разделом', 1, 1, 1, 0, 0, 1, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('lang', 'meta_site_lang', 0, 0, 'Язык', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Языки сайта', 'Добавить язык', 'язык сайта', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('listing', 'listing', 0, 0, 'Объявление', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Объявления', 'Новое объявление', 'объявление', 0, 1, 10, 'type', 'detail', 0, 'listing.listing_status_id = 1 AND [listing.listing_type_id = {status}] AND [listing.property_type_id = {type}] AND [listing.property_subtype_id = {subtype}] AND [listing.bedrooms = {bedrooms}] AND [listing.price = {price}] AND [listing.loc_city_id = {city}] AND [(listing.loc_city_id <> {city_exclude} OR listing.loc_city_id IS NULL)] AND [listing.loc_region_id = {region}] AND [(listing.loc_region_id <> {region_exclude} OR listing.loc_region_id IS NULL)] AND [listing.loc_country_id = {country}] AND [(listing.loc_country_id <> {country_exclude} OR listing.loc_country_id IS NULL)] AND [is_suburb = {suburbs}] AND [listing.market_type_id = {market_type}] AND [loc_metro_id = {metro}] AND [loc_street_id = {street}] AND [loc_road_id = {road}]', NULL),
('listing_image', 'listing_image', 0, 1, 'Фотография объекта', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Фотографии', 'Новая фотография', 'фотографию', 0, 1, NULL, NULL, NULL, 0, 'listing_id = {detail}', NULL),
('listing_main', 'listing', 0, 0, 'Недвижимость на главной странице', 1, 1, 0, 0, 0, 0, 0, 0, 'featured', 'Недвижимость', NULL, NULL, 0, 1, NULL, NULL, NULL, 1, 'listing_status_id=1', NULL),
('listing_plan', 'listing_image', 0, 1, 'План этажа', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Планы этажей', 'Добавить план этажа', NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('listing_status', 'listing_status', 0, 0, 'Статус объявления', 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('listing_type', 'listing_type', 0, 0, 'Тип объявления', 1, 1, 0, 0, 0, 0, 1, 0, NULL, 'Типы объявлений', NULL, NULL, 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('listing_type2meta_table_field', 'listing_type2meta_table_field', 0, 0, 'Связь типа недвижимости с полем объявления', 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('listing_video', 'listing_video', 0, 0, 'Видео объекта', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Видео', 'Новое видео', 'видео', 0, 1, NULL, NULL, NULL, 0, 'listing_id = {detail}', NULL),
('loc_city', 'loc_city', 0, 0, 'Город', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Города', 'Новый город', 'город', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('loc_city_district', 'loc_city_district', 0, 0, 'Район города', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Районы', 'Новый район', 'район', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('loc_country', 'loc_country', 0, 0, 'Страна', 0, 1, 1, 0, 0, 0, 1, 0, NULL, 'Расположение', 'Новая страна', 'страну', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('loc_direction', 'loc_direction', 0, 0, 'Направление поиска', 0, 1, 0, 0, 0, 0, 0, 0, NULL, 'Направления поиска', 'Новое направление', NULL, 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('loc_metro', 'loc_metro', 0, 0, 'Метро', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Метро', 'Новая станция метро', 'станцию метро', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('loc_metro_line', 'loc_metro_line', 0, 0, 'Линия метро', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Линии метро', 'Новая линия', 'линию', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('loc_project', 'loc_project', 0, 0, 'Жилой комплекс', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Жилые комплексы', 'Новый жилой комплекс', 'жилой комплекс', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('loc_region', 'loc_region', 0, 0, 'Регион', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Регионы', 'Новый регион', 'регион', 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('loc_road', 'loc_road', 0, 0, 'Шоссе', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Шоссе', 'Новое шоссе', 'шоссе', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('loc_street', 'loc_street', 0, 0, 'Улица', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Улицы', 'Новая улица', 'улицу', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('market_type', 'market_type', 0, 0, 'Рынок недвижимости', 1, 1, 1, 0, 0, 0, 1, 0, NULL, 'Типы рынков недвижимости', 'Новый тип', 'тип рынка недвижимости', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('menu', 'section2container', 1, 0, 'Пункт меню', 1, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_copy', 'meta_table', 0, 0, 'Копирование мета таблицы', 0, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_field', 'meta_table_field', 0, 0, 'Поле', 1, 1, 1, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_table', 'meta_table', 0, 0, 'Таблица', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Таблицы', 'Новая таблица', 'таблицу', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_table2section_type', 'meta_table2section_type', 0, 0, 'Связь таблицы с типом раздела', 0, 1, 1, 0, 0, 1, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_table2table', 'meta_table2table', 0, 0, 'Связь между таблицами', 1, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_table_field_group', 'meta_table_field_group', 0, 0, 'Группа полей', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Группы полейединица измерения', 'Новая группа полей', 'группу полей', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('meta_table_field_option', 'meta_table_field_option', 0, 0, 'Опция выбора', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Опции выбора', 'Новая опция', 'опцию', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('news', 'news', 1, 1, 'Новость', 1, 1, 1, 0, 1, 0, 0, 0, NULL, 'Новости', 'Добавить новость', 'новость', 1, 1, 10, NULL, NULL, 0, 'news.published AND [news_tag_id = {news_tag}]', NULL),
('news_folder', 'news_folder', 1, 0, 'Группа новостей', 0, 1, 1, 0, 0, 1, 1, 0, NULL, 'Группы новостей', 'Новая группа новостей', 'группу новостей', 1, 1, 10, NULL, 'news', 0, 'news_folder.published', NULL),
('news_folder2section', 'news_folder2section', 0, 0, 'Связь группы новостей с разделом', 1, 1, 1, 0, 0, 1, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('news_tag', 'news_tag', 0, 0, 'Тег новости', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Теги новостей', 'Новый тег', NULL, 1, 1, NULL, NULL, NULL, 0, NULL, NULL),
('news_tag2news', 'news_tag2news', 0, 0, 'Связь тега с новостью', 0, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('password', 'user', 0, 0, 'Смена пароля', 0, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('password_generate', 'user', 0, 0, 'Генерация нового пароля', 0, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('price_term', 'price_term', 0, 0, 'Цена аренды за', 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL),
('property_subtype', 'property_subtype', 0, 0, 'Подтип недвижимости', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Подтипы недвижимости', 'Новый подтип', 'подтип недвижимости', 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('property_type', 'property_type', 0, 0, 'Тип недвижимости', 1, 1, 0, 0, 0, 0, 1, 0, NULL, 'Типы объектов недвижимости', NULL, NULL, 0, 1, NULL, NULL, NULL, 0, NULL, NULL),
('section', 'section', 1, 0, 'Раздел', 1, 1, 1, 0, 1, 1, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('section_type', 'section_type', 0, 0, 'Тип раздела', 0, 1, 1, 0, 0, 0, 0, 0, NULL, NULL, 'Новый тип раздела', NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('seo_parameter', 'seo_parameter', 0, 0, 'Параметр ЧПУ', 1, 1, 1, 0, 0, 0, 0, 0, NULL, 'Параметры ЧПУ', 'Новый параметр', NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('seo_parameter2section_type', 'seo_parameter2section_type', 0, 0, 'Связь параметра ЧПУ с типом раздела', 1, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('seo_parameter_gen', 'seo_parameter', 0, 0, 'Формирование значений параметра ЧПУ', 0, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('seo_url_data', 'seo_url_data', 0, 0, 'Данные SEO', 0, 1, 1, 0, 0, 1, 1, 0, NULL, 'Данные SEO', 'Новый URL', 'Данные SEO', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('setting', 'setting', 0, 0, 'Настройки', 0, 1, 0, 0, 0, 0, 1, 0, NULL, 'Настройки', NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('setting_admin', 'setting', 0, 0, 'Настройки сайта', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Настройки', 'Новая настройка', 'настройку', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('site', 'meta_site', 0, 0, 'Сайт', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Сайты', 'Добавить сайт', 'сайт', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('testimonial', 'news', 1, 1, 'Отзыв', 1, 1, 1, 0, 1, 1, 0, 0, NULL, 'Отзывы', 'Добавить отзыв', 'отзыв', 0, 1, NULL, NULL, NULL, 0, 'published', NULL),
('top_section', 'section', 1, 0, 'Сайт', 0, 1, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('unit', 'unit', 0, 0, 'Единица измерения', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Единицы измерения', 'Новая единица измерения', 'единицу измерения', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('user', 'user', 0, 0, 'Пользователь', 0, 1, 1, 0, 0, 0, 0, 0, NULL, 'Пользователи', 'Новый пользователь', 'пользователя', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('user2users_group', 'user2users_group', 0, 0, 'Связь пользователя с группой пользователей', 0, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('users_group', 'users_group', 0, 0, 'Группа пользователей', 0, 1, 1, 0, 0, 1, 0, 0, NULL, 'Группы пользователей', 'Новая группа пользователей', 'группу пользователей', 1, 0, NULL, NULL, NULL, 0, NULL, NULL),
('users_group2users', 'user2users_group', 0, 0, 'Связь группы пользователей c пользователем', 0, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meta_table2section_type`
--

CREATE TABLE `meta_table2section_type` (
  `id` int(11) NOT NULL,
  `meta_table_id` varchar(40) NOT NULL,
  `section_type_id` varchar(16) NOT NULL,
  `is_in_site_tree` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table2section_type`
--

INSERT INTO `meta_table2section_type` (`id`, `meta_table_id`, `section_type_id`, `is_in_site_tree`) VALUES
(3, 'testimonial', 'index', 1),
(4, 'banner', 'index', 0),
(10, 'listing_image', 'property_detail', 0),
(11, 'listing_video', 'property_detail', 0),
(12, 'news_folder', 'index', 1),
(13, 'news_folder', 'news', 1),
(14, 'listing', 'property_detail', 0),
(17, 'listing_type', 'property', 0),
(18, 'property_type', 'property', 0),
(19, 'property_subtype', 'property', 0),
(20, 'currency', 'property_detail', 0),
(21, 'currency', 'property', 0),
(22, 'loc_direction', 'property', 0),
(23, 'listing', 'property', 0),
(24, 'market_type', 'property', 0),
(25, 'testimonial', 'testimonials', 1),
(26, 'loc_metro_line', 'property', 0),
(27, 'loc_metro', 'property', 0),
(28, 'loc_street', 'property', 0),
(29, 'loc_road', 'property', 0),
(30, 'loc_city', 'property', 0),
(31, 'client', 'index', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meta_table2table`
--

CREATE TABLE `meta_table2table` (
  `id` int(11) NOT NULL,
  `meta_table_id` varchar(40) NOT NULL,
  `detail_meta_table_id` varchar(40) NOT NULL DEFAULT '0',
  `many2many_meta_table_id` varchar(40) DEFAULT NULL,
  `sort_num` int(1) NOT NULL DEFAULT '0',
  `title_subquery` varchar(255) DEFAULT NULL,
  `title_addnew` varchar(255) DEFAULT NULL,
  `is_bookmark` int(1) NOT NULL,
  `locked` int(1) NOT NULL DEFAULT '0',
  `condition_field` varchar(255) DEFAULT NULL,
  `condition_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table2table`
--

INSERT INTO `meta_table2table` (`id`, `meta_table_id`, `detail_meta_table_id`, `many2many_meta_table_id`, `sort_num`, `title_subquery`, `title_addnew`, `is_bookmark`, `locked`, `condition_field`, `condition_value`) VALUES
(1, 'section', 'section', NULL, 20, 'Подразделы', 'Новый подраздел', 0, 1, NULL, NULL),
(2, 'section', 'article', NULL, 30, 'Статьи', 'Новая статья', 0, 1, NULL, NULL),
(3, 'top_section', 'section', NULL, 1, 'Разделы', 'Новый раздел', 0, 1, NULL, NULL),
(4, 'container', 'menu', 'section', 1, 'Пункты меню', 'Добавить раздел в меню', 0, 1, NULL, NULL),
(5, 'meta_table', 'meta_field', NULL, 1, 'Поля', 'Новое поле', 0, 1, NULL, NULL),
(6, 'meta_table', 'meta_table2table', 'meta_table', 2, 'Связанные таблицы', 'Связанная таблица', 0, 1, NULL, NULL),
(7, 'news_folder', 'news', NULL, 10, 'Новости', 'Добавить новость', 0, 0, NULL, NULL),
(8, 'user', 'user2users_group', 'users_group', 10, 'Принадлежит к группам', 'Включить пользователя в группу', 0, 0, NULL, NULL),
(9, 'users_group', 'users_group2users', 'user', 10, 'Пользователи в группе', 'Включить в группу пользователя', 0, 0, NULL, NULL),
(10, 'section', 'news_folder2section', 'news_folder', 40, 'Группы новостей', 'Группа новостей', 0, 0, NULL, NULL),
(11, 'meta_field', 'meta_table_field_option', NULL, 10, 'Опции выбора', 'Новая опция выбора', 0, 0, 'type_extra', 'lookup_custom,lookup_multi'),
(12, 'doc_folder', 'doc', NULL, 10, 'Документы', 'Новый документ', 0, 0, NULL, NULL),
(13, 'section', 'doc_folder2section', 'doc_folder', 50, 'Группы документов', 'Группа документов', 0, 0, NULL, NULL),
(14, 'site', 'lang', NULL, 10, 'Дополнительные языки', 'Добавить язык', 0, 0, NULL, NULL),
(15, 'section_type', 'meta_table2section_type', 'meta_table', 10, 'Данные', 'Данные', 0, 0, NULL, NULL),
(16, 'section_type', 'seo_parameter2section_type', 'seo_parameter', 20, 'Параметры ЧПУ', 'Параметры ЧПУ', 0, 0, NULL, NULL),
(17, 'banner_type', 'banner', NULL, 10, 'Баннеры', 'Новый баннер', 0, 0, NULL, NULL),
(18, 'property_type', 'property_subtype', NULL, 10, 'Подтипы объектов', 'Новый подтип', 0, 0, NULL, NULL),
(19, 'loc_country', 'loc_region', NULL, 10, 'Регионы', 'Новый регион', 0, 0, NULL, NULL),
(20, 'loc_country', 'loc_city', NULL, 20, 'Города', 'Новый город', 0, 0, NULL, NULL),
(21, 'loc_region', 'loc_city', NULL, 10, 'Города', 'Новый город', 0, 0, NULL, NULL),
(22, 'loc_region', 'loc_road', NULL, 20, 'Шоссе', 'Новое шоссе', 0, 0, NULL, NULL),
(23, 'loc_city', 'loc_city_district', NULL, 10, 'Районы', 'Новый район', 1, 0, NULL, NULL),
(24, 'loc_city', 'loc_street', NULL, 20, 'Улицы', 'Новая улица', 1, 0, NULL, NULL),
(25, 'loc_city', 'loc_project', NULL, 30, 'Жилые комплексы', 'Новый жилой комплекс', 1, 0, NULL, NULL),
(26, 'loc_city', 'loc_metro_line', NULL, 40, 'Линии метро', 'Новая линия метро', 1, 0, NULL, NULL),
(27, 'loc_metro_line', 'loc_metro', NULL, 10, 'Станции метро', 'Новая станция метро', 0, 0, NULL, NULL),
(28, 'loc_city', 'loc_metro', NULL, 50, 'Станции метро', 'Новая станция метро', 1, 0, NULL, NULL),
(29, 'listing_type', 'listing', NULL, 10, 'Объявления', 'Новое объявление', 0, 0, NULL, NULL),
(34, 'listing', 'listing_image', NULL, 10, 'Фотографии', 'Новая фотография', 1, 0, NULL, NULL),
(35, 'listing', 'listing_video', NULL, 20, 'Видео', 'Новое видео', 1, 0, NULL, NULL),
(36, 'listing', 'listing_plan', NULL, 15, 'Планы этажей', 'План этажа', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meta_table_field`
--

CREATE TABLE `meta_table_field` (
  `id` int(11) NOT NULL,
  `field` varchar(32) NOT NULL DEFAULT '',
  `meta_table_id` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `meta_table_field_group_id` varchar(20) NOT NULL DEFAULT '',
  `type` varchar(16) NOT NULL DEFAULT '',
  `type_extra` varchar(16) DEFAULT NULL,
  `nullable` int(1) NOT NULL DEFAULT '0',
  `lookup_external_meta_table_id` varchar(40) DEFAULT NULL,
  `lookup_meta_table_field_id` int(11) DEFAULT NULL,
  `lookup_multi` int(1) NOT NULL DEFAULT '0',
  `lookup_filter` varchar(255) DEFAULT NULL,
  `lookup_quick_add` int(1) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `comment_en` text,
  `default_value` varchar(255) DEFAULT NULL,
  `unit_id` varchar(16) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `readonly` int(1) NOT NULL DEFAULT '0',
  `is_title` int(1) NOT NULL DEFAULT '0',
  `is_in_subquery` int(1) NOT NULL DEFAULT '0',
  `in_subquery_wide` int(1) NOT NULL DEFAULT '0',
  `default_order_num` int(2) DEFAULT NULL,
  `in_subquery_colnum` int(2) DEFAULT NULL,
  `in_subquery_title` varchar(255) DEFAULT NULL,
  `locked` int(1) NOT NULL DEFAULT '0',
  `editable` int(1) NOT NULL DEFAULT '0',
  `multi_lang` int(1) NOT NULL DEFAULT '0',
  `sql_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table_field`
--

INSERT INTO `meta_table_field` (`id`, `field`, `meta_table_id`, `title`, `title_en`, `meta_table_field_group_id`, `type`, `type_extra`, `nullable`, `lookup_external_meta_table_id`, `lookup_meta_table_field_id`, `lookup_multi`, `lookup_filter`, `lookup_quick_add`, `required`, `sort_num`, `comment`, `comment_en`, `default_value`, `unit_id`, `published`, `readonly`, `is_title`, `is_in_subquery`, `in_subquery_wide`, `default_order_num`, `in_subquery_colnum`, `in_subquery_title`, `locked`, `editable`, `multi_lang`, `sql_value`) VALUES
(1, 'article_type_id', 'article', 'Тип', '', '', 'varchar(16)', 'lookup', 0, NULL, 21, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 4, NULL, 0, 1, 0, NULL),
(2, 'body', 'article', 'Текст', '', '', 'mediumtext', 'html', 0, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(3, 'dir', 'section', 'Директория', '', '', 'varchar(64)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 4, NULL, 0, 1, 0, NULL),
(5, 'meta_description', 'section', 'Мета description', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 140, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(6, 'name', 'news_folder', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 1, 2, NULL, 0, 1, 0, NULL),
(7, 'name', 'section_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(8, 'path', 'section', 'Путь', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(9, 'published', 'article', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 1, 0, NULL),
(10, 'published', 'news_folder', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 2, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 1, 0, NULL),
(11, 'published', 'section', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 120, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 1, 0, NULL),
(12, 'section_id', 'article', 'Раздел', '', '', 'int(11)', 'lookup', 0, NULL, 19, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(13, 'section_id', 'section', 'Родительский раздел', '', '', 'int(11)', 'lookup', 1, NULL, 19, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(14, 'section_type_id', 'section', 'Тип', '', '', 'varchar(16)', 'lookup', 0, NULL, 7, 0, 'published<>0', 0, 1, 60, NULL, NULL, 'article', NULL, 1, 0, 0, 1, 0, NULL, 5, NULL, 0, 1, 0, NULL),
(15, 'sort_num', 'article', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 70, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 2, 1, 'Порядок', 0, 1, 0, NULL),
(16, 'sort_num', 'section', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(17, 'target_blank', 'section', 'В новом окне', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(18, 'title', 'article', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 3, NULL, 0, 1, 1, NULL),
(19, 'title', 'section', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 2, NULL, 0, 1, 1, NULL),
(20, 'url', 'section', 'Ссылка', '', '', 'varchar(255)', 'url', 1, NULL, NULL, 0, NULL, 0, 0, 70, 'Для разделов типа \'Ссылка\'', NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(21, 'name', 'article_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 1, 0, NULL),
(22, 'name', 'container', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, 1, NULL, NULL, 0, 1, 0, NULL),
(23, 'meta_title', 'top_section', 'Заголовок окна', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, 0, NULL, NULL, 0, 1, 1, NULL),
(24, 'news_folder_id', 'news_folder2section', 'Группа публикаций', '', '', 'int(11)', 'lookup', 0, NULL, 6, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 1, 2, 'Наименование', 0, 1, 0, NULL),
(26, 'container_id', 'menu', 'Меню', '', '', 'int(11)', 'lookup', 0, NULL, 22, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(27, 'section_id', 'menu', 'Раздел', '', '', 'int(11)', 'lookup', 0, NULL, 19, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(28, 'sort_num', 'menu', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(29, 'title', 'menu', 'Наименование в меню', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, NULL, 0, 1, 1, NULL),
(30, 'name', 'setting', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, 1, NULL, 0, 1, 0, NULL),
(31, 'value', 'setting', 'Значение', '', '', 'text', 'html', 1, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 2, NULL, 0, 1, 0, NULL),
(32, 'type', 'setting', 'Тип', '', '', 'varchar(8)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(33, 'id', 'meta_table', 'Мета-таблица', '', '', 'varchar(32)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 1, 0, NULL),
(34, 'table_name', 'meta_table', 'Таблица в БД', '', '', 'varchar(32)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 4, NULL, 0, 1, 0, NULL),
(35, 'depends_on_site', 'meta_table', 'Свои данные для сайта', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(36, 'title', 'meta_table', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 1, 2, NULL, 0, 1, 0, NULL),
(37, 'sortable', 'meta_table', 'Сортируется', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(38, 'editable', 'meta_table', 'Редактируется', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 70, NULL, NULL, '1', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(39, 'deletable', 'meta_table', 'Добавляется/Удаляется', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(40, 'is_in_site_tree', 'meta_table', 'В дереве сайта', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 90, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(41, 'is_many2many', 'meta_table', 'Многие ко многим', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(42, 'title_list', 'meta_table', 'Заголовок в списке', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(43, 'title_addnew', 'meta_table', 'На кнопке добавления', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 120, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(44, 'title_in_delete_confirm', 'meta_table', 'В запросе на удаление', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 130, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(45, 'meta_table_id', 'meta_table2table', 'Мастер таблица', '', '', 'varchar(32)', 'lookup', 0, NULL, 36, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(46, 'detail_meta_table_id', 'meta_table2table', 'Таблица', '', '', 'varchar(32)', 'lookup', 0, NULL, 36, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(47, 'many2many_meta_table_id', 'meta_table2table', 'Таблица многие ко многим', '', '', 'varchar(32)', 'lookup', 1, NULL, 36, 0, NULL, 0, 0, 3, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(48, 'sort_num', 'meta_table2table', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 2, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(49, 'field', 'meta_field', 'Имя поля', '', '', 'varchar(32)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(50, 'meta_table_id', 'meta_field', 'Мета таблица', '', '', 'varchar(32)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(51, 'title', 'meta_field', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(52, 'sort_num', 'meta_field', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 200, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 2, 1, 'Порядок', 0, 1, 0, NULL),
(53, 'type', 'meta_field', 'Тип поля', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, 'varchar(255)', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(54, 'type_extra', 'meta_field', 'Тип в системе', '', '', 'varchar(16)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 4, 'Тип', 0, 1, 0, NULL),
(55, 'nullable', 'meta_field', 'Может быть NULL', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(56, 'lookup_meta_table_field_id', 'meta_field', 'Поле для lookup', '', '', 'int(11)', 'lookup', 0, NULL, 51, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(57, 'required', 'meta_field', 'Обязательное поле', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 90, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(58, 'comment', 'meta_field', 'Комментарий к полю', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 130, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(59, 'default_value', 'meta_field', 'Значение по умолчанию', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 120, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(60, 'published', 'meta_field', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 210, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 1, 0, NULL),
(61, 'readonly', 'meta_field', 'Только для чтения', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 140, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(62, 'is_title', 'meta_field', 'Является заголовком', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(63, 'is_in_subquery', 'meta_field', 'Показывать в списке', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 150, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(64, 'in_subquery_wide', 'meta_field', 'В списке: широкий', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 160, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(65, 'in_subquery_colnum', 'meta_field', 'В списке: столбец номер', '', '', 'int(2)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 170, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(66, 'in_subquery_title', 'meta_field', 'В списке: наименование', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 180, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(67, 'default_order_num', 'meta_field', 'В списке: упорядочивать', '', '', 'int(2)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 190, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(68, 'news_folder_id', 'news', 'Группа публикаций', '', '', 'int(11)', 'lookup', 0, NULL, 6, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(69, 'title', 'news', 'Заголовок', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 4, NULL, 0, 1, 1, NULL),
(70, 'produced', 'news', 'Дата', '', '', 'datetime', 'date', 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 1, 0, NULL),
(71, 'annotation', 'news', 'Краткий текст', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(72, 'body', 'news', 'Текст', '', '', 'mediumtext', 'html', 1, NULL, NULL, 0, NULL, 0, 0, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(73, 'published', 'news', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 1, 0, NULL),
(74, 'img_src', 'section', 'Картинка с названием', '', '', 'varchar(255)', 'image', 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(81, 'title_subquery', 'meta_table2table', 'Заголовок списка', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 4, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(82, 'title_addnew', 'meta_table2table', 'На кнопке добавления', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 5, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(98, 'title', 'users_group', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 1, 2, NULL, 0, 1, 0, NULL),
(99, 'name', 'users_group', 'Системное имя', '', '', 'varchar(32)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(101, 'login', 'user', 'Логин', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(103, 'middlename', 'user', 'Отчество', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(104, 'surname', 'user', 'Фамилия', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 3, NULL, 0, 1, 0, NULL),
(105, 'enabled', 'user', 'Разрешен доступ', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 90, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 0, 'Доступ', 0, 1, 0, NULL),
(106, 'email', 'user', 'E-mail', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 5, NULL, 0, 1, 0, NULL),
(107, 'name', 'user', 'Имя', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 4, NULL, 0, 1, 0, NULL),
(108, 'user_id', 'user2users_group', 'Пользователь', '', '', 'int(11)', 'lookup', 0, NULL, 101, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(109, 'users_group_id', 'user2users_group', 'Группа пользователей', '', '', 'int(11)', 'lookup', 0, NULL, 98, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(110, 'user_id', 'users_group2users', 'Пользователь', '', '', 'int(11)', 'lookup', 0, NULL, 101, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(111, 'users_group_id', 'users_group2users', 'Группа пользователей', '', '', 'int(11)', 'lookup', 0, NULL, 98, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(112, 'protected', 'section', 'Личный раздел', '', '', 'int(11)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(124, 'phone', 'user', 'Контактный телефон', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 6, 'Телефон', 0, 1, 0, NULL),
(134, 'login', 'password', 'Логин', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(135, 'surname', 'password', 'Фамилия', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(136, 'name', 'password', 'Имя', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(140, 'email', 'password_generate', 'E-mail', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(141, 'surname', 'password_generate', 'Фамилия', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(142, 'name', 'password_generate', 'Имя', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(150, 'title', 'meta_copy', 'Таблица', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(159, 'img_src', 'menu', 'Иконка', '', '', 'varchar(255)', 'image', 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(223, 'title', 'site', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, NULL, 1, NULL, 0, 1, 0, NULL),
(224, 'path', 'site', 'Путь', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 2, NULL, 0, 1, 0, NULL),
(226, 'path_files', 'site', 'Путь к файлам сайта', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(227, 'id', 'site', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 1, 0, NULL),
(262, 'is_bookmark', 'meta_table2table', 'Оформить закладкой', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(275, 'id', 'section_type', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 1, 0, NULL),
(311, 'img_src', 'news', 'Картинка (218х205)', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(313, 'id', 'container', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 1, 0, NULL),
(356, 'name', 'setting_admin', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 1, NULL, 0, 1, 0, NULL),
(358, 'type', 'setting_admin', 'Тип', '', '', 'varchar(8)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(359, 'id', 'setting_admin', 'Иденитификатор', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 1, 0, NULL),
(435, 'title', 'unit', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, NULL),
(436, 'sort_num', 'unit', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 0, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(440, 'id', 'unit', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 1, 0, NULL),
(466, 'title', 'meta_table_field_option', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, 3, 4, NULL, 0, 1, 1, NULL),
(468, 'sort_num', 'meta_table_field_option', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(470, 'published', 'meta_table_field_option', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 1, 0, NULL),
(667, 'sql_filter', 'meta_table', 'Фильтр записей (SQL)', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 140, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(676, 'multi_lang', 'meta_field', 'На разных языках', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(687, 'img_src', 'meta_table_field_option', 'Иконка', '', '', 'varchar(255)', 'image', 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(839, 'domain', 'site', 'Домены', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 50, 'Список доменов через пробел', NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(840, 'locale', 'site', 'Локаль', '', '', 'varchar(8)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(881, 'lookup_multi', 'meta_field', 'Множественный выбор', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 70, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(883, 'is_group_title', 'meta_table_field_option', 'Название группы опций', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, '0', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(1382, 'lookup_filter', 'meta_field', 'Фильтр записей lookup (SQL)', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 65, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(1532, 'company', 'user', 'Организация', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 7, NULL, 0, 0, 0, NULL),
(1533, 'position', 'user', 'Должность', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 80, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2385, 'created', 'user', 'Дата регистрации', '', '', 'datetime', 'datetime', 0, NULL, NULL, 0, NULL, 0, 1, 85, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, 1, 'Регистрация', 0, 0, 0, NULL),
(2386, 'unit_id', 'meta_field', 'Единица измерения', '', '', 'varchar(16)', 'lookup', 1, NULL, 435, 0, NULL, 0, 0, 135, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(2390, 'title', 'currency', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 1, NULL),
(2391, 'sort_num', 'currency', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(2392, 'id', 'currency', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 1, 0, NULL),
(2393, 'rate', 'currency', 'Курс', '', '', 'float', 'float', 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 0, 0, NULL),
(2421, 'admin_access', 'users_group', 'Доступ только к', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 30, 'Идентификаторы мета-таблиц, через запятую', NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2468, 'doc_folder_id', 'doc', 'Группа документов', '', '', 'int(11)', 'lookup', 0, NULL, 2475, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2469, 'title', 'doc', 'Заголовок', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 3, NULL, 0, 0, 1, NULL),
(2473, 'published', 'doc', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 0, 0, NULL),
(2474, 'doc_src', 'doc', 'Файл', '', '', 'varchar(255)', 'doc', 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2475, 'name', 'doc_folder', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 1, 2, NULL, 0, 0, 0, NULL),
(2476, 'published', 'doc_folder', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 2, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(2477, 'doc_folder_id', 'doc_folder2section', 'Группа документов', '', '', 'int(11)', 'lookup', 0, NULL, 2475, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 2, 'Наименование', 0, 0, 0, NULL),
(2480, 'sort_num', 'doc', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(2819, 'id', 'seo_parameter', 'Имя параметра в ЧПУ', '', '', 'varchar(40)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(2820, 'sort_num', 'seo_parameter', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(2821, 'real_name', 'seo_parameter', 'Имя GET-параметра', '', '', 'varchar(40)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 20, NULL, 0, 0, 0, NULL),
(2822, 'meta_table_field_id', 'seo_parameter', 'Текстовое значение взять в поле', '', '', 'int(11)', 'lookup', 1, NULL, 51, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2823, 'is_multi_value', 'seo_parameter', 'Может иметь несколько значений', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, 5, 'Множ.', 0, 0, 0, NULL),
(2824, 'id', 'seo_parameter_gen', 'Имя параметра в ЧПУ', '', '', 'varchar(40)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(2826, 'real_name', 'seo_parameter_gen', 'Имя GET-параметра', '', '', 'varchar(40)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(2827, 'meta_table_field_id', 'seo_parameter_gen', 'Где искать ID для передачи в GET', '', '', 'int(11)', 'lookup', 0, NULL, 51, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2829, 'published', 'seo_parameter', 'Включить', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, '1', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(2918, 'lookup_external_meta_table_id', 'meta_field', 'Таблица связи для lookup', '', '', 'varchar(40)', 'lookup', 0, NULL, 36, 0, 'is_many2many<>0', 0, 0, 61, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(2921, 'img_src_big', 'news', 'Картинка', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3085, 'sql_value', 'meta_field', 'Вычисляемое значение (SQL)', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 67, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3086, 'activated__real', 'seo_parameter', 'Активен', '', '', 'varchar(255)', 'calc_boolean', 0, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Актив.', 0, 0, 0, 'seo_parameter.published AND (seo_parameter.activated OR seo_parameter.type_id <> \'\' OR meta_table_field_id IS NULL)'),
(3094, 'type_id', 'seo_parameter', 'Тип', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 25, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 30, NULL, 0, 0, 0, NULL),
(3095, 'activated', 'seo_parameter', 'Текстовые значения сформированы', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 0, 65, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3097, 'title', 'seo_parameter', 'Текст в заголовке окна (title)', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 35, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1, NULL),
(3135, 'url', 'seo_url_data', 'URL', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 2, NULL, 0, 0, 0, NULL),
(3136, 'title', 'seo_url_data', 'TITLE', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, 10, NULL, 0, 0, 0, NULL),
(3137, 'meta_keywords', 'seo_url_data', 'META Keywords', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3138, 'meta_description', 'seo_url_data', 'META Description', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3139, 'body', 'seo_url_data', 'SEO-текст', '', '', 'text', 'html', 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3140, 'published', 'seo_url_data', 'Публиковать', '', '', 'varchar(255)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 70, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3141, 'meta_description', 'top_section', 'Meta description', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3154, 'own_domain', 'site', 'Свой домен', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 0, 45, NULL, NULL, '0', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3167, 'title', 'lang', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, NULL, 1, NULL, 0, 1, 0, NULL),
(3170, 'id', 'lang', 'Идентификатор', '', '', 'varchar(2)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, NULL, 0, 1, 0, NULL),
(3172, 'locale', 'lang', 'Локаль', '', '', 'varchar(8)', NULL, 1, NULL, NULL, 0, '', 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(3174, 'domain', 'lang', 'Домен', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3175, 'meta_title', 'section', 'Meta title', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 130, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1, NULL),
(3176, 'hidden', 'section', 'Не показывать в меню', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 115, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3177, 'meta_table_id', 'section_type', 'Данные из таблиц', '', '', 'varchar(40)', 'lookup_external', 1, 'meta_table2section_type', 36, 1, 'frontend_passthrough', 0, 0, 40, 'Передать в шаблон данные из указанных таблиц в массиве $_DATA', NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3179, 'id', 'article_type', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 20, NULL, 0, 0, 0, NULL),
(3180, 'published', 'section_type', 'Активен', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Акт.', 0, 0, 0, NULL),
(3185, 'published', 'news_folder2section', 'Публиковать', '', '', 'int(1)', 'calc_boolean', 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, 'SELECT published FROM news_folder WHERE news_folder.id=news_folder_id'),
(3186, 'published', 'doc_folder2section', 'Публиковать', '', '', 'int(1)', 'calc_boolean', 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, 'SELECT published FROM doc_folder WHERE doc_folder.id=doc_folder_id'),
(3187, 'frontend_passthrough', 'meta_table', 'Сайт: передавать данные', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 150, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Сайт', 0, 0, 0, NULL),
(3188, 'frontend_onpage_num', 'meta_table', 'Сайт: записей на странице', '', '', 'int(3)', 'number', 1, NULL, NULL, 0, NULL, 0, 0, 180, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3189, 'frontend_sql_filter', 'meta_table', 'Сайт: SQL фильтр', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 210, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3229, 'name', 'banner_type', 'Название', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 2, NULL, 0, 0, 0, NULL),
(3230, 'sort_num', 'banner_type', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 0, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3233, 'banner_type_id', 'banner', 'Тип баннера', '', '', 'varchar(40)', 'hidden', 0, NULL, 3229, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3234, 'title', 'banner', 'Заголовок', '', '', 'varchar(30)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 3, NULL, 0, 0, 0, NULL),
(3235, 'published', 'banner', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 120, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 0, 0, ''),
(3236, 'img_src', 'banner', 'Картинка', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, 'banners', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3237, 'sort_num', 'banner', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 0, 110, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3238, 'body', 'banner', 'Текст', '', '', 'text', 'textarea', 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3239, 'url', 'banner', 'Cсылка', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3240, 'url_title', 'banner', 'Надпись на ссылке', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3241, 'id', 'banner_type', 'Идентификатор', '', '', 'varchar(40)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3243, 'frontend_id_param_name', 'meta_table', 'Сайт: имя параметра с id', '', '', 'varchar(40)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 200, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3244, 'frontend_on_all_pages', 'meta_table', 'Сайт: на все страницы', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 160, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3245, 'meta_table_id', 'meta_table2section_type', 'Таблица', '', '', 'varchar(40)', 'lookup', 0, 'meta_table2section_type', 36, 0, 'meta_table.frontend_passthrough <> 0', 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 2, 'Название', 0, 0, 0, NULL),
(3246, 'section_type_id', 'meta_table', 'Сайт: на страницы типов', '', '', 'varchar(16)', 'lookup_external', 1, 'meta_table2section_type', 7, 1, 'section_type.is_system = 0', 0, 0, 170, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3247, 'is_system', 'section_type', 'Системный', '', '', 'int(1)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3260, 'is_in_extras', 'meta_table', 'В настройках', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3272, 'sort_num', 'doc_folder2section', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 5, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3273, 'sort_num', 'news_folder2section', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 5, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3275, 'annotation', 'doc', 'Описание', '', '', 'text', 'html', 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1, NULL),
(3276, 'img_src', 'doc', 'Иконка', '', '', 'varchar(255)', 'image', 1, NULL, NULL, 0, NULL, 0, 0, 35, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3278, 'lang_title', 'site', 'Язык', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 55, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 19, 'Язык', 0, 0, 0, NULL),
(3282, 'is_in_site_tree', 'meta_table2section_type', 'В дереве сайта', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'В дереве', 0, 0, 0, NULL),
(3288, 'sort_num', 'seo_parameter2section_type', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3362, 'name', 'color_scheme', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 1, 0, ''),
(3363, 'id', 'color_scheme', 'Идентификатор CSS', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 20, NULL, 0, 0, 0, NULL),
(3364, 'color_scheme_id', 'banner', 'Цветовое оформление', '', '', 'varchar(16)', 'lookup', 0, NULL, 3362, 0, NULL, 0, 1, 90, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3365, 'img_src_big', 'banner', 'Картинка исходная', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, 'banners', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3372, 'w', 'banner_type', 'Ширина', '', '', 'int(4)', 'number', 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3373, 'h', 'banner_type', 'Высота', '', '', 'int(4)', 'number', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3374, 'title', 'banner_type', 'Заголовок', '', '', 'varchar(255)', 'calc', 0, NULL, NULL, 0, NULL, 0, 0, 25, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 1, NULL, 0, 0, 0, 'CONCAT(banner_type.name,\' (\',banner_type.w,\'x\',banner_type.h,\')\')'),
(3375, 'bg_color', 'banner', 'Цвет фона', '', '', 'varchar(16)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 100, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3378, 'video_url', 'banner', 'Ссылка на видео (YouTube)', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3429, 'redirect_url', 'seo_url_data', 'Redirect 301', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(3430, 'title', 'news_tag', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 10, 2, NULL, 0, 1, 1, NULL),
(3431, 'news_tag_id', 'news_tag2news', 'Тег', '', '', 'int(11)', 'lookup', 0, NULL, 3430, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 10, 1, NULL, 0, 1, 0, NULL),
(3432, 'news_id', 'news_tag2news', 'Публикация', '', '', 'int(11)', 'lookup', 0, NULL, 69, 0, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(3433, 'news_tag_id', 'news', 'Тег', '', '', 'varchar(255)', 'lookup_external', 0, 'news_tag2news', 3430, 1, NULL, 0, 0, 90, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 4, NULL, 0, 0, 0, NULL),
(3461, 'seo_parameter_id', 'seo_parameter2section_type', 'Параметр ЧПУ', '', '', 'varchar(40)', 'lookup', 0, NULL, 2819, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 2, 'Имя параметра', 0, 0, 0, NULL),
(3474, 'frontend_act_param_name', 'meta_table', 'Сайт: имя параметра активации', '', '', 'varchar(40)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 190, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3506, 'img_src_detail', 'news', 'Картинка (545х375)', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3535, 'title', 'meta_table_field_group', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 2, NULL, 0, 1, 0, ''),
(3536, 'sort_num', 'meta_table_field_group', 'Порядок следования', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 1, 0, NULL),
(3537, 'id', 'meta_table_field_group', 'Идентификатор', '', '', 'varchar(16)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 10, NULL, 0, 1, 0, ''),
(3539, 'meta_table_field_group_id', 'meta_field', 'Группа', '', '', 'varchar(20)', 'lookup', 0, NULL, 3535, 0, NULL, 0, 0, 69, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, 10, NULL, 0, 0, 0, NULL),
(3566, 'searchable', 'meta_table', 'С поиском', '', '', 'varchar(255)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 0, 85, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3581, 'multi_lang', 'meta_table', 'На разных языках', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 75, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3583, 'meta_site_lang_id', 'news', 'Язык', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 4, NULL, 0, 0, 0, NULL),
(3585, 'multi_lang', 'setting_admin', 'На разных языках', '', '', 'int(0)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3586, 'multi_lang', 'setting', 'На разных языках', '', '', 'int(1)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3589, 'title', 'property_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 1, NULL),
(3590, 'sort_num', 'property_type', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3591, 'title', 'listing_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3592, 'sort_num', 'listing_type', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3593, 'title', 'property_subtype', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 20, NULL, 0, 0, 1, NULL),
(3594, 'sort_num', 'property_subtype', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 5, NULL, 0, 0, 0, NULL),
(3595, 'property_type_id', 'property_subtype', 'Тип объекта', '', '', 'int(5)', 'lookup', 0, NULL, 3589, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3596, 'published', 'property_subtype', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3597, 'listing_type_id', 'property_subtype', 'В разделах', '', '', 'varchar(40)', 'lookup', 0, NULL, 3591, 1, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 15, NULL, 0, 0, 0, NULL),
(3598, 'title', 'loc_country', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3599, 'sort_num', 'loc_country', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3600, 'title', 'loc_city', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3601, 'sort_num', 'loc_city', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3602, 'published', 'loc_city', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 5, 'Публ.', 0, 0, 0, NULL),
(3603, 'loc_country_id', 'loc_city', 'Страна', '', '', 'int(5)', 'lookup', 0, NULL, 3598, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3604, 'published', 'loc_country', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3605, 'title', 'loc_region', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3606, 'sort_num', 'loc_region', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3607, 'published', 'loc_region', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, ''),
(3608, 'loc_country_id', 'loc_region', 'Страна', '', '', 'int(5)', 'lookup', 0, NULL, 3598, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3609, 'loc_region_id', 'loc_city', 'Регион', '', '', 'int(5)', 'lookup', 0, NULL, 3605, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3610, 'title', 'loc_road', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3611, 'sort_num', 'loc_road', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3612, 'published', 'loc_road', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, ''),
(3614, 'loc_region_id', 'loc_road', 'Регион', '', '', 'int(5)', 'lookup', 0, NULL, 3605, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3615, 'is_region_center', 'loc_city', 'Центр региона', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 6, 'Центр', 0, 0, 0, NULL),
(3616, 'is_suburb', 'loc_city', 'Пригород центра', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 7, 'Ближ.', 0, 0, 0, NULL),
(3617, 'title', 'loc_city_district', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3618, 'sort_num', 'loc_city_district', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3619, 'published', 'loc_city_district', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, ''),
(3620, 'loc_city_id', 'loc_city_district', 'Город', '', '', 'int(5)', 'lookup', 0, NULL, 3600, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3621, 'title', 'loc_street', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3622, 'sort_num', 'loc_street', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 0, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3623, 'published', 'loc_street', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3624, 'loc_city_id', 'loc_street', 'Город', '', '', 'int(5)', 'lookup', 0, NULL, 3600, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, ''),
(3625, 'title', 'loc_project', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3626, 'sort_num', 'loc_project', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 0, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3627, 'published', 'loc_project', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3628, 'loc_city_id', 'loc_project', 'Город', '', '', 'int(5)', 'lookup', 0, NULL, 3600, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, ''),
(3629, 'title', 'loc_metro_line', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL);
INSERT INTO `meta_table_field` (`id`, `field`, `meta_table_id`, `title`, `title_en`, `meta_table_field_group_id`, `type`, `type_extra`, `nullable`, `lookup_external_meta_table_id`, `lookup_meta_table_field_id`, `lookup_multi`, `lookup_filter`, `lookup_quick_add`, `required`, `sort_num`, `comment`, `comment_en`, `default_value`, `unit_id`, `published`, `readonly`, `is_title`, `is_in_subquery`, `in_subquery_wide`, `default_order_num`, `in_subquery_colnum`, `in_subquery_title`, `locked`, `editable`, `multi_lang`, `sql_value`) VALUES
(3630, 'sort_num', 'loc_metro_line', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3631, 'published', 'loc_metro_line', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, ''),
(3632, 'loc_city_id', 'loc_metro_line', 'Город', '', '', 'int(5)', 'lookup', 0, NULL, 3600, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, ''),
(3633, 'color', 'loc_metro_line', 'Цвет', '', '', 'varchar(40)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3634, 'title', 'loc_metro', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3635, 'sort_num', 'loc_metro', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3636, 'published', 'loc_metro', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, ''),
(3637, 'loc_city_id', 'loc_metro', 'Город', '', '', 'int(5)', 'lookup', 0, NULL, 3600, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, ''),
(3638, 'loc_metro_line_id', 'loc_metro', 'Линия метро', '', '', 'int(5)', 'lookup', 0, NULL, 3629, 1, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(3665, 'title', 'listing_status', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3671, 'title', 'building_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3672, 'sort_num', 'building_type', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3679, 'title', 'market_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3680, 'sort_num', 'market_type', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3683, 'title', 'deal_type', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3684, 'sort_num', 'deal_type', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3721, 'title', 'price_term', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, ''),
(3722, 'sort_num', 'price_term', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3728, 'title', 'amenity', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 2, 10, NULL, 0, 0, 0, NULL),
(3729, 'sort_num', 'amenity', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, ''),
(3730, 'amenity_id', 'amenity2listing', 'Преимущество', '', '', 'int(11)', 'lookup', 0, NULL, 3728, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 10, 1, NULL, 0, 1, 0, NULL),
(3731, 'listing_id', 'amenity2listing', 'Объявление', '', '', 'int(11)', 'lookup', 0, NULL, NULL, 0, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(3749, 'title', 'listing_image', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3750, 'sort_num', 'listing_image', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3751, 'published', 'listing_image', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3754, 'img_src_original', 'listing_image', 'Картинка исходная', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, 'properties/{Y}/{M}/{listing_id}', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3755, 'img_src', 'listing_image', 'Картинка на сайте (?x566)', '', '', 'varchar(255)', 'image_preview', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, 'properties', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3756, 'img_src_thumb', 'listing_image', 'Картинка уменьшенная (173x115)', '', '', 'varchar(255)', 'image_preview', 0, NULL, NULL, 0, NULL, 0, 1, 70, NULL, NULL, 'properties', NULL, 1, 0, 1, 0, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3757, 'title', 'listing_video', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3758, 'sort_num', 'listing_video', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 90, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3759, 'published', 'listing_video', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3761, 'poster_img_src_original', 'listing_video', 'Картинка (постер) исходная', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, 'properties', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3762, 'poster_img_src', 'listing_video', 'Постер на сайте (770x513)', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, 'properties', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3763, 'poster_img_src_thumb', 'listing_video', 'Постер уменьшенный (173x115)', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 80, NULL, NULL, 'properties', NULL, 1, 0, 1, 0, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3764, 'video_src_mp4', 'listing_video', 'Файл видео (mp4)', '', '', 'varchar(255)', 'video', 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3765, 'video_src_webm', 'listing_video', 'Файл видео (webm)', '', '', 'varchar(255)', 'video', 1, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3766, 'video_url', 'listing_video', 'Ссылка', '', '', 'varchar(300)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3769, 'news_folder_id', 'testimonial', 'Группа публикаций', '', '', 'int(11)', 'hidden', 0, NULL, 6, 0, NULL, 0, 0, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(3770, 'title', 'testimonial', 'Персона', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 4, NULL, 0, 1, 1, NULL),
(3771, 'produced', 'testimonial', 'Дата', '', '', 'datetime', 'date', 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1, 1, NULL, 0, 1, 0, NULL),
(3772, 'annotation', 'testimonial', 'О персоне', '', '', 'varchar(255)', 'textarea', 1, NULL, NULL, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(3773, 'body', 'testimonial', 'Отзыв', '', '', 'mediumtext', 'html', 1, NULL, NULL, 0, NULL, 0, 1, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 1, NULL),
(3774, 'published', 'testimonial', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 1, 0, NULL),
(3775, 'img_src', 'testimonial', 'Фото (70х70)', '', '', 'varchar(255)', 'image_preview', 1, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, 'persons', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 1, 0, NULL),
(3776, 'img_src_big', 'testimonial', 'Фото', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, 'persons', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3777, 'news_tag_id', 'testimonial', 'Тег', '', '', 'varchar(255)', 'lookup_external', 0, 'news_tag2news', 3430, 1, '', 0, 0, 90, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 4, NULL, 0, 0, 0, NULL),
(3779, 'meta_site_lang_id', 'testimonial', 'Язык', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 4, NULL, 0, 0, 0, NULL),
(3780, 'sort_num', 'testimonial', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3786, 'filter_data_by_meta_table', 'meta_table', 'Свои данные для мета-таблицы', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 45, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3787, 'title', 'listing_main', 'Заголовок', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3789, 'featured_sort_num', 'listing_main', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 120, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3790, 'published', 'listing_main', 'Опубликовано на сайте', '', '', 'int(1)', 'calc_boolean', 0, NULL, NULL, 0, NULL, 0, 0, 100, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 3, 'Публ.', 0, 0, 0, 'listing_status_id=1'),
(3791, 'featured', 'listing_main', 'Показывать на главной', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, 2, 'Глав.', 0, 0, 0, NULL),
(3792, 'produced', 'listing_main', 'Дата публикации', '', '', 'datetime', 'date', 0, NULL, NULL, 0, NULL, 0, 1, 20, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, NULL, 5, 'Дата', 0, 0, 0, NULL),
(3793, 'area_total', 'listing_main', 'Общая площадь', '', '', 'int(11)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3794, 'floor_count', 'listing_main', 'Этажей в доме', '', '', 'int(5)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3795, 'price', 'listing_main', 'Цена', '', '', 'int(11)', 'currency', 0, NULL, NULL, 0, NULL, 0, 0, 70, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3796, 'bedrooms', 'listing_main', 'Кол-во комнат', '', '', 'int(2)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3797, 'currency_id', 'listing_main', 'Валюта', '', '', 'varchar(16)', 'lookup', 0, NULL, 2390, 0, NULL, 0, 0, 80, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3798, 'property_type_id', 'listing_main', 'Тип недвижимости', '', '', 'int(5)', 'hidden', 0, NULL, 3589, 0, NULL, 0, 0, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3799, 'img_src_thumb', 'listing_main', 'Картинка (70x70)', '', '', 'varchar(300)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 90, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3804, 'ref_no', 'listing', 'Ref No', '', '', 'varchar(40)', NULL, 1, NULL, NULL, 0, '', 0, 1, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3805, 'property_type_id', 'listing', 'Тип недвижимости', '', '', 'int(5)', 'lookup', 0, NULL, 3589, 0, '', 0, 1, 30, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3806, 'property_subtype_id', 'listing', 'Подтип недвижимости', '', '', 'int(5)', 'lookup', 0, NULL, 3593, 0, NULL, 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 10, 10, 'Тип', 0, 0, 0, NULL),
(3807, 'loc_country_id', 'listing', 'Страна', '', '', 'int(5)', 'lookup', 0, NULL, 3598, 0, NULL, 0, 1, 50, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(3808, 'loc_city_id', 'listing', 'Город', '', '', 'int(5)', 'lookup', 1, NULL, 3600, 0, NULL, 1, 0, 70, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 40, NULL, 0, 0, 0, NULL),
(3809, 'loc_street_id', 'listing', 'Улица', '', '', 'int(5)', 'lookup', 1, NULL, 3621, 0, NULL, 0, 0, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 45, NULL, 0, 0, 0, NULL),
(3810, 'loc_project_id', 'listing', 'Жилой комплекс', '', '', 'int(5)', 'lookup', 1, NULL, 3625, 0, NULL, 1, 0, 100, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3811, 'loc_road_id', 'listing', 'Шоссе (в области)', '', '', 'int(5)', 'lookup', 1, NULL, 3610, 0, NULL, 0, 0, 120, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, 47, NULL, 0, 0, 0, NULL),
(3812, 'loc_metro_id', 'listing', 'Метро', '', '', 'int(5)', 'lookup', 1, NULL, 3634, 0, '', 0, 0, 90, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3813, 'address', 'listing', 'Адрес', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 0, 130, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 50, NULL, 0, 0, 1, NULL),
(3814, 'price', 'listing', 'Цена', '', '', 'int(11)', 'currency', 0, NULL, NULL, 0, NULL, 0, 1, 160, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 60, NULL, 0, 0, 0, NULL),
(3815, 'currency_id', 'listing', 'Валюта', '', '', 'varchar(16)', 'lookup', 0, NULL, 2390, 0, '', 0, 0, 170, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3816, 'area_total', 'listing', 'Общая площадь', '', '', 'decimal(11,1)', 'float', 0, NULL, NULL, 0, NULL, 0, 1, 180, NULL, NULL, NULL, 'm2', 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3817, 'title', 'listing', 'Заголовок', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, NULL, 10, NULL, 0, 0, 1, NULL),
(3818, 'body', 'listing', 'Описание', '', '', 'text', 'html', 1, NULL, NULL, 0, '', 0, 0, 150, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1, NULL),
(3819, 'area_living', 'listing', 'Жилая площадь', '', 'details', 'decimal(11,1)', 'float', 1, NULL, NULL, 0, NULL, 0, 0, 260, NULL, NULL, NULL, 'm2', 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3820, 'area_kitchen', 'listing', 'Площадь кухни', '', 'details', 'decimal(11,1)', 'float', 1, NULL, NULL, 0, NULL, 0, 0, 270, NULL, NULL, NULL, 'm2', 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3821, 'area_plot', 'listing', 'Площадь участка', '', 'details', 'decimal(11,1)', 'float', 1, NULL, NULL, 0, NULL, 0, 0, 280, NULL, NULL, NULL, 'are', 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3822, 'map_latlng', 'listing', 'Координаты на карте', '', '', 'varchar(40)', 'google_map', 1, NULL, NULL, 0, '', 0, 0, 140, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3823, 'contact_phone', 'listing', 'Контактный телефон', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, '', 0, 0, 230, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3824, 'contact_email', 'listing', 'Контактный email', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, '', 0, 0, 220, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3825, 'user_id', 'listing', 'Создал пользователь', '', '', 'int(11)', 'lookup', 0, NULL, 101, 0, NULL, 0, 1, 210, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, NULL, 1, 'Агент', 0, 0, 0, NULL),
(3826, 'listing_status_id', 'listing', 'Статус объявления', '', '', 'int(1)', 'lookup', 0, NULL, 3665, 0, NULL, 0, 1, 190, NULL, NULL, '1', NULL, 1, 0, 0, 0, 0, NULL, 10, 'Статус', 0, 0, 0, NULL),
(3827, 'bedrooms', 'listing', 'Кол-во комнат', '', 'details', 'int(2)', 'number', 1, NULL, NULL, 0, NULL, 0, 0, 250, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 11, 'Комн.', 0, 0, 0, NULL),
(3828, 'bathrooms_details', 'listing', 'Санузел (тип, кол-во)', '', 'details', 'varchar(40)', NULL, 1, NULL, NULL, 0, '', 0, 0, 320, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3829, 'floor_number', 'listing', 'Этаж', '', 'details', 'int(5)', 'number', 1, NULL, NULL, 0, '', 0, 0, 290, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3830, 'floor_count', 'listing', 'Этажей в доме', '', 'details', 'int(5)', 'number', 1, NULL, NULL, 0, '', 0, 0, 300, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3831, 'building_type_id', 'listing', 'Тип дома', '', 'details', 'int(5)', 'lookup', 1, NULL, 3671, 0, '', 0, 0, 310, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3832, 'balcony_details', 'listing', 'Балкон (тип, кол-во)', '', 'details', 'varchar(40)', NULL, 1, NULL, NULL, 0, '', 0, 0, 330, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3833, 'lift_details', 'listing', 'Лифт (тип, кол-во)', '', 'details', 'varchar(40)', NULL, 1, NULL, NULL, 0, '', 0, 0, 340, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3834, 'windows_view', 'listing', 'Окна выходят', '', 'details', 'varchar(40)', 'lookup_custom', 1, NULL, NULL, 1, '', 0, 0, 350, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3835, 'metro_distance_walking', 'listing', 'До метро пешком (минут)', '', 'details', 'int(5)', 'number', 1, NULL, NULL, 0, '', 0, 0, 360, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3836, 'metro_distance_transport', 'listing', 'До метро трансп. (минут)', '', 'details', 'int(5)', 'number', 1, NULL, NULL, 0, '', 0, 0, 370, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3837, 'city_distance', 'listing', 'Расстояние от МКАД (км)', '', 'details', 'int(5)', 'number', 1, NULL, NULL, 0, '', 0, 0, 380, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3838, 'market_type_id', 'listing', 'Рынок недвижимости', '', 'details', 'int(5)', 'lookup', 1, NULL, 3679, 0, '', 0, 0, 390, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3839, 'mortgage_available', 'listing', 'Возможна ипотека', '', 'details', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 410, NULL, NULL, '0', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3840, 'deal_type_id', 'listing', 'Тип сделки', '', 'details', 'int(5)', 'lookup', 1, NULL, 3683, 0, '', 0, 0, 400, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3841, 'produced', 'listing', 'Дата публикации', '', '', 'datetime', 'date', 0, NULL, NULL, 0, NULL, 0, 1, 240, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 3, 5, 'Дата', 0, 0, 0, NULL),
(3842, 'published', 'listing', 'Опубликовано на сайте', '', '', 'int(1)', 'calc_boolean', 0, NULL, NULL, 0, '', 0, 0, 200, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 7, 'Публ.', 0, 0, 0, 'listing_status_id=1'),
(3843, 'amenity_id', 'listing', 'Преимущества', '', 'details', 'int(11)', 'lookup_external', 1, 'amenity2listing', 3728, 1, '', 0, 0, 420, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3844, 'loc_region_id', 'listing', 'Регион', '', '', 'int(5)', 'lookup', 1, NULL, 3605, 0, '', 0, 0, 60, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 30, NULL, 0, 0, 0, NULL),
(3845, 'featured', 'listing', 'На главной странице', '', 'featured', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 430, NULL, NULL, '0', NULL, 1, 0, 0, 1, 0, NULL, 8, 'Глав.', 0, 0, 0, NULL),
(3846, 'featured_sort_num', 'listing', 'Порядок на главной', '', 'featured', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 440, NULL, NULL, '10', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3847, 'img_src', 'listing', 'Картинка (450x300)', '', 'image', 'varchar(300)', 'image', 1, NULL, NULL, 0, NULL, 0, 0, 500, 'Генерируется автоматически из первой по порядку фотографии объекта', NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3848, 'loc_city_district_id', 'listing', 'Район города', '', '', 'int(5)', 'lookup', 1, NULL, 3617, 0, '', 0, 0, 80, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3849, 'area_room_details', 'listing', 'Комнаты', '', 'details', 'varchar(40)', NULL, 1, NULL, NULL, 0, '', 0, 0, 265, NULL, NULL, NULL, 'm2', 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3850, 'is_region_center', 'listing', 'Центр региона', '', 'details', 'int(1)', 'calc_view', 0, NULL, NULL, 0, '', 0, 0, 1000, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 'SELECT is_region_center FROM loc_city WHERE loc_city.id = listing.loc_city_id'),
(3851, 'img_src_thumb', 'listing', 'Картинка (70x70)', '', 'image', 'varchar(300)', 'image', 1, NULL, NULL, 0, NULL, 0, 0, 510, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3852, 'listing_type_id', 'listing', 'Тип объявления', '', '', 'int(5)', 'lookup', 0, NULL, 3591, 0, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3853, 'price_term_id', 'listing', 'Цена аренды за', '', '', 'varchar(1)', 'lookup', 0, NULL, 3721, 0, NULL, 0, 1, 175, NULL, NULL, '1', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3854, 'listing_type_id', 'listing_main', 'Тип объявления', '', '', 'int(5)', 'lookup', 0, NULL, 3591, 0, NULL, 0, 0, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3855, 'img_src', 'listing_main', 'Картинка (450x300)', '', '', 'varchar(255)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 85, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3856, 'listing_type2meta_table_field', 'listing_type', 'Поля только для этого типа', '', '', 'int(11)', 'lookup_external', 0, 'listing_type2meta_table_field', 51, 1, 'meta_table_id=\'listing\'', 0, 0, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3857, 'meta_table_field_id', 'listing_type2meta_table_field', 'Поле', '', '', 'int(11)', 'lookup', 0, NULL, 51, 0, NULL, 0, 0, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3858, 'title', 'loc_direction', 'Наименование', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, '', 0, 1, 40, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 10, NULL, 0, 0, 0, NULL),
(3859, 'sort_num', 'loc_direction', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, NULL, 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3860, 'published', 'loc_direction', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3861, 'is_suburb', 'listing', 'Пригород центра', '', 'details', 'int(1)', 'calc_view', 0, NULL, NULL, 0, NULL, 0, 0, 1010, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 'SELECT is_suburb FROM loc_city WHERE loc_city.id = listing.loc_city_id'),
(3862, 'lookup_quick_add', 'meta_field', 'Быстрое добавление', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 0, 68, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3863, 'rating', 'listing', 'Рейтинг в списке', '', 'featured', 'int(11)', 'number', 0, NULL, NULL, 0, NULL, 0, 0, 450, 'Чем больше рейтинг, тем выше объявление в общем списке', NULL, NULL, NULL, 1, 0, 0, 1, 0, 2, 9, 'Рейт.', 0, 0, 0, NULL),
(3864, 'agent_source', 'listing', 'Агентство (импорт)', '', '', 'varchar(40)', 'hidden', 0, NULL, NULL, 0, NULL, 0, 0, 254, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 1, NULL, 'Агент', 0, 0, 0, NULL),
(3865, 'property_subtype_id', 'listing_main', 'Подтип', '', '', 'int(11)', 'lookup', 0, NULL, 3593, 0, NULL, 0, 0, 35, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3866, 'loc_city_id', 'listing_main', 'Город', '', '', 'int(11)', 'lookup', 0, NULL, 3600, 0, NULL, 0, 0, 36, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3867, 'address', 'listing_main', 'Адрес', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 0, 38, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3868, 'loc_metro_id', 'listing_main', 'Метро', '', '', 'int(11)', 'lookup', 0, NULL, 3634, 0, NULL, 0, 0, 39, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3869, 'title', 'client', 'Название', '', '', 'varchar(255)', NULL, 0, NULL, NULL, 0, NULL, 0, 1, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, NULL, 3, NULL, 0, 0, 1, NULL),
(3871, 'img_src', 'client', 'Логотип', '', '', 'varchar(255)', 'image', 0, NULL, NULL, 0, NULL, 0, 1, 30, NULL, NULL, 'partners', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3872, 'web', 'client', 'Ссылка', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3873, 'sort_num', 'client', 'Порядок следования', '', '', 'int(11)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 50, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, 'Порядок', 0, 0, 0, NULL),
(3874, 'published', 'client', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 2, 'Публ.', 0, 0, 0, NULL),
(3875, 'w', 'listing_video', 'Ширина', '', '', 'int(4)', 'number', 1, NULL, NULL, 0, NULL, 0, 0, 85, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3876, 'h', 'listing_video', 'Высота', '', '', 'int(4)', 'number', 1, NULL, NULL, 0, NULL, 0, 0, 86, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3877, 'title', 'listing_plan', 'Наименование', '', '', 'varchar(255)', NULL, 1, NULL, NULL, 0, NULL, 0, 0, 40, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, 20, NULL, 0, 0, 0, NULL),
(3878, 'sort_num', 'listing_plan', 'Порядок', '', '', 'int(5)', 'sort', 0, NULL, NULL, 0, '', 0, 1, 100, NULL, NULL, '10', NULL, 1, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 0, NULL),
(3879, 'published', 'listing_plan', 'Публиковать', '', '', 'int(1)', 'boolean', 0, NULL, NULL, 0, '', 0, 1, 110, NULL, NULL, '1', NULL, 1, 0, 0, 1, 0, NULL, 1, 'Публ.', 0, 0, 0, NULL),
(3880, 'img_src_original', 'listing_plan', 'Картинка исходная', '', '', 'varchar(255)', 'image_big', 1, NULL, NULL, 0, '', 0, 1, 50, NULL, NULL, 'properties/{Y}/{M}/{listing_id}', NULL, 1, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3881, 'img_src', 'listing_plan', 'Картинка на сайте (?x566)', '', '', 'varchar(255)', 'image_preview', 0, NULL, NULL, 0, NULL, 0, 1, 60, NULL, NULL, 'properties', NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL),
(3882, 'img_src_thumb', 'listing_plan', 'Картинка уменьшенная (173x115)', '', '', 'varchar(255)', 'image_preview', 0, NULL, NULL, 0, '', 0, 1, 70, NULL, NULL, 'properties', NULL, 1, 0, 1, 0, 0, NULL, 10, NULL, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meta_table_field_group`
--

CREATE TABLE `meta_table_field_group` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table_field_group`
--

INSERT INTO `meta_table_field_group` (`id`, `title`, `sort_num`) VALUES
('', 'Основное', 10),
('details', 'Параметры', 15),
('featured', '★', 20),
('image', 'Картинка', 17),
('seo', 'SEO', 100);

-- --------------------------------------------------------

--
-- Table structure for table `meta_table_field_option`
--

CREATE TABLE `meta_table_field_option` (
  `id` int(5) NOT NULL,
  `meta_table_field_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `img_src` varchar(255) DEFAULT NULL,
  `is_group_title` int(1) DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meta_table_field_option`
--

INSERT INTO `meta_table_field_option` (`id`, `meta_table_field_id`, `title`, `title_en`, `img_src`, `is_group_title`, `sort_num`, `published`, `title_seo`) VALUES
(1, 3675, 'На улицу', '', NULL, 0, 10, 1, NULL),
(2, 3675, 'Во двор', '', NULL, 0, 20, 1, NULL),
(3, 3715, 'Улица', '', NULL, 0, 10, 1, NULL),
(4, 3715, 'Двор', '', NULL, 0, 20, 1, NULL),
(5, 3834, 'На улицу', '', NULL, 0, 10, 1, NULL),
(6, 3834, 'Во двор', '', NULL, 0, 20, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `meta_site_lang_id` varchar(40) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `meta_table_id` varchar(40) NOT NULL,
  `news_folder_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `produced` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `annotation` text,
  `annotation_en` text,
  `body` text,
  `body_en` text,
  `sort_num` smallint(5) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `img_src` varchar(255) DEFAULT NULL,
  `img_src_detail` varchar(255) DEFAULT NULL,
  `img_src_big` varchar(255) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `meta_site_lang_id`, `meta_site_id`, `meta_table_id`, `news_folder_id`, `title`, `title_en`, `produced`, `annotation`, `annotation_en`, `body`, `body_en`, `sort_num`, `published`, `img_src`, `img_src_detail`, `img_src_big`, `updated`, `title_seo`) VALUES
(2, '', '', 'testimonial', NULL, 'Юлия', '', '0000-00-00 00:00:00', 'Обладательница квартиры в новом ЖК', NULL, '<p>Продавала однушку в старом панельном доме. Уже через три месяца стала обладателем современной квартиры в строящемся ЖК комфорт класса и машиноместа в подземном гараже дома без привлечения дополнительных средств! Спасибо АН "МСК Ключ" за рациональное размещение моих денежных средств и оптимальное решение моего жилищного вопроса!</p>', NULL, 10, 1, '/uploads/images/persons/yuliya.jpg', NULL, NULL, '2015-07-07 15:55:39', 'zhanna-kopylova'),
(3, '', '', 'news', 1, 'Наши цены на вашей стороне', '', '2015-03-09 00:00:00', 'Наши цены на вашей стороне. Список наших объектов недвижимости включает в себя самые новые предложения.', NULL, '<p><iframe allowfullscreen="" style="border:0" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d71503.07143210972!2d-3.2053387499999997!3d55.94120834999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1461623656860" frameborder="0" height="450" width="600"> </iframe></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', NULL, 0, 1, NULL, NULL, NULL, '2016-04-25 22:35:03', 'nashi-tseny-na-vashey-storone-ved-my-zainteresovany-v-tom-chtoby-imenno-u-nas-vy-nashli-podhodyaschee-vam-predlozhenie'),
(6, '', '', 'news', 1, 'Список наших объектов недвижимости включает в себя самые новые предложения', '', '2015-03-08 00:00:00', 'Наши цены на вашей стороне. Список наших объектов недвижимости включает в себя самые новые предложения. Вы всегда можете обратиться к нам за советом или консультацией. Наши цены на вашей стороне.', NULL, '<p>Catch your eyes in the first seconds, make sure that you can shine your business. No matter who you are or where you’re from, you’ll be served with the great good and best attitude.</p>\r\n<p>We believe that our products will never disappoint you, among all the stars, we’ll be the brightest. We always try our best to be the one who receive the love, please believe that you are not the only one who find it’s great.</p>\r\n<p>Like it or hate it. You totally have right to raise your opinions. Let’s your word speaks your mind. Stay away from all the unwelcome guests, you won’t have to face any persecution using our service.</p>', NULL, 0, 1, NULL, NULL, NULL, '2015-03-16 15:27:50', 'spisok-nashih-obektov-nedvizhimosti-vklyuchaet-v-sebya-samye-novye-predlozheniya-i-postoyanno-obnovlyaetsya'),
(7, '', '', 'news', 1, 'Вы всегда можете обратиться к нам за советом или консультацией', '', '2015-03-07 00:00:00', 'Список наших объектов недвижимости включает в себя самые новые предложения. Вы всегда можете обратиться к нам за советом или консультацией.', NULL, '<p>Catch your eyes in the first seconds, make sure that you can shine your business. No matter who you are or where you’re from, you’ll be served with the great good and best attitude.</p>\r\n<p>We believe that our products will never disappoint you, among all the stars, we’ll be the brightest. We always try our best to be the one who receive the love, please believe that you are not the only one who find it’s great.</p>\r\n<p>Like it or hate it. You totally have right to raise your opinions. Let’s your word speaks your mind. Stay away from all the unwelcome guests, you won’t have to face any persecution using our service.</p>', NULL, 0, 1, NULL, NULL, NULL, '2015-03-16 15:27:53', 'vy-vsegda-mozhete-obratitsya-k-nam-za-sovetom-ili-konsultatsiey'),
(8, '', '', 'testimonial', NULL, 'Ольга', '', '0000-00-00 00:00:00', 'Бизнесмен, Москва', NULL, '<p>Хочу выразить свою признательность  за профессиональную работу риелтеру Ирине Аркадьевне Крипень и поделиться отзывом о ее работе.</p>\r\n<p>Когда у меня впервые возникла необходимость в услугах риелтера, я обратилась за рекомендациями к знакомым, т.к.  сделки с недвижимостью считаю делом крайне ответственным и мне важно, чтобы человек, который этим занимается,  был профессиональным и порядочным.   Ирина Крипень, рекомендованная мне друзьями бизнесменами из  «Золотого клуба», оказалась именно таким профессионалом.</p>\r\n<p>Хотя моя сделка не была сложной (продажа квартиры) мне понравилось,  как она грамотно подошла к оценке рынка и поиску покупателей. Сделка прошла быстро,  без каких-либо накладок.  Квартира была продана за ту сумму, которая меня полностью устраивала.</p>\r\n<p>Именно поэтому, когда мне понадобилась более сложная сделка с недвижимостью,  я снова  обратилась к Ирине.  Нужно было поменять квартиру  в отдаленном районе на квартиру в моем районе. Условия я поставила жесткие:  денег добавлять не буду,  новая квартира нужна  в пределах 10 минут пешком  от моего дома и к определенному сроку.  Дело в том, что хотелось сделать подарок к свадьбе дочери, и чтобы молодые жили рядом.</p>\r\n<p>Несмотря на сложность предложенных условий, Ирина блестяще справилась с поставленной задачей. Ключи от новой квартиры были торжественно вручены молодым в день свадьбы.</p>', NULL, 20, 1, NULL, NULL, NULL, '2015-07-07 15:54:42', 'olga'),
(9, '', '', 'testimonial', NULL, 'Наталья Курочкина', '', '0000-00-00 00:00:00', 'Москвичка', NULL, '<p><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.8000001907349px;">В наше время несложно найти человека, предлагающего услуги в сфере рынка недвижимости. Но крайне сложно найти действительно хорошего риелтора, который знает свое дело и готов быстро и надежно решить ваш вопрос. К счастью, мне повезло.</span></p>\r\n<p><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.8000001907349px;">Столкнувшись с продажей квартиры, у меня возникло немало трудностей и вопросов.&nbsp;</span><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.8000001907349px;">Прекрасная команда профессионалов и мастеров своего дела, помогли мне разобраться во всех вопросах, качественно и, что немаловажно, быстро выполнили свои обязанности.</span></p>\r\n<p><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.8000001907349px;">Спасибо огромное! Если мне еще доведется столкнуться с продажей или покупкой недвижимости обращаться буду только к Вам!</span></p>', NULL, 30, 1, NULL, NULL, NULL, '2015-07-07 14:51:43', 'natalya'),
(10, '', '', 'testimonial', NULL, 'Екатерина Чурикова', '', '0000-00-00 00:00:00', 'Москвичка', NULL, '<p><span style="font-family: Arial, sans-serif; font-size: 11.5pt; line-height: 16.15pt;">Риелторов Ирину Аркадьевну и Марину Михайловну знаю давно, помогали в продаже и покупке квартиры неоднократно, всё быстро и без проблем.</span></p>\r\n<p><span style="font-family: Arial, sans-serif; font-size: 11.5pt; line-height: 16.15pt;">Огромное хочу сказать им спасибо за помощь.</span></p>\r\n<p><span style="font-size: 11.5pt; font-family: Arial, sans-serif;">Очень рекомендую это Агентство недвижимости «МСК КЛЮЧ».<o:p></o:p></span></p>', NULL, 40, 1, '/uploads/images/persons/ec.jpg', NULL, NULL, '2015-07-07 13:18:01', 'ekaterina-churikova'),
(11, '', '', 'testimonial', NULL, 'Елена', '', '0000-00-00 00:00:00', 'Москвичка', NULL, '<p>Хочу выразить огромную благодарность агентству «МСК КЛЮЧ», а именно Крипень Ирине Аркадьевне и Марине Михайловне за высочайший профессионализм и любовь к своему делу. Обращались к ним за помощью в продаже и покупке  новой квартиры, ситуация была не из простых.</p>\r\n<p>Квартиру продали в кротчайший срок, причём на выгодных  условиях и так же приобрели альтернативное жильё. Специалисты знают свою работу на 1000%.</p>\r\n<p>Кстати, обращаемся к ним не в первый раз. Огромное Вам спасибо, желаем Вам удачи и дальнейшего процветания. Очень рекомендую всем таких профессионалов своего дела.</p>', NULL, 50, 1, NULL, NULL, NULL, '2015-07-07 14:08:18', 'elena');

-- --------------------------------------------------------

--
-- Table structure for table `news_folder`
--

CREATE TABLE `news_folder` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `published` int(1) NOT NULL DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_folder`
--

INSERT INTO `news_folder` (`id`, `meta_site_id`, `name`, `published`, `sort_num`) VALUES
(1, '', 'Новости', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_folder2section`
--

CREATE TABLE `news_folder2section` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL DEFAULT '0',
  `news_folder_id` int(11) NOT NULL DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_folder2section`
--

INSERT INTO `news_folder2section` (`id`, `section_id`, `news_folder_id`, `sort_num`) VALUES
(1, 2, 1, 10),
(2, 14, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `news_tag`
--

CREATE TABLE `news_tag` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` int(5) NOT NULL DEFAULT '0',
  `title_sef` varchar(255) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news_tag2news`
--

CREATE TABLE `news_tag2news` (
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_tag_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `price_term`
--

CREATE TABLE `price_term` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price_term`
--

INSERT INTO `price_term` (`id`, `title`, `title_en`, `sort_num`) VALUES
(1, 'Месяц', '', 10),
(2, 'День', '', 20),
(3, 'м² в год', '', 30);

-- --------------------------------------------------------

--
-- Table structure for table `property_subtype`
--

CREATE TABLE `property_subtype` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `property_type_id` smallint(5) UNSIGNED NOT NULL,
  `listing_type_id` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_subtype`
--

INSERT INTO `property_subtype` (`id`, `property_type_id`, `listing_type_id`, `title`, `title_en`, `sort_num`, `published`, `title_seo`) VALUES
(1, 1, '1,2', 'Комната', '', 10, 1, 'komnata'),
(2, 1, '1,2', 'Квартира', '', 20, 1, 'kvartira'),
(3, 1, '1', 'Свободная планировка', '', 30, 1, 'svobodnaya-planirovka'),
(4, 1, '1', 'Доля', '', 40, 1, 'dolya'),
(5, 2, '1,2', 'Дом', '', 10, 1, 'dom'),
(6, 2, '1,2', 'Часть дома', '', 20, 1, 'chast-doma'),
(7, 2, '1,2', 'Таунхаус', '', 30, 1, 'taunhaus'),
(8, 2, '1,2', 'Участок', '', 40, 1, 'uchastok'),
(9, 3, '1,2', 'Офис', '', 10, 1, 'ofis'),
(10, 3, '1,2', 'Торговля', '', 20, 1, 'torgovlya'),
(11, 3, '1,2', 'Сервис', '', 30, 1, 'servis'),
(12, 3, '1,2', 'Кафе, ресторан', '', 40, 1, 'kafe-restoran'),
(13, 3, '1,2', 'Гараж', '', 50, 1, 'garazh'),
(14, 3, '1,2', 'Склад', '', 60, 1, 'sklad'),
(15, 3, '1,2', 'Производство', '', 70, 1, 'proizvodstvo'),
(16, 3, '1,2', 'Здание, особняк', '', 80, 1, 'zdanie-osobnyak'),
(17, 3, '1,2', 'Гостиница', '', 90, 1, 'gostinitsa'),
(18, 3, '1,2', 'Земельный участок', '', 100, 1, 'zemelnyy-uchastok'),
(19, 3, '1,2', 'Арендный бизнес', '', 110, 1, 'arendnyy-biznes'),
(20, 3, '1', 'Продажа бизнеса', '', 120, 1, 'prodazha-biznesa'),
(21, 3, '1,2', 'Юридический адрес', '', 130, 1, 'yuridicheskiy-adres'),
(22, 3, '1,2', 'Свободное назначение', '', 140, 1, 'svobodnoe-naznachenie');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `meta_site_lang_id` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title_seo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `meta_site_lang_id`, `title`, `title_en`, `sort_num`, `title_seo`) VALUES
(1, '', 'Квартира, комната', 'Apartment, Room', 10, 'kvartira-komnata'),
(2, '', 'Дом, коттедж, участок', 'Villa, Townhouse, Land Plot', 20, 'dom-kottedzh-uchastok'),
(3, '', 'Коммерческая недвижимость', 'Commercial', 30, 'kommercheskaya-nedvizhimost');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `meta_site_lang_id` varchar(40) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `section_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `img_src` varchar(255) DEFAULT NULL,
  `dir` varchar(64) DEFAULT '',
  `path` varchar(255) DEFAULT NULL,
  `section_type_id` varchar(16) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `target_blank` int(1) NOT NULL DEFAULT '0',
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0',
  `protected` int(1) NOT NULL DEFAULT '0',
  `hidden` int(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_description_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `meta_site_lang_id`, `meta_site_id`, `section_id`, `title`, `title_en`, `img_src`, `dir`, `path`, `section_type_id`, `url`, `target_blank`, `sort_num`, `published`, `protected`, `hidden`, `meta_title`, `meta_title_en`, `meta_description`, `meta_description_en`) VALUES
(1, '', '', NULL, 'Разделы сайта', '', NULL, '', '', 'link', '/', 0, 0, 0, 0, 0, 'Агентство недвижимости «МСК Ключ»', 'Booclick', NULL, NULL),
(2, ',en', '', 1, 'Главная страница', 'Home', NULL, '', '/', 'index', NULL, 0, 10, 1, 0, 0, NULL, '', NULL, NULL),
(4, '', '', 1, 'Недвижимость', '', NULL, 'property', '/', 'property_detail', NULL, 0, 20, 1, 0, 0, NULL, NULL, NULL, NULL),
(5, '', '', 1, 'Услуги', '', NULL, 'services', '/', 'article', NULL, 0, 30, 1, 0, 0, NULL, NULL, NULL, NULL),
(6, '', '', 1, 'О компании', '', NULL, 'company', '/', 'menuitem', NULL, 0, 40, 1, 0, 0, NULL, NULL, NULL, NULL),
(7, '', '', 1, 'Контакты', '', NULL, 'contacts', '/', 'contacts', NULL, 0, 50, 1, 0, 0, NULL, NULL, NULL, NULL),
(8, '', '', 4, 'Жилая недвижимость', '', NULL, 'residential', '/property/', 'link', '/property/search/?status=1&type=1', 0, 10, 1, 0, 0, NULL, NULL, NULL, NULL),
(9, '', '', 4, 'Загородная недвижимость', '', NULL, 'country', '/property/', 'link', '/property/search/?status=1&type=2', 0, 20, 1, 0, 0, NULL, NULL, NULL, NULL),
(10, '', '', 4, 'Новостройки', '', NULL, 'new-build', '/property/', 'link', '/property/search/?market_type=2&status=1&type=1', 0, 30, 1, 0, 0, NULL, NULL, NULL, NULL),
(11, '', '', 4, 'Коммерческая недвижимость', '', NULL, 'commercial', '/property/', 'link', '/property/search/?status=1&type=3', 0, 40, 1, 0, 0, NULL, NULL, NULL, NULL),
(12, '', '', 4, 'Зарубежная недвижимость', '', NULL, 'abroad', '/property/', 'link', '/property/search/?status=1&type=1&direction=5&country_exclude=1', 0, 50, 1, 0, 0, NULL, NULL, NULL, NULL),
(13, '', '', 6, 'Об агентстве МСК Ключ', '', NULL, 'about', '/company/', 'article', NULL, 0, 10, 1, 0, 0, NULL, NULL, NULL, NULL),
(14, '', '', 6, 'Новости', '', NULL, 'news', '/company/', 'news', NULL, 0, 20, 1, 0, 0, NULL, NULL, NULL, NULL),
(15, '', '', 5, 'Услуга 1', '', NULL, '1', '/services/', 'article', NULL, 0, 10, 1, 0, 0, NULL, NULL, NULL, NULL),
(17, '', '', 5, 'Услуга 2', '', NULL, '2', '/services/', 'article', NULL, 0, 20, 1, 0, 0, NULL, NULL, NULL, NULL),
(18, '', '', 5, 'Услуга 3', '', NULL, '3', '/services/', 'article', NULL, 0, 30, 1, 0, 0, NULL, NULL, NULL, NULL),
(19, '', '', 4, 'Найти недвижимость', '', NULL, 'search', '/property/', 'property', NULL, 0, 100, 1, 0, 0, NULL, NULL, NULL, NULL),
(20, '', '', 6, 'Отзывы клиентов', '', NULL, 'testimonials', '/company/', 'testimonials', NULL, 0, 30, 1, 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `section2container`
--

CREATE TABLE `section2container` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `section_id` int(11) NOT NULL DEFAULT '0',
  `container_id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `img_src` varchar(255) DEFAULT NULL,
  `sort_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section2container`
--

INSERT INTO `section2container` (`id`, `meta_site_id`, `section_id`, `container_id`, `title`, `title_en`, `img_src`, `sort_num`) VALUES
(1, '', 4, 'main', NULL, NULL, NULL, 10),
(2, '', 5, 'main', NULL, NULL, NULL, 10),
(3, '', 6, 'main', NULL, NULL, NULL, 10),
(4, '', 7, 'main', NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `section_type`
--

CREATE TABLE `section_type` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `is_system` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section_type`
--

INSERT INTO `section_type` (`id`, `meta_site_id`, `name`, `published`, `is_system`) VALUES
('article', '', 'Текст', 1, 0),
('contacts', '', 'Контакты', 1, 0),
('feedback', '', 'Обратная связь', 1, 0),
('index', '', 'Главная страница', 1, 0),
('link', '', 'Ссылка', 1, 1),
('menuitem', '', 'Пункт меню', 1, 1),
('news', '', 'Новости', 1, 0),
('property', '', 'Недвижимость (список)', 1, 0),
('property_detail', '', 'Недвижимость (объект)', 1, 0),
('testimonials', '', 'Отзывы', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seo_parameter`
--

CREATE TABLE `seo_parameter` (
  `id` varchar(40) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `real_name` varchar(40) NOT NULL,
  `type_id` varchar(16) NOT NULL DEFAULT '',
  `meta_table_field_id` int(11) DEFAULT NULL,
  `is_multi_value` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `activated` int(1) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seo_parameter`
--

INSERT INTO `seo_parameter` (`id`, `meta_site_id`, `real_name`, `type_id`, `meta_table_field_id`, `is_multi_value`, `title`, `title_en`, `activated`, `published`, `sort_num`) VALUES
('city', '', 'city', '', 3600, 1, NULL, NULL, 1, 1, 10),
('country', '', 'country', '', 3598, 1, NULL, NULL, 1, 1, 10),
('detail', '', 'detail', '', 3787, 0, NULL, NULL, 1, 1, 10),
('direction', '', 'direction', '', 3858, 0, NULL, NULL, 1, 1, 10),
('komnat', '', 'bedrooms', 'numeric', NULL, 0, 'Комнат', NULL, 0, 1, 10),
('market', '', 'market_type', '', 3679, 0, NULL, NULL, 1, 1, 10),
('metro', '', 'metro', '', 3634, 1, NULL, NULL, 1, 1, 10),
('news', '', 'news', '', 69, 0, NULL, NULL, 1, 1, 10),
('price', '', 'price', 'numeric', NULL, 0, 'Цена', NULL, 0, 1, 10),
('region', '', 'region', '', 3605, 0, NULL, NULL, 1, 1, 10),
('status', '', 'status', '', 3591, 0, NULL, NULL, 1, 1, 10),
('street', '', 'street', '', 3621, 0, NULL, NULL, 1, 1, 10),
('subtype', '', 'subtype', '', 3593, 1, NULL, NULL, 1, 1, 10),
('type', '', 'type', '', 3589, 0, NULL, NULL, 1, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `seo_parameter2section_type`
--

CREATE TABLE `seo_parameter2section_type` (
  `id` int(11) NOT NULL,
  `seo_parameter_id` varchar(40) NOT NULL,
  `section_type_id` varchar(16) NOT NULL,
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seo_parameter2section_type`
--

INSERT INTO `seo_parameter2section_type` (`id`, `seo_parameter_id`, `section_type_id`, `sort_num`) VALUES
(1, 'news', 'news', 10),
(2, 'detail', 'property_detail', 10),
(3, 'status', 'property', 10),
(4, 'type', 'property', 30),
(5, 'subtype', 'property', 40),
(6, 'direction', 'property', 50),
(7, 'metro', 'property', 90),
(8, 'city', 'property', 80),
(9, 'street', 'property', 100),
(10, 'region', 'property', 70),
(11, 'country', 'property', 60),
(12, 'market', 'property', 20),
(13, 'komnat', 'property', 110),
(14, 'price', 'property', 120);

-- --------------------------------------------------------

--
-- Table structure for table `seo_url_data`
--

CREATE TABLE `seo_url_data` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `redirect_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `h1` varchar(255) DEFAULT NULL,
  `body` text,
  `published` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `value` text,
  `value_en` text,
  `type` varchar(8) DEFAULT NULL,
  `multi_lang` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `meta_site_id`, `name`, `value`, `value_en`, `type`, `multi_lang`) VALUES
('email_feedback', '', 'Адрес e-mail для сообщений обратной связи', 'max@e-i.com.ru', NULL, 'textarea', 0),
('phone', '', 'Контактный телефон', '+7 (495) 968-01-11', NULL, 'text', 0),
('phone_mobile', '', 'Мобильный телефон', '+7 (903) 968-01-11', NULL, 'text', 0),
('title_best_offers', '', 'Заголовок над объектами на главной', 'Лучшие предложения продажи', NULL, 'text', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL DEFAULT '',
  `sort_num` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `title`, `title_en`, `sort_num`) VALUES
('are', 'сот.', 'ares', 20),
('m2', 'м²', 'm²', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '*',
  `passkey` varchar(8) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `enabled` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `confirmation_code` varchar(32) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `meta_site_id`, `login`, `password`, `passkey`, `email`, `enabled`, `name`, `middlename`, `surname`, `phone`, `company`, `position`, `confirmation_code`, `created`) VALUES
(1, '', 'admin', '7b0d879b240a88d40954c40f4d5616cb', '>;Z<Qx*;', 'mx3@mail.ru', 1, 'Administrator', NULL, '.', '3', '1', '2', '2K5Njkm8TZ59msCabnfPcHCyNSIIHN', '2012-08-01 00:00:00'),
(2, '', 'agent', '7b0d879b240a88d40954c40f4d5616cb', '>;Z<Qx*;', 'agent@example.com', 1, '.', NULL, '.', NULL, NULL, NULL, NULL, '2015-07-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user2users_group`
--

CREATE TABLE `user2users_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `users_group_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user2users_group`
--

INSERT INTO `user2users_group` (`id`, `user_id`, `users_group_id`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `id` int(11) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `admin_access` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`id`, `meta_site_id`, `name`, `title`, `admin_access`) VALUES
(1, '', 'admin', 'Администраторы', NULL),
(2, '', 'agent', 'Агенты', 'listing,listing_image,listing_video');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `id` varchar(255) NOT NULL,
  `meta_site_id` varchar(16) NOT NULL DEFAULT '',
  `is_backoffice` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`id`, `meta_site_id`, `is_backoffice`, `user_id`, `ip`, `created`, `updated`) VALUES
('lj606bhtlb1imbjfaoi130pjg5', '', 1, 1, '127.0.0.1', '2017-01-27 07:09:17', '2017-01-27 07:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `_agent_banned_id`
--

CREATE TABLE `_agent_banned_id` (
  `id` int(11) NOT NULL,
  `source` varchar(16) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenity`
--
ALTER TABLE `amenity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `amenity2listing`
--
ALTER TABLE `amenity2listing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amenity_id` (`amenity_id`),
  ADD KEY `amenity2listing_ibfk_2` (`listing_id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_section_id_idx` (`section_id`),
  ADD KEY `article_type_id_idx` (`article_type_id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `article_type`
--
ALTER TABLE `article_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banner_type_id_idx` (`banner_type_id`),
  ADD KEY `color_scheme_id` (`color_scheme_id`),
  ADD KEY `color_scheme_id_2` (`color_scheme_id`);

--
-- Indexes for table `banner2section`
--
ALTER TABLE `banner2section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banner_id` (`banner_id`,`section_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `banner_type`
--
ALTER TABLE `banner_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_type2section`
--
ALTER TABLE `banner_type2section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id` (`section_id`,`banner_type_id`),
  ADD KEY `banner_type_id` (`banner_type_id`);

--
-- Indexes for table `building_type`
--
ALTER TABLE `building_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `color_scheme`
--
ALTER TABLE `color_scheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_type`
--
ALTER TABLE `deal_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `doc`
--
ALTER TABLE `doc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_folder_id` (`doc_folder_id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `doc_folder`
--
ALTER TABLE `doc_folder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `doc_folder2section`
--
ALTER TABLE `doc_folder2section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id` (`section_id`,`doc_folder_id`),
  ADD KEY `doc_folder2section_doc_folder_id_idx` (`doc_folder_id`),
  ADD KEY `doc_folder2section_section_id_idx` (`section_id`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD UNIQUE KEY `agent_source` (`agent_source`,`agent_ref_no`),
  ADD KEY `property_type_id_idx` (`property_type_id`),
  ADD KEY `listing_type_id` (`listing_type_id`),
  ADD KEY `property_subtype_id` (`property_subtype_id`),
  ADD KEY `market_type_id` (`market_type_id`),
  ADD KEY `loc_city_id` (`loc_city_id`),
  ADD KEY `loc_street_id` (`loc_street_id`),
  ADD KEY `loc_project_id` (`loc_project_id`),
  ADD KEY `loc_road_id` (`loc_road_id`),
  ADD KEY `loc_metro_id` (`loc_metro_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `building_type_id` (`building_type_id`),
  ADD KEY `loc_country_id` (`loc_country_id`),
  ADD KEY `listing_ibfk_1` (`listing_status_id`),
  ADD KEY `deal_type_id` (`deal_type_id`),
  ADD KEY `price_term_id` (`price_term_id`),
  ADD KEY `loc_region_id` (`loc_region_id`),
  ADD KEY `loc_city_district_id` (`loc_city_district_id`);

--
-- Indexes for table `listing_image`
--
ALTER TABLE `listing_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `meta_table_id` (`meta_table_id`);

--
-- Indexes for table `listing_status`
--
ALTER TABLE `listing_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing_type`
--
ALTER TABLE `listing_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `listing_type2meta_table_field`
--
ALTER TABLE `listing_type2meta_table_field`
  ADD PRIMARY KEY (`listing_type_id`,`meta_table_field_id`),
  ADD KEY `meta_table_field_id` (`meta_table_field_id`);

--
-- Indexes for table `listing_video`
--
ALTER TABLE `listing_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `loc_city`
--
ALTER TABLE `loc_city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `cian_id` (`cian_id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `loc_country_id` (`loc_country_id`),
  ADD KEY `loc_region_id` (`loc_region_id`);

--
-- Indexes for table `loc_city_district`
--
ALTER TABLE `loc_city_district`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `loc_city_id` (`loc_city_id`);

--
-- Indexes for table `loc_country`
--
ALTER TABLE `loc_country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `loc_direction`
--
ALTER TABLE `loc_direction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `loc_metro`
--
ALTER TABLE `loc_metro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `cian_id` (`cian_id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `loc_city_id` (`loc_city_id`),
  ADD KEY `loc_metro_line_id` (`loc_metro_line_id`);

--
-- Indexes for table `loc_metro_line`
--
ALTER TABLE `loc_metro_line`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `loc_city_id` (`loc_city_id`);

--
-- Indexes for table `loc_project`
--
ALTER TABLE `loc_project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `loc_city_id` (`loc_city_id`);

--
-- Indexes for table `loc_region`
--
ALTER TABLE `loc_region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `cian_id` (`cian_id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `loc_country_id` (`loc_country_id`);

--
-- Indexes for table `loc_road`
--
ALTER TABLE `loc_road`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `loc_region_id` (`loc_region_id`);

--
-- Indexes for table `loc_street`
--
ALTER TABLE `loc_street`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `cian_id` (`cian_id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `loc_city_id` (`loc_city_id`);

--
-- Indexes for table `market_type`
--
ALTER TABLE `market_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `meta_site`
--
ALTER TABLE `meta_site`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`);

--
-- Indexes for table `meta_site_lang`
--
ALTER TABLE `meta_site_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `meta_table`
--
ALTER TABLE `meta_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frontend_id_param_name` (`frontend_id_param_name`);

--
-- Indexes for table `meta_table2section_type`
--
ALTER TABLE `meta_table2section_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_table_id` (`meta_table_id`,`section_type_id`),
  ADD KEY `section_type_id` (`section_type_id`);

--
-- Indexes for table `meta_table2table`
--
ALTER TABLE `meta_table2table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_table_id` (`meta_table_id`,`detail_meta_table_id`),
  ADD KEY `meta_table_id_2` (`meta_table_id`),
  ADD KEY `meta_table_id_link` (`detail_meta_table_id`),
  ADD KEY `many2many_meta_table_id` (`many2many_meta_table_id`);

--
-- Indexes for table `meta_table_field`
--
ALTER TABLE `meta_table_field`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `field` (`field`,`meta_table_id`),
  ADD KEY `meta_table_id_idx` (`meta_table_id`),
  ADD KEY `meta_table_field_id_link_idx` (`lookup_meta_table_field_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `lookup_external_meta_table_id` (`lookup_external_meta_table_id`),
  ADD KEY `meta_table_field_group_id` (`meta_table_field_group_id`);

--
-- Indexes for table `meta_table_field_group`
--
ALTER TABLE `meta_table_field_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `meta_table_field_option`
--
ALTER TABLE `meta_table_field_option`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_sef` (`title_seo`),
  ADD KEY `meta_table_field_id_idx` (`meta_table_field_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `news_folder_id` (`news_folder_id`,`produced`),
  ADD KEY `meta_site_id` (`meta_site_id`),
  ADD KEY `meta_table_id` (`meta_table_id`);

--
-- Indexes for table `news_folder`
--
ALTER TABLE `news_folder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `news_folder2section`
--
ALTER TABLE `news_folder2section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id` (`section_id`,`news_folder_id`),
  ADD KEY `news_folder2section_news_folder_id_idx` (`news_folder_id`),
  ADD KEY `news_folder2section_section_id_idx` (`section_id`);

--
-- Indexes for table `news_tag`
--
ALTER TABLE `news_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_sef` (`title_sef`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `news_tag2news`
--
ALTER TABLE `news_tag2news`
  ADD PRIMARY KEY (`news_id`,`news_tag_id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `news_tag_id` (`news_tag_id`);

--
-- Indexes for table `price_term`
--
ALTER TABLE `price_term`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `property_subtype`
--
ALTER TABLE `property_subtype`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`),
  ADD KEY `property_type_id` (`property_type_id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `title_seo` (`title_seo`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`,`dir`,`meta_site_id`),
  ADD KEY `section_section_id_idx` (`section_id`),
  ADD KEY `section_section_type_id_idx` (`section_type_id`),
  ADD KEY `meta_site_id_idx` (`meta_site_id`);

--
-- Indexes for table `section2container`
--
ALTER TABLE `section2container`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id` (`section_id`,`container_id`),
  ADD KEY `section2container_section_id_idx` (`section_id`),
  ADD KEY `section2container_container_id_idx` (`container_id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `section_type`
--
ALTER TABLE `section_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `seo_parameter`
--
ALTER TABLE `seo_parameter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `real_name` (`real_name`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `seo_parameter2section_type`
--
ALTER TABLE `seo_parameter2section_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seo_parameter_id` (`seo_parameter_id`,`section_type_id`),
  ADD KEY `section_type_id` (`section_type_id`);

--
-- Indexes for table `seo_url_data`
--
ALTER TABLE `seo_url_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`name`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `user2users_group`
--
ALTER TABLE `user2users_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`users_group_id`),
  ADD KEY `user2users_group_user_id_idx` (`user_id`),
  ADD KEY `user2users_group_users_group_id_idx` (`users_group_id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_site_id` (`meta_site_id`);

--
-- Indexes for table `_agent_banned_id`
--
ALTER TABLE `_agent_banned_id`
  ADD PRIMARY KEY (`source`,`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenity`
--
ALTER TABLE `amenity`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `amenity2listing`
--
ALTER TABLE `amenity2listing`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `banner2section`
--
ALTER TABLE `banner2section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banner_type2section`
--
ALTER TABLE `banner_type2section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `building_type`
--
ALTER TABLE `building_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `deal_type`
--
ALTER TABLE `deal_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `doc`
--
ALTER TABLE `doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `doc_folder`
--
ALTER TABLE `doc_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `doc_folder2section`
--
ALTER TABLE `doc_folder2section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `listing_image`
--
ALTER TABLE `listing_image`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `listing_type`
--
ALTER TABLE `listing_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `listing_video`
--
ALTER TABLE `listing_video`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loc_city`
--
ALTER TABLE `loc_city`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `loc_city_district`
--
ALTER TABLE `loc_city_district`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `loc_country`
--
ALTER TABLE `loc_country`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loc_direction`
--
ALTER TABLE `loc_direction`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `loc_metro`
--
ALTER TABLE `loc_metro`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=610;
--
-- AUTO_INCREMENT for table `loc_metro_line`
--
ALTER TABLE `loc_metro_line`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `loc_project`
--
ALTER TABLE `loc_project`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loc_region`
--
ALTER TABLE `loc_region`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loc_road`
--
ALTER TABLE `loc_road`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `loc_street`
--
ALTER TABLE `loc_street`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;
--
-- AUTO_INCREMENT for table `market_type`
--
ALTER TABLE `market_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `meta_table2section_type`
--
ALTER TABLE `meta_table2section_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `meta_table2table`
--
ALTER TABLE `meta_table2table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `meta_table_field`
--
ALTER TABLE `meta_table_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3883;
--
-- AUTO_INCREMENT for table `meta_table_field_option`
--
ALTER TABLE `meta_table_field_option`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `news_folder`
--
ALTER TABLE `news_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `news_folder2section`
--
ALTER TABLE `news_folder2section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `news_tag`
--
ALTER TABLE `news_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `price_term`
--
ALTER TABLE `price_term`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `property_subtype`
--
ALTER TABLE `property_subtype`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `section2container`
--
ALTER TABLE `section2container`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `seo_parameter2section_type`
--
ALTER TABLE `seo_parameter2section_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `seo_url_data`
--
ALTER TABLE `seo_url_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user2users_group`
--
ALTER TABLE `user2users_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_group`
--
ALTER TABLE `users_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenity2listing`
--
ALTER TABLE `amenity2listing`
  ADD CONSTRAINT `amenity2listing_ibfk_1` FOREIGN KEY (`amenity_id`) REFERENCES `amenity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amenity2listing_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listing` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`article_type_id`) REFERENCES `article_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `article_type`
--
ALTER TABLE `article_type`
  ADD CONSTRAINT `article_type_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `banner`
--
ALTER TABLE `banner`
  ADD CONSTRAINT `banner_ibfk_1` FOREIGN KEY (`banner_type_id`) REFERENCES `banner_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `banner_ibfk_2` FOREIGN KEY (`color_scheme_id`) REFERENCES `color_scheme` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `banner2section`
--
ALTER TABLE `banner2section`
  ADD CONSTRAINT `banner2section_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `banner2section_ibfk_2` FOREIGN KEY (`banner_id`) REFERENCES `banner` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banner_type2section`
--
ALTER TABLE `banner_type2section`
  ADD CONSTRAINT `banner_type2section_ibfk_1` FOREIGN KEY (`banner_type_id`) REFERENCES `banner_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `banner_type2section_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `container`
--
ALTER TABLE `container`
  ADD CONSTRAINT `container_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `doc`
--
ALTER TABLE `doc`
  ADD CONSTRAINT `doc_ibfk_1` FOREIGN KEY (`doc_folder_id`) REFERENCES `doc_folder` (`id`),
  ADD CONSTRAINT `doc_ibfk_2` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `doc_folder`
--
ALTER TABLE `doc_folder`
  ADD CONSTRAINT `doc_folder_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `doc_folder2section`
--
ALTER TABLE `doc_folder2section`
  ADD CONSTRAINT `doc_folder2section_ibfk_1` FOREIGN KEY (`doc_folder_id`) REFERENCES `doc_folder` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doc_folder2section_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listing`
--
ALTER TABLE `listing`
  ADD CONSTRAINT `listing_ibfk_1` FOREIGN KEY (`listing_status_id`) REFERENCES `listing_status` (`id`),
  ADD CONSTRAINT `listing_ibfk_10` FOREIGN KEY (`loc_metro_id`) REFERENCES `loc_metro` (`id`),
  ADD CONSTRAINT `listing_ibfk_12` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `listing_ibfk_14` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `listing_ibfk_15` FOREIGN KEY (`building_type_id`) REFERENCES `building_type` (`id`),
  ADD CONSTRAINT `listing_ibfk_16` FOREIGN KEY (`loc_country_id`) REFERENCES `loc_country` (`id`),
  ADD CONSTRAINT `listing_ibfk_18` FOREIGN KEY (`deal_type_id`) REFERENCES `deal_type` (`id`),
  ADD CONSTRAINT `listing_ibfk_19` FOREIGN KEY (`price_term_id`) REFERENCES `price_term` (`id`),
  ADD CONSTRAINT `listing_ibfk_2` FOREIGN KEY (`property_type_id`) REFERENCES `property_type` (`id`),
  ADD CONSTRAINT `listing_ibfk_20` FOREIGN KEY (`loc_region_id`) REFERENCES `loc_region` (`id`),
  ADD CONSTRAINT `listing_ibfk_21` FOREIGN KEY (`loc_city_district_id`) REFERENCES `loc_city_district` (`id`),
  ADD CONSTRAINT `listing_ibfk_3` FOREIGN KEY (`property_subtype_id`) REFERENCES `property_subtype` (`id`),
  ADD CONSTRAINT `listing_ibfk_4` FOREIGN KEY (`market_type_id`) REFERENCES `market_type` (`id`),
  ADD CONSTRAINT `listing_ibfk_6` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`),
  ADD CONSTRAINT `listing_ibfk_7` FOREIGN KEY (`loc_street_id`) REFERENCES `loc_street` (`id`),
  ADD CONSTRAINT `listing_ibfk_8` FOREIGN KEY (`loc_project_id`) REFERENCES `loc_project` (`id`),
  ADD CONSTRAINT `listing_ibfk_9` FOREIGN KEY (`loc_road_id`) REFERENCES `loc_road` (`id`);

--
-- Constraints for table `listing_image`
--
ALTER TABLE `listing_image`
  ADD CONSTRAINT `listing_image_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listing` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_image_ibfk_2` FOREIGN KEY (`meta_table_id`) REFERENCES `meta_table` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `listing_type2meta_table_field`
--
ALTER TABLE `listing_type2meta_table_field`
  ADD CONSTRAINT `listing_type2meta_table_field_ibfk_1` FOREIGN KEY (`listing_type_id`) REFERENCES `listing_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_type2meta_table_field_ibfk_2` FOREIGN KEY (`meta_table_field_id`) REFERENCES `meta_table_field` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listing_video`
--
ALTER TABLE `listing_video`
  ADD CONSTRAINT `listing_video_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listing` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loc_city`
--
ALTER TABLE `loc_city`
  ADD CONSTRAINT `loc_city_ibfk_1` FOREIGN KEY (`loc_country_id`) REFERENCES `loc_country` (`id`),
  ADD CONSTRAINT `loc_city_ibfk_2` FOREIGN KEY (`loc_region_id`) REFERENCES `loc_region` (`id`);

--
-- Constraints for table `loc_city_district`
--
ALTER TABLE `loc_city_district`
  ADD CONSTRAINT `loc_city_district_ibfk_1` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`);

--
-- Constraints for table `loc_metro`
--
ALTER TABLE `loc_metro`
  ADD CONSTRAINT `loc_metro_ibfk_1` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`);

--
-- Constraints for table `loc_metro_line`
--
ALTER TABLE `loc_metro_line`
  ADD CONSTRAINT `loc_metro_line_ibfk_1` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`);

--
-- Constraints for table `loc_project`
--
ALTER TABLE `loc_project`
  ADD CONSTRAINT `loc_project_ibfk_1` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`);

--
-- Constraints for table `loc_region`
--
ALTER TABLE `loc_region`
  ADD CONSTRAINT `loc_region_ibfk_1` FOREIGN KEY (`loc_country_id`) REFERENCES `loc_country` (`id`);

--
-- Constraints for table `loc_road`
--
ALTER TABLE `loc_road`
  ADD CONSTRAINT `loc_road_ibfk_3` FOREIGN KEY (`loc_region_id`) REFERENCES `loc_region` (`id`);

--
-- Constraints for table `loc_street`
--
ALTER TABLE `loc_street`
  ADD CONSTRAINT `loc_street_ibfk_1` FOREIGN KEY (`loc_city_id`) REFERENCES `loc_city` (`id`);

--
-- Constraints for table `meta_site_lang`
--
ALTER TABLE `meta_site_lang`
  ADD CONSTRAINT `meta_site_lang_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `meta_table2section_type`
--
ALTER TABLE `meta_table2section_type`
  ADD CONSTRAINT `meta_table2section_type_ibfk_1` FOREIGN KEY (`meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meta_table2section_type_ibfk_2` FOREIGN KEY (`section_type_id`) REFERENCES `section_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meta_table2table`
--
ALTER TABLE `meta_table2table`
  ADD CONSTRAINT `meta_table2table_ibfk_4` FOREIGN KEY (`meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meta_table2table_ibfk_5` FOREIGN KEY (`detail_meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meta_table2table_ibfk_6` FOREIGN KEY (`many2many_meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meta_table_field`
--
ALTER TABLE `meta_table_field`
  ADD CONSTRAINT `meta_table_field_ibfk_1` FOREIGN KEY (`meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meta_table_field_ibfk_3` FOREIGN KEY (`lookup_meta_table_field_id`) REFERENCES `meta_table_field` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meta_table_field_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`),
  ADD CONSTRAINT `meta_table_field_ibfk_5` FOREIGN KEY (`lookup_external_meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `meta_table_field_ibfk_6` FOREIGN KEY (`meta_table_field_group_id`) REFERENCES `meta_table_field_group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`news_folder_id`) REFERENCES `news_folder` (`id`),
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `news_ibfk_3` FOREIGN KEY (`meta_table_id`) REFERENCES `meta_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_folder`
--
ALTER TABLE `news_folder`
  ADD CONSTRAINT `news_folder_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `news_folder2section`
--
ALTER TABLE `news_folder2section`
  ADD CONSTRAINT `news_folder2section_ibfk_1` FOREIGN KEY (`news_folder_id`) REFERENCES `news_folder` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_folder2section_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_tag2news`
--
ALTER TABLE `news_tag2news`
  ADD CONSTRAINT `news_tag2news_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_tag2news_ibfk_2` FOREIGN KEY (`news_tag_id`) REFERENCES `news_tag` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_subtype`
--
ALTER TABLE `property_subtype`
  ADD CONSTRAINT `property_subtype_ibfk_1` FOREIGN KEY (`property_type_id`) REFERENCES `property_type` (`id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `section_ibfk_4` FOREIGN KEY (`section_type_id`) REFERENCES `section_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `section_ibfk_5` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `section2container`
--
ALTER TABLE `section2container`
  ADD CONSTRAINT `section2container_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `section2container_ibfk_2` FOREIGN KEY (`container_id`) REFERENCES `container` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section2container_ibfk_3` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `section_type`
--
ALTER TABLE `section_type`
  ADD CONSTRAINT `section_type_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `seo_parameter`
--
ALTER TABLE `seo_parameter`
  ADD CONSTRAINT `seo_parameter_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `seo_parameter2section_type`
--
ALTER TABLE `seo_parameter2section_type`
  ADD CONSTRAINT `seo_parameter2section_type_ibfk_1` FOREIGN KEY (`seo_parameter_id`) REFERENCES `seo_parameter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seo_parameter2section_type_ibfk_2` FOREIGN KEY (`section_type_id`) REFERENCES `section_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seo_url_data`
--
ALTER TABLE `seo_url_data`
  ADD CONSTRAINT `seo_url_data_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `setting`
--
ALTER TABLE `setting`
  ADD CONSTRAINT `setting_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user2users_group`
--
ALTER TABLE `user2users_group`
  ADD CONSTRAINT `user2users_group_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user2users_group_ibfk_2` FOREIGN KEY (`users_group_id`) REFERENCES `users_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_group`
--
ALTER TABLE `users_group`
  ADD CONSTRAINT `users_group_ibfk_1` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_session_ibfk_2` FOREIGN KEY (`meta_site_id`) REFERENCES `meta_site` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
