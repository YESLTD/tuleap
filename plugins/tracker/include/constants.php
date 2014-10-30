<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */
define('TRACKER_BASE_URL', '/plugins/tracker');
define('TRACKER_BASE_DIR', dirname(__FILE__));
define('TRACKER_TEMPLATE_DIR', realpath(dirname(__FILE__).'/../templates'));

define('TRACKER_EVENT_INCLUDE_CSS_FILE', 'tracker_event_include_css_file');

/**
 * The trackers from a project have been duplicated in another project
 *
 * Parameters:
 * 'tracker_mapping' => The mapping between source and target project trackers
 * 'group_id'        => The id of the target project
 *
 * No expected results
 */
define('TRACKER_EVENT_TRACKERS_DUPLICATED', 'tracker_event_trackers_duplicated');

/**
 * An artifact has just been created/updated. Redirect to a plugin specific url if needed.
 *
 * Parameters:
 * 'request'  => The initial request
 * 'artifact' => The involved artifact
 *
 * Either a redirection has been done or nothing has been done 
 * (in this case plugins/tracker will commpute the redirection)
 */
define('TRACKER_EVENT_REDIRECT_AFTER_ARTIFACT_CREATION_OR_UPDATE', 'tracker_event_redirect_after_artifact_creation_or_update');

/**
 * We build the form action for a new artifact. Let the plugin inject its own variable.
 *
 * Parameters:
 * 'request'          => The initial request
 * 'query_parameters' => The actual form action parameters
 *
 * No expected results than the query_parameters modified if needed 
 */
define('TRACKER_EVENT_BUILD_ARTIFACT_FORM_ACTION', 'tracker_event_build_artifact_form_action');

/**
 * An artifact has just been (un)associated to another one
 *
 * Parameters:
 * 'artifact'             => The artifact which receive the (un)association
 * 'linked-artifact-id'   => The (previously) linked artifact id
 * 'request'              => The request
 * 'user'                 => The user who made the request
 * 'form_element_factory' => The FormElementFactory
 *
 * Expected results:
 *  No expected results
 */
define('TRACKER_EVENT_ARTIFACT_ASSOCIATION_EDITED', 'tracker_event_artifact_association_edited');

/**
 * Should we display a selector to choose the parent of an item during creation?
 * If so, which artifacts are possible parents for the created item?
 *
 * By default, we display the selector with open artifacts parents
 *
 * Parameters:
 * 'user'             => User    The current user
 * 'parent_tracker'   => Tracker The parent tracker
 *
 * Re
 * 'possible_parents' => array of Tracker_Artifact
 * 'label'            => string the label of the possible parents list
 * 'display_selector' => bool true if we can display the selector
 */
define('TRACKER_EVENT_ARTIFACT_PARENTS_SELECTOR', 'tracker_event_artifact_parents_selector');

/**
 * Fetch the semantics used by other plugins
 *
 * Parameters:
 * 'semantics' => @var Tracker_SemanticCollection A collection of semantics that needs adding to.
 * 'tracker'   => @var Tracker                    The Tracker the semantics are defined upon
 *
 * Expected results
 * The semantics parameter is populated with additional semantic fields
 */
define('TRACKER_EVENT_MANAGE_SEMANTICS', 'tracker_event_manage_semantics');

/**
 * Create a semantic from xml in other plugins
 *
 * Parameters:
 * 'xml'           => @var SimpleXMLElement
 * 'xml_mapping'   => @var array
 * 'tracker'       => @var Tracker
 * 'semantic'      => @var array
 * 'type'          => @var string
 *
 * Expected results
 * The semantic parameter is populated with a Tracker_Semantic object if it exists for the given type
 */
define('TRACKER_EVENT_SEMANTIC_FROM_XML', 'tracker_event_semantic_from_xml');

/**
 * Fetches all the semantic names
 *
 * Parameters:
 * 'semantic' => @var array of semantic name strings
 */
define('TRACKER_EVENT_SOAP_SEMANTICS', 'tracker_event_soap_semantics');

/**
 * Get the various factories that can retrieve semantics
 *
 * Parameters:
 *  'factories' => All semantic factories
 */
define('TRACKER_EVENT_GET_SEMANTIC_FACTORIES', 'tracker_event_get_semantic_factories');

/**
 * Get the various criteria that may enhance a report
 *
 * Parameters:
 *  'array_of_html_criteria' string[]                (OUT) html code to be included in the criteria list
 *  'tracker'                Tracker                 (IN)  the current tracker
 *  'additional_criteria'    Tracker_Report_AdditionalCriteria[]  (IN)
 *  'user'                   PFUser                  (IN)  the current user
 */
define('TRACKER_EVENT_REPORT_DISPLAY_ADDITIONAL_CRITERIA', 'tracker_event_report_display_additional_criteria');

/**
 * We are searching the matching ids
 *
 * Parameters:
 * 'request'                CodendiRequest
 * 'result'                 array
 * 'search_performed'       Boolean
 * 'tracker'                Tracker  (IN)     the current tracker
 * 'additional_criteria'    Tracker_Report_AdditionalCriteria[]  (IN)
 * 'user'                   PFUser
 * 'form_element_factory'   Tracker_FormElementFactory
 */
define('TRACKER_EVENT_REPORT_PROCESS_ADDITIONAL_QUERY', 'tracker_event_report_process_additional_query');

/**
 * We want to save in database additional criteria
 *
 * Parameters:
 * 'additional_criteria'    Tracker_Report_AdditionalCriteria[]  (IN)
 * 'report'                 Tracker_Report                       (IN)
 */
define('TRACKER_EVENT_REPORT_SAVE_ADDITIONAL_CRITERIA', 'tracker_event_report_save_additional_criteria');

/**
 * We want to save in database additional criteria
 *
 * Parameters:
 * 'additional_criteria_values'    array($key => $value) (OUT)
 * 'report'                        Tracker_Report        (IN)
 */
define('TRACKER_EVENT_REPORT_LOAD_ADDITIONAL_CRITERIA', 'tracker_event_report_load_additional_criteria');

/**
 * Event emitted when an artifact is updated but before notification
 *
 * Parameters:
 *   'artifact' Tracker_Artifact (IN)
 */
define('TRACKER_EVENT_ARTIFACT_POST_UPDATE', 'tracker_event_artifact_post_update');

/**
 * Event emitted when a field data can be augmented by plugins
 *
 * Parameters:
 *   'additional_criteria'    Tracker_Report_AdditionalCriteria[]  (IN)
 *   'result'                 String (OUT)
 *   'artifact_id'            Int (IN)
 *   'field'                  Tracker_FormElement_Field (IN)
 */
define('TRACKER_EVENT_FIELD_AUGMENT_DATA_FOR_REPORT', 'tracker_event_field_augment_data_for_report');

/**
 * Event emitted when an artifact is deleted
 *
 * Parameters:
 *   'artifact'    Tracker_Artifact
 */
define('TRACKER_EVENT_ARTIFACT_DELETE', 'tracker_event_artifact_delete');