<?php

class elections_Core {
	public static function parliament_seats()
	{
		$db = new Database();

		$result = $db->query('SELECT * FROM `parliament_seats`');
		foreach ($result as $row)
		{
			$seats[$row->id] = $row;
		}

		return $seats;
	}

	public static function state_seats($parliament_seat_id)
	{
		$db = new Database();

		$result = $db->query('SELECT `id`, `name`, `latitude`, `longitude` FROM `state_seats` WHERE `parliament_id` = ?', $parliament_seat_id);
		foreach ($result as $row)
		{
			$seats[$row->id] = $row;
		}

		return $seats;
	}

	public static function canonical_seat_id($seat_id)
	{
		if (preg_match('/^\s*([PN])\.?\s?([0-9]+)\s*$/i', $seat_id, $matches))
		{
			return strtoupper($matches[1]) . $matches[2];
		}
		else
		{
			return '';
		}
	}

	public static function valid_parliament_seat($parliament_seat_id)
	{
		$db = new Database();

		$result = $db->query('SELECT `id` FROM `parliament_seats` WHERE `id` = ?', $parliament_seat_id);
		return $result->count() == 1;
	}

	public static function valid_state_seat($state_seat_id, $parliament_seat_id)
	{
		// $parliament_seat_id can be an array if called as a validation callback
		if (is_array($parliament_seat_id))
		{
			$parliament_seat_id = $parliament_seat_id[0];
		}

		$db = new Database();

		$result = $db->query('SELECT `id` FROM `state_seats` WHERE `id` = ? AND `parliament_id` = ?', $state_seat_id, $parliament_seat_id);
		return $result->count() == 1;
	}
}
