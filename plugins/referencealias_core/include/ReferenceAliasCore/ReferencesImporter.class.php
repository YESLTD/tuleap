<?php
/**
 * Copyright (c) Sogilis, 2016. All Rights Reserved.
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

namespace Tuleap\ReferenceAliasCore;

use Logger;
use WrapperLogger;
use Project;
use SimpleXMLElement;

class ReferencesImporter
{
    /** @var Dao */
    private $dao;

    /** @var Logger */
    private $logger;

    const XREF_PCK = 'pkg';

    public function __construct(Dao $dao, Logger $logger)
    {
        $this->dao = $dao;
        $this->logger = $logger;
    }

    public function importCompatRefXML(Project $project, SimpleXMLElement $xml, array $created_refs)
    {
        foreach ($xml->children() as $reference) {
            $source = (string) $reference['source'];
            $target = (string) $reference['target'];
            $target_on_system = null;
            $xref_kind = $this->cross_ref_kind($source);

            if ($xref_kind === self::XREF_PCK) {
                $object_type = 'package';
            } else {
                $this->logger->warn("Cross reference kind '$xref_kind' for $source not supported");
                continue;
            }

            if (isset($created_refs[$object_type][$target])) {
                $target_on_system = $created_refs[$object_type][$target];
            } else {
                $this->logger->warn("Could not find object for $source (wrong object type $object_type or missing imported object $target)");
                continue;
            }

            $row = $this->dao->getRef($source)->getRow();
            if (!empty($row)) {
                $this->logger->warn("The source $source already exists in the database. It will not be imported.");
                continue;
            }

            if (! $this->dao->insertRef($project, $source, $target_on_system)) {
                $this->logger->error("Could not insert object for $source");
            } else {
                $this->logger->info("Imported original ref '$source' -> $object_type $target_on_system");
            }
        }
    }

    private function cross_ref_kind($xref)
    {
        $matches = array();
        if (preg_match('/^([a-zA-Z]*)/', $xref, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }
}
