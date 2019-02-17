<?php

/**
 * Created by PhpStorm.
 * User: Chexxor
 * Date: 4/21/2017
 * Time: 6:21 PM
 */
class OutputFormat
{
	public function dtOut(DateTime $dt) : String {
		return $dt->format("F j, Y") . " at " . $dt->format("g:i A");
	}
}