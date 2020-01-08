<?php

/**
 * Currency class for work with currency
 */

class Currency {

	public $isoCode = '';

	//EXAMPLE OF ACCEPTABLE CODES TO WORK WITH
	const JAPAN = 'JPY';
	const USA = 'USD';
	const UKRAINE = 'UAH';
	const CANADA = 'CAD';
	const MEXICAN = 'MEX';

	const ACCEPTABLE_CODES = [
		self::JAPAN,
		self::USA,
		self::UKRAINE,
		self::UKRAINE,
		self::CANADA,
		self::MEXICAN,
	];

	public function __construct( $isoName ) {
		$this->setIsoCode( $isoName );
	}

	public function setIsoCode( $isoName ) {
		$acceptable_codes = self::ACCEPTABLE_CODES;

		if ( ! empty( $acceptable_codes ) && in_array( $isoName, $acceptable_codes ) ) {
			$this->isoCode = $isoName;
		} else {
			throw new InvalidArgumentException( 'Invalid Code!' );
		}
	}

	public function getIsoCode() {
		return $this->isoCode;
	}

}

class Money {

	private $amount;
	private $currency;
	public $money;

	public function __construct( $amount = 0, $currency = '' ) {
		if ( $amount > 0 ) {
			$this->setAmount( $amount );
		}
		if ( ! empty( $currency ) ) {
			$this->setCurrency( $currency );
		}
	}

	public function setAmount( $amount ) {
		if ( is_float( $amount ) || is_int( $amount ) ) {
			$this->amount = $amount;
		} else {
			throw new InvalidArgumentException( 'Invalid Amount!' );
		}
	}

	public function setCurrency( $currency ) {
		$currency = preg_replace('/\s+/', '', $currency);
		$this->currency = $currency;
	}

	public function getMoney() {
			$this->money = $this->amount . ' ' . $this->currency;
		if ( $this->validateMoney( $this->money ) ) {
			return $this->money;
		}
	}

	//Validate money
	public function validateMoney( $money ) {
		if ( is_string( $money ) ) {
			$money_array = explode(" ", $money);
			if ( is_numeric( $money_array[0] ) && is_string($money_array[1])  ) {
				return true;
			} else {
				throw new InvalidArgumentException('Money Validation Failed!');
			}
		} else {
			throw new InvalidArgumentException('Money Validation Failed!');
		}
	}

	public function equals ( $val1, $val2 ) {
		if ( $this->validateMoney($val1) && $this->validateMoney($val2) ) {
			$money_array1 = explode(" ", $val1);
			$money_array2 = explode(" ", $val2);

			if ( $money_array1[1] !== $money_array2[1] ) {
				return false;
			}

			if ( $money_array1[0] > $money_array2[0] ) {
				return $val1 . ' is bigger than ' . $val2;
			} elseif ( $money_array1[0] < $money_array2[0] ) {
				return $val2 . ' is bigger than ' . $val1;
			} else {
				return $val2 . ' and ' . $val1 . ' are equal';
			}
		}
	}

	public function add( $val1, $val2 ) {
		if ( $this->validateMoney($val1) && $this->validateMoney($val2) ) {
			$result = '';
			$money_array1 = explode(" ", $val1);
			$money_array2 = explode(" ", $val2);

			if ( $money_array1[1] !== $money_array2[1] ) {
				throw new InvalidArgumentException('Currency Failed');
			} else {
				$result = $money_array1[0] + $money_array2[0];
			}
			return $result . ' ' .  $money_array1[1];
		}
	}

}

$currency = new Currency( 'USD' );

$get_code = $currency->getIsoCode();

$money1 = new Money( 15.6, $get_code );
$money2 = new Money( 11, $get_code );

$equals = new Money();

echo $get_code;
echo '<br>';
echo $money1->getMoney();
echo '<br>';
echo $money2->getMoney();
echo '<br>';
echo $equals->equals( $money1->getMoney(), $money2->getMoney() );
echo '<br>';
echo $equals->add( $money1->getMoney(), $money2->getMoney() );
