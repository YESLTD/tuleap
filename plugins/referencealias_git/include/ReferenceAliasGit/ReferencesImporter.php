<?php
/**
 * Copyright (c) Enalean SAS, 2016. All Rights Reserved.
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

namespace Tuleap\ReferenceAliasGit;

use Logger;
use Project;
use SimpleXMLElement;
use GitRepository;

class ReferencesImporter
{
    /** @var Dao */
    private $dao;

    /** @var Logger */
    private $logger;

    const XREF_CMMT  = 'cmmt';

    public function __construct(Dao $dao, Logger $logger)
    {
        $this->dao    = $dao;
        $this->logger = $logger;
    }

    public function importCompatRefXML(Project $project, SimpleXMLElement $xml, GitRepository $repository)
    {
        foreach ($xml->children() as $reference) {
            $source = (string) $reference['source'];
            $sha1   = (string) $reference['target'];

            $reference_keyword = $this->getReferenceKeyword($source);

            if ($reference_keyword !== self::XREF_CMMT) {
                $this->logger->warn("Cross reference kind '$reference_keyword' for $source not supported");
                continue;
            }

            $row = $this->dao->getRef($source)->getRow();
            if (! empty($row)) {
                $this->logger->warn("The source $source already exists in the database. It will not be imported.");
                continue;
            }

            $repository_id = $repository->getId();

            if (! $this->dao->insertRef($source, $repository_id, $sha1)) {
                $this->logger->error("Could not insert object for $source");
            } else {
                $this->logger->info("Imported original ref '$source' -> git repo $repository_id, sha1 $sha1.");
            }
        }
    }

    private function getReferenceKeyword($reference)
    {
        $matches = array();
        if (preg_match('/^([a-zA-Z]*)/', $reference, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }
}
