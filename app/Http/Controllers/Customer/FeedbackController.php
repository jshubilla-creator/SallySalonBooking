<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get completed appointments that don't have feedback yet
        $appointmentsWithoutFeedback = $user->appointments()
            ->where('status', 'completed')
            ->whereDoesntHave('feedback')
            ->with(['service', 'specialist'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        // Get existing feedback
        $existingFeedback = $user->feedback()
            ->with(['appointment.service', 'appointment.specialist'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.feedback.index', compact('appointmentsWithoutFeedback', 'existingFeedback'));
    }

    public function create(Appointment $appointment)
    {
        // Check if appointment exists
        if (!$appointment) {
            return redirect()->route('customer.feedback.index')
                ->with('error', 'Appointment not found.');
        }

        // Debug information
        \Log::info('Feedback create attempt', [
            'appointment_id' => $appointment->id,
            'appointment_user_id' => $appointment->user_id,
            'current_user_id' => Auth::id(),
            'current_user_name' => Auth::user()->name ?? 'Unknown'
        ]);

        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            \Log::error('Unauthorized feedback access attempt', [
                'appointment_id' => $appointment->id,
                'appointment_user_id' => $appointment->user_id,
                'current_user_id' => Auth::id()
            ]);
            abort(403, 'Unauthorized access to appointment.');
        }

        // Check if feedback already exists for this appointment
        if ($appointment->feedback()->exists()) {
            return redirect()->route('customer.feedback.index')
                ->with('error', 'Feedback already exists for this appointment.');
        }

        // Only allow feedback for completed appointments
        if ($appointment->status !== 'completed') {
            return redirect()->route('customer.feedback.index')
                ->with('error', 'You can only provide feedback for completed appointments.');
        }

        $appointment->load(['service', 'specialist']);

        return view('customer.feedback.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'type' => 'required|in:service,specialist,general',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to appointment.');
        }

        // Check if feedback already exists for this appointment
        if ($appointment->feedback()->exists()) {
            return back()->with('error', 'Feedback already exists for this appointment.');
        }

        // Only allow feedback for completed appointments
        if ($appointment->status !== 'completed') {
            return back()->with('error', 'You can only provide feedback for completed appointments.');
        }

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'appointment_id' => $appointment->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'type' => $request->type,
            'is_public' => true,
        ]);

        return redirect()->route('customer.feedback.index')
            ->with('success', 'Thank you for your feedback! Your review has been submitted successfully.');
    }

    public function edit(Feedback $feedback)
    {
        // Ensure the feedback belongs to the authenticated user
        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to feedback.');
        }

        $feedback->load(['appointment.service', 'appointment.specialist']);

        return view('customer.feedback.edit', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        // Ensure the feedback belongs to the authenticated user
        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to feedback.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'type' => 'required|in:service,specialist,general',
        ]);

        $feedback->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'type' => $request->type,
        ]);

        return redirect()->route('customer.feedback.index')
            ->with('success', 'Your feedback has been updated successfully.');
    }

    public function destroy(Feedback $feedback)
    {
        // Ensure the feedback belongs to the authenticated user
        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to feedback.');
        }

        $feedback->delete();

        return redirect()->route('customer.feedback.index')
            ->with('success', 'Your feedback has been deleted successfully.');
    }
}
