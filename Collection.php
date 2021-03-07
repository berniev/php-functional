<?php
declare(strict_types=1);

namespace pdox\converter\qbeQuery\toSql;

use Exception;

class Collection
{
    private array $array;

    public function __Construct(array $initial)
    {
        $this->array = $initial;
    }

    public function Map(callable $funct): static
    {
        return new static(array_map($funct, $this->array));
    }

    public function Filter(?callable $funct = null): static
    {
        $arr = array_filter($this->array, $funct);
        return new static($arr);
    }

    public function Reduce(mixed $startValue, callable $funct): mixed
    {
        $res = array_reduce($this->array, $funct, $startValue);
        return $res;
    }

    public function Values(): array
    {
        return $this->array;
    }

    public function Walk(callable $funct): static
    {
        array_walk($this->array, $funct);
        return $this;
    }

    public function WalkRecursive(callable $funct): static
    {
        array_walk_recursive($this->array, $funct);
        return $this;
    }

    public function Implode(string $separator, string $left = '', string $right = ''): string
    {

        return count($this->array) ? $left . implode($separator, $this->array) . $right : '';
    }

    public function Count(): int
    {
        return count($this->array);
    }

    public function CountTo(&$to): static
    {
        $to = count($this->array);
        return $this;
    }

    public function IfCount(callable $ifCount, callable $ifAction, ?callable $ifElse = null): static
    {
        if ( $ifCount(count($this->array)) ) {
            $ifAction();
        } elseif ( $ifElse ) {
            {
                $ifElse();
            }
        }
        return $this;
    }

    public function First(): mixed
    {
        $first = array_shift($this->array);
        return $first;
    }

    public function Last(): mixed
    {
        if ( !$this->array ) {
            throw new Exception("Can't get last: Collection is empty");
        }
        return array_pop($this->array);
    }

    public function Distinct(): static
    {
        return new static(array_unique($this->array));
    }

    public function Each(callable $funct)
    {
        return new static(
            array_reduce(
                $this->array,
                fn($carry, $val) => array_merge($carry, $funct($val)),
                []
            )
        );
    }

    public function Concat(Collection $collect): static
    {
        return new static(array_merge($this->array, $collect->Values()));
    }

    public function Flatten(): static
    {
        $flattened = [];
        array_walk_recursive(
            $this->array,
            function($val) use (&$flattened)
            {
                $flattened[] = $val;
            }
        );
        return new static($flattened);
    }

}