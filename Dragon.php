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
	public $collectTime;

	/** @var int */
	public $iron;

	/** @var \DateTime */
	public $ironTime;

	/** @var string */
	public $battleType;

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