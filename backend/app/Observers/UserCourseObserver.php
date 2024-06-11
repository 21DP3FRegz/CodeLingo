<?php

namespace App\Observers;

use App\Models\UserCourse;
use App\Models\User;

class UserCourseObserver
{
    /**
     * Handle the UserCourse "created" event.
     */
    public function created(UserCourse $userCourse): void
    {
        //
    }

    /**
     * Handle the UserCourse "updated" event.
     */
    public function updated(UserCourse $userCourse): void
    {
        $user = $userCourse->user;
        $pointsToAdd = 10;
        $user->increment('points', $pointsToAdd);
    }

    /**
     * Handle the UserCourse "deleted" event.
     */
    public function deleted(UserCourse $userCourse): void
    {
        //
    }

    /**
     * Handle the UserCourse "restored" event.
     */
    public function restored(UserCourse $userCourse): void
    {
        //
    }

    /**
     * Handle the UserCourse "force deleted" event.
     */
    public function forceDeleted(UserCourse $userCourse): void
    {
        //
    }
}
