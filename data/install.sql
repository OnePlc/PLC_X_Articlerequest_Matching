--
-- Base Table
--
CREATE TABLE `articlerequest_Matching` (
  `Articlerequest_Matching_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `articlerequest_Matching`
  ADD PRIMARY KEY (`Articlerequest_Matching_ID`);

ALTER TABLE `articlerequest_Matching`
  MODIFY `Articlerequest_Matching_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Articlerequest_Matching\\Controller\\Articlerequest_MatchingController', 'Add', '', '', 0),
('edit', 'OnePlace\\Articlerequest_Matching\\Controller\\Articlerequest_MatchingController', 'Edit', '', '', 0),
('index', 'OnePlace\\Articlerequest_Matching\\Controller\\Articlerequest_MatchingController', 'Index', 'Articlerequest_Matchings', '/articlerequest_Matching', 1),
('list', 'OnePlace\\Articlerequest_Matching\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Articlerequest_Matching\\Controller\\Articlerequest_MatchingController', 'View', '', '', 0),
('dump', 'OnePlace\\Articlerequest_Matching\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\Articlerequest_Matching\\Controller\\SearchController', 'Search', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('articlerequest_Matching-single', 'Articlerequest_Matching', 'OnePlace\\Articlerequest_Matching\\Model\\Articlerequest_Matching', 'OnePlace\\Articlerequest_Matching\\Model\\Articlerequest_MatchingTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('articlerequest_Matching-index', 'articlerequest_Matching-single', 'Articlerequest_Matching Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('articlerequest_Matching-base', 'articlerequest_Matching-single', 'Articlerequest_Matching', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Articlerequest_Matching', 'fas fa-save', 'Save Articlerequest_Matching', '#', 'primary saveForm', '', 'articlerequest_Matching-single', 'link', '', ''),
(NULL, 'Edit Articlerequest_Matching', 'fas fa-edit', 'Edit Articlerequest_Matching', '/articlerequest_Matching/edit/##ID##', 'primary', '', 'articlerequest_Matching-view', 'link', '', ''),
(NULL, 'Add Articlerequest_Matching', 'fas fa-plus', 'Add Articlerequest_Matching', '/articlerequest_Matching/add', 'primary', '', 'articlerequest_Matching-index', 'link', '', ''),
(NULL, 'Export Articlerequest_Matchings', 'fas fa-file-excel', 'Export Articlerequest_Matchings', '/articlerequest_Matching/export', 'primary', '', 'articlerequest_Matching-index', 'link', '', ''),
(NULL, 'Find Articlerequest_Matchings', 'fas fa-searh', 'Find Articlerequest_Matchings', '/articlerequest_Matching/search', 'primary', '', 'articlerequest_Matching-index', 'link', '', ''),
(NULL, 'Export Articlerequest_Matchings', 'fas fa-file-excel', 'Export Articlerequest_Matchings', '#', 'primary initExcelDump', '', 'articlerequest_Matching-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-searh', 'New Search', '/articlerequest_Matching/search', 'primary', '', 'articlerequest_Matching-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'articlerequest_Matching-base', 'articlerequest_Matching-single', 'col-md-3', '/articlerequest_Matching/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- User XP Activity
--
INSERT INTO `user_xp_activity` (`Activity_ID`, `xp_key`, `label`, `xp_base`) VALUES
(NULL, 'articlerequest_Matching-add', 'Add New Articlerequest_Matching', '50'),
(NULL, 'articlerequest_Matching-edit', 'Edit Articlerequest_Matching', '5'),
(NULL, 'articlerequest_Matching-export', 'Edit Articlerequest_Matching', '5');

COMMIT;