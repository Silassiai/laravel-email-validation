<?php

namespace Silassiai\LaravelEmailValidation\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailProviderDomain extends Model
{
    use HasFactory;

    public const ID = 'id';
    public const DOMAIN_NAME = 'domain_name';
    public const TLD = 'tld'; // valid top level domain
    public const POPULAR = 'popular';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const EXCLUDED = 'excluded';

    /** @var string[] $fillable */
    protected $fillable = [
        self::TLD,
        self::DOMAIN_NAME,
        self::POPULAR,
    ];

    /** @var string[] $casts */
    protected $casts = [
        self::TLD => 'array',
    ];

    public function scopePopular($query): Builder
    {
        return $query->where(self::POPULAR, true);
    }

    public function scopeExcluded($query): Builder
    {
        return $query->where(self::POPULAR, false);
    }
}
