<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Subscriber;
use App\Models\Donation;
use App\Models\MerchSale;

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
        
        // Return the paginated result as JSON
        return response()->json($paginatedEvents);
    }
    
    public function markAsRead(Request $request, $id, $type)
    {
        // Find the event by its ID and type (follower, subscriber, donation, merch_sale)
        $event = null;
        switch ($type) {
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
                return response()->json(['error' => 'Invalid event type'], 400);
        }
        
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }
        
        // Mark it as read
        $event->is_read = true;
        
        // Save the changes
        $event->save();
        
        // Return a success response
        return response()->json(['message' => 'Event marked as read']);
    }
}