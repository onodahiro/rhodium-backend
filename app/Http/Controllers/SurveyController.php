<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\TestSurvey;

class SurveyController extends Controller
{
    public function saveAnswer(Request $request) {
        $survey = new TestSurvey;
        $survey->text = $request->text;
        $survey->save();

        return 'sucsess';
    }
}
