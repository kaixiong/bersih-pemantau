<?php

class elections_Core {
	public static function parliament_seats() {
		$db = new Database();
		$result = $db->query('SELECT * FROM `parliament_seats`');
		foreach ($result as $row) {
			$seats[$row->id] = $row;
		}
		return $seats;
	}

	public static function state_seats($parliament_seat_id) {
		$db = new Database();
		$result = $db->query('SELECT `id`, `name`, `latitude`, `longitude` FROM `state_seats` WHERE `parliament_id` = ?', $parliament_seat_id);
		foreach ($result as $row) {
			$seats[$row->id] = $row;
		}
		return $seats;
	}
}
