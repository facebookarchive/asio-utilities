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
 * Same as m(), but wrap results into ResultOrExceptionWrappers.
 */
async function mw<Tk, Tv>(
  KeyedTraversable<Tk, Awaitable<Tv>> $awaitables,
): Awaitable<Map<Tk, ResultOrExceptionWrapper<Tv>>> {
  $wait_handles = Map {};
  foreach ($awaitables as $index => $awaitable) {
    $wait_handles[$index] = wrap($awaitable)->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromMap($wait_handles);
  // TODO: When systemlib supports closures
  // return $wait_handles->map($o ==> $o->result());
  $ret = Map {};
  foreach($wait_handles as $key => $value) {
    $ret[$key] = $value->result();
  }
  return $ret;
}

/**
 * Yield a map of values indexed by key for a given vector of keys.
 */
async function mc<Tk, Tv>(
  (function (Tk): Awaitable<Tv>) $gen,
  Traversable<Tk> $keys,
): Awaitable<Map<Tk, Tv>> {
  $gens = Map {};
  foreach ($keys as $key) {
    $gens[$key] = $gen($key)->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromMap($gens);
  // TODO: When systemlib supports closures
  // return $gens->map($o ==> $o->result());
  $ret = Map {};
  foreach($gens as $key => $value) {
    $ret[$key] = $value->result();
  }
  return $ret;
}


/**
 * Same as mc(), but wrap results into ResultOrExceptionWrappers.
 */
async function mcw<Tk, Tv>(
  (function (Tk): Awaitable<Tv>) $gen,
  Traversable<Tk> $keys,
): Awaitable<Map<Tk, ResultOrExceptionWrapper<Tv>>> {
  $gens = Map {};
  foreach ($keys as $key) {
    $gens[$key] = wrap($gen($key))->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromMap($gens);
  // TODO: When systemlib supports closures
  // return $gens->map($o ==> $o->result());
  $ret = Map {};
  foreach($gens as $key => $value) {
    $ret[$key] = $value->result();
  }
  return $ret;
}

/**
 * Filter a Map with an Awaitable callback
 */
async function mf<Tk, Tv>(
  \ConstMap<Tk, Tv> $inputs,
  (function (Tv): Awaitable<bool>) $callable,
): Awaitable<Map<Tk, Tv>> {
  $gens = $inputs->map($callable);
  $tests = await m($gens);
  $results = Map {};
  foreach ($inputs as $key => $value) {
    if ($tests[$key]) {
      // array_filter preserves keys, so we do the same.
      $results[$key] = $value;
    }
  }
  return $results;
}

/**
 * Similar to mfk(), but passes element keys as well
 */
async function mfk<Tk, Tv>(
  \ConstMap<Tk, Tv> $inputs,
  (function (Tk, Tv): Awaitable<bool>) $callable,
): Awaitable<Map<Tk, Tv>> {
  $gens = $inputs->mapWithKey($callable);
  $tests = await m($gens);
  $results = Map {};
  foreach ($inputs as $key => $value) {
    if ($tests[$key]) {
      // array_filter preserves keys, so we do the same.
      $results[$key] = $value;
    }
  }
  return $results;
}

/**
 * Similar to Map::map, but maps the values using awaitables
 */
async function mm<Tk, Tv, Tr>(
  \ConstMap<Tk, Tv> $inputs,
  (function (Tv): Awaitable<Tr>) $callable,
): Awaitable<Map<Tk, Tr>> {
  return await m($inputs->map($callable));
}

/**
 * Similar to mm(), but passes element keys as well
 */
async function mmk<Tk, Tv, Tr>(
  \ConstMap<Tk, Tv> $inputs,
  (function (Tk, Tv): Awaitable<Tr>) $callable,
): Awaitable<Map<Tk, Tr>> {
  return await m($inputs->mapWithKey($callable));
}

} // namespace HH\Asio
