<?php

/**
 * Class UserController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\Helper;
use App\Invoice;
use App\Job;
use App\Profession;
use App\Language;
use App\Mail\AdminEmailMailable;
use App\Mail\FreelancerEmailMailable;
use App\Mail\GeneralEmailMailable;
use App\Repositories\ProfessionRepository;
use App\Package;
use App\Profile;
use App\Proposal;
use App\Report;
use App\Review;
use App\SiteManagement;
use App\User;
use App\CalendarEvent;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Input;
use View;
use App\Offer;
use App\Message;
use Illuminate\Support\Arr;
use App\Payout;
use File;
use Storage;
use PDF;
use App\Item;
use App\Http\Controllers\Exception;
use App\Service;

/**
 * Class UserController
 *
 */
class UserController extends Controller
{
    /**
     * Defining public scope of varriable
     *
     * @access public
     *
     * @var array $user
     */
    use HasRoles;
    protected $user;
    protected $settings;
    protected $professionRepository;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param instance $user    make instance
     * @param instance $profile make profile instance
     *
     * @return void
     */
    public function __construct(User $user, Profile $profile, SiteManagement $settings, ProfessionRepository $professionRepository)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->settings = $settings;
        $this->professionRepository = $professionRepository;
    }

    /**
     * Admin dashboard
     *
     * @access public
     *
     * @return View
     */

    public function adminDashboard(){
        if (Auth::user()) {
            $freelancer_id = Auth::user()->id;
            $ongoing_projects = Proposal::getProposalsByStatus($freelancer_id, 'hired', 3);
            $cancelled_projects = Proposal::getProposalsByStatus($freelancer_id, 'cancelled');
            $package_item = Item::where('subscriber', $freelancer_id)->first();
            $package = !empty($package_item) ? Package::find($package_item->product_id) : array();
            $option = !empty($package) && !empty($package['options']) ? unserialize($package['options']) : '';
            $expiry = !empty($option) ? $package_item->updated_at->addDays($option['duration']) : '';
            $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
            $message_status = Message::where('status', 0)->where('receiver_id', $freelancer_id)->count();
            $notify_class = $message_status > 0 ? 'wt-insightnoticon' : '';
            $completed_projects = Proposal::getProposalsByStatus($freelancer_id, 'completed');
            $currency = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            $trail = !empty($package) && $package['trial'] == 1 ? 'true' : 'false';
            $icons = SiteManagement::getMetaValue('icons');
            $enable_package = !empty($currency) && !empty($currency[0]['enable_packages']) ? $currency[0]['enable_packages'] : 'true';
            $latest_proposals_icon = !empty($icons['hidden_latest_proposal']) ? $icons['hidden_latest_proposal'] : 'img-20.png';
            $latest_package_expiry_icon = !empty($icons['hidden_package_expiry']) ? $icons['hidden_package_expiry'] : 'img-21.png';
            $latest_new_message_icon = !empty($icons['hidden_new_message']) ? $icons['hidden_new_message'] : 'img-19.png';
            $latest_saved_item_icon = !empty($icons['hidden_saved_item']) ? $icons['hidden_saved_item'] : 'img-22.png';
            $latest_cancel_project_icon = !empty($icons['hidden_cancel_project']) ? $icons['hidden_cancel_project'] : 'img-16.png';
            $latest_ongoing_project_icon = !empty($icons['hidden_ongoing_project']) ? $icons['hidden_ongoing_project'] : 'img-17.png';
            $latest_pending_balance_icon = !empty($icons['hidden_pending_balance']) ? $icons['hidden_pending_balance'] : 'icon-01.png';
            $latest_current_balance_icon = !empty($icons['hidden_current_balance']) ? $icons['hidden_current_balance'] : 'icon-02.png';
            $published_services_icon = !empty($icons['hidden_published_services']) ? $icons['hidden_published_services'] : 'payment-method.png';
            $cancelled_services_icon = !empty($icons['hidden_cancelled_services']) ? $icons['hidden_cancelled_services'] : 'decline.png';
            $completed_services_icon = !empty($icons['hidden_completed_services']) ? $icons['hidden_completed_services'] : 'completed-task.png';
            $ongoing_services_icon = !empty($icons['hidden_ongoing_services']) ? $icons['hidden_ongoing_services'] : 'onservice.png';
            $access_type = Helper::getAccessType();
            $applications = Proposal::where('freelancer_id',$freelancer_id)->count();
            $professions = $this->professionRepository->getProfessionsByRole();
            $lastest_proposals = Proposal::getLastWeekProposals($freelancer_id);

            return view(
                'back-end.admin.dashboard',
                compact(
                    'access_type',
                    'ongoing_projects',
                    'cancelled_projects',
                    'expiry_date',
                    'notify_class',
                    'completed_projects',
                    'symbol',
                    'trail',
                    'latest_proposals_icon',
                    'latest_package_expiry_icon',
                    'latest_new_message_icon',
                    'latest_saved_item_icon',
                    'latest_cancel_project_icon',
                    'latest_ongoing_project_icon',
                    'latest_pending_balance_icon',
                    'latest_current_balance_icon',
                    'published_services_icon',
                    'cancelled_services_icon',
                    'completed_services_icon',
                    'ongoing_services_icon',
                    'enable_package',
                    'package',
                    'lastest_proposals',
                    'message_status',
                    'applications',
                    'professions'
                )
            );
        }
    }

    /**
     * Profile Manage Account/ Profile Settings
     *
     * @access public
     *
     * @return View
     */
    
    public function accountSettings()
    {
        $languages = Language::pluck('title', 'id');
        $user_id = Auth::user()->id;
        $profile = new Profile();
        $saved_options = $profile::select('profile_searchable', 'profile_blocked', 'english_level')
            ->where('user_id', $user_id)->get()->first();
        $english_levels = Helper::getEnglishLevelList();
        $user_level = !empty($saved_options->english_level) ? $saved_options->english_level : trans('lang.basic');
        $user = $this->user::find($user_id);
        $user_languages = array();
        if (!empty($user->languages)) {
            foreach ($user->languages as $user_language) {
                $user_languages[] = $user_language->id;
            }
        }
        if (file_exists(resource_path('views/extend/back-end/settings/security-settings.blade.php'))) {
            return view(
                'extend.back-end.settings.security-settings',
                compact('languages', 'saved_options', 'user_languages', 'english_levels', 'user_level')
            );
        } else {
            return view(
                'back-end.settings.security-settings',
                compact('languages', 'saved_options', 'user_languages', 'english_levels', 'user_level')
            );
        }
    }

    /**
     * Save user account settings.
     *
     * @param mixed $request request attribute
     *
     * @access public
     *
     * @return View
     */
    public function saveAccountSettings(Request $request)
    {
        $server_verification = Helper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $profile = new Profile();
        $user_id = Auth::user()->id;
        $profile->storeAccountSettings($request, $user_id);
        Session::flash('message', trans('lang.account_settings_saved'));
        return Redirect::back();
    }

    /**
     * Reset password form.
     *
     * @access public
     *
     * @return View
     */
    public function resetPassword($role = null)
    {
        if ($role == 'employer') {
            return view('back-end.employer.profile-settings.reset_password');
        }

        if ($role == 'freelancer') {
            return view('back-end.freelancer.profile-settings.reset_password');
        }

        if ($role == 'support') {
            return view('back-end.support.profile-settings.reset_password');
        }

        if (file_exists(resource_path('views/extend/back-end/settings/reset-password.blade.php'))) {
            return view('extend.back-end.settings.reset-password');
        } else {
            return view('back-end.settings.reset-password');
        }
    }

    /**
     * Update reset password.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function requestPassword(Request $request)
    {
        $server_verification = Helper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            Validator::extend(
                'old_password',
                function ($attribute, $value, $parameters) {
                    return Hash::check($value, Auth::user()->password);
                }
            );
            $this->validate(
                $request,
                [
                    'old_password'         => 'required',
                    'confirm_password'     => 'required',
                    'confirm_new_password' => 'required',
                ]
            );
            $user_id = $request['user_id'];
            $user = User::find($user_id);
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->confirm_password === $request->confirm_new_password) {
                    $user->password = Hash::make($request->confirm_password);
                    // Send email
                    if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                        $email_params = array();
                        $template = DB::table('email_types')->select('id')->where('email_type', 'reset_password_email')->get()->first();
                        if (!empty($template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                            $email_params['name'] = Helper::getUserName($user_id);
                            $email_params['email'] = $user->email;
                            $email_params['password'] = $request->confirm_password;
                            try {
                                $templateMail = new GeneralEmailMailable(
                                    'reset_password_email',
                                    $template_data,
                                    $email_params
                                );
                                Mail::to($user->email)
                                    ->send(
                                        $templateMail
                                    );
                                $messageBody = $templateMail->prepareEmailResetPassword($email_params);
                                $notificationMessage = ['receiver_id' => $user->id,'author_id' => 1,'message' => $messageBody];
                                $service = new Message();
                                $service->saveNofiticationMessage($notificationMessage);
                            } catch (\Exception $e) {
                                Session::flash('error', trans('lang.ph_email_warning'));
                                return Redirect::back();
                            }
                        }
                    }
                    $user->save();
                    Session::flash('message', trans('passwords.reset'));
                    Auth::logout();
                    return Redirect::to('/');
                } else {
                    Session::flash('error', trans('lang.confirmation'));
                    return Redirect::back();
                }
            } else {
                Session::flash('error', trans('lang.pass_not_match'));
                return Redirect::back();
            }
        } else {
            Session::flash('error', trans('lang.something_wrong'));
            return Redirect::back();
        }
    }

    /**
     * Email Notification Settings Form.
     *
     * @access public
     *
     * @return View
     */
    public function emailNotificationSettings()
    {
        $user_email = !empty(Auth::user()) ? Auth::user()->email : '';
        if (file_exists(resource_path('views/extend/back-end/settings/email-notifications.blade.php'))) {
            return view('extend.back-end.settings.email-notifications', compact('user_email'));
        } else {
            return view('back-end.settings.email-notifications', compact('user_email'));
        }
    }

    /**
     * Save Email Notification Settings.
     *
     * @param mixed $request request attribute
     *
     * @access public
     *
     * @return View
     */
    public function saveEmailNotificationSettings(Request $request)
    {
        $server_verification = Helper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $profile = new Profile();
        $user_id = Auth::user()->id;
        $profile->storeEmailNotification($request, $user_id);
        Session::flash('message', trans('lang.email_settings_saved'));
        return Redirect::back();
    }

    /**
     * Delete Account From.
     *
     * @access public
     *
     * @return View
     */
    public function deleteAccount()
    {
        if (file_exists(resource_path('views/extend/back-end/settings/delete-account.blade.php'))) {
            return view('extend.back-end.settings.delete-account');
        } else {
            return view('back-end.settings.delete-account');
        }
    }

    /**
     * User delete account.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function destroy(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $this->validate(
            $request,
            [
                'old_password' => 'required',
                'retype_password'    => 'required',
            ]
        );
        $json = array();
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if (Hash::check($request->old_password, $user->password)) {
            if (!empty($user_id)) {
                $user->profile()->delete();
                $user->skills()->detach();
                $user->languages()->detach();
                $user->categories()->detach();
                $user->roles()->detach();
                $user->delete();
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    //$delete_reason = Helper::getDeleteAccReason($request['delete_reason']);
                    $email_params = array();
                    $template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_delete_account')->get()->first();
                    if (!empty($template->id)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                        $email_params['reason'] = ''; //$delete_reason;
                        Mail::to(config('mail.username'))
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_delete_account',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                Auth::logout();
                $json['acc_del'] = trans('lang.acc_deleted');
                return $json;
            } else {
                $json['type'] = 'warning';
                $json['msg'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'warning';
            $json['msg'] = trans('lang.pass_mismatched');
            return $json;
        }
    }

    /**
     * Delete user by admin.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function deleteUser(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (!empty($request['user_id'])) {
            $user = User::find($request['user_id']);
            if (!empty($user)) {
                $role = $user->getRoleNames()->first();
                if ($role == 'employer') {
                    if (!empty($user->jobs)) {
                        foreach ($user->jobs as $key => $job) {
                            Job::deleteRecord($job->id);
                        }
                    }
                } else if ($role == 'freelancer') {
                    if (!empty($user->proposals)) {
                        foreach ($user->proposals as $key => $proposal) {
                            Proposal::deleteRecord($proposal->id);
                        }
                    }
                }
                $user->profile()->delete();
                $user->skills()->detach();
                $user->services()->detach();
                $user->categories()->detach();
                $user->roles()->detach();
                $user->languages()->detach();
                DB::table('reviews')->where('user_id', $request['user_id'])
                    ->orWhere('receiver_id', $request['user_id'])->delete();
                DB::table('payouts')->where('user_id', $request['user_id'])->delete();
                DB::table('offers')->where('user_id', $request['user_id'])
                    ->orWhere('freelancer_id', $request['user_id'])->delete();
                DB::table('messages')->where('user_id', $request['user_id'])
                    ->orWhere('receiver_id', $request['user_id'])->delete();
                DB::table('items')->where('subscriber', $request['user_id'])
                    ->delete();
                DB::table('followers')->where('follower', $request['user_id'])
                    ->orWhere('following', $request['user_id'])->delete();
                DB::table('disputes')->where('user_id', $request['user_id'])->delete();
                $user->delete();
                $json['type'] = 'success';
                $json['message'] = trans('lang.ph_user_delete_message');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    
    /**
     * Disable user by admin.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function disableUser(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (!empty($request['user_id'])) {
            $user = User::find($request['user_id']);
            if (!empty($user)) {
                if($user->is_disabled==="false"){
                    $user['is_disabled'] = "true";
                    $user->save();
                    $json['message'] = trans('lang.ph_user_disable_message');
                }
                else{
                    $user['is_disabled'] = "false";
                    $user->save();
                    $json['message'] = trans('lang.ph_user_enable_message');
                }
                $json['type'] = 'success';
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get Manage Account Data
     *
     * @access public
     *
     * @return View
     */
    public function getManageAccountData()
    {
        if (Auth::user()) {
            $json = array();
            $user_id = Auth::user()->id;
            $profile = User::find($user_id)->profile->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                if ($profile->profile_searchable == 'true') {
                    $json['profile_searchable'] = 'true';
                }
                if ($profile->profile_blocked == 'true') {
                    $json['profile_blocked'] = 'true';
                }
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }

    /**
     * Get User Notification Settings
     *
     * @access public
     *
     * @return View
     */
    public function getUserEmailNotificationSettings()
    {
        $json = array();
        $profile = new Profile();
        $notifications = $profile::select('weekly_alerts', 'message_alerts')
            ->where('user_id', Auth::user()->id)->get()->first();
        if (!empty($notifications)) {
            $json['type'] = 'success';
            if ($notifications->weekly_alerts == 'true') {
                $json['weekly_alerts'] = 'true';
            }
            if ($notifications->message_alerts == 'true') {
                $json['message_alerts'] = 'true';
            }
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    /**
     * Get User Searchable Settings
     *
     * @access public
     *
     * @return View
     */
    public function getUserSearchableSettings()
    {
        $json = array();
        $profile = new Profile();
        // $user_data = $profile::select('profile_searchable', 'profile_blocked')
        //     ->where('user_id', Auth::user()->id)->get()->first();
        $user_data = User::find(Auth::user()->id);
        if (!empty($user_data)) {
            $json['type'] = 'success';
            if ($user_data->is_disabled == 'true') {
                $json['profile_blocked'] = 'true';
            }
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    /**
     * Get user saved item list
     *
     * @param mixed $request request attributes
     * @param int   $role    role
     *
     * @access public
     *
     * @return View
     */
    public function getSavedItems(Request $request, $role = '')
    {
        if (Auth::user()) {
            $user = $this->user::find(Auth::user()->id);
            $profile = $user->profile;
            $saved_jobs        = !empty($profile->saved_jobs) ? unserialize($profile->saved_jobs) : array();
            $saved_freelancers = !empty($profile->saved_freelancer) ? unserialize($profile->saved_freelancer) : array();
            $saved_employers   = !empty($profile->saved_employers) ? unserialize($profile->saved_employers) : array();
            $currency          = SiteManagement::getMetaValue('commision');
            $symbol            = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            if ($request->path() === 'employer/saved-items') {
                if (file_exists(resource_path('views/extend/back-end/employer/saved-items.blade.php'))) {
                    return view(
                        'extend.back-end.employer.saved-items',
                        compact(
                            'profile',
                            'saved_jobs',
                            'saved_freelancers',
                            'saved_employers',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.saved-items',
                        compact(
                            'profile',
                            'saved_jobs',
                            'saved_freelancers',
                            'saved_employers',
                            'symbol'
                        )
                    );
                }
            } elseif ($request->path() === 'freelancer/saved-items') {
                if (file_exists(resource_path('views/extend/back-end/freelancer/saved-items.blade.php'))) {
                    return view(
                        'extend.back-end.freelancer.saved-items',
                        compact(
                            'profile',
                            'saved_jobs',
                            'saved_freelancers',
                            'saved_employers',
                            'symbol'
                        )
                    );
                } else {
                    return view(
                        'back-end.freelancer.saved-items',
                        compact(
                            'profile',
                            'saved_jobs',
                            'saved_freelancers',
                            'saved_employers',
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
     * Get User Saved Item
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function getUserWishlist(Request $request)
    {
        if (Auth::user()) {
            $user = $this->user::find(Auth::user()->id);
            $profile = $user->profile;
            if (!empty($request['slug'])) {
                $json = array();
                $selected_user = DB::table('users')->select('id')
                    ->where('slug', $request['slug'])->get()->first();
                $role = $this->user::getUserRoleType($selected_user->id);
                if ($role->role_type == 'freelancer') {
                    $json['user_type'] = 'freelancer';
                    if (in_array($selected_user->id, unserialize($profile->saved_freelancer))) {
                        $json['current_freelancer'] = 'true';
                    }
                    return $json;
                } else if ($role->role_type == 'employer') {
                    $json['user_type'] = 'employer';
                    $employer_jobs = $this->user::find($selected_user->id)
                        ->jobs->pluck('id')->toArray();
                    if (!empty($employer_jobs) && !empty(unserialize($profile->saved_jobs))) {
                        if (in_array($employer_jobs, unserialize($profile->saved_jobs))) {
                            $json['employer_jobs'] = 'true';
                        }
                    }
                    if (in_array($selected_user->id, unserialize($profile->saved_employers))) {
                        $json['current_employer'] = 'true';
                    }
                    return $json;
                }
            }
        }
    }

    /**
     * Add job to whishlist.
     *
     * @param mixed $request request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function addWishlist(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (Auth::user()) {
            $json['authentication'] = true;
            if (!empty($request['id'])) {
                $user_id = Auth::user()->id;
                $id = $request['id'];
                if (!empty($request['column']) && ($request['column'] === 'saved_employers' || $request['column'] === 'saved_freelancer' || $request['column'] === 'saved_services')) {
                    if (!empty($request['seller_id'])) {
                        if ($user_id == $request['seller_id']) {
                            $json['type'] = 'error';
                            $json['message'] = trans('lang.login_from_different_user');
                            return $json;
                        }
                    } else {
                        if ($user_id == $id) {
                            $json['type'] = 'error';
                            $json['message'] = trans('lang.login_from_different_user');
                            return $json;
                        }
                    }
                }
                $profile = new Profile();
                $add_wishlist = $profile->addWishlist($request['column'], $id, $user_id);
                if ($add_wishlist == "success") {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.added_to_wishlist');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.something_wrong');
                    return $json;
                }
            }
        } else {
            $json['authentication'] = false;
            $json['message'] = trans('lang.need_to_reg');
            return $json;
        }
    }

    /**
     * Submit Reviews.
     *
     * @param \Illuminate\Http\Request $request request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function submitReview(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (Auth::user()) {
            if ($request['type']) {
                $project_type = $request['type'];
            } else {
                $project_type = 'job';
            }
            $user_id = Auth::user()->id;
            $submit_review = Review::submitReview($request, $user_id, $project_type);
            if ($submit_review['type'] == "success") {
                $json['type'] = 'success';
                $json['message'] = trans('lang.feedback_submit');
                //send email
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    $freelancer = User::find($request['receiver_id']);
                    $email_params = array();
                    $email_params['name'] = Helper::getUserName($freelancer->id);
                    $email_params['link'] = url('profile/' . $freelancer->slug);
                    $email_params['employer'] = Helper::getUserName($user_id);
                    $email_params['employer_profile'] = url('profile/' . Auth::user()->slug);
                    $email_params['ratings'] = $submit_review['rating'];
                    $email_params['review'] = $request['feedback'];
                    if ($project_type == 'job') {
                        $job = Job::find($request['job_id']);
                        $email_params['project_title'] = $job->title;
                        $email_params['completed_project_link'] = url('/job/' . $job->slug);
                        //$freelancer = Proposal::select('freelancer_id')->where('status', 'completed')->first();
                        $job_completed_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_job_completed')->get()->first();
                        if (!empty($job_completed_template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($job_completed_template->id);
                            Mail::to(config('mail.username'))
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_job_completed',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                        $freelancer_job_completed_template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_job_completed')->get()->first();
                        if (!empty($freelancer_job_completed_template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($freelancer_job_completed_template->id);
                            $templateMail = new FreelancerEmailMailable(
                                'freelancer_email_job_completed',
                                $template_data,
                                $email_params
                            );
                            Mail::to($freelancer->email)
                                ->send(
                                    $templateMail
                                );
                            $messageBody = $templateMail->prepareFreelancerEmailJobCompleted($email_params);
                            $notificationMessage = ['receiver_id' => $freelancer->id,'author_id' => 1,'message' => $messageBody];
                            $service = new Message();
                            $service->saveNofiticationMessage($notificationMessage);

                        }
                    } else if ($project_type == 'service') {
                        $service = Service::find($request['service_id']);
                        $email_params['project_title'] = $service->title;
                        $email_params['completed_project_link'] = url('service/' . $service->slug);
                        $template_data = Helper::getFreelancerCompletedServiceEmailContent();

                        $templateMail = new FreelancerEmailMailable(
                            'freelancer_email_job_completed',
                            $template_data,
                            $email_params
                        );

                        Mail::to($freelancer->email)
                            ->send(
                                $templateMail
                            );
                        $messageBody = $templateMail->prepareFreelancerEmailJobCompleted($email_params);
                        $notificationMessage = ['receiver_id' => $freelancer->id,'author_id' => 1,'message' => $messageBody];
                        $service = new Message();
                        $service->saveNofiticationMessage($notificationMessage);



                    }
                }
                return $json;
            } elseif ($submit_review['type'] == "rating_error") {
                $json['type'] = 'error';
                $json['message'] = trans('lang.rating_required');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Download Attachements.
     *
     * @param \Illuminate\Http\Request $request request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadAttachments(Request $request)
    {
        if (!empty($request['attachments'])) {
            $freelancer_id = $request['freelancer_id'];
            $path = storage_path() . '/app/uploads/proposals/' . $freelancer_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            $zip = new \Chumper\Zipper\Zipper();
            foreach ($request['attachments'] as $attachment) {
                $zip->make($path . '/attachments.zip')->add($path . '/' . $attachment);
            }
            $zip->close();
            return response()->download(storage_path('app/uploads/proposals/' . $freelancer_id . '/attachments.zip'));
        } else {
            Session::flash('error', trans('lang.files_not_found'));
            return Redirect::back();
        }
    }

    /**
     * Submit Report
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function storeReport(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (Auth::user()) {
            $this->validate(
                $request,
                [
                    'description' => 'required',
                    'reason' => 'required',
                ]
            );
            if ($request['model'] == "App\Job" && $request['report_type'] <> 'proposal_cancel') {
                $job = Job::find($request['id']);
                if ($job->employer->id == Auth::user()->id) {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_authorize');
                    return $json;
                }
            }
            if ($request['model'] == "App\Service" && $request['report_type'] <> 'service_cancel') {
                $service = Service::find($request['id']);
                $freelancer = $service->seller->first();
                if ($freelancer->id == Auth::user()->id) {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_authorize');
                    return $json;
                }
            }
            $report = Report::submitReport($request);
            if ($report == 'success') {
                $json['type'] = 'success';
                $user = $this->user::find(Auth::user()->id);
                //send email
                if (
                    $request['report_type'] == 'job-report'
                    || $request['report_type'] == 'employer-report'
                    || $request['report_type'] == 'freelancer-report'
                ) {
                    if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                        $email_params = array();
                        if ($request['report_type'] == 'job-report') {
                            $report_project_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_project')->get()->first();
                            if (!empty($report_project_template->id)) {
                                $job = Job::where('id', $request['id'])->first();
                                $template_data = EmailTemplate::getEmailTemplateByID($report_project_template->id);
                                $email_params['reported_project'] = $job->title;
                                $email_params['link'] = url('job/' . $job->slug);
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to(config('mail.username'))
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_project',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        } else if ($request['report_type'] == 'employer-report') {
                            $report_employer_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_employer')->get()->first();
                            if (!empty($report_employer_template->id)) {
                                $template_data = EmailTemplate::getEmailTemplateByID($report_employer_template->id);
                                $employer = User::find($request['id']);
                                $email_params['reported_employer'] = Helper::getUserName($request['id']);
                                $email_params['link'] = url('profile/' . $employer->slug);;
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to(config('mail.username'))
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_employer',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        } else if ($request['report_type'] == 'freelancer-report') {
                            $report_freelancer_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_freelancer')->get()->first();
                            if (!empty($report_freelancer_template->id)) {
                                $freelancer = User::find($request['id']);
                                $template_data = EmailTemplate::getEmailTemplateByID($report_freelancer_template->id);
                                $email_params['reported_freelancer'] = Helper::getUserName($request['id']);
                                $email_params['link'] = url('profile/' . $freelancer->slug);
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to(config('mail.username'))
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_freelancer',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        }
                    }
                } else if ($request['report_type'] == 'proposal_cancel') {
                    $freelancer_job_cancelled = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_cancel_job')->get()->first();
                    $json['message'] = trans('lang.job_cancelled');
                    if (!empty($freelancer_job_cancelled->id)) {
                        if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                            $template_data = EmailTemplate::getEmailTemplateByID($freelancer_job_cancelled->id);
                            $job = Job::find($request['id']);
                            $proposal = Proposal::where('id', $request['proposal_id'])->first();
                            $freelancer = User::find($proposal->freelancer_id);
                            $email_params['project_title'] = $job->title;
                            $email_params['cancelled_project_link'] = url('job/' . $job->slug);
                            $email_params['name'] = Helper::getUserName($proposal->freelancer_id);
                            $email_params['link'] = url('profile/' . $freelancer->slug);
                            $email_params['employer_profile'] = url('profile/' . Auth::user()->slug);
                            $email_params['emp_name'] = Helper::getUserName(Auth::user()->id);
                            $email_params['msg'] = $request['description'];
                            $templateMail = new FreelancerEmailMailable(
                                'freelancer_email_cancel_job',
                                $template_data,
                                $email_params
                            );
                                Mail::to($freelancer->email)
                                ->send(
                                    $templateMail
                                );
                            $messageBody = $templateMail->prepareFreelancerEmailJobCancelled($email_params);
                            $notificationMessage = ['receiver_id' => $freelancer->id,'author_id' => 1,'message' => $messageBody];
                            $service = new Message();
                            $service->saveNofiticationMessage($notificationMessage);

                            $job_cancelle_admin_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_cancel_job')->get()->first();
                            if (!empty($job_cancelle_admin_template)) {
                                $template_data = EmailTemplate::getEmailTemplateByID($job_cancelle_admin_template->id);
                            } else {
                                $template_data = '';
                            }
                            Mail::to(config('mail.username'))
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_cancel_job',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                } else if ($request['report_type'] == 'service_cancel') {
                    $json['message'] = trans('lang.service_cancelled');
                    if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                        $freelancer_job_cancelled = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_cancel_job')->get()->first();
                        if (!empty($freelancer_job_cancelled->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($freelancer_job_cancelled->id);
                            $service = Service::find($request['id']);
                            $freelancer = $service->seller->first();
                            $email_params['project_title'] = $service->title;
                            $email_params['cancelled_project_link'] = url('service/' . $service->slug);
                            $email_params['name'] = Helper::getUserName($freelancer->id);
                            $email_params['link'] = url('profile/' . $freelancer->slug);
                            $email_params['employer_profile'] = url('profile/' . Auth::user()->slug);
                            $email_params['emp_name'] = Helper::getUserName(Auth::user()->id);
                            $email_params['msg'] = $request['description'];
                            $templateMail = new FreelancerEmailMailable(
                                'freelancer_email_cancel_job',
                                $template_data,
                                $email_params
                            );
                            Mail::to($freelancer->email)
                                ->send(
                                    $templateMail
                                );
                            $messageBody = $templateMail->prepareFreelancerEmailJobCancelled($email_params);
                            $notificationMessage = ['receiver_id' => $freelancer->id,'author_id' => 1,'message' => $messageBody];
                            $service = new Message();
                            $service->saveNofiticationMessage($notificationMessage);

                        }

                        $job_cancelle_admin_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_cancel_job')->get()->first();
                        if (!empty($job_cancelle_admin_template)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($job_cancelle_admin_template->id);
                        } else {
                            $template_data = '';
                        }
                        Mail::to(config('mail.username'))
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_cancel_job',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                if ($request['report_type'] == 'service_cancel') {
                    $json['progress'] = trans('lang.report_submitting');
                }
                $json['message'] = trans('lang.report_submitted');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Store resource in DB.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function sendPrivateMessage(Request $request)
    {
        if (Auth::user()) {
            $server = Helper::worketicIsDemoSiteAjax();
            if (!empty($server)) {
                $response['type'] = 'error';
                $response['message'] = $server->getData()->message;
                return $response;
            }
            if (!empty($request['description'])) {
                $user_id = Auth::user()->id;
                $json = array();

                if ($request['project_type'] == 'job') {
                    $purchased_proposal = DB::table('proposals')->select('status')->where('id', $request['proposal_id'])->get()->first();
                    $status = $purchased_proposal->status;
                    if ($status == "hired") {
                        $proposal = new Proposal();
                        $send_message = $proposal::sendMessage($request, $user_id);
                    } else {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.not_allowed_msg');
                        return $json;
                    }
                } else {
                    $purchase_service = Helper::getPivotService($request['proposal_id']);
                    $status = $purchase_service->status;
                    if ($status == "hired") {
                        $service = new Service();
                        $send_message = $service::sendMessage($request, $user_id);
                    } else {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.not_allowed_msg');
                        return $json;
                    }
                }
                if ($send_message = 'success') {
                    $json['type'] = 'success';
                    $json['progress_message'] = trans('lang.sending_msg');
                    $json['message'] = trans('lang.msg_sent');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.something_wrong');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.desc_required');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Get Private Messages.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrivateMessage(Request $request)
    {
        $json = array();
        $messages = array();
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            if (!empty($request['id'])) {
                $freelancer_id = $request['recipent_id'];
                $proposal_id = $request['id'];
                $project_type = !empty($request['project_type']) ? $request['project_type'] : 'job';
                $proposal = new Proposal();
                if (Auth::user()->getRoleNames()[0] == 'admin') {
                    if ($project_type == 'service') {
                        $project = DB::table('service_user')->select('user_id')->where('id', $proposal_id)->first();
                    } else {
                        $job = DB::table('proposals')->select('job_id')->where('id', $proposal_id)->first();
                        $project = DB::table('jobs')->where('id', $job->job_id)->select('user_id')->first();
                    }
                    $message_data = $proposal::getProjectHistory($project->user_id, $freelancer_id, $proposal_id, $project_type);
                } else {
                    $freelancer_id = '';
                    $message_data = $proposal::getMessages($user_id, $freelancer_id, $proposal_id, $project_type);
                }
                // $message_data = $proposal::getMessages($user_id, $freelancer_id, $proposal_id, $project_type);
                if (!empty($message_data)) {
                    foreach ($message_data as $key => $data) {
                        $content = strip_tags(stripslashes($data->content));
                        $excerpt = str_limit($content, 100);
                        $default_avatar = url('images/user-login.png');
                        $profile_image = !empty($data->avater)
                            ? '/uploads/users/' . $data->author_id . '/' . $data->avater
                            : $default_avatar;
                        $messages[$key]['id'] = $data->id;
                        $messages[$key]['author_id'] = $data->author_id;
                        $messages[$key]['proposal_id'] = $data->proposal_id;
                        $messages[$key]['content'] = $content;
                        $messages[$key]['excerpt'] = $excerpt;
                        $messages[$key]['user_image'] = asset($profile_image);
                        $messages[$key]['created_at'] = Carbon::parse($data->created_at)->format('d-m-Y');
                        $messages[$key]['notify'] = $data->notify;
                        $messages[$key]['attachments'] = !empty($data->attachments) ? 1 : 0;
                    }
                    $json['type'] = 'success';
                    $json['messages'] = $messages;
                    return $json;
                } else {
                    $json['messages'] = trans('lang.something_wrong');
                    return $json;
                }
            } else {
                $json['messages'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Download Attachments.
     *
     * @param \Illuminate\Http\Request $id ID
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadMessageAttachments($id)
    {
        if (!empty($id)) {
            $messages = DB::table('private_messages')->select('attachments', 'author_id', 'project_type')->where('id', $id)->get()->toArray();
            $attachments = unserialize($messages[0]->attachments);
            if ($messages[0]->project_type == 'service') {
                $project_type = 'services';
            } elseif ($messages[0]->project_type == 'job') {
                $project_type = 'proposals';
            }
            $path = storage_path() . '/app/uploads/' . $project_type . '/' . $messages[0]->author_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            $zip = new \Chumper\Zipper\Zipper();
            foreach ($attachments as $attachment) {
                if (Storage::disk('local')->exists('uploads/' . $project_type . '/' . $messages[0]->author_id . '/' . $attachment)) {
                    $zip->make($path . '/' . $id . '-attachments.zip')->add($path . '/' . $attachment);
                }
            }
            $zip->close();
            if (Storage::disk('local')->exists('uploads/' . $project_type . '/' . $messages[0]->author_id . '/' . $id . '-attachments.zip')) {
                return response()->download(storage_path('app/uploads/' . $project_type . '/' . $messages[0]->author_id . '/' . $id . '-attachments.zip'));
            } else {
                Session::flash('error', trans('lang.file_not_found'));
                return Redirect::back();
            }
        }
    }

    /**
     * Checkout Page.
     *
     * @param \Illuminate\Http\Request $id ID
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($id)
    {
        if (!empty($id)) {
            $package_options = Helper::getPackageOptions(Auth::user()->getRoleNames()[0]);
            $package = Package::find($id);
            $payout_settings = SiteManagement::getMetaValue('commision');
            $payment_gateway = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : array();
            $symbol = !empty($payout_settings) && !empty($payout_settings[0]['currency']) ? Helper::currencyList($payout_settings[0]['currency']) : array();
            if (file_exists(resource_path('views/extend/back-end/package/checkout.blade.php'))) {
                return view::make('extend.back-end.package.checkout', compact('package', 'package_options', 'payment_gateway', 'symbol'));
            } else {
                return view::make('back-end.package.checkout', compact('package', 'package_options', 'payment_gateway', 'symbol'));
            }
        }
    }

    /**
     * Print Thankyou.
     *
     * @return \Illuminate\Http\Response
     */
    public function thankyou()
    {
        if (Auth::user()) {
            echo trans('lang.thankyou');
        } else {
            abort(404);
        }
    }

    /**
     * Get Invoices.
     *
     * @param \Illuminate\Http\Request $type type
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployerInvoices($type = '')
    {
        if (Auth::user()->getRoleNames()[0] != 'admin' && Auth::user()->getRoleNames()[0] === 'employer') {
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            $invoices = array();
            $expiry_date = '';
            if ($type === 'project') {
                $invoices = DB::table('invoices')
                    ->join('items', 'items.invoice_id', '=', 'invoices.id')
                    ->select('invoices.*')
                    ->where('items.subscriber', Auth::user()->id)
                    ->where('invoices.type', $type)
                    ->get();
                if (file_exists(resource_path('views/extend/back-end/employer/invoices/project.blade.php'))) {
                    return view('extend.back-end.employer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
                } else {
                    return view('back-end.employer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
                }
            } elseif ($type === 'package') {
                $invoices = DB::table('invoices')
                    ->join('items', 'items.invoice_id', '=', 'invoices.id')
                    ->join('packages', 'packages.id', '=', 'items.product_id')
                    ->select('invoices.*', 'packages.options')
                    ->where('items.subscriber', Auth::user()->id)
                    ->where('invoices.type', $type)
                    ->get();
                if (file_exists(resource_path('views/extend/back-end/employer/invoices/package.blade.php'))) {
                    return view('extend.back-end.employer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
                } else {
                    return view('back-end.employer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
                }
            }
        }
    }

    /**
     * Get Freelancer Invoices.
     *
     * @param \Illuminate\Http\Request $type type
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerInvoices($type = '')
    {
        if (Auth::user()->getRoleNames()[0] != 'admin' && Auth::user()->getRoleNames()[0] === 'freelancer') {
            $invoices = array();
            $invoices = DB::table('invoices')
                ->join('items', 'items.invoice_id', '=', 'invoices.id')
                ->join('packages', 'packages.id', '=', 'items.product_id')
                ->select('invoices.*', 'packages.options')
                ->where('items.subscriber', Auth::user()->id)
                ->where('invoices.type', $type)
                ->get();
            $expiry_date = '';
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            if ($type === 'project') {
                if (file_exists(resource_path('views/extend/back-end/freelancer/invoices/project.blade.php'))) {
                    return view('extend.back-end.freelancer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
                } else {
                    return view('back-end.freelancer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
                }
            } elseif ($type === 'package') {
                if (file_exists(resource_path('views/extend/back-end/freelancer/invoices/package.blade.php'))) {
                    return view('extend.back-end.freelancer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
                } else {
                    return view('back-end.freelancer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
                }
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Invoices.
     *
     * @param integer $id roletype
     *
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($id)
    {
        if (!empty($id)) {
            $invoice_info = DB::table('invoices')
                ->join('items', 'items.invoice_id', '=', 'invoices.id')
                ->select('items.*', 'invoices.*')
                ->where('invoices.id', '=', $id)
                ->get()->first();
            $currency_code = !empty($invoice_info->currency_code) ? strtoupper($invoice_info->currency_code) : 'USD';
            $code = Helper::currencyList($currency_code);
            $symbol = !empty($code) ? $code['symbol'] : '??';
            if (Auth::user()->getRoleNames()->first() === 'freelancer') {
                if (file_exists(resource_path('views/extend/back-end/freelancer/invoices/show.blade.php'))) {
                    return view::make('extend.back-end.freelancer.invoices.show', compact('invoice_info', 'symbol', 'currency_code'));
                } else {
                    return view::make('back-end.freelancer.invoices.show', compact('invoice_info', 'symbol', 'currency_code'));
                }
            } elseif (Auth::user()->getRoleNames()->first() === 'employer') {
                if (file_exists(resource_path('views/extend/back-end/employer/invoices/show.blade.php'))) {
                    return view::make('extend.back-end.employer.invoices.show', compact('invoice_info', 'symbol', 'currency_code'));
                } else {
                    return view::make('back-end.employer.invoices.show', compact('invoice_info', 'symbol', 'currency_code'));
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProfileSettings()
    {
        $profile = Profile::where('user_id', Auth::user()->id)
            ->get()->first();
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        if (file_exists(resource_path('views/extend/back-end/admin/profile-settings/personal-detail/index.blade.php'))) {
            return view(
                'extend.back-end.admin.profile-settings.personal-detail.index',
                compact(
                    'banner',
                    'avater',
                    'tagline',
                    'description'
                )
            );
        } else {
            return view(
                'back-end.admin.profile-settings.personal-detail.index',
                compact(
                    'banner',
                    'avater',
                    'tagline',
                    'description'
                )
            );
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
        $this->validate(
            $request,
            [
                'first_name'    => 'required',
                'last_name'    => 'required',
                'email' => 'required|email',
            ]
        );
        $json = array();
        if (!empty($request)) {
            $user_id = Auth::user()->id;
            $this->profile->storeProfile($request, $user_id);
            $json['type'] = 'success';
            $json['process'] = trans('lang.saving_profile');
            return $json;
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
            return Helper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['hidden_banner_image'])) {
            $profile_image = $request['hidden_banner_image'];
            return Helper::uploadTempImage($path, $profile_image);
        }
    }

    /**
     * Store project Offer
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeProjectOffers(Request $request)
    {
        $this->validate(
            $request,
            [
                'projects' => 'required',
                'desc'    => 'required',
            ]
        );

        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        if (!empty($request)) {
            $offer = new Offer();
            if (Auth::user()->getRoleNames()->first() === 'employer') {
                $storeProjectOffers = $offer->saveProjectOffer($request, $request['freelancer_id']);
                if ($storeProjectOffers == "success") {
                    $json['type'] = 'success';
                    $json['progressing'] = trans('lang.send_offer');
                    $json['message'] = trans('lang.offer_sent');
                    $user = $this->user::find(Auth::user()->id);
                    //send email
                    if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                        $email_params = array();
                        $send_freelancer_offer = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_send_offer')->get()->first();
                        $message = new Message();
                        if (!empty($send_freelancer_offer->id)) {
                            $job = Job::where('id', $request['projects'])->first();
                            $freelancer = User::find($request['freelancer_id']);
                            $f_link = url('profile/' . $freelancer->slug);
                            $f_name = Helper::getUserName($freelancer->id);
                            $e_name = Helper::getUserName(Auth::user()->id);
                            $e_link = url('profile/' . $user->slug);
                            $p_link = url('job/' . $job->slug);
                            $p_title = $job->title;
                            $msg = $request['desc'];
                            $template_data = EmailTemplate::getEmailTemplateByID($send_freelancer_offer->id);
                            $message->user_id = intval(Auth::user()->id);
                            $message->receiver_id = intval($request['freelancer_id']);
                            $message->body = Helper::getProjectOfferContent($e_name, $e_link, $p_link, $p_title, $msg);
                            $message->status = 0;
                            $message->save();
                            $email_params['project_title'] = $p_title;
                            $email_params['project_link'] = $p_link;
                            $email_params['employer_profile'] = $e_link;
                            $email_params['emp_name'] = $e_name;
                            $email_params['link'] = $f_link;
                            $email_params['name'] = $f_name;
                            $email_params['msg'] = $msg;
                            $templateMail = new FreelancerEmailMailable(
                                'freelancer_email_send_offer',
                                $template_data,
                                $email_params
                            );
                            Mail::to($freelancer->email)
                                ->send(
                                    $templateMail
                                );
                            $messageBody = $templateMail->prepareFreelancerEmailSendOffer($email_params);
                            $notificationMessage = ['receiver_id' => $freelancer->id,'author_id' => 1,'message' => $messageBody];
                            $service = new Message();
                            $service->saveNofiticationMessage($notificationMessage);

                        }
                    }
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_send_offer');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_authorize');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Raise Dispute
     *
     * @param mixed $slug get job slug
     *
     * @access public
     *
     * @return View
     */
    public function raiseDispute($slug)
    {
        $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
        $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
        $job = Job::where('slug', $slug)->first();
        $reasons = Arr::pluck(Helper::getReportReasons(), 'title', 'title');
        if (file_exists(resource_path('views/extend/back-end/freelancer/jobs/dispute.blade.php'))) {
            return View(
                'extend.back-end.freelancer.jobs.dispute',
                compact(
                    'job',
                    'reasons',
                    'show_breadcrumbs'
                )
            );
        } else {
            return View(
                'back-end.freelancer.jobs.dispute',
                compact(
                    'job',
                    'reasons',
                    'show_breadcrumbs'
                )
            );
        }
    }

    /**
     * Raise dispute
     *
     * @param mixed $request $req->attr
     *
     * @access public
     *
     * @return View
     */
    public function storeDispute(Request $request)
    {
        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $storeDispute = $this->user->saveDispute($request);
        if ($storeDispute == "success") {
            $json['type'] = 'success';
            $json['message'] = trans('lang.dispute_raised');
            $user = $this->user::find(Auth::user()->id);
            //send email
            if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                $email_params = array();
                $dispute_raised_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_dispute_raised')->get()->first();
                if (!empty($dispute_raised_template->id)) {
                    $job = Job::where('id', $request['proposal_id'])->first();
                    $template_data = EmailTemplate::getEmailTemplateByID($dispute_raised_template->id);
                    $email_params['project_title'] = $job->title;
                    $email_params['project_link'] = url('job/' . $job->slug);
                    $email_params['sender_link'] = url('profile/' . $user->slug);
                    $email_params['name'] = Helper::getUserName(Auth::user()->id);
                    $email_params['msg'] = $request['description'];
                    $email_params['reason'] = $request['reason'];
                    Mail::to(config('mail.username'))
                        ->send(
                            new AdminEmailMailable(
                                'admin_email_dispute_raised',
                                $template_data,
                                $email_params
                            )
                        );
                }
            }
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Raise dispute
     *
     * @access public
     *
     * @return View
     */
    public function userListing()
    {
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $users = $this->user::where('first_name', 'like', '%' . $keyword . '%')
                                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                                    ->orWhere('email', 'like', '%' . $keyword . '%')
                                    ->paginate(7)
                                    ->setPath('');
                $pagination = $users->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $users = User::select('*')->latest()->paginate(10);
            }
            if (file_exists(resource_path('views/extend/back-end/admin/users/index.blade.php'))) {
                return view('extend.back-end.admin.users.index', compact('users'));
            } else {
                return view('back-end.admin.users.index', compact('users'));
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Freelancer Payouts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayouts()
    {
        if (!empty($_GET['year']) && !empty($_GET['month'])) {
            $year = $_GET['year'];
            $month = $_GET['month'];
            $payouts =  DB::table('payouts')
                ->select('*')
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->paginate(10)->setPath('');
            $pagination = $payouts->appends(
                array(
                    'year' => Input::get('year')
                )
            );
        } else {
            $payouts =  Payout::paginate(10);
        }
        $selected_year = !empty($_GET['year']) ? $_GET['year'] : '';
        $selected_month = !empty($_GET['month']) ? $_GET['month'] : '';
        // $payout_years =  Payout::selectRaw('YEAR(created_at) as year')->orderBy('year', 'desc')->get()->pluck('year')->toArray();
        $months = Helper::getMonthList();
        $years = array_combine(range(date("Y"), 1970), range(date("Y"), 1970));
        if (file_exists(resource_path('views/extend/back-end/admin/payouts.blade.php'))) {
            return view(
                'extend.back-end.admin.payouts',
                compact('payouts', 'years', 'selected_year', 'months', 'selected_month')
            );
        } else {
            return view(
                'back-end.admin.payouts',
                compact('payouts', 'years', 'selected_year', 'months', 'selected_month')
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($year, $month)
    {
        $payouts =  DB::table('payouts')
            ->select('*')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();
        $pdf = PDF::loadView('back-end.admin.payouts-pdf', compact('payouts', 'year', 'month'));
        return $pdf->download('payout-'.$month.'-'.$year.'.pdf');
    }

    /**
     * Verify Code
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyUserEmailCode(Request $request)
    {
        $role = Auth::user()->getRoleNames()->first();
        if (!empty($request['code'])) {
            if ($request['code'] === $user->verification_code) {
                $user->user_verified = 1;
                $user->verification_code = null;
                $user->save();
                return Redirect::to($role . '/dashboard');
            } else {
                Session::flash('error', trans('lang.ph_email_warning'));
                return Redirect::back();
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.verify_code');
            return $json;
        }
    }

    /**
     * Submit user refound to payouts
     *
     * @return \Illuminate\Http\Response
     */
    public function submitUserRefund(Request $request)
    {
        $server_verification = Helper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $json = array();
        if (!empty($request)) {
            $this->validate(
                $request,
                [
                    'refundable_user_id' => 'required',
                ]
            );
            $role = $this->user::getUserRoleType($request['refundable_user_id']);
            if ($role->role_type == 'freelancer') {
                $update_status = '';
                if ($request['type'] == 'job') {
                    $update_status = $this->user->updateCancelProject($request);
                } elseif ($request['type'] == 'service') {
                    $update_status = $this->user->updateCancelService($request);
                }
                if ($update_status = 'success') {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.status_updated');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.something_wrong');
                    return $json;
                }
            } elseif ($role->role_type == 'employer') {
                $refound = $this->user->transferRefund($request);
                if ($refound == 'payout_not_available') {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.user_payout_not_set');
                    return $json;
                } else if ($refound == 'success') {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.refund_transfer');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.all_required');
                    return $json;
                }
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Verify Code
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePayoutDetail(Request $request)
    {
        $user_id = $request['id'];
        if (!empty($user_id)) {

            $payout_setting = $this->profile->savePayoutDetail($request, $user_id);
            $json['type'] = 'success';
            $json['message'] = 'payout update successfully';
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.verify_code');
            return $json;
        }
    }

    /**
     * Get payout detail
     *
     */
    public function getPayoutDetail()
    {
        $json = array();
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $payout_detail = !empty($user->profile) ? Helper::getUnserializeData($user->profile->payout_settings) : array();
            $json['type'] = 'success';
            $json['payouts'] = $payout_detail;
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.verify_code');
            return $json;
        }
    }

    public function paymentSettings()
    {
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $user->user_role = $this->user::getUserRoleType(Auth::user()->id);
            $payout_settings = $this->settings::getMetaValue('commision');
            $available_payment_options = !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : array();
            $payment_options = array();
            if(!empty($available_payment_options)){
                foreach($available_payment_options as $option){
                    $payment_options[$option] = $option;
                }
            }
            return view('back-end.settings.payment_settings', 
                array(
                    'user' => $user,
                    'payment_options' => $payment_options
                )
            );
        }
    }

    public function getPaymentSettings(Request $request){
        $user = User::find(Auth::user()->id);
        $paymentSettings = array();
        $paymentSettings['payment_option'] = $user->payment_option;
        $paymentSettings['p60'] = $user->p60;
        $paymentSettings['paypal'] = $user->paypal;
        $paymentSettings['bacs'] = $user->bacs;
        $paymentSettings['bacs_sortcode'] = $user->bacs_sortcode;
        $paymentSettings['bacs_account'] = $user->bacs_account;
        $paymentSettings['cheque'] = $user->cheque;
        $paymentSettings['limited_company_number'] = $user->limitied_company_number;
        
        return json_encode($paymentSettings);
    }

    public function savePaymentSettings(Request $request){
        if(Auth::user()){
            $user = User::find(Auth::user()->id);   
            $user->payment_option = $request->payment_option;
            if($request->paypal) $user->paypal = $request->paypal;
            if($request->bacs) $user->bacs = $request->bacs;
            if($request->bacs_sortcode) $user->bacs_sortcode = $request->bacs_sortcode;
            if($request->bacs_account) $user->bacs_account = $request->bacs_account;
            if($request->cheque) $user->cheque = $request->cheque;
            if($request->limited_company_number) $user->limitied_company_number = $request->limited_company_number;
            $user->save();
            $json['type'] = "success";
            $json['msg'] = "Your payment settings have been saved successfully";
            return $json;
        }
    }

    public function getAllAvailabilities()
    {
        $arrEvents = DB::table('calendar_events')
            ->join('users', 'calendar_events.user_id', '=', 'users.id')
            ->where('calendar_events.class', '=', 'available_class')
            ->select('calendar_events.*', 'users.first_name', 'users.last_name')
            ->get()->all();

        return $arrEvents ?? [];
    }
    
    public function deleteAvailability(Request $request)
    {        
        CalendarEvent::find($request->event_id)->delete();

        return ['success' => true];
    }
    
    public function getUserProfessions(Request $request){
        $user = User::find(Auth::user()->id);
        if($user->profession_id){
            $professions = array();
            $main_profession = Profession::find($user->profession_id);
            array_push($professions, $main_profession);
            $extra_professions = $user->professions()->get();
            foreach($extra_professions as $pro){
                array_push($professions, $pro);
            }
            sort($professions);
        } else{
            $professions = $this->professionRepository->getProfessionsByRole();
        }
        return response()->json($professions);
    }

    public function allPayments(Request $request){
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $payments = DB::table('invoices')->where('payer_email', 'like', '%' . $keyword . '%')
                                    ->orWhere('seller_email', 'like', '%' . $keyword . '%')
                                    ->paginate(10)
                                    ->setPath('');
                $pagination = $payments->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $payments = DB::table('invoices')->select('*')->latest()->paginate(10);
            }
            if (file_exists(resource_path('views/extend/back-end/admin/analytics/payments.blade.php'))) {
                return view('extend.back-end.admin.analytics.payments', compact('payments'));
            } else {
                return view('back-end.admin.analytics.payments', compact('payments'));
            }
        } else {
            abort(404);
        }
    }

    public function monthlyUsers(Request $request){
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['year']) && $_GET['year']!='All') {
                $year = $_GET['year'];
                $monthlyUsers = DB::table('users')
                                ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
                                ->where(DB::raw('YEAR(created_at)'), '=', $year)
                                ->groupBy(DB::raw('YEAR(created_at)'))
                                ->groupBY(DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'DESC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'DESC')
                                ->paginate(10)
                                ->setPath('');
                $pagination = $monthlyUsers->appends(
                    array(
                        'year' => Input::get('year')
                    )
                );
            } else{
                $monthlyUsers = DB::table('users')
                                ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
                                ->groupBy(DB::raw('YEAR(created_at)'))
                                ->groupBY(DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'DESC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'DESC')
                                ->paginate(10);
            }

            
            if (file_exists(resource_path('views/extend/back-end/admin/analytics/monthly-users.blade.php'))) {
                return view('extend.back-end.admin.analytics.monthly-users', compact('monthlyUsers'));
            } else {
                return view('back-end.admin.analytics.monthly-users', compact('monthlyUsers'));
            }
        } else {
            abort(404);
        }
    }

    public function popularFreelancers(Request $request){
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                
                $popularUsers = DB::table('proposals')
                                ->select(
                                    DB::raw("COUNT('proposals.freelancer_id') as count"), 
                                    DB::raw("MAX(CONCAT(users.first_name, ' ', users.last_name)) as full_name"), 
                                    DB::raw("MAX(users.email) as email"),
                                    DB::raw("MAX(professions.title) as profession")
                                )
                                ->join('users', 'proposals.freelancer_id', '=', 'users.id')
                                ->leftJoin('professions', 'users.profession_id', '=', 'professions.id')
                                ->where('users.first_name', 'like', '%' . $keyword . '%')
                                ->orWhere('users.last_name', 'like', '%' . $keyword . '%')
                                ->orWhere('users.email', 'like', '%' . $keyword . '%')
                                ->orWhere('professions.title', 'like', '%' . $keyword . '%')
                                ->groupBy('proposals.freelancer_id')
                                ->orderBy(DB::raw("COUNT('proposals.freelancer_id')"), 'DESC')
                                ->paginate(10)
                                ->setPath('');
                $pagination = $popularUsers->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else{
                $popularUsers = DB::table('proposals')
                                ->select(
                                    DB::raw("COUNT('proposals.freelancer_id') as count"), 
                                    DB::raw("MAX(CONCAT(users.first_name, ' ', users.last_name)) as full_name"), 
                                    DB::raw("MAX(users.email) as email"),
                                    DB::raw("MAX(professions.title) as profession")
                                )
                                ->join('users', 'proposals.freelancer_id', '=', 'users.id')
                                ->leftJoin('professions', 'users.profession_id', '=', 'professions.id')
                                ->groupBy('proposals.freelancer_id')
                                ->orderBy(DB::raw("COUNT('proposals.freelancer_id')"), 'DESC')
                                ->paginate(10)
                                ->setPath('');
            }
            
            if (file_exists(resource_path('views/extend/back-end/admin/analytics/popular-users.blade.php'))) {
                return view('extend.back-end.admin.analytics.popular-users', compact('popularUsers'));
            } else {
                return view('back-end.admin.analytics.popular-users', compact('popularUsers'));
            }
        } else {
            abort(404);
        }
    }

    public function growthActivity(Request $request){
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if(!empty($_GET['from']) && !empty($_GET['to'])) {
                $firstDate = date('Y-m-d', strtotime(str_replace('/', '-', ('01'.'/'.$_GET['from']))));
                $secondDate = date('Y-m-d', strtotime(str_replace('/', '-', ('01'.'/'.$_GET['to']))));
                $temp = $firstDate;
                if($firstDate > $secondDate){
                    $firstDate = $secondDate;
                    $secondDate = $temp;
                }

                $lastMonthTotalUsersCount = DB::table('users')
                                                ->where('created_at', '<=', date('Y-m-t 23:59:59', strtotime($firstDate)))
                                                ->get()
                                                ->count();
                $thisMonthTotalUsersCount = DB::table('users')
                                                ->where('created_at', '<=', date('Y-m-t 23:59:59', strtotime($secondDate)))
                                                ->get()
                                                ->count();
                $usersGrowthData['before'] = $lastMonthTotalUsersCount;
                $usersGrowthData['now'] = $thisMonthTotalUsersCount;
                $usersGrowthData['more'] = $thisMonthTotalUsersCount - $lastMonthTotalUsersCount;
                $usersGrowthData['percent'] = $lastMonthTotalUsersCount > 0 ? round((($thisMonthTotalUsersCount - $lastMonthTotalUsersCount) / $lastMonthTotalUsersCount) * 100, 2) : 0;

                $usersGrowth = DB::table('users')
                                    ->where('created_at', '>', date('Y-m-t 23:59:59', strtotime($firstDate)))
                                    ->where('created_at', '<=', date('Y-m-t 23:59:59', strtotime($secondDate)))
                                    ->get()->count();
                $newUsersData['more'] = $usersGrowth;

                $jobsGrowth = DB::table('jobs')
                                    ->where('created_at', '>', date('Y-m-t 23:59:59', strtotime($firstDate)))
                                    ->where('created_at', '<=', date('Y-m-t 23:59:59', strtotime($secondDate)))
                                    ->get()->count();
                $newJobsData['more'] = $jobsGrowth;

                $availabilitiesGrowth = DB::table('calendar_events')
                                            ->where('class', 'available_class')
                                            ->where('created_at', '>', date('Y-m-t 23:59:59', strtotime($firstDate)))
                                            ->where('created_at', '<=', date('Y-m-t 23:59:59', strtotime($secondDate)))
                                            ->get()->count();
                $newAvailabilitiesData['more'] = $availabilitiesGrowth;
            } else {
                $lastMonthTotalUsersCount = DB::table('users')
                                                ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime('last day of previous month')))
                                                ->get()
                                                ->count();
                $thisMonthTotalUsersCount = DB::table('users')
                                            ->get()
                                            ->count();
                $usersGrowthData['before'] = $lastMonthTotalUsersCount;
                $usersGrowthData['now'] = $thisMonthTotalUsersCount;
                $usersGrowthData['more'] = $thisMonthTotalUsersCount - $lastMonthTotalUsersCount;
                $usersGrowthData['percent'] = $lastMonthTotalUsersCount > 0 ? round((($thisMonthTotalUsersCount - $lastMonthTotalUsersCount) / $lastMonthTotalUsersCount) * 100, 2) : 0;

                $usersGrowth = DB::table('users')
                                        ->where('created_at', '>', date('Y-m-d 23:59:59', strtotime('last day of previous month')))
                                        ->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime('last day of this month')))
                                        ->get()
                                        ->count();
                $newUsersData['more'] = $usersGrowth;

                $jobsGrowth = DB::table('jobs')
                                        ->where('created_at', '>', date('Y-m-d 23:59:59', strtotime('last day of previous month')))
                                        ->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime('last day of this month')))
                                        ->get()
                                        ->count();
                $newJobsData['more'] = $jobsGrowth;

                $availabilityGrowth = DB::table('calendar_events')
                                        ->where('class', 'available_class')
                                        ->where('created_at', '>', date('Y-m-d 23:59:59', strtotime('last day of previous month')))
                                        ->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime('last day of this month')))
                                        ->get()
                                        ->count();
                $newAvailabilitiesData['more'] = $availabilityGrowth;
            }
            $activity['user_change'] = $newUsersData;
            $activity['job_change'] = $newJobsData;
            $activity['availability_change'] = $newAvailabilitiesData;
            $growth = $usersGrowthData;
            
            if (file_exists(resource_path('views/extend/back-end/admin/analytics/growth-activity.blade.php'))) {
                return view('extend.back-end.admin.analytics.growth-activity', compact('growth', 'activity'));
            } else {
                return view('back-end.admin.analytics.growth-activity', compact('growth', 'activity'));
            }
        } else {
            abort(404);
        }
    }

    public function internationalLocations(Request $request){
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                
                $internationalLocations = DB::table('users')
                                ->select(
                                    DB::raw("COUNT('country') as count"), 
                                    DB::raw("MAX('country') as country")
                                )
                                ->where('country', 'like', '%' . $keyword . '%')
                                ->where('country', '!=', null)
                                ->groupBy('country')
                                ->orderBy(DB::raw("COUNT('country')"), 'DESC')
                                ->paginate(10)
                                ->setPath('');
                $pagination = $internationalLocations->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else{
                $internationalLocations = DB::table('users')
                                ->select(
                                    DB::raw("COUNT('country') as count"), 
                                    DB::raw("MAX('country') as country")
                                )
                                ->where('country', '!=', null)
                                ->groupBy('country')
                                ->orderBy(DB::raw("COUNT('country')"), 'DESC')
                                ->paginate(10)
                                ->setPath('');
            }

            if (file_exists(resource_path('views/extend/back-end/admin/analytics/international-locations.blade.php'))) {
                return view('extend.back-end.admin.analytics.international-locations', compact('internationalLocations'));
            } else {
                return view('back-end.admin.analytics.international-locations', compact('internationalLocations'));
            }
        } else {
            abort(404);
        }
    }
}
