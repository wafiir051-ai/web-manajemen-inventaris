<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 1. INI ADALAH ALAMAT BARU UNTUK SPATIE V5
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Product extends Model
{
    use LogsActivity;

    protected $fillable = ['category_id', 'sku', 'name', 'stock', 'price', 'image'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['stock', 'price', 'name'])
            ->logOnlyDirty() // Ini sudah otomatis mencegah pembuatan log kosong jika tidak ada data yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Data produk ini telah di-{$eventName}");
    }

    protected static function boot()
    {
        parent::boot();

        // Event 'creating' akan berjalan TEPAT SEBELUM data disimpan ke database
        static::creating(function ($product) {
            // Jika SKU kosong dari form, kita buat otomatis
            if (empty($product->sku)) {
                // Mencari ID terakhir di database untuk membuat nomor urut
                $latestProduct = static::latest('id')->first();
                $nextId = $latestProduct ? $latestProduct->id + 1 : 1;

                // Format: PRD-TahunBulan-NomorUrut (Contoh: PRD-2605-0001)
                $product->sku = 'PRD-' . date('ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
