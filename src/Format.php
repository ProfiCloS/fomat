<?php
namespace ProfiCloS;

use Exception;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

class Format
{

	public const CURRENCY_CZK = 'CZK';
	public const CURRENCY_EUR = 'EUR';
	public const CURRENCY_USD = 'USD';

	protected const OPTION_DECIMALS = 'd';
	protected const OPTION_SYMBOL = 's';
	protected const OPTION_SYMBOL_SEPARATOR = 'ss';
	protected const OPTION_SYMBOL_AFTER = 'sa';
	public static $currencyOptions = [
		self::CURRENCY_CZK => [
			self::OPTION_DECIMALS => 0,
			self::OPTION_SYMBOL => 'Kč',
			self::OPTION_SYMBOL_SEPARATOR => ' ',
			self::OPTION_SYMBOL_AFTER => true
		],
		self::CURRENCY_EUR => [
			self::OPTION_DECIMALS => 3,
			self::OPTION_SYMBOL => '€',
			self::OPTION_SYMBOL_SEPARATOR => '',
			self::OPTION_SYMBOL_AFTER => false
		],
		self::CURRENCY_USD => [
			self::OPTION_DECIMALS => 2,
			self::OPTION_SYMBOL => '$',
			self::OPTION_SYMBOL_SEPARATOR => '',
			self::OPTION_SYMBOL_AFTER => false
		],
	];

	public static function number($input, $decimals = 2): string
	{
		return number_format($input, $decimals, ',', ' ');
	}

	public static function float($input): float
	{
		$input = str_replace([',', ' '], ['.', ''], $input);
		return (float) $input;
	}

	public static function currency($input, $currency = self::CURRENCY_CZK): string
	{
		$options = self::$currencyOptions[$currency];
		$symbol = $options[self::OPTION_SYMBOL];
		$number = self::number($input, $options[self::OPTION_DECIMALS]);
		$separator = $options[self::OPTION_SYMBOL_SEPARATOR];
		return !$options[self::OPTION_SYMBOL_AFTER] ? $symbol . $separator . $number : $number . $separator . $symbol;
	}

	public static function quantity($number, string $unit, $decimals = 2): string
	{
		return self::number($number, $decimals) . ' ' . self::measureUnit($unit);
	}

	public static function measureUnit(string $unit): string
	{
		return Strings::lower($unit);
	}

	/**
	 * @param $date
	 * @param string $format
	 * @return string
	 * @throws Exception
	 */
	public static function date($date, $format = 'd.m.Y'): string
	{
		if($date === null || $date === '') {
			return '';
		}
		if(!$date instanceof DateTime) {
			$date = new DateTime($date);
		}

		return $date->format($format);
	}

	/**
	 * @param $date
	 * @param string $format
	 * @return string
	 * @throws Exception
	 */
	public static function time($date, $format = 'H:i'): string
	{
		if($date === null || $date === '') {
			return '';
		}
		if(!$date instanceof DateTime) {
			$date = new DateTime($date);
		}

		return $date->format($format);
	}

	/**
	 * @param $dateTime
	 * @param string $format
	 * @return string
	 * @throws Exception
	 */
	public static function dateTime($dateTime, $format = 'd.m.Y H:i'): string
	{
		return self::date($dateTime, $format);
	}

	public static function inflection(int $num, string $one, string $twoFour, string $more): string
	{
		if($num === 1) {
			return $one;
		}
		if($num > 1 && $num < 5) {
			return $twoFour;
		}

		return $more;
	}

	/**
	 * @param array $age
	 * @return string
	 * @throws Exception
	 */
	public static function age(array $age): string
	{
		if($age['years'] > 0) {
			return $age['years'] . ' ' . self::inflection($age['years'], 'rok', 'roky', 'let');
		}

		if($age['months'] > 0) {
			return $age['months'] . ' ' . self::inflection($age['months'], 'měsíc', 'měsíce', 'měsíců');
		}

		return $age['days'] . ' ' . self::inflection($age['days'], 'den', 'dny', 'dní');
	}

	public static function camelCase($string)
	{
		return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
	}

}
