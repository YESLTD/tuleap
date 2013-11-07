<?php
/**
 * Copyright (c) Enalean, 2013. All Rights Reserved.
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

class Tracker_REST_TrackerRepresentation {
    const ROUTE = 'trackers';

    /** @var int */
    public $id;

    /** @var string */
    public $uri;

    /** @var string */
    public $html_url;

    /** @var Rest_ResourceReference */
    public $project;

    /** @var string */
    public $label;

    /** @var string */
    public $description;

    /** @var string */
    public $item_name;

    /** @var array {@type Tracker_REST_FieldRepresentation} */
    public $fields    = array();

    /** @var array {@type Tracker_REST_SemanticRepresentation} */
    public $semantics = array();

    /** @var Tracker_REST_WorkflowRepresentation */
    public $workflow;

    public function __construct(Tracker $tracker, array $tracker_fields, array $semantics, Tracker_REST_WorkflowRepresentation $worflow = null) {
        $this->id          = $tracker->getId();
        $this->uri         = self::ROUTE . '/' . $this->id;
        $this->html_url    = $tracker->getUri();
        $this->project     = new Rest_ResourceReference($tracker->getProject()->getID(), \Tuleap\Project\REST\v1\ProjectResource::ROUTE);
        $this->label       = $tracker->getName();
        $this->description = $tracker->getDescription();
        $this->item_name   = $tracker->getItemName();
        $this->fields      = $tracker_fields;
        $this->semantics   = $semantics;
        $this->workflow    = $worflow;
    }
}
