<?php
/*
 * Copyright (c) Enalean, 2015. All Rights Reserved.
 * Copyright 2005, STMicroelectronics
 *
 * Originally written by Manuel Vacelet
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

require_once('PHPWikiActions.class.php');
require_once(dirname(__FILE__) . '/../lib/PHPWikiEntry.class.php');
//require_once('InterWikiLink.class.php');

/**
 *
 * @package WikiService
 * @copyright STMicroelectronics, 2005
 * @author Manuel Vacelet <manuel.vacelet-abecedaire@st.com>
 * @license http://opensource.org/licenses/gpl-license.php GPL
 */
class PHPWikiServiceActions extends PHPWikiActions {
  /* private */ var $gid;

  function PHPWikiServiceActions(&$controler, $id) {
      $this->PHPWikiActions($controler);
    $this->gid = $id;
  }

}
?>