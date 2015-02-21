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
 * Translate an awaitable into itself.
 */
async function id<Tv>(Awaitable<Tv> $awaitable): Awaitable<Tv> {
  return await $awaitable;
}

/**
 * Same as id(), but wrap result into ResultOrExceptionWrapper.
 */
async function wrap<Tv>(
  Awaitable<Tv> $awaitable,
): Awaitable<ResultOrExceptionWrapper<Tv>> {
  try {
    $result = await $awaitable;
    return new WrappedResult($result);
  } catch (\Exception $e) {
    return new WrappedException($e);
  }
}

/**
 * Await on a known value
 */
async function val<T>(T $v): Awaitable<T> {
  return $v;
}

} // namespace HH\Asio
