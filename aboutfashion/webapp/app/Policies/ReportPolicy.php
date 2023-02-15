<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use App\Models\Review;

use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy{
    use HandlesAuthorization;

    public function store(User $user, Review $review){
    // User can only give reports of reviews they don´t own
      if(Auth::check()){
        if($review->id_user == $user->id){
            return false;
        }
        return true;
      }
      return false;
    }

    public function update(User $user, Report $report){
      // Users can only update reports they own
      if(Auth::check()){
        return $user->id == $report->id_user;
      }
    }

    public function delete(User $user, Review $report){
      // Users can only delete reports they own
      if(Auth::check()){
        return $user->id == $report->id_user;
      }
    }
}