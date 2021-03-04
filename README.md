# php-functional
Handle arrays in a functional-programming-like way.

By using a simple class like this suddenly code becomes:
* Simpler 
* Easier to read
* Easier to debug
* Easier to test
* Variables are mostly eliminated
* Problems are broken into manageable small steps

On the down side it is likely a bit slower, but in many/most situations this will not be a concern.

Example:
````
array $arr;

$funct = fn($item) => $item > 10;

$result =

  (new Collection($arr))
  
  ->Map( fn($item) => $item->GetValue() )
  
  ->Filter( $funct )
  
  ->Implode(', ');
  ````
  Every function that generates an array returns it in a new Collection. This facilitates chaining. To get the actual array values use Values().
  
  Functions that generate scalar values return them directly.
  
  The concept is dead simple, but the result is spectacular.
  
  Add more functions to the class to taste.
  
