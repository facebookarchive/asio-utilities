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
 * Same as v(), but wrap results into ResultOrExceptionWrappers.
 */
async function vw<Tv>(
  Traversable<Awaitable<Tv>> $awaitables,
): Awaitable<Vector<ResultOrExceptionWrapper<Tv>>> {
  $wait_handles = Vector {};
  $wait_handles->reserve(count($awaitables));
  foreach ($awaitables as $awaitable) {
    $wait_handles[] = wrap($awaitable)->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromVector($wait_handles);
  // TODO: When systemlib supports closures
  // return $wait_handles->map($o ==> $o->result());
  $ret = Vector {};
  foreach($wait_handles as $value) {
    $ret[] = $value->result();
  }
  return $ret;
}

/**
 * Yield the vector of values created by
 * mapping each element of $keys through $gen and awaiting the results.
 */
async function vc<Tk, Tv>(
  (function (Tk): Awaitable<Tv>) $gen,
  Traversable<Tk> $keys,
): Awaitable<Vector<Tv>> {
  $wait_handles = Vector {};
  $wait_handles->reserve(count($keys));
  foreach ($keys as $key) {
    $wait_handles[] = $gen($key)->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromVector($wait_handles);
  // TODO: When systemlib supports closures
 // return $wait_handles->map($o ==> $o->result());
  $ret = Vector {};
  foreach($wait_handles as $value) {
    $ret[] = $value->result();
  }
  return $ret;
}

/**
 * Same as vc(), but wrap results into ResultOrExceptionWrappers.
 */
async function vcw<Tk, Tv>(
  (function (Tk): Awaitable<Tv>) $gen,
  Traversable<Tk> $keys,
): Awaitable<Vector<ResultOrExceptionWrapper<Tv>>> {
  $wait_handles = Vector {};
  $wait_handles->reserve(count($keys));
  foreach ($keys as $key) {
    $wait_handles[] = wrap($gen($key))->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromVector($wait_handles);
  // TODO: When systemlib supports closures
  // return $wait_handles->map($o ==> $o->result());
  $ret = Vector {};
  foreach($wait_handles as $value) {
    $ret[] = $value->result();
  }
  return $ret;
}

/**
 * Vector version of mf()
 */
async function vf<T>(
  \ConstVector<T> $inputs,
  (function (T): Awaitable<bool>) $callable,
): Awaitable<Vector<T>> {
  $gens = $inputs->map($callable);
  $tests = await v($gens);
  $results = Vector {};
  foreach ($inputs as $key => $value) {
    if ($tests[$key]) {
      $results[] = $value;
    }
  }
  return $results;
}

/**
 * Similar to vf(), but passes element keys as well
 */
async function vfk<T>(
  \ConstVector<T> $inputs,
  (function (int, T): Awaitable<bool>) $callable,
): Awaitable<Vector<T>> {
  $gens = $inputs->mapWithKey($callable);
  $tests = await v($gens);
  $results = Vector {};
  foreach ($inputs as $key => $value) {
    if ($tests[$key]) {
      $results[] = $value;
    }
  }
  return $results;
}

/**
 * Similar to Vector::map, but maps the values using awaitables
 */
async function vm<Tv, Tr>(
  \ConstVector<Tv> $inputs,
  (function (Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<Tr>> {
  return await v($inputs->map($callable));
}

/**
 * Similar to vm(), but passes element keys as well
 */
async function vmk<Tv, Tr>(
  \ConstVector<Tv> $inputs,
  (function (int, Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<Tr>> {
  return await v($inputs->mapWithKey($callable));
}

} // namespace HH\Asio
