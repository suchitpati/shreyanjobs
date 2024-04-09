<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\consultantas;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use Illuminate\Support\Facades\Hash;

class consultantsController extends Controller
{
    public function addConsultantsDetails(Request $request){


        if ($request->file('resume')) {

            $allowedExtensions = ['pdf', 'doc', 'docx'];
            // $maxFileSize = 3 * 1024;

            if (in_array($request->file('resume')->getClientOriginalExtension(), $allowedExtensions)) {
                $fileName = time() . '.' . $request->file('resume')->getClientOriginalExtension();
                $request->file('resume')->move(public_path('pdf'), $fileName);
            } else {
                return response()->json([
                    'message' => 'Only PDF and DOC files are allowed, and the file must be less than 3MB.',
                    'error' => 100,
                ]);
            }



        $Constant = consultantas::create([
            'fullname' => $request->fullname,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'work_authorization' => $request->work_authorization,
            'relocate' => $request->relocate,
            'primary_skill' => $request->primary_skill,
            'primary_skill_experience' => $request->primary_skill_experience,
            'secondary_skill'=>$request->secondary_skill,
            'secondary_skill_experience'=>$request->secondary_skill_experience,
            'resume'=>$fileName,
            'is_active' => 1,
            'new_job_report_time'=>$request->new_job_report_time
        ]);


        return response()->json([
            'message' => 'Details added successfully',
            'success' => 200,
            'employer_id' => $Constant->id

        ]);
    } else {
        return response()->json([
            'message' => 'No Resume file provided',
            'error' => 100,
        ]);
    }

    }
    public function updateConsultantsDetails(Request $request, $id){
        $Constant = consultantas::find($id);
        if(!$Constant){
            return response()->json([
                'message' => 'Consultant not found',
                'error' => 404
            ], 404);
        }

        $Constant->update([
            'fullname' => $request->fullname,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'work_authorization' => $request->work_authorization,
            'relocate' => $request->relocate,
            'primary_skill' => $request->primary_skill,
            'primary_skill_experience' => $request->primary_skill_experience,
            'secondary_skill'=>$request->secondary_skill,
            'secondary_skill_experience'=>$request->secondary_skill_experience,
            'resume'=>$request->resume,
            'is_active' => $request->is_active,
            'new_job_report_time'=>$request->new_job_report_time
        ]);

        return response()->json([
            'message' => 'Details updated successfully',
            'success' => 200,
            'employer_id' => $Constant->id
        ]);
    }

    public function deleteConsultantsDetails($id){
        $Constant = consultantas::find($id);
        if(!$Constant){
            return response()->json([
                'message' => 'Consultant not found',
                'error' => 404
            ], 404);
        }

        $Constant->delete();

        return response()->json([
            'message' => 'Details deleted successfully',
            'success' => 200,
            'employer_id' => $id
        ]);

    }

    public function consultantDetails(Request $request)
    {
        $consultantas = consultantas::find($request->consultants_id);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'consultant_details' => $consultantas
        ]);
    }

    public function getAllConsultants(Request $request)
    {
        $consultantas = consultantas::all();
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'consultant_details' => $consultantas
        ]);
    }

}

