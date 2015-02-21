<?hh // strict
/* Copyright (c) 2015, Facebook, Inc.
 * All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 */

namespace HH\Asio {

///// Mapped /////

/**
 * Similar to Vector::map, but maps the values using awaitables
 */
async function vm<Tv, Tr>(
  Traversable<Tv> $inputs,
  (function (Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<Tr>> {
  $awaitables = Vector { };
  foreach ($inputs as $input) {
    $awaitables[] = $callable($input);
  }
  return await v($awaitables);
}

/**
 * Similar to vm(), but passes element keys as well
 */
async function vmk<Tk, Tv, Tr>(
  KeyedTraversable<Tk, Tv> $inputs,
  (function (Tk, Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<Tr>> {
  $awaitables = Vector { };
  foreach ($inputs as $k => $v) {
    $awaitables[] = $callable($k, $v);
  }
  return await v($awaitables);
}

///// Filtered /////

/**
 * Apply an async filtering function, and return a Vector of outputs.
 */
async function vf<Tk, T>(
  KeyedTraversable<Tk, T> $inputs,
  (function (T): Awaitable<bool>) $callable,
): Awaitable<Vector<T>> {
  $tests = await mm($inputs, $callable);
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
async function vfk<Tk, T>(
  KeyedTraversable<Tk, T> $inputs,
  (function (Tk, T): Awaitable<bool>) $callable,
): Awaitable<Vector<T>> {
  $tests = await mmk($inputs, $callable);
  $results = Vector {};
  foreach ($inputs as $key => $value) {
    if ($tests[$key]) {
      $results[] = $value;
    }
  }
  return $results;
}

////////////////////
////// Wrapped /////
////////////////////

/**
 * Same as v(), but wrap results into ResultOrExceptionWrappers.
 */
async function vw<Tv>(
  Traversable<Awaitable<Tv>> $awaitables,
): Awaitable<Vector<ResultOrExceptionWrapper<Tv>>> {
  return await vm(
    $awaitables,
    async $x ==> await wrap($x),
  );
}

///// Mapped /////

/**
 * Like vm(), except using a ResultOrExceptionWrapper.
 */
async function vmw<Tv, Tr>(
  Traversable<Tv> $inputs,
  (function (Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<ResultOrExceptionWrapper<Tr>>> {
  return await vm(
    $inputs,
    async $x ==> await wrap($callable($x)),
  );
}

/**
 * Like vmk(), except using a ResultOrExceptionWrapper.
 */
async function vmkw<Tk, Tv, Tr>(
  KeyedTraversable<Tk, Tv> $inputs,
  (function (Tk, Tv): Awaitable<Tr>) $callable,
): Awaitable<Vector<ResultOrExceptionWrapper<Tr>>> {
  return await vmk(
    $inputs,
    async ($k, $v) ==> await wrap($callable($k, $v)),
  );
}

///// Filtered /////

/**
 * Like vf(), except using a ResultOrExceptionWrapper.
 */
async function vfw<Tk,T>(
  KeyedTraversable<Tk, T> $inputs,
  (function (T): Awaitable<bool>) $callable,
): Awaitable<Vector<ResultOrExceptionWrapper<T>>> {
  $tests = await mm($inputs, async $x ==> await wrap($callable($x)));
  $results = Vector {};
  foreach ($inputs as $key => $value) {
    $test = $tests[$key];
    if ($test->isFailed()) {
      $results[] = new WrappedException($test->getException());
    } else if ($test->getResult() === true) {
      $results[] = new WrappedResult($value);
    }
  }
  return $results;
}

/**
 * Like vfk(), except using a ResultOrExceptionWrapper.
 */
async function vfkw<Tk, T>(
  KeyedTraversable<Tk, T> $inputs,
  (function (Tk, T): Awaitable<bool>) $callable,
): Awaitable<Vector<ResultOrExceptionWrapper<T>>> {
  $tests = await mmk(
    $inputs,
    async ($k, $v) ==> await wrap($callable($k, $v)),
  );
  $results = Vector {};
  foreach ($inputs as $key => $value) {
    $test = $tests[$key];
    if ($test->isFailed()) {
      $results[] = new WrappedException($test->getException());
    } else if ($test->getResult() === true) {
      $results[] = new WrappedResult($value);
    }
  }
  return $results;
}

} // namespace HH\Asio
