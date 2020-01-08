<?php

/**
 * Currency class for work with currency
 */

class Currency {

	protected $isoCode = '';

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

	protected $amount;
	protected $currency;
	protected $money;

	public function __construct( $amount = 0, $currency = '' ) {
		if ( $amount > 0 ) {
			$this->setAmount( $amount );
		}
		if ( ! empty( $currency ) ) {
			$this->setCurrency( $currency );
		}

		$this->setMoney();
	}

	public function setAmount( $amount ) {
		if ( is_float( $amount ) || is_int( $amount ) ) {
			$this->amount = $amount;
		} else {
			throw new InvalidArgumentException( 'Invalid Amount!' );
		}
	}

	public function setCurrency( $currency ) {
		$currency       = preg_replace( '/\s+/', '', $currency );
		$this->currency = $currency;
	}

	private function setMoney() {
		if ( ! empty( $this->amount ) && ! empty( $this->currency ) ) {
			$this->money = $this->amount . ' ' . $this->currency;
		} else {
			throw new InvalidArgumentException( 'Set Money Validation Failed!' );
		}
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
			$money_array = explode( " ", $money );
			if ( is_numeric( $money_array[0] ) && is_string( $money_array[1] ) ) {
				return true;
			} else {
				throw new InvalidArgumentException( 'Money Validation Failed!' );
			}
		} else {
			throw new InvalidArgumentException( 'Money Validation Failed!' );
		}
	}

	public function equals( $val1, $val2 ) {
		if ( $this->validateMoney( $val1 ) && $this->validateMoney( $val2 ) ) {
			$money_array1 = explode( " ", $val1 );
			$money_array2 = explode( " ", $val2 );

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

	public function add( $val ) {
		if ( $this->validateMoney( $val ) ) {
			$past_val   = explode( " ", $this->money );
			$val_to_add = explode( " ", $val );

			if ( $past_val[1] !== $val_to_add[1] ) {
				return false;
			}

			$current_amount = $past_val[0];
			$val_to_add = $val_to_add[0];

			$this->amount = $current_amount + $val_to_add;
			$this->setMoney();
		}
	}

}

$currency = new Currency( 'USD' );

$get_code = $currency->getIsoCode();

$money1 = new Money( 15.6, $get_code );
$money2 = new Money( 11, $get_code );

$money = new Money( 10, $get_code );

echo $get_code;
echo '<br>';
echo $money1->getMoney();
echo '<br>';
echo $money2->getMoney();
echo '<br>';
echo $money->equals( $money1->getMoney(), $money2->getMoney() );
echo '<br>';
echo $money->add( $money1->getMoney() );
echo $money->getMoney();
echo '<br>';
echo $money->add( $money2->getMoney() );
echo $money->getMoney();
