<?php
namespace App\Service;

use App\Model\NFT;

class Filter
{
    public static function parse(string $query): array
    {
        $filters = [];

        $chunks = explode(';', $query);
        foreach ($chunks as $chunk) {
            $partialChunks = explode('=', $chunk);
            $filters[$partialChunks[0]] = $partialChunks[1];
        }

        return $filters;
    }

    public static function build(array $filters): string
    {
        $string = '';

        foreach ($filters as $trait => $property) {
            $string .= $trait . '=' . $property . ';';
        }

        return rtrim($string, ';');
    }

    public static function validate(array $filters): bool
    {
        $reflector = new \ReflectionClass(NFT::class);
        $validProperties = array_diff(
            array_map(fn($prop) => $prop->getName(), $reflector->getProperties()),
            ['id', 'nft_id']
        );

        foreach (array_keys($filters) as $key) {
            if (!in_array($key, $validProperties, true)) {
                return false;
            }
        }

        return true;
    }

    public static function queryHasFilter(string $query, string $trait): bool
    {
        return array_key_exists($trait, self::parse($query));
    }

    public static function queryRemoveTrait(string $query, string $trait): string
    {
        if (!self::queryHasFilter($query, $trait)) {
            return $query;
        }

        $filters = self::parse($query);
        unset($filters[$trait]);

        return self::build($filters);
    }
}
