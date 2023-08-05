<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventShowResource;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::published()->available()->paginate(1);
        // $events=Event::whereNotNull('published_at')->where('date','>',Carbon::now())->get();
        return ['events' => EventResource::collection($events)->response()->getData()]; //
    }

    public function show(Event $event)
    {
        return response(['event' => new EventResource($event)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
        $event = Event::create($request->except('image'));
        $event->attachImage($request->image);
        return response(['notify' => 'created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        return $request->all();
        $event->update($request->except('image'));
        if ($request->image != null) {
            $event->updateImage($request->image);
        }

        return response(['notify' => 'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Storage::delete($event->image);
        $event->delete();
        return response(['notify' => 'deleted successfully'], Response::HTTP_NO_CONTENT);
    }
    public function all()
    {
        $events = Event::all();
        return ['events' => $events];
    }
    public function search($searchKey)
    {
        // $search=$request->query('searchKey');
        // Log::info($request->all());
        $events = Event::published()->available()->where('name', 'like', '%' . $searchKey . '%')->paginate(10);
        // return response(['k'=>$searchKey]);
        return response(['events' => EventResource::collection($events)->response()->getData()]);
    }
    public function getCategories()
    {
        // with this query there will be error because were using order by to get latest and we are only selecting category
        // but order by use created at so wrong like this
        // $categories=Event::select('category')->distinct()->latest()->paginate(10);
        // correction
        // $categories=Event::select('category','created_at')->distinct()->latest()->paginate(10);
        $categories=Event::latest()->select('category')->paginate(10);
        return response(['categories'=>$categories]);
    }
    public function getEventsByTime($time)
    {

        $events = '';
        if ($time) {
            if ($time == 'today') {
                $events = Event::published()->available()->whereBetween('date', [Carbon::today(), Carbon::tomorrow()])->paginate(1);
            } else if ($time == 'tomorrow') {
                $events = Event::published()->available()->where('date', Carbon::tomorrow())->paginate(10);
            } else if ($time == 'nextWeek') {
                $events = Event::published()->available()->whereBetween('date', [Carbon::today(), Carbon::today()->addDays(7)])->paginate(1);
            } else if ($time == 'nextMonth') {
                $events = Event::published()->available()->whereBetween('date', [Carbon::today(), Carbon::today()->addMonth()])->paginate(1);
            }
        } else {
            return response('', Response::HTTP_NO_CONTENT);
        }
        return response(['events' => EventResource::collection($events)->response()->getData()]);
    }

    public function myEvents()
    {
        return response([
            'events' => EventResource::collection(auth()->user()->speaker->events),
        ]);
    }
    public function getEventInfo(Event $event)
    {
        $event->load('comments');
        $id = $event->speaker->user_id;
        $speaker = User::whereId($id)->first();
        $event->speaker_name = $speaker->name;
        $event->speaker_slug = $speaker->slug;
        return response(['event' => new EventShowResource($event)]);
    }
    public function getEventsByCategory($category)
    {
        $events = Event::published()->available()->where('category', $category)->paginate(10);
        return response(['events' => EventResource::collection($events)->response()->getData()]);
    }
    // search event for speaker in  speaker dashboard
    public function speakerEventSearch($searchKey)
    {
        $id = auth()->user()->speaker->id;
        $events = Event::where('name', 'like', '%' . $searchKey . '%')->where('speaker_id', $id)->paginate(10);
        return response(['events' => EventResource::collection($events)->response()->getData()]);
    }
}
