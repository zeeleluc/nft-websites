<?php

namespace App\Model;

class NFT
{
    public int $id;
    public ?int $nft_id;
    public ?string $background;
    public ?string $back_props;
    public ?string $body;
    public ?string $plebs_heads;
    public ?string $clothes;
    public ?string $eyes;
    public ?string $hair;
    public ?string $hands;
    public ?string $mouth;
    public ?string $special;
    public ?string $accessories;
    public ?string $hats;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->nft_id = $data['nft_id'] ?? null;
        $this->background = $data['background'] ?? null;
        $this->back_props = $data['back_props'] ?? null;
        $this->body = $data['body'] ?? null;
        $this->plebs_heads = $data['plebs_heads'] ?? null;
        $this->clothes = $data['clothes'] ?? null;
        $this->eyes = $data['eyes'] ?? null;
        $this->hair = $data['hair'] ?? null;
        $this->hands = $data['hands'] ?? null;
        $this->mouth = $data['mouth'] ?? null;
        $this->special = $data['special'] ?? null;
        $this->accessories = $data['accessories'] ?? null;
        $this->hats = $data['hats'] ?? null;
    }

    public function getAttributes(): array
    {
        $attributes = [];
        foreach (get_object_vars($this) as $column => $value) {
            if ($column !== 'id' && $column !== 'nft_id' && $value !== null) {
                $attributes[revert_snake_case($column)] = revert_snake_case($value);
            }
        }

        return $attributes;
    }

    public function getName(): string
    {
        return 'Weeping Pleb #' . $this->nft_id;
    }

    public function getImage(): string
    {
        return env('CDN_ENDPOINT_IMAGES') . $this->nft_id . '.png';
    }
}
