<?php
/**
 * Class EmployerController.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Profession;
use App\Role;
use App\Repositories\ProfessionRepository;
use Illuminate\Http\Request;
use App\Helper;
use App\Department;
use App\Location;
use App\Profile;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\User;
use Session;
use App\Language;
use App\Category;
use App\Skill;
use App\Job;
use App\Team;
use App\Proposal;
use DB;
use App\Package;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Invoice;
use App\Item;
use Carbon\Carbon;
use App\Message;
use App\SiteManagement;
use App\Service;
use App\Review;
use App\Payout;

/**
 * Class EmployerController
 */
class EmployerController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $employer
     */
    protected $employer;
    protected $user;
    protected $team;
    protected $professionRepository;

    /**
     * Create a new controller instance.
     *
     * @param instance $employer instance
     *
     * @return void
     */
    public function __construct(Profile $employer, User $user, Team $team, ProfessionRepository $professionRepository)
    {
        $this->employer = $employer;
        $this->user = $user;
        $this->team = $team;
        $this->professionRepository = $professionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = $this->employer::where('user_id', Auth::user()->id)
            ->get()->first();
        $employees = Helper::getEmployeesList();
        $departments = Department::all();
        $locations = Location::pluck('title', 'id');
        $gender = !empty($profile->gender) ? $profile->gender : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $address = !empty($profile->address) ? $profile->address : '';
        $longitude = !empty($profile->longitude) ? $profile->longitude : '';
        $latitude = !empty($profile->latitude) ? $profile->latitude : '';
        $emp_contact = !empty($profile->user->emp_contact) ? $profile->user->emp_contact : '';
        $emp_telno = !empty($profile->user->emp_telno) ? $profile->user->emp_telno : '';
        $emp_website = !empty($profile->user->emp_website) ? $profile->user->emp_website : '';
        $emp_cqc_rating = !empty($profile->user->emp_cqc_rating) ? $profile->user->emp_cqc_rating : '';
        $emp_cqc_rating_date = !empty($profile->user->emp_cqc_rating_date) ? $profile->user->emp_cqc_rating_date : '';
        $no_of_employees = !empty($profile->no_of_employees) ? $profile->no_of_employees : '';
        $department_id = !empty($profile->department_id) ? $profile->department_id : '';
        $org_type = !empty($profile->org_type) ? $profile->org_type : '';
        $hourly_rate = !empty($profile->hourly_rate) ? $profile->hourly_rate : '';
        $hourly_rate_negotiable = !empty($profile->hourly_rate_negotiable) ? $profile->hourly_rate_negotiable : '';
        $hourly_rate_desc = !empty($profile->hourly_rate_desc) ? $profile->hourly_rate_desc : '';
        $payout_id = !empty($profile->payout_id) ? $profile->payout_id : '';
        $packages = DB::table('items')->where('subscriber', Auth::user()->id)->count();
        $package_options = Package::select('options')->where('role_id', Auth::user()->id)->first();
        $options = !empty($package_options) ? unserialize($package_options['options']) : array();
        $register_form = SiteManagement::getMetaValue('reg_form_settings');
        $show_emplyr_inn_sec = !empty($register_form) && !empty($register_form[0]['show_emplyr_inn_sec']) ? $register_form[0]['show_emplyr_inn_sec'] : 'true';
        if (file_exists(resource_path('views/extend/back-end/employer/profile-settings/personal-detail/index.blade.php'))) {
            return view(
                'extend.back-end.employer.profile-settings.personal-detail.index',
                compact(
                    'payout_id',
                    'employees',
                    'departments',
                    'locations',
                    'gender',
                    'tagline',
                    'description',
                    'banner',
                    'avater',
                    'address',
                    'longitude',
                    'latitude',
                    'no_of_employees',
                    'department_id',
                    'options',
                    'packages',
                    'show_emplyr_inn_sec',
                    'emp_contact',
                    'emp_telno',
                    'emp_website',
                    'emp_cqc_rating',
                    'emp_cqc_rating_date',
                    'org_type',
                    'hourly_rate_negotiable',
                    'hourly_rate',
                    'hourly_rate_desc',
                    'profile'

                )
            );
        } else {
            return view(
                'back-end.employer.profile-settings.personal-detail.index',
                compact(
                    'payout_id',
                    'employees',
                    'departments',
                    'locations',
                    'gender',
                    'tagline',
                    'description',
                    'banner',
                    'avater',
                    'address',
                    'longitude',
                    'latitude',
                    'no_of_employees',
                    'department_id',
                    'options',
                    'packages',
                    'show_emplyr_inn_sec',
                    'emp_contact',
                    'emp_telno',
                    'emp_website',
                    'emp_cqc_rating',
                    'emp_cqc_rating_date',
                    'org_type',
                    'hourly_rate_negotiable',
                    'hourly_rate',
                    'hourly_rate_desc',
                    'profile'
                )
            );
        }
    }


    /**
     * Upload Image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        $path = Helper::PublicPath() . '/uploads/users/temp/';
        if (!empty($request['hidden_avater_image'])) {
            $profile_image = $request['hidden_avater_image'];
            $image_size = array(
                'small' => array(
                    'width' => 36,
                    'height' => 36,
                ),
                'medium-small' => array(
                    'width' => 60,
                    'height' => 60,
                ),
                'medium' => array(
                    'width' => 100,
                    'height' => 100,
                ),
            );
            // return Helper::uploadTempImage($path, $profile_image);
            return Helper::uploadTempImageWithSize($path, $profile_image, '', $image_size);
        } elseif (!empty($request['hidden_banner_image'])) {
            $image_size = array(
                'small' => array(
                    'width' => 350,
                    'height' => 172,
                ),
                'medium' => array(
                    'width' => 1140,
                    'height' => 400,
                ),
            );
            $profile_image = $request['hidden_banner_image'];
            return Helper::uploadTempImageWithSize($path, $profile_image, '', $image_size);
        }
    }

    /**
     * Store profile settings.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProfileSettings(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        $this->validate(
            $request,
            [
                'first_name'    => 'required',
                'last_name'    => 'required',
                'org_name'      => 'required'
            ]
        );
        if (!empty($request)) {
            $user_id = Auth::user()->id;
            $this->employer->storeProfile($request, $user_id);
            $this->user->storeEmployerFields($request, $user_id);
            $json['type'] = 'success';
            $json['process'] = trans('lang.saving_profile');
            return $json;
        }
    }

    /**
     * Show Employer Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function employerDashboard()
    {
        if (Auth::user()) {
            $ongoing_jobs = array();
            $employer_id = Auth::user()->id;
            $package_item = Item::where('subscriber', $employer_id)->first();
            $package = !empty($package_item) ? Package::find($package_item->product_id) : array();
            $option = !empty($package) && !empty($package['options']) ? unserialize($package['options']) : '';
            $expiry = !empty($option) && !empty($package_item) ? $package_item->updated_at->addDays($option['duration']) : '';
            $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
            $message_status = Message::where('status', 0)->where('receiver_id', $employer_id)->count();
            $notify_class = $message_status > 0 ? 'wt-insightnoticon' : '';
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            $enable_package = !empty($currency) && !empty($currency[0]['employer_package']) ? $currency[0]['employer_package'] : 'true';
            $icons  = SiteManagement::getMetaValue('icons');
            $latest_proposals_icon = !empty($icons['hidden_latest_proposal']) ? $icons['hidden_latest_proposal'] : 'img-20.png';
            $latest_package_expiry_icon = !empty($icons['hidden_package_expiry']) ? $icons['hidden_package_expiry'] : 'img-21.png';
            $latest_new_message_icon = !empty($icons['hidden_new_message']) ? $icons['hidden_new_message'] : 'img-19.png';
            $latest_saved_item_icon = !empty($icons['hidden_saved_item']) ? $icons['hidden_saved_item'] : 'img-22.png';
            $latest_cancel_job_icon = !empty($icons['hidden_cancel_job']) ? $icons['hidden_cancel_job'] : 'img-16.png';
            $latest_ongoing_job_icon = !empty($icons['hidden_ongoing_job']) ? $icons['hidden_ongoing_job'] : 'img-17.png';
            $latest_completed_job_icon = !empty($icons['hidden_completed_job']) ? $icons['hidden_completed_job'] : 'img-18.png';
            $latest_posted_job_icon = !empty($icons['hidden_posted_job']) ? $icons['hidden_posted_job'] : 'img-15.png';
            $ongoing_jobs = Auth::user()->jobs->where('status', 'hired')->take(8);
            $cancelled_services_icon = !empty($icons['hidden_cancelled_services']) ? $icons['hidden_cancelled_services'] : 'decline.png';
            $completed_services_icon = !empty($icons['hidden_completed_services']) ? $icons['hidden_completed_services'] : 'completed-task.png';
            $ongoing_services_icon = !empty($icons['hidden_ongoing_services']) ? $icons['hidden_ongoing_services'] : 'onservice.png';
            $access_type = Helper::getAccessType();
            $professions = $this->professionRepository->getProfessionsByRole();
            $latest_proposal = Proposal::getLastWeekProposalsByJobList($employer_id);
            if (file_exists(resource_path('views/extend/back-end/employer/dashboard.blade.php'))) {
                return view(
                    'extend.back-end.employer.dashboard',
                    compact(
                        'access_type',
                        'ongoing_jobs',
                        'expiry_date',
                        'notify_class',
                        'symbol',
                        'latest_proposals_icon',
                        'latest_package_expiry_icon',
                        'latest_new_message_icon',
                        'latest_saved_item_icon',
                        'latest_cancel_job_icon',
                        'latest_ongoing_job_icon',
                        'latest_completed_job_icon',
                        'latest_posted_job_icon',
                        'cancelled_services_icon',
                        'completed_services_icon',
                        'ongoing_services_icon',
                        'enable_package',
                        'package',
                        'message_status',
                        'latest_proposal',
                        'professions'
                    )
                );
            } else {
                return view(
                    'back-end.employer.dashboard',
                    compact(
                        'access_type',
                        'ongoing_jobs',
                        'expiry_date',
                        'notify_class',
                        'symbol',
                        'latest_proposals_icon',
                        'latest_package_expiry_icon',
                        'latest_new_message_icon',
                        'latest_saved_item_icon',
                        'latest_cancel_job_icon',
                        'latest_ongoing_job_icon',
                        'latest_completed_job_icon',
                        'latest_posted_job_icon',
                        'cancelled_services_icon',
                        'completed_services_icon',
                        'ongoing_services_icon',
                        'enable_package',
                        'package',
                        'message_status',
                        'latest_proposal',
                        'professions'
                    )
                );
            }
        }
    }

    /**
     * Show Employer Jobs.
     *
     * @param string $status job status
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmployerJobs($status)
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        if (Auth::user()) {
            $ongoing_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'hired')->paginate(7);
            $completed_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'completed')->paginate(7);
            $cancelled_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'cancelled')->paginate(7);
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            if (!empty($status) && $status === 'hired') {
                if (file_exists(resource_path('views/extend/back-end/employer/jobs/ongoing.blade.php'))) {
                    return view(
                        'extend.back-end.employer.jobs.ongoing',
                        compact(
                            'ongoing_jobs',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.jobs.ongoing',
                        compact(
                            'ongoing_jobs',
                            'symbol'
                        )
                    );
                }
            } elseif (!empty($status) && $status === 'completed') {
                if (file_exists(resource_path('views/extend/back-end/employer/jobs/completed.blade.php'))) {
                    return view(
                        'extend.back-end.employer.jobs.completed',
                        compact(
                            'completed_jobs',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.jobs.completed',
                        compact(
                            'completed_jobs',
                            'symbol'
                        )
                    );
                }
            }
        }
    }

    /**
     * Show Employer Jobs.
     *
     * @param string $status job status
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmployerServices($status)
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        if (Auth::user()) {
            $employer = User::find($employer_id);
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            if (!empty($status) && $status === 'hired') {
                $services = $employer->purchasedServices;
                if (file_exists(resource_path('views/extend/back-end/employer/services/ongoing.blade.php'))) {
                    return view(
                        'extend.back-end.employer.services.ongoing',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.services.ongoing',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                }
            } elseif (!empty($status) && $status === 'completed') {
                $services = $employer->completedServices;
                if (file_exists(resource_path('views/extend/back-end/employer/services/completed.blade.php'))) {
                    return view(
                        'extend.back-end.employer.services.completed',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.services.completed',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                }
            } elseif (!empty($status) && $status === 'cancelled') {
                $services = $employer->cancelledServices;
                if (file_exists(resource_path('views/extend/back-end/employer/services/cancelled.blade.php'))) {
                    return view(
                        'extend.back-end.employer.services.cancelled',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.services.cancelled',
                        compact(
                            'services',
                            'symbol'
                        )
                    );
                }
            }
        }
    }

    /**
     * Service Detail.
     *
     * @param int    $id     id
     * @param string $status status
     *
     * @return \Illuminate\Http\Response
     */
    public function showServiceDetail($service_id, $pivot_id, $status)
    {
        if (Auth::user()) {
            $pivot_service = Helper::getPivotService($pivot_id);
            $service = Service::find($service_id);
            $seller = Helper::getServiceSeller($service->id);
            $freelancer = !empty($seller) ? User::find($seller->user_id) : '';
            $service_status = Helper::getProjectStatus();
            $review_options = DB::table('review_options')->get()->all();
            // $avg_rating = Review::where('receiver_id', $freelancer->id)->sum('avg_rating');
            $freelancer_rating  = !empty($freelancer) && !empty($freelancer->profile->ratings) ? Helper::getUnserializeData($freelancer->profile->ratings) : 0;
            $rating = !empty($freelancer_rating) ? $freelancer_rating[0] : 0;
            $stars  =  !empty($freelancer_rating) ? $freelancer_rating[0] / 5 * 100 : 0;
            $reviews = !empty($freelancer) ? Review::where('receiver_id', $freelancer->id)->where('job_id', $service_id)->where('project_type', 'service')->get() : '';
            $feedbacks = !empty($freelancer) ? Review::select('feedback')->where('receiver_id', $freelancer->id)->count() : '';
            $cancel_proposal_text = trans('lang.cancel_proposal_text');
            $cancel_proposal_button = trans('lang.send_request');
            $validation_error_text = trans('lang.field_required');
            $cancel_popup_title = trans('lang.reason');
            $attachment = Helper::getUnserializeData($service->attachments);
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            if (file_exists(resource_path('views/extend/back-end/employer/services/show.blade.php'))) {
                return view(
                    'extend.back-end.employer.services.show',
                    compact(
                        'pivot_service',
                        'service',
                        'freelancer',
                        'service_status',
                        'attachment',
                        'review_options',
                        'stars',
                        'rating',
                        'feedbacks',
                        'cancel_proposal_text',
                        'cancel_proposal_button',
                        'validation_error_text',
                        'cancel_popup_title',
                        'service_id',
                        'pivot_id',
                        'symbol'
                    )
                );
            } else {
                return view(
                    'back-end.employer.services.show',
                    compact(
                        'pivot_service',
                        'service',
                        'freelancer',
                        'service_status',
                        'attachment',
                        'review_options',
                        'stars',
                        'rating',
                        'feedbacks',
                        'cancel_proposal_text',
                        'cancel_proposal_button',
                        'validation_error_text',
                        'cancel_popup_title',
                        'service_id',
                        'pivot_id',
                        'symbol'
                    )
                );
            }
        } else {
            abort(404);
        }
    }

    /**
     * Employer Payment Process.
     *
     * @param string $id proposal ID
     *
     * @return \Illuminate\Http\Response
     */
    public function employerPaymentProcess($id)
    {
        if (Auth::user() && !empty($id)) {
            if (Auth::user()) {
                $user_id = Auth::user()->id;
                $employer = User::find($user_id);
                $proposal = Proposal::where('id', $id)->get()->first();
                $job = $proposal->job;
                $freelancer = User::find($proposal->freelancer_id);
                $freelancer_name = Helper::getUserName($proposal->freelancer_id);
                $profile = User::find($proposal->freelancer_id)->profile;
                $attachments = !empty($proposal->attachments) ? unserialize($proposal->attachments) : '';
                $user_image = !empty($profile) ? $profile->avater : '';
                $profile_image = !empty($user_image) ? '/uploads/users/' . $proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
                $payout_settings = SiteManagement::getMetaValue('commision');
                $payment_gateway = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
                $currency   = SiteManagement::getMetaValue('commision');
                $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
                if (file_exists(resource_path('views/extend/back-end/employer/jobs/checkout.blade.php'))) {
                    return view(
                        'extend.back-end.employer.jobs.checkout',
                        compact(
                            'job',
                            'freelancer_name',
                            'profile_image',
                            'proposal',
                            'payment_gateway',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.jobs.checkout',
                        compact(
                            'job',
                            'freelancer_name',
                            'profile_image',
                            'proposal',
                            'payment_gateway',
                            'symbol'
                        )
                    );
                }
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get employer payouts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayouts()
    {
        $payouts =  Payout::where('user_id', Auth::user()->id)->paginate(10);
        if (file_exists(resource_path('views/extend/back-end/employer/payouts.blade.php'))) {
            return view(
                'extend.back-end.employer.payouts.payouts',
                compact('payouts')
            );
        } else {
            return view(
                'back-end.employer.payouts.payouts',
                compact('payouts')
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payoutSettings()
    {
        if (Auth::user()) {
            $payrols = Helper::getPayoutsList();
            $user = User::find(Auth::user()->id);
            $payout_settings = $user->profile->count() > 0 ? Helper::getUnserializeData($user->profile->payout_settings) : ''; 
            if (file_exists(resource_path('views/extend/back-end/employer/payouts/payout_settings.blade.php'))) {
                return view(
                    'extend.back-end.employer.payouts.payout_settings', compact('payrols', 'payout_settings')
                );
            } else {
                return view(
                    'back-end.employer.payouts.payout_settings', compact('payrols', 'payout_settings')
                );
            }
        } else {
            abort(404);
        }
    }

    public function getCalendarEvents()
    {
        if(Auth::user())
        {
            switch (Auth::user()->getRoleNames()->first())
            {
                case "freelancer":
                    $arrEvents = DB::table('calendar_events')
                        ->where('user_id','=',Auth::user()->id)
                        ->select('calendar_events.recurring_date AS repeat','calendar_events.*')
                        ->get()->all();
                    break;
                case "employer":
                    $arrEvents = DB::table('calendar_events')
                        ->where('class', '=', 'booking_calendar')
                        ->orWhere(function ($query) {
                            $query->whereRaw('class = "available_class" OR class = "busy_class"')
                                ->where('user_id', '=',  Auth::user()->id);
                        })
                        ->select('calendar_events.recurring_date AS repeat','calendar_events.*')
                        ->get()->all();
                    //$arrEvents['jobs'] = DB::table('jobs')
                    //    ->where('user_id', '=',  Auth::user()->id)
                    //    ->get()->keyBy('id')->toArray();

                    break;

            }

        }
        else{
            $arrEvents = DB::table('calendar_events')
                ->where('class', '=', 'booking_calendar')
                ->select('calendar_events.recurring_date AS repeat','calendar_events.*')
                ->get()->all();
        }

        if(count($arrEvents))
        {
            return $arrEvents;
        }
        else{
            return array();
        }
    }

    public function getJobs()
    {
        //$jobs = auth()->user()->calendars->toArray();
        $jobs = CalendarEvent::join('jobs', 'calendar_events.job_id', '=', 'jobs.id')
                    ->where('jobs.user_id', Auth::user()->id)
                    ->select('jobs.*', 'calendar_events.*', 'calendar_events.id as id')
                    ->get();

        return response($jobs);
    }

    public function getProfessions()
    {
        $professions = Profession::whereIn('role_id', [
            Role::FREELANCER_ROLE,
            Role::SUPPORT_ROLE,
        ])->get()->toArray();

        return response($professions);
    }

    public function availability()
    {
        return view('back-end.employer.profile-settings.availability');

    }

    public function updateCalendarEvent(Request $request)
    {
        if (Auth::user() && $request['event_id']) {
            $this->validate(
                $request,
                [
                    'title' => 'required',
                    'booking_content'    => 'required',
                    'start_date'    => 'required',
                    'booking_start'    => 'required',
                    'booking_end'    => 'required',
                ]
            );
            $arrNewEvent = CalendarEvent::find($request['event_id']);
            $arrNewEvent->user_id = Auth::user()->id;
            $arrNewEvent->title = $request['title'];
            $arrNewEvent->content = ($request['booking_content'])?$request['booking_content']:'';
            $arrNewEvent->contentFull = ($request['booking_content'])?$request['booking_content']:'';
            $arrNewEvent->recurring_date = ($request['recurring_date'])?$request['recurring_date']:null;
            $arrNewEvent->recurring_end_date = ($request['recurring_end_date'])?date('Y-m-d', strtotime($request['recurring_end_date'])):null;
            $arrNewEvent->class = 'booking_calendar';
            $arrNewEvent->skill_id = ($request['profession_id']) ? $request['profession_id'] : null;
            $arrNewEvent->job_id = ($request['job_id'])?$request['job_id']:null;
            $booking_start = ($request['booking_start']) ? $request['booking_start'] : '23:59';
            $booking_end = ($request['booking_end']) ? $request['booking_end'] : '00:00';
            array_filter($request['start_date']);
            array_filter($request['end_date']);
            $arrNewEvent->start = date('Y-m-d H:i:s', strtotime($request['start_date'][0] . ' ' . $booking_start));
            $arrNewEvent->end = date('Y-m-d H:i:s', strtotime($request['end_date'][0] . ' ' . $booking_end));
            $arrNewEvent->save();


            //$arrNewEvent['start'] = $request['start_date'] . ' ' . $request['booking_start'];
            //$arrNewEvent['end'] = (($request['end_date']) ? $request['end_date'] : $request['start_date']) . ' ' . $request['booking_end'];
            //dd($request,count($request['start_date']));
            //for($d=0;$d<count($request['start_date']);$d++) {
            //    if ($request['start_date']) {
            //        if ($request['recurring_date']) {
            //            $reqStart = $request['start_date'][$d];
            //            $reqEnd = ($request['end_date'][$d]) ? $request['end_date'][$d] : $request['start_date'][$d];
            //            $recurringEndDay = Carbon::parse($request['recurring_end_date']);
            //            $carbStart = new Carbon($reqStart);
            //            $carbEnd = Carbon::parse($reqEnd);
            //            if ($request['recurring_date'] == 'day') {
            //                $difference = ($carbStart->diff($recurringEndDay)->days < 1) ? 'today' : $carbStart->diffInDays($recurringEndDay);
            //                echo $difference;
            //                for ($g = 0; $g <= $difference; $g++) {
            //                    $arrNewEvent['start'] = Carbon::parse($reqStart)->addDay($g)->format('Y-m-d') . ' ' . $booking_start;
            //                    $arrNewEvent['end'] = Carbon::parse($reqEnd)->addDay($g)->format('Y-m-d') . ' ' . $booking_end;
            //                    //echo $arrNewEvent['start'] . '=>' . $arrNewEvent['end'] . '<br>';
            //                    DB::table('calendar_events')->insert($arrNewEvent);
            //                }
            //            } else {
            //                if ($request['recurring_date'] == 'week') {
            //                    $difference = ($carbStart->diff($recurringEndDay)->days < 1) ? 'today' : $carbStart->diffInWeeks($recurringEndDay);
            //                    for ($g = 0; $g <= $difference; $g++) {
            //                        $arrNewEvent['start'] = Carbon::parse($reqStart)->addDay($g * 7)->format('Y-m-d') . ' ' . $booking_start;
            //                        $arrNewEvent['end'] = Carbon::parse($reqEnd)->addDay($g * 7)->format('Y-m-d') . ' ' . $booking_end;
            //                        //echo $arrNewEvent['start'] . '=>' . $arrNewEvent['end'] . '<br>';
            //                        DB::table('calendar_events')->insert($arrNewEvent);
            //                    }
            //                } else {
            //                    if ($request['recurring_date'] == 'month') {
            //                        $difference = ($carbStart->diff($recurringEndDay)->days < 1) ? 'today' : $carbStart->diffInMonths($recurringEndDay);
            //                        for ($g = 0; $g <= $difference; $g++) {
            //                            $arrNewEvent['start'] = Carbon::parse($reqStart)->addMonth($g)->format('Y-m-d') . ' ' . $booking_start;
            //                            $arrNewEvent['end'] = Carbon::parse($reqEnd)->addMonth($g)->format('Y-m-d') . ' ' . $booking_end;
            //                            //echo $arrNewEvent['start'] . '=>' . $arrNewEvent['end'] . '<br>';
            //                            DB::table('calendar_events')->insert($arrNewEvent);
            //                        }
            //                    }
            //                }
            //            }
            //
            //        }
            //        else {
            //            $arrNewEvent['start'] = Carbon::parse($request['start'][$d])->addDay($request['start'][$d])->format('Y-m-d') . $booking_end;
            //            $arrNewEvent['end'] = Carbon::parse($request['end'][$d])->addDay($request['end'][$d])->format('Y-m-d') . $booking_start;
            //            //echo $arrNewEvent['start'] . '=>' . $arrNewEvent['end'] . '<br>';
            //            DB::table('calendar_events')->insert($arrNewEvent);
            //        }
            //    }
            //}

            $job = Job::find($request['job_id']);
            $job->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $job->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $job->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
            $job->project_rates = filter_var($request['project_rates'], FILTER_SANITIZE_STRING);
            $job->home_visits = filter_var($request['home_visits'], FILTER_SANITIZE_STRING);
            $job->job_appo_slot_times = filter_var($request['job_appo_slot_times'][0], FILTER_SANITIZE_STRING);
            $job->job_adm_catch_time = filter_var($request['job_adm_catch_time'], FILTER_SANITIZE_STRING);
            $job->breaks = filter_var($request['breaks'], FILTER_SANITIZE_STRING);
            $job->direct_booking = filter_var($request['direct_booking'], FILTER_SANITIZE_STRING);
            $job->save();

            return array('success'=>true);
        } else {
            return array('error'=>true);
        }
    }
    public function deleteCalendarEvent(Request $request)
    {        
        CalendarEvent::find($request->event_id)->delete();

        return ['success' => true];
    }

    public function hireFreelancer(Request $request){
        if(Auth::user()){
            $user = User::where('slug', $request->slug)->first();
            $profile = User::find(Auth::user()->id)->profile;
            $chat_settings = SiteManagement::getMetaValue('chat_settings');

            if (file_exists(resource_path('views/extend/back-end/employer/proposals/hire.blade.php'))) {
                return View(
                    'extend.back-end.employer.proposals.hire',
                    compact('user', 'profile', 'chat_settings')
                );
            } else {
                return View(
                    'back-end.employer.proposals.hire',
                    compact('user', 'profile', 'chat_settings')
                );
            }
        }
    }

    public function showTeams(Request $request){
        if (Auth::user()) {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $teams = Team::where('team_name', 'like', '%' . $keyword . '%')
                                    ->paginate(7)
                                    ->setPath('');
                $pagination = $teams->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $teams = Team::select('*')->latest()->paginate(10);
            }
            if (file_exists(resource_path('views/extend/back-end/employer/teams/index.blade.php'))) {
                return view('extend.back-end.employer.teams.index', compact('teams'));
            } else {
                return view('back-end.employer.teams.index', compact('teams'));
            }
        } else {
            abort(404);
        }
    }

    public function addTeam(Request $request){
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);

            if (file_exists(resource_path('views/extend/back-end/employer/teams/create.blade.php'))) {
                return view('extend.back-end.employer.teams.create', compact('user'));
            } else {
                return view('back-end.employer.teams.create', compact('user'));
            }
        } else {
            abort(404);
        }
    }

    public function postAddTeam(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        $response = $this->team->addTeam($request);
        if($response['type']=="success"){
            $json['type'] = 'success';
            $json['message'] = trans('lang.team_create_success');
            return $json;
        } else{
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    public function editTeam(Request $request){
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $team = Team::where('slug', $request->slug)->first();
            $members = array();

            if (file_exists(resource_path('views/extend/back-end/employer/teams/edit.blade.php'))) {
                return view('extend.back-end.employer.teams.edit', compact('user', 'team', 'members'));
            } else {
                return view('back-end.employer.teams.edit', compact('user', 'team', 'members'));
            }
        } else {
            abort(404);
        }
    }

    public function updateTeam(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        $response = $this->team->updateTeam($request);
        if($response['type']=="success"){
            $json['type'] = 'success';
            $json['message'] = trans('lang.team_create_success');
            return $json;
        } else{
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    public function getTeamDetail(Request $request){
        if($request->id){
            $team = Team::find($request->id);
            return $team;
        }
    }

    public function addTeamMembers(Request $request)
    {
        $user = auth()->user();
        $team_slug = $request->slug;
        $categories = Category::all();
        $locations = Location::all();
        $languages = Language::all();
        $skills = Skill::all();
        $keyword = !empty($_GET['s']) ? $_GET['s'] : '';
        $has_access = true;
        $type = "freelancer";

        if (!$user->hasRole('employer')){
            $has_access = false;
        }

        if (!$has_access) {
          App::abort(403, 'Access Denied');
        }

        $search_locations = !empty($_GET['locations']) ? $_GET['locations'] : array();
        $search_skills = !empty($_GET['skills']) ? $_GET['skills'] : array();
        $search_languages = !empty($_GET['languages']) ? $_GET['languages'] : array();
        $search_employees = !empty($_GET['employees']) ? $_GET['employees'] : array();
        $search_hourly_rates = !empty($_GET['hourly_rate']) ? $_GET['hourly_rate'] : array();
        $search_freelaner_types = !empty($_GET['freelaner_type']) ? $_GET['freelaner_type'] : array();
        $search_english_levels = !empty($_GET['english_level']) ? $_GET['english_level'] : array();
        $current_date = Carbon::now()->toDateTimeString();
        $currency = SiteManagement::getMetaValue('commision');
        $symbol   = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $inner_page  = SiteManagement::getMetaValue('inner_page_data');
        $payment_settings = SiteManagement::getMetaValue('commision');
        $enable_package = !empty($payment_settings) && !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
        $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
        $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
        $days_avail = !empty($_GET['days_avail']) ? $_GET['days_avail'] : array();
        $hours_avail = !empty($_GET['hours_avail']) ? $_GET['hours_avail'] : array();
        $avail_date_from = null;
        $avail_date_to = null;

        $location = $request->input('location');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        $profession_id = $request->input('profession_id');
        $start_date = $request->input('avail_date_from') ?? $request->input('start_date') ?? null;
        $end_date = $request->input('avail_date_to') ?? $request->input('end_date') ?? null;
        $time = [
            'hours' => $request->input('hours'),
            'minutes' => $request->input('minutes')
        ];
        $rate = $request->input('rate');

        $only_date = true;
        
        if($request->avail_date_from && $request->hours) {
            $only_date = false;
            $avail_date_from = $request->avail_date_from . ' ' . $request->hours . ':' . $request->minutes . ':00';
            $avail_date_from = Carbon::createFromFormat('d/m/Y H:i:s', $avail_date_from)->format('Y-m-d H:i:s');
        } else if($request->avail_date_from) {
            $avail_date_from = $request->avail_date_from;
            $avail_date_from = Carbon::createFromFormat('d/m/Y', $avail_date_from)->format('Y-m-d');
        }
        if($request->avail_date_to && $request->hours) {
            $only_date = false;
            $avail_date_to = $request->avail_date_to . ' ' . $request->hours . ':' . $request->minutes . ':00';
            $avail_date_to = Carbon::createFromFormat('d/m/Y H:i:s', $avail_date_to)->format('Y-m-d H:i:s');
        } else if($request->avail_date_to) {
            $avail_date_to = $request->avail_date_to;
            $avail_date_to = Carbon::createFromFormat('d/m/Y', $avail_date_to)->format('Y-m-d');
        }

        if (!empty($request->slug)) {
            $users_total_records = User::count();
            $search =  User::getSearchResult(
                $user,
                $type,
                $keyword,
                $search_locations,
                $search_employees,
                $search_skills,
                $search_hourly_rates,
                $search_freelaner_types,
                $search_english_levels,
                $search_languages,
                $days_avail,
                $hours_avail,
                $avail_date_from,
                $avail_date_to,
                $location,
                $latitude,
                $longitude,
                $radius,
                $profession_id,
                $only_date,
                $rate
            );
            if(!($location || $profession_id || $avail_date_from || $avail_date_to ))
                $users = [];
            else $users = count($search['users']) > 0 ? $search['users'] : [];
            /*
            $users = User::select('users.*')
                            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('model_has_roles.model_type', '=', 'App\User')
                            ->where('roles.role_type', '=', "freelancer")
                            ->get();
            */
            $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ?
                unserialize(auth()->user()->profile->saved_freelancer) : array();
            $save_employer = !empty(auth()->user()->profile->saved_employers) ?
                unserialize(auth()->user()->profile->saved_employers) : array();
            $f_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['f_list_meta_title']) ? $inner_page[0]['f_list_meta_title'] : trans('lang.freelancer_listing');
            $f_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['f_list_meta_desc']) ? $inner_page[0]['f_list_meta_desc'] : trans('lang.freelancer_meta_desc');
            $show_f_banner = !empty($inner_page) && !empty($inner_page[0]['show_f_banner']) ? $inner_page[0]['show_f_banner'] : 'true';
            $f_inner_banner = !empty($inner_page) && !empty($inner_page[0]['f_inner_banner']) ? $inner_page[0]['f_inner_banner'] : null;
            if (file_exists(resource_path('views/extend/back-end/employer/teams/add-members.blade.php'))) {
                return view(
                    'extend.back-end.employer.teams.add-members',
                    compact(
                        'type',
                        'users',
                        'team_slug',
                        'categories',
                        'locations',
                        'languages',
                        'skills',
                        'keyword',
                        'users_total_records',
                        'save_freelancer',
                        'symbol',
                        'current_date',
                        'f_list_meta_title',
                        'f_list_meta_desc',
                        'show_f_banner',
                        'f_inner_banner',
                        'enable_package',
                        'show_breadcrumbs',
                        'location',
                        'latitude',
                        'longitude',
                        'radius',
                        'profession_id',
                        'avail_date_from',
                        'avail_date_to',
                        'time',
                        'rate'
                    )
                );
            } else {
                return view(
                    'back-end.employer.teams.add-members',
                    compact(
                        'type',
                        'users',
                        'team_slug',
                        'categories',
                        'locations',
                        'languages',
                        'skills',
                        'keyword',
                        'users_total_records',
                        'save_freelancer',
                        'symbol',
                        'current_date',
                        'f_list_meta_title',
                        'f_list_meta_desc',
                        'show_f_banner',
                        'f_inner_banner',
                        'enable_package',
                        'show_breadcrumbs',
                        'location',
                        'latitude',
                        'longitude',
                        'radius',
                        'profession_id',
                        'avail_date_from',
                        'avail_date_to',
                        'time',
                        'rate'
                    )
                );
            }

        } else {
            abort(404);
        }
    }
}
