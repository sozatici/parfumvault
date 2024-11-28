ALTER TABLE `user_prefs` CHANGE `owner` `owner_id` INT(11) NOT NULL;
ALTER TABLE `backup_provider` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `gdrive_name`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`;
ALTER TABLE `batchIDHistory` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created`;
ALTER TABLE `bottles` CHANGE `updated` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00', CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `bottles` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `cart` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `purity`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `customers` CHANGE `updated` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00', CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `documents` CHANGE `created` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `updated` `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `documents` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `formulaCategories` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `colorKey`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `formulas` CHANGE `created` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `updated` `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `formulas` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `formulasMetaData` CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `formulasMetaData` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `src`; 
ALTER TABLE `formulasRevisions` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `revisionMethod`; 
ALTER TABLE `formulasTags` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `tag_name`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `formula_history` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `user`; 
ALTER TABLE `IFRALibrary` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `cat12`; 
ALTER TABLE `ingCategory` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `colorKey`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `ingredients` CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `ingredients` ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`; 
ALTER TABLE `ingredients` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `ingredient_compounds` CHANGE `created` `created_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `ingredient_compounds` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `ingredient_safety_data` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `add_info_other`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `ingReplacements` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `notes`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `ingSafetyInfo` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `GHS`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
INSERT INTO `ingStrength` (`id`, `name`) VALUES ('4', 'Extreme');
ALTER TABLE `ingSuppliers` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `min_gr`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `inventory_accessories` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `pieces`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `inventory_compounds` CHANGE `updated` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `makeFormula` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `toAdd`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `perfumeTypes` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `description`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`, ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `sds_data` CHANGE `created` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `updated` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'; 
ALTER TABLE `sds_data` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `updated_at`; 
ALTER TABLE `suppliers` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `storage_location`; 
ALTER TABLE `synonyms` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `created_at`; 
ALTER TABLE `templates` CHANGE `created` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `updated` `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
ALTER TABLE `templates` ADD `owner_id` INT NOT NULL DEFAULT '0' AFTER `description`; 
