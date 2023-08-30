<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Subscriber;
use App\Models\Donation;
use App\Models\MerchSale;
use Carbon\Carbon;

class StreamEventsController extends Controller
{
    public function getEvents(Request $request)
    {
        // Fetch events from 'followers', 'subscribers', 'donations', 'merch_sales'
        $followers = Follower::all();
        $subscribers = Subscriber::all();
        $donations = Donation::all();
        $merchSales = MerchSale::all();

        // Combine them into a single list
        $events = $followers->concat($subscribers)->concat($donations)->concat($merchSales);

        // Sort them by creation date
        $sortedEvents = $events->sortByDesc('created_at');

        // Paginate the result (e.g., 100 per page)
        $paginatedEvents = $sortedEvents->paginate(100);

        return response()->json($paginatedEvents);
    }
    
    public function markAsRead(Request $request, $id, $type)
    {
        // Find the event by its ID and type
        $event = null;
        switch($type) {
            case 'follower':
                $event = Follower::find($id);
                break;
            case 'subscriber':
                $event = Subscriber::find($id);
                break;
            case 'donation':
                $event = Donation::find($id);
                break;
            case 'merchSale':
                $event = MerchSale::find($id);
                break;
        }

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Mark it as read
        $event->is_read = true;
        
        // Save the changes
        $event->save();

        return response()->json(['message' => 'Marked as read']);
    }
}