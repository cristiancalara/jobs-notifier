<?php

namespace App;

use App\Upwork\Rating\Criteria\BudgetCriteria;
use App\Upwork\Rating\Criteria\ClientCountryCriteria;
use App\Upwork\Rating\Criteria\ClientFeedbackCriteria;
use App\Upwork\Rating\Criteria\ClientMaxHourlyRateCriteria;
use App\Upwork\Rating\Criteria\ContractorTierCriteria;
use App\Upwork\Rating\Criteria\DateCreatedCriteria;
use App\Upwork\Rating\Criteria\SubcategoryCriteria;
use App\Upwork\Rating\Criteria\TitleCriteria;
use App\Upwork\Rating\Rating;
use App\Upwork\Rating\Criteria\JobTypeCriteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Job
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $status_id
 * @property string $api_id
 * @property string $title
 * @property string $category2
 * @property string|null $subcategory2
 * @property string $job_type
 * @property mixed|null $client
 * @property int|null $budget
 * @property string $duration
 * @property string $workload
 * @property string $job_status
 * @property mixed $skills
 * @property string|null $snippet
 * @property string $url
 * @property \Illuminate\Support\Carbon $date_created
 * @property array|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection|null $assignments
 * @property-read \Illuminate\Support\Collection|null $hourly_assignments
 * @property-read \Illuminate\Support\Collection|null $fixed_assignments
 * @property-read float|null $avg_hourly_rate
 * @property-read int|null $hours_paid
 * @property-read float|null $max_hourly_rate
 * @property-read mixed $rating
 * @property-read \App\Status|null $status
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereApiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereCategory2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereDateCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereJobStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereSnippet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereSubcategory2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereWorkload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Job whereUserId($value)
 */
class Job extends Model
{
    protected $dates = [
        'date_created',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'client' => 'array',
        'skills' => 'array',
        'extra'  => 'array'
    ];

    protected $with = ['user', 'status'];

    protected $appends = [
        'rating',
        'assignments',
        'hourly_assignments',
        'fixed_assignments',
        'avg_hourly_rate',
        'hours_paid',
        'max_hourly_rate'
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function getSnippetAttribute($value)
    {
        return nl2br($value);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAssignmentsAttribute()
    {
        $assignments = $this->extra['assignments']['assignment'] ?? null;
        if ( ! $assignments) {
            return collect([]);
        }

        return collect($assignments);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFixedAssignmentsAttribute()
    {
        return $this->assignments->filter(function ($assignment) {
            return $assignment['as_job_type'] === 'Fixed';
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getHourlyAssignmentsAttribute()
    {
        return $this->assignments->filter(function ($assignment) {
            return $assignment['as_job_type'] === 'Hourly';
        });
    }

    /**
     * @return float|null
     */
    public function getAvgHourlyRateAttribute()
    {
        // No hourly assignments.
        if ( ! $this->hourly_assignments->count()) {
            return null;
        }

        $sum = $this->hourly_assignments->reduce(function ($sum, $assignment) {
            // as_rate = '$10.00'
            $rate = (float)substr($assignment['as_rate'], 1);

            return $sum + $rate;
        });

        $avg = $sum / $this->hourly_assignments->count();

        return round($avg, 2);
    }

    /**
     * @return float|null
     */
    public function getMaxHourlyRateAttribute()
    {
        // No hourly assignments.
        if ( ! $this->hourly_assignments->count()) {
            return null;
        }

        return $this->hourly_assignments->max(function ($assignment) {
            // as_rate = '$10.00'
            return (float)substr($assignment['as_rate'], 1);
        });
    }

    /**
     * @return int
     */
    public function getHoursPaidAttribute()
    {
        // No hourly assignments.
        if ( ! $this->hourly_assignments->count()) {
            return 0;
        }

        return $this->hourly_assignments->reduce(function ($sum, $assignment) {
            return $sum + (int)$assignment['as_total_hours'];
        });
    }

    /**
     * @return float|int
     */
    public function getRatingAttribute()
    {
        return (new Rating([
            new TitleCriteria,
            new JobTypeCriteria,
            new ContractorTierCriteria,
            new ClientFeedbackCriteria,
            new ClientCountryCriteria,
            new ClientMaxHourlyRateCriteria,
            new BudgetCriteria,
            new DateCreatedCriteria,
            new SubcategoryCriteria
        ]))->for($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @param $j
     *
     * @return Job
     */
    public static function fromAPI($j)
    {
        $job = new self();

        $job->api_id       = $j->id;
        $job->title        = $j->title;
        $job->category2    = $j->category2;
        $job->subcategory2 = $j->subcategory2;
        $job->job_type     = $j->job_type;
        $job->client       = (array)$j->client;
        $job->budget       = $j->budget;
        $job->duration     = $j->duration;
        $job->workload     = $j->workload;
        $job->job_status   = $j->job_status;
        $job->skills       = (array)$j->skills;
        $job->snippet      = $j->snippet;
        $job->url          = $j->url;
        $job->date_created = new Carbon($j->date_created);
        $job->extra        = $j->extra;

        return $job;
    }
}
