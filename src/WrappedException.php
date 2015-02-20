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
 * Represents a result of failed operation.
 */
final class WrappedException<Te as \Exception,Tr>
  implements ResultOrExceptionWrapper<Tr> {
  public function __construct(private Te $exception) {}

  public function isSucceeded(): bool {
    return false;
  }

  public function isFailed(): bool {
    return true;
  }

  public function getResult(): Tr {
    throw $this->exception;
  }

  public function getException(): Te {
    return $this->exception;
  }
}

} // namespace HH\Asio
