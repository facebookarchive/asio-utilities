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
 * Represents a result of operation that may have failed.
 */
interface ResultOrExceptionWrapper<T> {
  /**
   * Return true iff the operation succeeded.
   */
  public function isSucceeded(): bool;

  /**
   * Return true iff the operation failed.
   */
  public function isFailed(): bool;

  /**
   * Return the result of the operation, or throw underlying exception.
   *
   * - if the operation succeeded: return its result
   * - if the operation failed: throw the exception incating failure
   */
  public function getResult(): T;

  /**
   * Return the underlying exception, or fail with invariant violation.
   *
   * - if the operation succeeded: fails with invariant violation
   * - if the operation failed: returns the exception indicating failure
   */
  public function getException(): \Exception;
}

} // namespace HH\Asio
