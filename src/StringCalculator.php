<?php

namespace App;

use Exception;

class StringCalculator {

  /**
   * The maximum number allowed.
   */
  const MAX_NUMBER_ALLOWED = 1000;

  /**
   * The delimiter for the numbers.
   *
   * @var string
   */
  protected $delimiter = ",|\n";

  /**
   * Add the provided set of numbers.
   *
   * @param string $numbers
   * @return float|int
   *
   * @throws Exception
   */
  public function add(string $numbers) {

    $numbers = $this->parseString($numbers);

    $this->disallowNegatives($numbers);


    return array_sum(
      $this->ignoreGreaterThan1000($numbers)
    );
  }

  /**
   * Parse the numbers string.
   *
   * @param string $numbers
   * @return array|false|string[]
   */
  protected function parseString(string $numbers) {
    $custom_delimiter = "\/\/(.)\n";

    if (preg_match("/{$custom_delimiter}/", $numbers, $matches)) {
      $this->delimiter = $matches[1];

      $numbers = str_replace($matches[0], '', $numbers);
    }

    return preg_split("/{$this->delimiter}/", $numbers);
  }

  /**
   * Do not allow negative numbers.
   *
   * @param array $numbers
   * @throws Exception
   */
  protected function disallowNegatives(array $numbers): void {
    foreach ($numbers as $number) {

      if ($number < 0) {
        throw new Exception('Negative numbers not allowed.');
      }

    }

  }

  /**
   * Forget any number that is greater than 1,000.
   *
   * @param array $numbers
   * @return array
   */
  protected function ignoreGreaterThan1000(array $numbers): array {
    return array_filter($numbers, function ($number) {
      return $number <= self::MAX_NUMBER_ALLOWED;
    });
  }


}