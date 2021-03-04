<?php
declare(strict_types=1);

class Collection
{
    private array $array;

    public function __Construct(array $initial)
    {
        $this->array = $initial;
    }

    public function Map(callable $funct): Collection
    {
        return new static(array_map($funct, $this->array));
    }

    public function Filter(?callable $funct = null): Collection
    {
        $arr = array_filter($this->array, $funct);
        return new static($arr);
    }

    public function Reduce(mixed $startValue, callable $funct): mixed
    {
        $res= array_reduce($this->array, $funct, $startValue);
        return is_array($res) ? new Collection($res) : $res;
    }

    public function Values(): array
    {
        return $this->array;
    }

    public function Walk(callable $funct): Collection
    {
        array_walk($this->array, $funct);
        return $this;
    }

    public function WalkRecursive(callable $funct): Collection
    {
        array_walk_recursive($this->array, $funct);
        return $this;
    }

    public function Implode(string $separator): string
    {
        return implode($separator, $this->array);
    }
}