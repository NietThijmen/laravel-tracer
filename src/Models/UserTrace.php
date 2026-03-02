<?php

namespace Nietthijmen\LaravelTracer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $referer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *                                   {@inheritDoc Model}
 */
class UserTrace extends Model
{
    use HasTimestamps, MassPrunable;

    protected $fillable = [
        'qualified_route',
        'user_id',
        'ip_address',
        'user_agent',
        'referer',
    ];

    /**
     * @return Builder<static>
     */
    public function prunable(): Builder
    {
        $threshold = now()->subDays(config('tracer.prune_after_days', 30));

        return static::query()
            ->where('created_at', '<=', $threshold);
    }
}
