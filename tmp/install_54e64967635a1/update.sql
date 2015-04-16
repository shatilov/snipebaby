alter table #__jshopping_products CHANGE `product_quantity` `product_quantity` DECIMAL( 12, 2 ) NOT NULL;
alter table #__jshopping_order_item add column `basicprice` DECIMAL(12,2) NOT NULL;
alter table #__jshopping_order_item add column `basicpriceunit` varchar(255) NOT NULL;
INSERT INTO `#__jshopping_config_statictext` (`alias`) VALUES ('cart');