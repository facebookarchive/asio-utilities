<?hh // strict
/* Copyright (c) 2015, Facebook, Inc.
 * All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 */

namespace HH\Asio {

/**
 * Represents a result of succeeded operation.
 */
final class WrappedResult<T> implements ResultOrExceptionWrapper<T> {
  public function __construct(private T $result) {}

  public function isSucceeded(): bool {
    return true;
  }

  public function isFailed(): bool {
    return false;
  }

  public function getResult(): T {
    return $this->result;
  }

  public function getException(): \Exception {
    invariant_violation('Unable to get exception from WrappedResult');
  }
}

} // namespace HH\Asio
