DELETE FROM service WHERE short_name='plugin_svn';

DROP TABLE IF EXISTS plugin_svn_repositories;
DROP TABLE IF EXISTS plugin_svn_mailing_header;
DROP TABLE IF EXISTS plugin_svn_notification;
DROP TABLE IF EXISTS plugin_svn_accessfile_history;
DROP TABLE IF EXISTS plugin_svn_immutable_tag;
DROP TABLE IF EXISTS plugin_svn_hook_config;
