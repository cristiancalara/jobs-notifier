<?php

namespace App;

use App\Upwork\Rating\Criteria\BudgetCriteria;
use App\Upwork\Rating\Criteria\ClientCountryCriteria;
use App\Upwork\Rating\Criteria\ClientFeedbackCriteria;
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
 * @property string $date_created
 * @property mixed|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property int $user_id
 * @property int|null $status_id
 * @property-read mixed $rating
 * @property-read \App\Status|null $status
 * @property-read \App\User $user
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
        'rating'
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
