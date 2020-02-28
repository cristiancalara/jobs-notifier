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

class ArchivedJob extends Model
{
    protected $table = 'archived_jobs';
}
