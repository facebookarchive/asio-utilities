ASIO Utilities
==============

Obsolete In HHVM 3.11+
----------------------

These functions have been merged into HHVM, and we expected them to be included from 3.11.0 onwards.

Installation
------------

- add `hhvm/asio-utilities` to your composer.json

ResultOrExceptionWrapper
------------------------

When awaiting multiple handles, it can be useful to isolate exceptions from
each; ResultOrExceptionWrapper provides this:

```Hack
// HH\Asio\wrap(T): Awaitable<ResultOrExceptionWrapper<T>>
$w = await wrap(some_async_function_that_may_throw());
if ($w->isSucceeded()) {
  $result = $w->getResult();
  ...
} else {
  $exception = $w->getException();
  ...
}
```

Mapping and Filtering Functions
-------------------------------

HHVM 3.6 and above include HH\Asio\v() and HH\Asio\m() to make it easy to wait
on multiple wait handles; it's fairly common to want to combine this with
another option, such as mapping or filtering with an async function.

These functions are named according to their attributes:

First, how they take and return arguments according to types:
 * v - Vector
 * m - Map

Then, either one or two letters to indicate the operation:
 * f - filter
 * fk - filter with key
 * m - map
 * mk - map with keys

Finally, there is optionally a trailing 'w' to indicate that you want
a result or exception wrapper. For 'fw' functions, the behavior is that:

 * if the filter function returns true, the wrapped element is returned
 * if the filter function returns false, the element is omitted
 * if the filter function throws an exception, the wrapped exception is returned

This is also available without a filter or mapping operation - vw() and mw().

Function List
-------------

All functions are in the HH\Asio namespace;
`v()` and `m()` are built in to HHVM 3.6 and newer.

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Returns</th>
      <th>Mapped</th>
      <th>Filtered</th>
      <th>with key</th>
      <th>Wrapped</th>
      <th>Callback</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>v()</td>
      <td>Vector&lt;T&gt;</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
    </tr>
    <tr>
      <td>vm()</td>
      <td>Vector&lt;Tr&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td><code>(Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>vmk()</td>
      <td>Vector&lt;Tr&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td><code>(Tk, Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>vf()</td>
      <td>Vector&lt;Tv&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td><code>(Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>vfk()</td>
      <td>Vector&lt;Tv&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td><code>(Tk, Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>vw()</td>
      <td>Vector&lt;ResultOrExceptionWrapper&lt;T&gt;&gt;</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
    </tr>
    <tr>
      <td>vmw()</td>
      <td>Vector&lt;ResultOrExceptionWrapper&lt;Tr&gt;&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>vmkw()</td>
      <td>Vector&lt;ResultOrExceptionWrapper&lt;Tr&gt;&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tk, Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>vfw()</td>
      <td>Vector&lt;ResultOrExceptionWrapper&lt;Tv&gt;&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>vfkw()</td>
      <td>Vector&lt;ResultOrExceptionWrapper&lt;Tv&gt;&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tk, Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>m()</td>
      <td>Map&lt;Tk, Tv&gt;</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
    </tr>
    <tr>
      <td>mm()</td>
      <td>Map&lt;Tk, Tr&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td><code>(Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>mmk()</td>
      <td>Map&lt;Tk, Tr&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td><code>(Tk, Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>mf()</td>
      <td>Map&lt;Tk, Tv&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td><code>(Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>mfk()</td>
      <td>Map&lt;Tk, Tv&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td><code>(Tk, Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>mw()</td>
      <td>Map&lt;Tk, ResultOrExceptionWrapper&lt;T&gt;&gt;</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
    </tr>
    <tr>
      <td>mmw()</td>
      <td>Map&lt;Tk, ResultOrExceptionWrapper&lt;Tr&gt;&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>mmkw()</td>
      <td>Map&lt;Tk, ResultOrExceptionWrapper&lt;Tr&gt;&gt;</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tk, Tv): Awaitable&lt;Tr&gt;</code></tr>
    </tr>
    <tr>
      <td>mfw()</td>
      <td>Map&lt;Tk, ResultOrExceptionWrapper&lt;Tv&gt;&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
    <tr>
      <td>mfkw()</td>
      <td>Map&lt;Tk, ResultOrExceptionWrapper&lt;Tv&gt;&gt;</td>
      <td>:x:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td>:white_check_mark:</td>
      <td><code>(Tk, Tv): Awaitable&lt;bool&gt;</code></tr>
    </tr>
  </tbody>
</table>
