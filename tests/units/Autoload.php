<?php

/**
 * ---------------------------------------------------------------------
 *
 * GLPI - Gestionnaire Libre de Parc Informatique
 *
 * http://glpi-project.org
 *
 * @copyright 2015-2023 Teclib' and contributors.
 * @copyright 2003-2014 by the INDEPNET Development Team.
 * @licence   https://www.gnu.org/licenses/gpl-3.0.html
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * ---------------------------------------------------------------------
 */

namespace tests\units;

use DbTestCase;

require_once __DIR__ . '/../Autoload.php';

/* Test for inc/autoload.function.php */

class Autoload extends DbTestCase
{
    public function dataItemType()
    {
        return [
            ['Computer',                         false, false],
            ['Glpi\\Event',                      false, false],
            ['PluginFooBar',                     'Foo', 'Bar'],
            ['GlpiPlugin\\Foo\\Bar',             'Foo', 'Bar'],
            ['GlpiPlugin\\Foo\\Bar\\More',       'Foo', 'Bar\\More'],
            ['PluginFooBar\Invalid',             false, false],
            ['Glpi\Api\Deprecated\PluginFooBar', false, false],
            ['Invalid\GlpiPlugin\Foo\Bar',       false, false],
        ];
    }

    /**
     * @dataProvider dataItemType
     **/
    public function testIsPluginItemType($type, $plug, $class)
    {
        $res = isPluginItemType($type);
        if ($plug) {
            $this->array($res)
            ->isIdenticalTo([
                'plugin' => $plug,
                'class'  => $class
            ]);
        } else {
            $this->boolean($res)->isFalse;
        }
    }

    /**
     * Checks autoload of some class located in Glpi namespace.
     */
    public function testAutoloadGlpiEvent()
    {
        $this->boolean(class_exists('Glpi\\Event'))->isTrue();
    }
}
