<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpeakerRequest;
use App\Http\Requests\UpdateSpeakerRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\ShowSpeakerResource;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\User;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $speakers = Speaker::all();

        return response([
            'speakers' => SpeakerResource::collection($speakers),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpeakerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpeakerRequest $request, Speaker $speaker)
    {
        // $speakerData = array_filter($request->all(), function ($key) use ($speaker) {
        //     return $speaker->fillable($key);
        // }, ARRAY_FILTER_USE_KEY);

        $speaker->update($request->except('image'));
        if(isset($request->image))
            $speaker->updateImage($request->image);
        $user=$speaker->user;
        $user->update(['name'=>$request->name]);
        return response(['notify'=>'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speaker $speaker)
    {
        //
    }
    public function speakerInfo(User $user)
    {

        return response([
            'speaker' => new ShowSpeakerResource($user->speaker)
            // 'events' => EventResource::collection($user->speaker->events->whereNotNull('published_at')),
        ]);

    }
}
