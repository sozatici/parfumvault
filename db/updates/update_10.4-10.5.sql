ALTER TABLE `documents` ADD `isSDS` INT NOT NULL DEFAULT '0' AFTER `isBatch`; 
CREATE TABLE `sds_data` ( `id` INT NOT NULL AUTO_INCREMENT , `product_name` VARCHAR(255) NOT NULL , `product_use` VARCHAR(255) NOT NULL , `country` VARCHAR(255) NOT NULL DEFAULT 'United Kingdom' , `language` VARCHAR(255) NOT NULL DEFAULT 'English' , `product_type` VARCHAR(255) NOT NULL DEFAULT 'Substance' , `state_type` VARCHAR(255) NOT NULL DEFAULT 'Liquid' , `supplier_id` INT NOT NULL , `docID` INT NOT NULL, `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci; 
ALTER TABLE `ingredient_compounds` CHANGE `percentage` `min_percentage` DECIMAL(8,4) NOT NULL; 
ALTER TABLE `ingredient_compounds` ADD `max_percentage` DECIMAL(8,4) NOT NULL AFTER `min_percentage`;
ALTER TABLE `settings` ADD `defPercentage` VARCHAR(255) NOT NULL DEFAULT 'max_percentage' AFTER `defCatClass`; 
ALTER TABLE `settings` ADD `sds_disclaimer` MEDIUMTEXT NOT NULL DEFAULT 'PLEASE ADD A PROPER DISCLAIMER MESSAGE' AFTER `pv_host`; 
CREATE TABLE `ingredient_safety_data` (
  `ingID` int(11) NOT NULL,
  `first_aid_general` longtext DEFAULT NULL,
  `first_aid_inhalation` longtext DEFAULT NULL,
  `first_aid_skin` longtext DEFAULT NULL,
  `first_aid_eye` longtext DEFAULT NULL,
  `first_aid_ingestion` longtext DEFAULT NULL,
  `first_aid_self_protection` longtext DEFAULT NULL,
  `first_aid_symptoms` mediumtext DEFAULT NULL,
  `first_aid_dr_notes` mediumtext DEFAULT NULL,
  `firefighting_suitable_media` mediumtext DEFAULT NULL,
  `firefighting_non_suitable_media` mediumtext DEFAULT NULL,
  `firefighting_special_hazards` mediumtext DEFAULT NULL,
  `firefighting_advice` mediumtext DEFAULT NULL,
  `firefighting_other_info` mediumtext DEFAULT NULL,
  `accidental_release_per_precautions` mediumtext DEFAULT NULL,
  `accidental_release_env_precautions` mediumtext DEFAULT NULL,
  `accidental_release_cleaning` mediumtext DEFAULT NULL,
  `accidental_release_refs` mediumtext DEFAULT NULL,
  `accidental_release_other_info` mediumtext DEFAULT NULL,
  `handling_protection` mediumtext DEFAULT NULL,
  `handling_hygiene` mediumtext DEFAULT NULL,
  `handling_safe_storage` mediumtext DEFAULT NULL,
  `handling_joint_storage` mediumtext DEFAULT NULL,
  `handling_specific_uses` mediumtext DEFAULT NULL,
  `exposure_occupational_limits` mediumtext DEFAULT NULL,
  `exposure_biological_limits` mediumtext DEFAULT NULL,
  `exposure_intented_use_limits` mediumtext DEFAULT NULL,
  `exposure_other_remarks` mediumtext DEFAULT NULL,
  `exposure_face_protection` mediumtext DEFAULT NULL,
  `exposure_skin_protection` mediumtext DEFAULT NULL,
  `exposure_respiratory_protection` mediumtext DEFAULT NULL,
  `exposure_env_exposure` mediumtext DEFAULT NULL,
  `exposure_consumer_exposure` mediumtext DEFAULT NULL,
  `exposure_other_info` mediumtext DEFAULT NULL,
  `stabillity_reactivity` mediumtext DEFAULT NULL,
  `stabillity_chemical` mediumtext DEFAULT NULL,
  `stabillity_reactions` mediumtext DEFAULT NULL,
  `stabillity_avoid` mediumtext DEFAULT NULL,
  `stabillity_incompatibility` mediumtext DEFAULT NULL,
  `toxicological_acute_oral` mediumtext DEFAULT NULL,
  `toxicological_acute_dermal` mediumtext DEFAULT NULL,
  `toxicological_acute_inhalation` mediumtext DEFAULT NULL,
  `toxicological_skin` mediumtext DEFAULT NULL,
  `toxicological_eye` mediumtext DEFAULT NULL,
  `toxicological_sensitisation` mediumtext DEFAULT NULL,
  `toxicological_organ_repeated` mediumtext DEFAULT NULL,
  `toxicological_organ_single` mediumtext DEFAULT NULL,
  `toxicological_carcinogencity` mediumtext DEFAULT NULL,
  `toxicological_reproductive` mediumtext DEFAULT NULL,
  `toxicological_cell_mutation` mediumtext DEFAULT NULL,
  `toxicological_resp_tract` mediumtext DEFAULT NULL,
  `toxicological_other_info` mediumtext DEFAULT NULL,
  `toxicological_other_hazards` mediumtext DEFAULT NULL,
  `ecological_toxicity` mediumtext DEFAULT NULL,
  `ecological_persistence` mediumtext DEFAULT NULL,
  `ecological_bioaccumulative` mediumtext DEFAULT NULL,
  `ecological_soil_mobility` mediumtext DEFAULT NULL,
  `ecological_PBT_vPvB` mediumtext DEFAULT NULL,
  `ecological_endocrine_properties` mediumtext DEFAULT NULL,
  `ecological_other_adv_effects` mediumtext DEFAULT NULL,
  `ecological_additional_ecotoxicological_info` mediumtext DEFAULT NULL,
  `disposal_product` mediumtext DEFAULT NULL,
  `disposal_remarks` mediumtext DEFAULT NULL,
  `transport_un_number` mediumtext DEFAULT NULL,
  `transport_shipping_name` mediumtext DEFAULT NULL,
  `transport_hazard_class` mediumtext DEFAULT NULL,
  `transport_packing_group` mediumtext DEFAULT NULL,
  `transport_env_hazards` mediumtext DEFAULT NULL,
  `transport_precautions` mediumtext DEFAULT NULL,
  `transport_bulk_shipping` mediumtext DEFAULT NULL,
  `odor_threshold` text DEFAULT NULL,
  `pH` text DEFAULT NULL,
  `melting_point` text DEFAULT NULL,
  `boiling_point` text DEFAULT NULL,
  `flash_point` text DEFAULT NULL,
  `evaporation_rate` text DEFAULT NULL,
  `solubility` text DEFAULT NULL,
  `auto_infl_temp` text DEFAULT NULL,
  `decomp_temp` text DEFAULT NULL,
  `viscosity` text DEFAULT NULL,
  `explosive_properties` mediumtext DEFAULT NULL,
  `oxidising_properties` mediumtext DEFAULT NULL,
  `particle_chars` mediumtext DEFAULT NULL,
  `flammability` mediumtext DEFAULT NULL,
  `logP` varchar(255) DEFAULT NULL,
  `soluble` varchar(255) DEFAULT NULL,
  `color` text DEFAULT NULL,
  `low_flammability_limit` text DEFAULT NULL,
  `vapour_pressure` text DEFAULT NULL,
  `vapour_density` text DEFAULT NULL,
  `relative_density` text DEFAULT NULL,
  `pcp_other_info` mediumtext DEFAULT NULL,
  `pcp_other_sec_info` mediumtext DEFAULT NULL,
  `legislation_safety` mediumtext DEFAULT NULL,
  `legislation_eu` mediumtext DEFAULT NULL,
  `legislation_chemical_safety_assessment` mediumtext DEFAULT NULL,
  `legislation_other_info` mediumtext DEFAULT NULL,
  `add_info_changes` mediumtext DEFAULT NULL,
  `add_info_acronyms` mediumtext DEFAULT NULL,
  `add_info_references` mediumtext DEFAULT NULL,
  `add_info_HazCom` mediumtext DEFAULT NULL,
  `add_info_GHS` mediumtext DEFAULT NULL,
  `add_info_training` mediumtext DEFAULT NULL,
  `add_info_other` mediumtext DEFAULT NULL,
  PRIMARY KEY (`ingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `templates` ( `name`, `content`, `description`) VALUES('SDS Example template', '<!doctype html>\n<html lang=\"en\">\n\n<head>\n    <link href=\"/css/bootstrap.min.css\" rel=\"stylesheet\">\n    <link href=\"/css/bootstrap-icons/font/bootstrap-icons.min.css\" rel=\"stylesheet\" type=\"text/css\">\n    <link href=\"/css/fontawesome-free/css/all.min.css\" rel=\"stylesheet\">\n    <link href=\"/css/regulatory.css\" rel=\"stylesheet\">\n</head>\n\n<body>\n    <div class=\"container\">\n        <div class=\"sds\">\n            <div class=\"sds-company text-inverse fw-bold\">\n                <img src=\"%LOGO%\" class=\"img-thumbnail float-start\">\n            </div>\n            <div class=\"sds-date\">\n                <small>Language %SDS_LANGUAGE%</small>\n                <div class=\"date text-inverse mt-2\">%CURRENT_DATE%</div>\n                <div class=\"sds-detail\">\n                    According to Regulation (EC) No. 1907/2006 (amended by Regulation (EU) No. 2020/878)\n                </div>\n            </div>\n            <div id=\"section-1\">\n                <div class=\"sds-header\">\n                    <div class=\"sds-to\">\n                        <h4>1. Identification of the substance/mixture and of the company/undertaking</h4>\n                    </div>\n                </div>\n                <div class=\"sds-content mt-2\">\n                    <div class=\"mb-4\">\n                        <div class=\"fw-bold\">1.1 Product identifier</div>\n                        <div class=\"mt-2\">\n                            <div class=\"fw-bold\">Trade name/designation</div>\n                            <div>%SDS_PRODUCT_NAME%</div>\n                        </div>\n                    </div>\n                    <div class=\"mb-4\">\n                        <div class=\"fw-bold\">1.2 Relevant identified uses of the substance or mixture and uses advised against</div>\n                        <div class=\"mt-2\">\n                            <div class=\"fw-bold\">Relevant identified uses</div>\n                            <div>%SDS_PRODUCT_USE%</div>\n                        </div>\n                        <div class=\"mt-2\">\n                            <div class=\"fw-bold\">Uses advised against</div>\n                            <div>%SDS_PRODUCT_ADA%</div>\n                        </div>\n                    </div>\n\n                    <div class=\"mb-4\">\n                        <div class=\"fw-bold\">1.3 Details of the supplier of the safety data sheet</div>\n                        <div class=\"mt-2\">\n                            <div class=\"fw-bold\">Supplier</div>\n                            <div>%SDS_SUPPLIER_NAME%</div>\n                            <div>%SDS_SUPPLIER_ADDRESS%, %SDS_SUPPLIER_COUNTRY%, %SDS_SUPPLIER_PO%</div>\n                            <div>%SDS_SUPPLIER_EMAIL%</div>\n                            <div>%SDS_SUPPLIER_PHONE%</div>\n                            <div>%SDS_SUPPLIER_WEB%</div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n            <div id=\"section-2\">\n                <div class=\"sds-header\">\n                    <div class=\"sds-to\">\n                        <h4>2. Hazards identification</h4>\n                    </div>\n                </div>\n                <div class=\"alert alert-info mt-4\"><i class=\"fa-solid fa-info mx-2\"></i>\n                    2.2 Labeling\n                    <p>\n                        <span class=\"me-3\"><i class=\"fa fa-fw fa-lg mt-2\"></i>Label elements according to the regulation (EC) n°1272/2008 (CLP) and its amendments</span>\n                    </p>\n                </div>\n                <div class=\"sds-content mt-2\">\n                    %GHS_LABEL_LIST%\n                </div>\n            </div>\n            <div id=\"section-3\">\n                <div class=\"sds-header\">\n                    <div class=\"sds-to\">\n                        <h4>3. Composition/information on ingredients</h4>\n                    </div>\n                </div>\n                <div class=\"alert alert-info mt-4\"><i class=\"fa-solid fa-info mx-2\"></i>\n                    In accordance with the product knowledge, no nanomaterials have been identified. The mixture does not contain any substances classified as Substances of Very High Concern (SVHC) by the European Chemicals Agency (ECHA) under article 57 of REACH: http://echa.europa.eu/fr/candidate-list-table.\n                </div>\n                <div class=\"sds-content mt-2\">\n                    <div class=\"d-flex flex-wrap\">\n                       <table width=\"100%\" class=\"table table-sds\">\n                          <tbody>\n                             <th>Name</th>\n                             <th>CAS</th>\n                             <th>EINES</th>\n                             <th>Min percentage</th>\n                             <th>Max percentage</th>\n                             <th>GHS</th>\n                             %CMP_MATERIALS_LIST%\n                         </tbody>\n                     </table>\n                 </div>\n             </div>\n         </div>\n        <div id=\"section-4\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>4. First aid measures</h4>\n                </div>\n            </div>\n            <div class=\"alert alert-info mt-4\"><i class=\"fa-solid fa-info mx-2\"></i>\n                Description of first aid measures\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">General information</div>\n                    <div>%FIRST_AID_GENERAL%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Following inhalation</div>\n                    <div>%FIRST_AID_INHALATION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Following skin contact</div>\n                    <div>%FIRST_AID_SKIN%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Following eye contact</div>\n                    <div>%FIRST_AID_EYE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Following ingestion</div>\n                    <div>%FIRST_AID_INGESTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Self-protection of the first aider</div>\n                    <div>%FIRST_AID_SELF_PROTECTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Most important symptoms and effects, both acute and delayed</div>\n                    <div>%FIRST_AID_SYMPTOMS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Notes for the doctor</div>\n                    <div>%FIRST_AID_DR_NOTES%</div>\n                </div>\n            </div>\n        </div>\n        <div id=\"section-5\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>5. Firefighting measures</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Suitable extinguishing media</div>\n                    <div>%FIRE_SUIT_MEDIA%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Unsuitable extinguishing media</div>\n                    <div>%FIRE_NONSUIT_MEDIA%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Special hazards arising from the substance or mixture</div>\n                    <div>%FIRE_SPECIAL_HAZARDS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Advice for firefighters</div>\n                    <div>%FIRE_ADVICE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%FIRE_OTHER_INFO%</div>\n                </div>\n            </div>\n        </div>\n        <div id=\"section-6\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>6. Accidental release measures</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Personal precautions, protective equipment and emergency procedures</div>\n                    <div>%ACC_REL_PERSONAL_CAUTIONS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Environmental precautions</div>\n                    <div>%ACC_REL_ENV_CAUTIONS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Methods and material for containment and cleaning up</div>\n                    <div>%ACC_REL_CLEANING%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Reference to other sections</div>\n                    <div>%ACC_REL_REFERENCES%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%ACC_REL_OTHER_INFO%</div>\n                </div>\n            </div>\n        </div>\n        <div id=\"section-7\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>7. Handling and Storage</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Precautions for safe handling</div>\n                    <div>%HS_PROTECTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Advices on general occupational hygiene</div>\n                    <div>%HS_HYGIENE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Conditions for safe storage, including any incompatibilities</div>\n                    <div>%HS_SAFE_STORE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Advice on joint storage</div>\n                    <div>%HS_JOINT_STORE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Specific end uses</div>\n                    <div>%HS_SPECIFIC_USES%</div>\n                </div>\n            </div>\n        </div>\n        <div id=\"section-8\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>8. Exposure controls/personal protection</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Occupational exposure limits</div>\n                    <div>%EXPOSURE_OCC_LIMIT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Biological limit values</div>\n                    <div>%EXPOSURE_BIO_LIMIT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Exposure limits at intended use</div>\n                    <div>%EXPOSURE_USE_LIMIT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Remarks</div>\n                    <div>%EXPOSURE_OTHER_REM%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Eye/face protection</div>\n                    <div>%EXPOSURE_FACE_PROTECTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Skin protection</div>\n                    <div>%EXPOSURE_SKIN_PROTECTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Respiratory protection</div>\n                    <div>%EXPOSURE_RESP_PROTECTION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Environmental exposure controls</div>\n                    <div>%EXPOSURE_ENV_EXPOSURE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Consumer exposure controls</div>\n                    <div>%EXPOSURE_CONS_EXPOSURE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%EXPOSURE_OTHER_INFO%</div>\n                </div>\n            </div>\n        </div>\n        <div id=\"section-9\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>9. Physical and chemical Properties</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Physical state</div>\n                    <div>%PHYSICAL_STATE%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Color</div>\n                    <div>%COLOR%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Odor</div>\n                    <div>%ODOR%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Odor threshold</div>\n                    <div>%ODOR_THRESHOLD%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">pH</div>\n                    <div>%PH%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Melting/Freezing point</div>\n                    <div>%MELTING_POINT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Boiling point</div>\n                    <div>%BOILING_POINT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Flash point</div>\n                    <div>%FLASH_POINT%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Evaporation rate</div>\n                    <div>%EVAPORATION_RATE%</div>\n                </div> \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Water solubility</div>\n                    <div>%SOLUBILITY%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Partition coefficient, n-octanol/water (log Pow)</div>\n                    <div>%LOGP%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Auto-inflammability temperature</div>\n                    <div>%AUTO_INFL_TEMP%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Decomposition temperature</div>\n                    <div>%DECOMP_TEMP%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Viscosity</div>\n                    <div>%VISCOSITY%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Explosive properties</div>\n                    <div>%EXPLOSIVE_PROPERTIES%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Oxidising properties</div>\n                    <div>%OXIDISING_PROPERTIES%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Solubility in other Solvents</div>\n                    <div>%SOLVENTS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Particle characteristics</div>\n                    <div>%PARTICLE_CHARACTERISTICS%</div>\n                </div>                \n            </div>\n        </div>\n        <div id=\"section-10\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>10. Stability and Reactivity</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Reactivity</div>\n                    <div>%STABILLITY_REACTIVITY%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Chemical stability</div>\n                    <div>%STABILLITY_CHEMICAL%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Possibility of hazardous reactions</div>\n                    <div>%STABILLITY_REACTIONS%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Conditions to avoid</div>\n                    <div>%STABILLITY_AVOID%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Incompatible materials</div>\n                    <div>%STABILLITY_INCOMPATIBILITY%</div>\n                </div>             \n            </div>           \n        </div>\n        <div id=\"section-11\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>11. Toxicological information</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Acute oral toxicity</div>\n                    <div>%TOXICOLOGICAL_ACUTE_ORAL%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Acute dermal toxicity</div>\n                    <div>%TOXICOLOGICAL_ACUTE_DERMAL%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Acute inhalation toxicity</div>\n                    <div>%TOXICOLOGICAL_ACUTE_INHALATION%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Skin corrosion/irritation</div>\n                    <div>%TOXICOLOGICAL_SKIN%</div>\n                </div>\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Serious eye damage/irritation</div>\n                    <div>%TOXICOLOGICAL_EYE%</div>\n                </div>  \n\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Skin sensitisation</div>\n                    <div>%TOXICOLOGICAL_SENSITISATION%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Specific target organ toxicity (repeated exposure)</div>\n                    <div>%TOXICOLOGICAL_ORGAN_REPEATED%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Specific target organ toxicity (single exposure)</div>\n                    <div>%TOXICOLOGICAL_ORGAN_SINGLE%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Carcinogenicity</div>\n                    <div>%TOXICOLOGICAL_CARCINOGENCITY%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Reproductive toxicity</div>\n                    <div>%TOXICOLOGICAL_REPRODUCTIVE%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Germ cell mutagenicity</div>\n                    <div>%TOXICOLOGICAL_CELL_MUTATION%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Sensitisation to the respiratory tract</div>\n                    <div>%TOXICOLOGICAL_RESP_TRACT%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%TOXICOLOGICAL_OTHER_INFO%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Information on other hazards</div>\n                    <div>%TOXICOLOGICAL_OTHER_HAZARDS%</div>\n                </div>\n            </div>  \n        </div>\n\n        <div id=\"section-12\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>12. Ecological information</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Toxicity</div>\n                    <div>%ECOLOGICAL_TOXICITY%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Persistence and degradability</div>\n                    <div>%ECOLOGICAL_PERSISTENCE%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Bioaccumulative potential</div>\n                    <div>%ECOLOGICAL_BIOACCUMULATIVE%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Mobility in soil</div>\n                    <div>%ECOLOGICAL_SOIL_MOBILITY%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Results of PBT and vPvB assessment</div>\n                    <div>%ECOLOGICAL_PBT_VPVB%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Endocrine disrupting properties</div>\n                    <div>%ECOLOGICAL_ENDOCRINE_PROPERTIES%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Other adverse effects</div>\n                    <div>%ECOLOGICAL_OTHER_ADV_EFFECTS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional ecotoxicological information</div>\n                    <div>%ECOLOGICAL_ADDITIONAL_ECOTOXICOLOGICAL_INFO%</div>\n                </div>\n            </div>  \n        </div>\n        <div id=\"section-13\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>13. Disposal considerations</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\">\n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Product/Packaging disposal</div>\n                    <div>%DISPOSAL_PRODUCT%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Remark</div>\n                    <div>%DISPOSAL_REMARKS%</div>\n                </div>  \n            </div>  \n        </div>\n\n        <div id=\"section-14\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>14. Transport information</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\"> \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">UN number</div>\n                    <div>%TRANSPORT_UN_NUMBER%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">UN proper shipping name</div>\n                    <div>%TRANSPORT_SHIPPING_NAME%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Transport hazard class(es)</div>\n                    <div>%TRANSPORT_HAZARD_CLASS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Packing group</div>\n                    <div>%TRANSPORT_PACKING_GROUP%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Environmental hazards</div>\n                    <div>%TRANSPORT_ENV_HAZARDS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Special precautions for user</div>\n                    <div>%TRANSPORT_PRECAUTIONS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Bulk shipping according to IMO instruments</div>\n                    <div>%TRANSPORT_BULK_SHIPPING%</div>\n                </div>\n            </div>  \n        </div>    \n        <div id=\"section-15\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>15. Regulatory information</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\"> \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Safety, health and environmental regulations/legislation specific for the substance or mixture</div>\n                    <div>%LEGISLATION_SAFETY%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">EU legislation</div>\n                    <div>%LEGISLATION_EU%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Chemical Safety Assessment</div>\n                    <div>%LEGISLATION_CHEMICAL_SAFETY_ASSESSMENT%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%LEGISLATION_OTHER_INFO%</div>\n                </div>\n            </div>  \n        </div>\n\n\n        <div id=\"section-16\">\n            <div class=\"sds-header\">\n                <div class=\"sds-to\">\n                    <h4>16. Other information</h4>\n                </div>\n            </div>\n            <div class=\"sds-content mt-2\"> \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Indication of changes</div>\n                    <div>%ADD_INFO_CHANGES%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Abbreviations and acronyms</div>\n                    <div>%ADD_INFO_ACRONYMS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Key literature references and sources for data</div>\n                    <div>%ADD_INFO_REFERENCES%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">The classification of the mixture is in accordance with the evaluation method described in HazCom 2012</div>\n                    <div>%ADD_INFO_HAZCOM%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">The classification of the mixture is in accordance with the evaluation method described in the GHS</div>\n                    <div>%ADD_INFO_GHS%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Training advice</div>\n                    <div>%ADD_INFO_TRAINING%</div>\n                </div>  \n                <div class=\"mb-2\">\n                    <div class=\"fw-bold\">Additional information</div>\n                    <div>%ADD_INFO_OTHER%</div>\n                </div>\n            </div>  \n        </div>\n\n        <div class=\"sds-note\"><span class=\"text-center mb-3 fw-bold\">%BRAND_NAME%</span><br> \n            Creation date: %CURRENT_DATE%\n        </div>\n        <div class=\"sds-note alert alert-warning mt-4\"><i class=\"fa-solid fa-info mx-2\"></i>\n            %SDS_DISCLAIMER%\n        </div>\n        <div class=\"sds-footer\">\n            <p class=\"text-center mb-3 fw-bold\">\n            %BRAND_NAME%\n            </p>\n            <p class=\"text-center\">\n                <span class=\"me-3\"><i class=\"fa fa-fw fa-lg fa-globe mx-2\"></i>www.perfumersvault.com</span>\n            </p>\n        </div>\n    </div>\n</div>\n</body>\n</html>\n', 'This is an example template');
