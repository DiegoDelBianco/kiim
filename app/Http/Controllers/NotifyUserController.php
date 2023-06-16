<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotifyUserRequest;
use App\Http\Requests\UpdateNotifyUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\NotifyUser;
use App\Models\Customer;
use App\Models\CustomerService;

class NotifyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotifyUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NotifyUser $notifyUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotifyUser $notifyUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotifyUserRequest $request, NotifyUser $notifyUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotifyUser $notifyUser)
    {
        //
    }




    /**
     * Get the new notification data for the navbar notification.
     *
     * @param Request $request
     * @return Array
     */
    public function getNotificationsData(Request $request)
    {
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.

        $notifications = [
            [
                'icon' => 'fas fa-fw fa-envelope',
                'text' => rand(0, 10) . ' new messages',
                'time' => rand(0, 10) . ' minutes',
            ],
            [
                'icon' => 'fas fa-fw fa-users text-primary',
                'text' => rand(0, 10) . ' friend requests',
                'time' => rand(0, 60) . ' minutes',
            ],
            [
                'icon' => 'fas fa-fw fa-file text-danger',
                'text' => rand(0, 10) . ' new reports',
                'time' => rand(0, 60) . ' minutes',
            ],
        ];

        // Now, we create the notification dropdown main content.

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                       {$not['time']}
                     </span>";

            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}{$not['text']}{$time}
                              </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function getLabelMenu(){
        $customers = 0;
        $customers_services = 0;
        $customers_services_remarketing = 0;

        if( Auth::user()->hasRole('Master') ){
            $customers = Customer::where('tenancy_id', Auth::user()->tenancy_id)->count();
        }elseif( Auth::user()->hasRole('Gerente') ){
            $customers = Customer::where('tenancy_id', Auth::user()->tenancy_id)->where('team_id', Auth::user()->team_id)->count();
        }else
            $customers = Customer::where('tenancy_id', Auth::user()->tenancy_id)->where('user_id', Auth::user()->id)->count();

        $customers_services = Customer::countQueueByUser();
        $customers_services_remarketing = Customer::countRemarketingByUser();

        return json_encode([
            'status'   => 'success',
            'data'     => [
                'customers' => $customers,
                'customers_services' => $customers_services,
                'customers_services_remarketing' => $customers_services_remarketing,
            ]
        ]);
    }
}
