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
 * Wait until some later time in the future.
 */
async function later(): Awaitable<void> {
  // reschedule to the lowest priority
  return await RescheduleWaitHandle::create(
    RescheduleWaitHandle::QUEUE_DEFAULT,
    0,
  );
}

/**
 * Convenience wrapper for SleepWaitHandle
 */
async function usleep(
  int $usecs,
): Awaitable<void> {
  return await SleepWaitHandle::create($usecs);
}

} // namespace HH\Asio
