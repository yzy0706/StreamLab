<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Subscriber;
use App\Models\Donation;
use App\Models\MerchSale;
use Illuminate\Support\Facades\DB;

class StreamEventsController extends Controller
{
    public function getEvents(Request $request)
    {
        // Fetch events from 'followers', 'subscribers', 'donations', 'merch_sales'
        $followers = Follower::select('name', 'created_at', DB::raw("'follower' as event_type"))->get();
        $subscribers = Subscriber::select('name', 'subscription_tier', 'created_at', DB::raw("'subscriber' as event_type"))->get();
        $donations = Donation::select('amount', 'currency', 'donation_message', 'created_at', DB::raw("'donation' as event_type"))->get();
        $merchSales = MerchSale::select('item_name', 'amount', 'price', 'created_at', DB::raw("'merch_sale' as event_type"))->get();

        // Combine them into a single list
        $events = $followers->concat($subscribers)->concat($donations)->concat($merchSales);

        // Sort them by creation date
        $sortedEvents = $events->sortByDesc('created_at');

        // Paginate the result (e.g., 100 per page)
        $paginatedEvents = $sortedEvents->paginate(100);

        // Return the paginated result as JSON
        return response()->json($paginatedEvents);
    }

    public function markAsRead(Request $request, $id, $eventType)
    {
        // Mark event as read based on its type and ID
        switch($eventType) {
            case 'follower':
                $event = Follower::find($id);
                break;
            case 'subscriber':
                $event = Subscriber::find($id);
                break;
            case 'donation':
                $event = Donation::find($id);
                break;
            case 'merch_sale':
                $event = MerchSale::find($id);
                break;
            default:
                return response()->json(['message' => 'Invalid event type'], 400);
        }

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Mark the event as read
        $event->is_read = true;

        // Save the changes
        $event->save();

        // Return a success response
        return response()->json(['message' => 'Event marked as read']);
    }
}