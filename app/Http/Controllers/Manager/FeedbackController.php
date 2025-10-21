<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with(['user', 'appointment']);

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating !== '') {
            $query->where('rating', $request->rating);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(10);
        $ratings = [1, 2, 3, 4, 5];
        $types = ['service', 'specialist', 'general'];

        return view('manager.feedback.index', compact('feedback', 'ratings', 'types'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['user', 'appointment.service', 'appointment.specialist']);
        return view('manager.feedback.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully.');
    }
}
