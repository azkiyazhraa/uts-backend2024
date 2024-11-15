<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlumniController extends Controller
{
    public function index()
    {
        $data = Alumni::all();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data is empty',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Get All Resources',
                'data' => $data,
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'graduation_year' => 'required',
            'status' => 'required',
            'company_name' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        $alumni = Alumni::create($validator->validated());

        return response()->json([
            'message' => 'Resource added successfully',
            'data' => $alumni,
        ], 201);
    }


    public function show($id)
    {
        $data = Alumni::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        } else {
            return response()->json([
                'message' => 'Get Detail Resource',
                'data' => $data,
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'graduation_year' => 'required',
            'status' => 'required',
            'company_name' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        $alumni->update($validator->validated());

        return response()->json([
            'message' => 'Resource updated successfully',
            'data' => $alumni,
        ], 200);
    }


    public function destroy($id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        $alumni->delete();

        return response()->json([
            'message' => 'Resource is deleted successfully',
        ], 200);
    }

    public function search($name)
    {
        $alumni = Alumni::where('name', 'like', '%' . $name . '%')->get();

        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Get searched resource',
            'data' => $alumni,
        ], 200);
    }

    public function freshgraduate()
    {
        $alumni = Alumni::where('graduation_year', '<=', date('Y'))->get();

        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'No fresh graduates found',
            ], 404);
        }

        $total = $alumni->count();

        return response()->json([
            'message' => 'Get fresh graduate resources',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }


    public function employed()
    {
        $alumni = Alumni::where('status', 'employed')->get();

        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        $total = $alumni->count();

        return response()->json([
            'message' => 'Get employed resource',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }

    public function unemployed()
    {
        $alumni = Alumni::where('status', 'unemployed')->get();

        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        $total = $alumni->count();

        return response()->json([
            'message' => 'Get unemployed resource',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }
}
