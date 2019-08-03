<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Admin;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Posts;
use App\Models\VolunteeringActivity;
use App\Models\VolunteerSignUpActivity;
use App\Traits\UserRoleTrait;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardResponse implements Responsable
{
    use UserRoleTrait;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $data = [];
            #set default data
            $data['latest_members_count'] = 0;
            $data['volunteer_opportunities'] = 0;
            $data['volunteers'] = 0;
            $data['volunteering_hours'] = 0;
            $data['updated_at'] = now()->format('d/m/Y');
            $data['activities_count'] = ['active' => 0, 'all' => 0, 'success' => 0];
            $data['news_count'] = ['active' => 0, 'all' => 0, 'success' => 0];
            $data['volunteering_hours'] = 0;
            $data['latest_volunteers_count'] = 0;
            $data['latest_organizes_count'] = 0;
            #set default data
            $user = $request->user('api');
            #organize
            if ($user->isUser('organize')) {
                $selectMonths = $request->get('selectMonths');
                $fromMonths = $request->get('fromMonths');
                $fromYears = $request->get('fromYears');
                $toMonths = $request->get('toMonths');
                $toYears = $request->get('toYears');
                $format = 'Y-m-d';
                $minYear = 2015;
                $btwDate = [];
                switch ($selectMonths) {
                    case 'this1Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->format($format);
                            $btwDate[1] = $btwDate[1]->format($format);
                            break;
                        }
                    case 'past1Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonth()->format($format);
                            $btwDate[1] = $btwDate[1]->subMonth()->format($format);
                            break;
                        }
                    case 'past3Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonths(3)->format($format);
                            $btwDate[1] = $btwDate[1]->subMonths(3)->format($format);
                            break;
                        }
                    case 'past6Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonths(6)->format($format);
                            $btwDate[1] = $btwDate[1]->subMonth(6)->format($format);
                            break;
                        }
                    default:
                        {
                            if ($fromYears < $minYear) {
                                break;
                            }
                            if (!($fromYears <= $toYears)) {
                                break;
                            }
                            if ($fromYears === $toYears && !($fromMonths <= $toMonths)) {
                                break;
                            }
                            try {
                                $dateFormMonth = \DateTime::createFromFormat('!m', $fromMonths + 1)->format('F');
                                $dateToMonth = \DateTime::createFromFormat('!m', $toMonths + 1)->format('F');
                                $btwDate[] = new Carbon("first day of $dateFormMonth $fromYears");
                                $btwDate[] = new Carbon("last day of $dateToMonth $toYears");
                                $btwDate[0] = $btwDate[0]->format($format);
                                $btwDate[1] = $btwDate[1]->format($format);
                            } catch (\Exception $ex) {
                                Log::info("toFormatDateString: {$ex->getMessage()}");
                            }
                            break;
                        }
                }
                #volunteers
                $all_volunteers = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                    ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                    ->join('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                    ->where('volunteering_activities.user_id', $user->id)
                    ->groupBy('users.id');
                if (count($btwDate) > 1) {
                    $all_volunteers = $all_volunteers->whereBetween('volunteer_sign_up_activities.created_at', $btwDate)->get();
                } else {
                    $all_volunteers = $all_volunteers->get();
                }
                #volunteering
                $all_volunteer_opportunities = VolunteeringActivity::where('user_id', auth()->user()->id);
                if (count($btwDate) > 1) {
                    $all_volunteer_opportunities = $all_volunteer_opportunities->whereBetween('created_at', $btwDate)->get();
                } else {
                    $all_volunteer_opportunities = $all_volunteer_opportunities->get();
                }
                $data['volunteer_opportunities'] = count($all_volunteer_opportunities);
                $data['volunteers'] = count($all_volunteers);
                $data['updated_at'] = now()->format('d/m/Y');
            }
            #organize

            #volunteer statuses
            if ($user->isUser('volunteer')) {
                $selectMonths = $request->get('selectMonths');
                $fromMonths = $request->get('fromMonths');
                $fromYears = $request->get('fromYears');
                $toMonths = $request->get('toMonths');
                $toYears = $request->get('toYears');
                $format = 'Y-m-d';
                $minYear = 2015;
                $btwDate = [];
                switch ($selectMonths) {
                    case 'this1Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->format($format);
                            $btwDate[1] = $btwDate[1]->format($format);
                            break;
                        }
                    case 'past1Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonth()->format($format);
                            $btwDate[1] = $btwDate[1]->subMonth()->format($format);
                            break;
                        }
                    case 'past3Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonths(3)->format($format);
                            $btwDate[1] = $btwDate[1]->subMonths(3)->format($format);
                            break;
                        }
                    case 'past6Month':
                        {
                            $btwDate = Helpers::getFirstLastDayOfCurrentMonth();
                            $btwDate[0] = $btwDate[0]->subMonths(6)->format($format);
                            $btwDate[1] = $btwDate[1]->subMonth(6)->format($format);
                            break;
                        }
                    default:
                        {
                            if ($fromYears < $minYear) {
                                break;
                            }
                            if (!($fromYears <= $toYears)) {
                                break;
                            }
                            if ($fromYears === $toYears && !($fromMonths <= $toMonths)) {
                                break;
                            }
                            try {
                                $dateFormMonth = \DateTime::createFromFormat('!m', $fromMonths + 1)->format('F');
                                $dateToMonth = \DateTime::createFromFormat('!m', $toMonths + 1)->format('F');
                                $btwDate[] = new Carbon("first day of $dateFormMonth $fromYears");
                                $btwDate[] = new Carbon("last day of $dateToMonth $toYears");
                                $btwDate[0] = $btwDate[0]->format($format);
                                $btwDate[1] = $btwDate[1]->format($format);
                            } catch (\Exception $ex) {
                                Log::info("toFormatDateString: {$ex->getMessage()}");
                            }
                            break;
                        }
                }
                #volunteering
                $sign_up_statuses = DB::table('volunteer_sign_up_activities')
                    ->selectRaw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN 1 ELSE 0 END) AS `CHECKIN_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'confirm' THEN 1 ELSE 0 END) AS `CONFIRM_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.leader = 'yes' THEN 1 ELSE 0 END) AS `LEADER_COUNT`, 
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN  volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `HOURS_COUNT`")
                    ->where('user_id', $user->id);
                if (count($btwDate) > 1) {
                    $sign_up_statuses = $sign_up_statuses->whereBetween('volunteer_sign_up_activities.created_at', $btwDate)->first();
                } else {
                    $sign_up_statuses = $sign_up_statuses->first();
                }
                $data['volunteer_opportunities'] = $sign_up_statuses->CHECKIN_COUNT ?? 0;
                $data['volunteering_hours'] = $sign_up_statuses->HOURS_COUNT ?? 0;
                $data['updated_at'] = now()->format('d/m/Y');
            }
            #volunteer statuses
            #admin section
            if ($user->isUser('admin') || $user->isUser('super_admin')) {
                $data['latest_members_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->whereIn('user_types.type_user_id', User::getNonAdminUserIds())->count();
                $data['news_count'] = $this->getPostsCount('news');
                $data['activities_count'] = $this->getVolunteeringCount();
                $data['volunteering_hours'] = $this->getVolunteeringHours();
                $data['latest_volunteers_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('volunteer'))->count();
                $data['latest_organizes_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('organize'))->count();
                #for other pages
                $data['volunteer_opportunities'] = 0;
                $data['volunteers'] = 0;
                $data['updated_at'] = now()->format('d/m/Y');
                #for other pages
            }
            return response()->json(['data' => $data]);
        }
    }

    public function getPostsCount($type): array
    {
        $data = [];
        $data['active'] = Posts::where('type', $type)->where('status', 'open')->count();
        $data['all'] = Posts::where('type', $type)->count();
        return $data;
    }

    private function getVolunteeringCount()
    {
        $volunteering_activities = DB::table('volunteering_activities')
            ->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->selectRaw("SUM(CASE WHEN volunteering_activities.status = 'live' THEN 1 ELSE 0 END) AS `LIVE_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'closed' THEN 1 ELSE 0 END) AS `CLOSED_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'draft' THEN 1 ELSE 0 END) AS `DRAFT_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'cancelled' THEN 1 ELSE 0 END) AS `CANCELLED_COUNT`")
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('users.status', 'approved')
            ->first();

        $success_volunteering_activities = DB::table('volunteering_activities')
            ->selectRaw('COUNT(DISTINCT volunteering_activities.id) AS `SUCCESS_COUNT`')
            ->join('volunteer_sign_up_activities', 'volunteer_sign_up_activities.volunteering_activity_id', '=', 'volunteering_activities.id')
            ->where('volunteering_activities.status', 'closed')
            ->whereIn('volunteer_sign_up_activities.status', ['confirm', 'checkin'])
            ->first();

        $data = [];
        $data['active'] = $volunteering_activities->LIVE_COUNT;
        $data['all'] = DB::table('volunteering_activities')->get()->count();
        $data['success'] = $success_volunteering_activities->SUCCESS_COUNT;
        return $data;
    }

    public function getVolunteeringHours()
    {
        return DB::table('volunteer_sign_up_activities')->get()->sum('hour_per_volunteer');
    }
}
