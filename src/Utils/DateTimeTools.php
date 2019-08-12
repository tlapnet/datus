<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Throwable;

class DateTimeTools
{

	/**
	 * @param string|int|DateTimeInterface $time
	 */
	public static function ensureFormat($time, string $format = 'd.m.Y H:i:s'): string
	{
		try {
			return self::dateTimeFrom($time)->format($format);
		} catch (Throwable $e) {
			return $time;
		}
	}

	/**
	 * @param string|int|DateTimeInterface $time
	 */
	private static function dateTimeFrom($time): DateTimeImmutable
	{
		if ($time instanceof DateTimeInterface) {
			return new DateTimeImmutable($time->format('Y-m-d H:i:s.u'), $time->getTimezone());
		}

		if (is_int($time)) {
			if ($time <= 31557600) { // less than year
				$time += time();
			}

			return (new DateTimeImmutable('@' . $time))->setTimezone(new DateTimeZone(date_default_timezone_get()));
		}

		// textual
		return new DateTimeImmutable($time);
	}

}
