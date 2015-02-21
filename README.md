ASIO Utilities
==============

Installation
------------

- add hhvm/asio-utilities to your composer.json
- require vendor/hhvm/asio-utilities/init.php (autoload is not supported due to
  composer/composer#3683)

ResultOrExceptionWrapper
------------------------

When awaiting multiple handles, it can be useful to isolate exceptions from
each; ResultOrExceptionWrapper provides this:

```Hack
$w = wrap(some_async_function_that_may_throw());
if ($w->isSucceeded()) {
  $result = $w->getResult();
  ...
} else {
  $exception = $w->getException();
  ...
}
```

Identities
----------

 * id() - Take an Awaitable and return it unmodified
 * wrap() - Await an Awaitable and wrap it in a ResultOrExceptionWrapper
 * val() - A static value, yielded from an Awaitable immediately

Convenience
-----------

 * later() - Empty Awaitable which will schedule at lower priority
 * usleep() - Empty Awaitable which will yield in $usecs microseconds

Mapping and Filtering Functions
-------------------------------

HHVM 3.6 and above include HH\Asio\v() and HH\Asio\m() to make it easy to wait
on multiple wait handles; it's fairly common to want to combine this with
another option, such as mapping or filtering with an async function.

These functions are named according to a matric of their attributes:

First, how they take and return arguments according to types:
 * v - Vector
 * m - Map

Then, either one or two letters to indicate the operation:
 * f - filter
 * m - map
 * mk - map with keys

Wrapped Functions
-----------------

Finally, there is optionally a trailing 'w' to indicate that you want
a result or exception wrapper. For 'fw' functions, the behavior is that:

 * if the filter function returns true, the wrapped element is returned
 * if the filter function returns false, the element is omitted
 * if the filter function throws an exception, the wrapped exception is returned

This is also available without a filter or mapping operation - vw() and mw().

Function List
-------------

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Input</th>
      <th>Output</th>
      <th>Callback</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>v()</td>
      <td>Wait for all</td>
      <td>Traversable&lt;T&gt;</td>
      <td>Vector&lt;T&gt;</td>
    </tr>
    <tr>
      <td>vm()</td>
      <td>Map with async function</td>
      <td>Traversable&lt;Tv&gt;</td>
      <td>Vector&lt;Tr&gt;</td>
      <td>function(Tv): Awaitable&lt;Tr&gt;</tr>
    </tr>
  </tbody>
</table>
