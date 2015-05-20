<?hh // strict
/* Copyright (c) 2015, Facebook, Inc.
 * All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 */

/**
 * This file contains Asio functionality not currently part of a released
 * version of HHVM. However, the code herein is already in the release pipeline.
 * It will be removed here once part of the release.
 */

namespace HH\Asio {

/**
 * Wait for a given Awaitable to finish and return its result.
 *
 * Launches a new instance of scheduler to drive asynchronous execution
 * until the provided Awaitable is finished.
 */
function join<T>(Awaitable<T> $awaitable): T {
  invariant(
    $awaitable instanceof WaitHandle,
    'unsupported user-land Awaitable',
  );
  return $awaitable->join();
}

/**
 * Get result of an already finished Awaitable.
 *
 * Throws an InvalidOperationException if the Awaitable is not finished.
 */
function result<T>(Awaitable<T> $awaitable): T {
  invariant(
    $awaitable instanceof WaitHandle,
    'unsupported user-land Awaitable',
  );
  return $awaitable->result();
}

/**
 * Check whether the given Awaitable has finished.
 */
function has_finished<T>(Awaitable<T> $awaitable): bool {
  invariant(
    $awaitable instanceof WaitHandle,
    'unsupported user-land Awaitable',
  );
  return $awaitable->isFinished();
}

}
