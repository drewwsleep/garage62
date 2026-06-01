<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    public $timestamps = false;

    protected $fillable = [
        'model_id',
        'year',
        'price',
        'image_url',
        'color',
        'features',
        'services',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function title(): string
    {
        return trim(($this->carModel->brand ?? '') . ' ' . ($this->carModel->model ?? ''));
    }

    public function primaryImageUrl(): string
    {
        $value = trim((string) $this->image_url);
        if ($value === '') {
            return 'images/no-image.jpg';
        }
        if (preg_match('/^https?:\/\//i', $value) === 1) {
            return $value;
        }

        $filename = basename(str_replace('\\', '/', $value));
        return $filename === '' ? 'images/no-image.jpg' : 'images/' . $filename;
    }

    public function imageUrls(): array
    {
        $primaryUrl = $this->primaryImageUrl();
        if (preg_match('/^https?:\/\//i', $primaryUrl) === 1) {
            return [$primaryUrl];
        }

        $result = [];
        $matches = [];
        if (preg_match('/^(.*)_\d+(\.[a-zA-Z0-9]+)$/', $primaryUrl, $matches) === 1) {
            $base = $matches[1];
            $ext = $matches[2];

            for ($i = 1; $i <= 3; $i++) {
                $candidate = $base . '_' . $i . $ext;
                if (is_file(public_path(str_replace('/', DIRECTORY_SEPARATOR, $candidate)))) {
                    $result[] = $candidate;
                }
            }
        }

        return $result === [] ? [$primaryUrl] : array_values(array_unique($result));
    }
}
