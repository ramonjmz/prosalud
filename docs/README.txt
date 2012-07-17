
Updates
=========

mysql> select title,concat(first_name,' ',last_name) as name, first_name,last_na
me id from contacts where title ='paciente' having concat(first_name,' ',last_na
me) like '%naye%';


Como propuesta se agrego una  nueva tabla para almacenar el resultado de las pruebas realzadas en un analisis

CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `analysis_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ref_val_id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `result` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8

mysql> insert into results (analysis_id,item_id,ref_val_id,date_modified,result)
 values(23,'26','6',now(),'105');
Query OK, 1 row affected (0.00 sec)

mysql> insert into results (analysis_id,item_id,ref_val_id,date_modified,result)
 values(23,'25','8',now(),'105');
Query OK, 1 row affected (0.00 sec)

mysql> insert into results (analysis_id,item_id,ref_val_id,date_modified,result)
 values(23,'27','9',now(),'105');
Query OK, 1 row affected (0.00 sec)

README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "C:/Program Files (x86)/Zend/Apache2/htdocs/demo/public"
   ServerName .local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "C:/Program Files (x86)/Zend/Apache2/htdocs/demo/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>

