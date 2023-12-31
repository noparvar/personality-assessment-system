<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Questionnaire;
use App\Submit;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class QuestionnairesController extends Controller
{
    /**
     * Display the questionnaire and handle submissions.
     *
     * @param Questionnaire $questionnaire
     * @param Submit $submit
     * @return View|RedirectResponse
     */
    public function show(Questionnaire $questionnaire, Submit $submit)
    {
        $user = auth()->user();

        if ($submit->isPaid()) {
            if (!empty($submit->submit_data)) {
                return redirect(route('front.user.dashboard'))->with('error', __('The desired test has already been completed.'));
            } else {
                return view('front.questionnaire.show', compact('questionnaire', 'submit'));
            }
        }

        return redirect()->route('front.payment.factor', $questionnaire);
    }

    /**
     * Submit the questionnaire.
     *
     * @param Questionnaire $questionnaire
     * @param Submit $submit
     * @return RedirectResponse
     */
    public function submit(Questionnaire $questionnaire, Submit $submit): RedirectResponse
    {
        $user = auth()->user();

        if (!$questionnaire->canSubmit($user, $submit)) {
            return redirect(route('front.user.dashboard'))->with('error', __('You are not authorized to complete this test.'));
        }

        if (!empty($submit->submit_data)) {
            return redirect(route('front.user.dashboard'))->with('error', __('The desired test has already been completed.'));
        }

        // Save data
        $submit->update([
            'submit_data' => request()->except('_token'),
            'submit_at' => Carbon::now(),
        ]);

        // Save person type
        $personType = correction($submit);
        $submit->update([
            'person_type' => $personType,
        ]);

        // Redirect to the report page
        return redirect(route('front.questionnaire.report', [$questionnaire, $submit]));
    }

    /**
     * Display the report.
     *
     * @param Questionnaire $questionnaire
     * @param Submit $submit
     * @return Response|RedirectResponse
     */
    public function report(Questionnaire $questionnaire, Submit $submit)
    {
        $user = auth()->user();

        if ($questionnaire->id == $submit->questionnaire_id && $user->id == $submit->user_id && $submit->isSubmited()) {
            // Generate and render the PDF report
            return renderPDF($submit);
        }

        return redirect(route('front.user.dashboard'))->with('error', __('You are not authorized to view this report.'));
    }
}
