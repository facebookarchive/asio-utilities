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
 * A linked list node storing AsyncCondition and pointer to the next node.
 */
final class AsyncConditionNode<T> extends AsyncCondition<T> {
  private ?AsyncConditionNode<T> $next = null;

  public function addNext(): AsyncConditionNode<T> {
    invariant($this->next === null, 'The next node already exists');
    return $this->next = new AsyncConditionNode();
  }

  public function getNext(): ?AsyncConditionNode<T> {
    return $this->next;
  }
}

} // namespace HH\Asio
