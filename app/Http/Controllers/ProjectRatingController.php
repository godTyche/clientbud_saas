<?php

namespace App\Http\Controllers;

use App\Events\NewProjectEvent;
use App\Helper\Reply;
use App\Http\Requests\Project\StoreRating;
use App\Models\ProjectRating;
use Illuminate\Http\Request;

class ProjectRatingController extends AccountBaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRating $request)
    {
        $addProjectRatingPermission = user()->permission('add_project_rating');
        abort_403(!in_array($addProjectRatingPermission, ['all', 'added', 'owned', 'both']));

        $rating = new ProjectRating();
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->user_id = $this->user->id;
        $rating->project_id = $request->project_id;
        $rating->added_by = user()->id;
        $rating->last_updated_by = user()->id;
        $rating->save();

        $members = $rating->project->projectMembers;

        event(new NewProjectEvent($rating->project, $members, 'ProjectRating'));

        return Reply::success(__('messages.recordSaved'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRating $request, $id)
    {

        $addProjectRatingPermission = user()->permission('edit_project_rating');
        abort_403(!in_array($addProjectRatingPermission, ['all', 'added', 'owned', 'both']));

        $rating = ProjectRating::findOrFail($id);
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->user_id = $this->user->id;
        $rating->project_id = $request->project_id;
        $rating->added_by = user()->id;
        $rating->last_updated_by = user()->id;
        $rating->save();

        return Reply::success(__('messages.updateSuccess'));

    }

}
