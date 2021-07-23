<?php

namespace Chivo912\Encryptable;

trait EncryptableTrait
{
  /**
   * If the attribute is in the encryptable array
   * then decrypt it.
   *
   * @param  $key
   *
   * @return $value
   */
  public function getAttribute($key)
  {
    $value = parent::getAttribute($key);
    try {
      if (in_array($key, $this->encryptable)) {
        $value = decrypt($value);
      }
    } catch (\Exception $e) {
      return $value;
    }
    return $value;
  }

  /**
   * If the attribute is in the encryptable array
   * then encrypt it.
   *
   * @param $key
   * @param $value
   */
  public function setAttribute($key, $value)
  {
    if (in_array($key, $this->encryptable)) {
      $value = encrypt($value);
    }
    return parent::setAttribute($key, $value);
  }

  /**
   * When need to make sure that we iterate through
   * all the keys.
   *
   * @return array
   */
  public function attributesToArray()
  {
    $attributes = parent::attributesToArray();
    foreach ($this->encryptable as $key) {
      if (isset($attributes[$key])) {
        $attributes[$key] = decrypt($attributes[$key]);
      }
    }

    return $attributes;
  }
}
