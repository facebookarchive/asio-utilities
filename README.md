ASIO Utilities
==============

ResultOrExceptionWrapper
------------------------

When awaiting multiple handles, it can be useful to isolate exceptions from each;
ResultOrExceptionWrapper provides this:

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
 * call() - Call a function which returns an awaitable, and return that
 * val() - A static value, yielded from an Awaitable immediately

Convenience
-----------

 * later() - Empty Awaitable which will schedule at lower priority
 * usleep() - Empty Awaitable which will yield in $usecs microseconds

Mapping Functions
-----------------

HHVM 3.6 and above include HH\Asio\v() and HH\Asio\m() to make it easy to wait
on multiple wait handles; it's fairly common to want to combine this with
another option, such as mapping or filtering with an async function.

These functions are named according to a matric of their attributes:

First, how they take and return arguments according to types:
 * v - Vector
 * m - Map

// TODO: Copy more from README, explain difference between c and m, why no 'w'
for f/m/ ?
