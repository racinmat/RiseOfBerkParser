<?php

/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 14. 2. 2016
 * Time: 18:10
 */
class Dragon
{

	/** @var String */
	public $name;

	/** @var int */
	public $fishPerHour;

	/** @var int */
	public $woodPerHour;

	/** @var \DateTime */
	public $collectionTime;

	/** @var int */
	public $iron;

	/** @var \DateTime */
	public $ironCollectionTime;

	/** @var string */
	public $battleRange;

	/** @var int */
	public $battlePower;

	/**
	 * Dragon constructor.
	 * @param array $properties
	 */
	public function __construct(array $properties = [])
	{
		foreach ($properties as $key => $value) {
			$this->{$key} = $value;
		}
	}

}