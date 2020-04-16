--
-- add article link
--
ALTER TABLE `articlerequest` ADD `article_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `Articlerequest_ID`;
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'hidden', 'Matched Article', 'article_idfs', 'articlerequest-base', 'articlerequest-single', 'col-md-3', '', '', '0', '1', '0', '', '', '');

--
-- Matching Partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Matching', 'matching', 'articlerequest-matching', 'articlerequest-single', 'col-md-12', '', '', 0, 1, 0, '', '', '');

--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('articlerequest-matching', 'articlerequest-single', 'Matching', 'Matching Results', 'fas fa-list', '', '1', '', '');

--
-- Matching success permission
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`, `needs_globaladmin`) VALUES
('success', 'OnePlace\\Articlerequest\\Matching\\Controller\\MatchingController', 'Close Matching as successful', '', '', 0, 0);

--
-- add custom tags
--
INSERT INTO `core_entity_tag` (`Entitytag_ID`, `entity_form_idfs`, `tag_idfs`, `tag_value`, `parent_tag_idfs`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'article-single', '2', 'available', '0', '1', '2020-02-13 16:06:31', '1', '2020-02-13 16:06:31'),
(NULL, 'article-single', '2', 'sold', '0', '1', '2020-02-13 16:06:31', '1', '2020-02-13 16:06:31'),
(NULL, 'articlerequest-single', '2', 'open', '0', '1', '2020-02-13 19:40:52', '1', '2020-02-13 19:40:52'),
(NULL, 'articlerequest-single', '2', 'success', '0', '1', '2020-02-13 19:40:52', '1', '2020-02-13 19:40:52');

--
-- Widget
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'articlerequest_matching', 'Matching Results', 'index-Application\\Controller\\IndexController');