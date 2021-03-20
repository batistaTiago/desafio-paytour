<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitJobEntryRequest;
use App\Models\JobEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobEntryController extends Controller
{

    public function index(Request $request)
    {
        $school_levels = JobEntry::SCHOOL_LEVELS;
        return view('job_entry_form', compact('school_levels'));
    }

    public function store(SubmitJobEntryRequest $request)
    {
        
        $data = $request->validated();
        $data['ip'] = $request->ip();
        
        JobEntry::createAndSendMail($data);

        flash('Sua candidatura foi enviada com sucesso')->success();
        return redirect()->back();
    }
}
