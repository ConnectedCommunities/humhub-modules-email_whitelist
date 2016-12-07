<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class m150827_105357_create_email_whitelist_table extends EDbMigration
{
	public function up()
	{
        $this->createTable('email_whitelist', array(
            'id' => 'pk',
            'domain' => 'varchar(400) NOT NULL',
        ), '');
	}

	public function down()
	{
        $this->dropTable('email_whitelist');
	}
}