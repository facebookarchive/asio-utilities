<?php
/* Copyright (c) 2015, Facebook, Inc.
 * All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 */

// Composer does not support autoloading functions: composer/composer#3683
require_once(__DIR__.'/ResultOrExceptionWrapper.php');
require_once(__DIR__.'/WrappedException.php');
require_once(__DIR__.'/src/WrappedResult.php');
require_once(__DIR__.'/src/convenience.php');
require_once(__DIR__.'/src/maps.php');
require_once(__DIR__.'/src/vectors.php');
