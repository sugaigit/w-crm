<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\User;
use App\Models\Customer;
use App\Models\ActivityRecord;
use Auth;

class ActivityRecordController extends Controller
{
    public function edit(Request $request, $activityRecordId)
    {
        $activityRecord = ActivityRecord::find($activityRecordId);
        $activityRecordJobOfferId = jobOffer::find($activityRecord->job_offer_id)->id;

        return view('activity_records.edit', [
            'activityRecord' => $activityRecord,
            'activityRecordJobOfferId' => $activityRecordJobOfferId
        ]);
    }

    public function update(Request $request, $activityRecordId)
    {
        $request->validate([
            'date' => ['required'],
            'item' => ['required'],
        ]);
        $activityRecord = ActivityRecord::find($activityRecordId);

        $activityRecord->date = $request->input('date');
        $activityRecord->item = $request->input('item');
        $activityRecord->detail = $request->input('detail');

        $activityRecord->save();

        $jobOffer = JobOffer::find($request->job_offer_id);
        $users = User::all();
        $customers = Customer::all();
        $activityRecords = $jobOffer->activityRecords;

        $differentUserAlert = false;
        if (Auth::id() != $jobOffer->user->id) {
            $differentUserAlert = true;
            \Session::flash('AlertMsg', '警告：データーベースに登録されている営業担当とログインユーザーが一致しません');
        }

        return view('job_offers.detail', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
            'activityRecords' => $activityRecords,
            'isDraftJobOffer' => false,
            'differentUserAlert' => $differentUserAlert,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $activityRecord = ActivityRecord::findOrFail($id);
        $activityRecord->delete();

        \Session::flash('SucccessMsg', '削除しました');

        return redirect(route('job_offers.detail', $request->jobOfferId));
    }

}

