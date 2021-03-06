<?php
/**
 * Copyright (c) Enalean, 2016. All Rights Reserved.
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
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\Git\Permissions;

use GitRepository;

class FineGrainedPermissionReplicator
{
    /**
     * @var FineGrainedDao
     */
    private $fine_grained_dao;

    /**
     * @var FineGrainedPermissionSaver
     */
    private $saver;

    /**
     * @var DefaultFineGrainedPermissionFactory
     */
    private $factory;

    public function __construct(
        FineGrainedDao $fine_grained_dao,
        DefaultFineGrainedPermissionFactory $factory,
        FineGrainedPermissionSaver $saver
    ) {
        $this->fine_grained_dao = $fine_grained_dao;
        $this->factory          = $factory;
        $this->saver            = $saver;
    }

    public function replicateDefaultPermissions(
        GitRepository $repository
    ) {
        $project            = $repository->getProject();
        $branch_permissions = $this->factory->getBranchesFineGrainedPermissionsForProject($project);
        $tags_permissions   = $this->factory->getTagsFineGrainedPermissionsForProject($project);

        $this->fine_grained_dao->replicateFineGrainedPermissionsEnabledFromDefault(
            $project->getID(),
            $repository->getId()
        );

        foreach ($branch_permissions as $default_permission) {
            $replicated_permission = new FineGrainedPermission(
                0,
                $repository->getId(),
                $default_permission->getPatternWithoutPrefix(),
                $default_permission->getWritersUgroup(),
                $default_permission->getRewindersUgroup()
            );
            $this->saver->saveBranchPermission($replicated_permission);
        }

        foreach ($tags_permissions as $default_permission) {
            $replicated_permission = new FineGrainedPermission(
                0,
                $repository->getId(),
                $default_permission->getPatternWithoutPrefix(),
                $default_permission->getWritersUgroup(),
                $default_permission->getRewindersUgroup()
            );
            $this->saver->saveTagPermission($replicated_permission);
        }
    }
}
