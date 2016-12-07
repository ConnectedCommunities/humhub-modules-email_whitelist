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

namespace humhub\modules\email_whitelist\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\components\ActiveRecord;

/**
 * This is the model class for table "email_whitelist".
 *
 * The followings are the available columns in table 'email_whitelist':
 * @property integer $id
 * @property string $domain
 */
class EmailWhitelist extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'email_whitelist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(['domain'], 'required'),
			array(['domain'], 'string', 'max' => 400),
			array(['domain'], 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'domain' => 'Domain',
		);
	}


	/**
	 * Returns a list of whitelisted domains
	 */
	public function toArray()
	{

		$whitelist = array();

		foreach(EmailWhitelist::find()->all() as $row) {
			$whitelist[] = strtolower($row['domain']);
		}

		return $whitelist;
	}

	/**
	 * Checks to see if an email is
	 * in the whitelist
	 * @param string $email
	 * @return bool
	 */
	public static function emailIsAllowed($email)
	{
		$allowed = self::toArray();
		$domain = strtolower(array_pop(@explode('@', $email)));
		if (in_array($domain, $allowed)) { // email not whitelisted
			return true;
		} else {
			return false;
		}
	}

}
