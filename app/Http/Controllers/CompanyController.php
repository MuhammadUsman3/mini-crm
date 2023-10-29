<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use App\Mail\NewCompanyNotification;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @var \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        // Retrieve all companies using Eloquent ORM
        $companies = Company::all();

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(CompanyResource::collection($companies));
        } else {
            // Render the HTML view for non-API requests
            return view('companies.index', compact('companies'));
        }
    }

    /**
     * Display the company creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Render the view for creating a new company
        return view('companies.create');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param  \App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        // Create a new instance of the Company model
        $company = new Company();

        // Populate the company model with data from the request
        $company->name = $request->name;
        $company->email = $request->email;

        // skip image uploading on store when request from api
        if (!$request->expectsJson()) {
            // Store the uploaded logo image in the "public" storage disk
            $imagePath = $request->file('logo')->store('public');
            $company->logo = $imagePath;
        }

        // Set the company's website from the request
        $company->website = $request->website;

        // Save the company to the database
        $company->save();

        // Send a notification email to the company's email address
        Mail::to($request->email)->send(new NewCompanyNotification($company));

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Company created successfully', 'Company' => CompanyResource::make($company)], 201);
        } else {
            // Redirect to the index page for companies
            return redirect()->route('companies.index');
        }
    }

    /**
     * Display the details of a specific company.
     *
     * @param  \App\Models\Company  $company
     * @var \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Request $request)
    {
        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(CompanyResource::make($company));
        } else {
            // Load the 'companies.show' view and pass the 'company' variable to it
            return view('companies.show', compact('company'));
        }
    }

    /**
     * Display the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        // Check if the company exists
        if (!$company) {
            // Redirect to a 404 page or display an error message
            return abort(404);
        }

        // Load the 'companies.edit' view and pass the 'company' variable to it
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        // Update the company properties with values from the request
        $company->name = $request->input('name');
        $company->email = $request->input('email');

        // skip image uploading on update when request from api
        if (!$request->expectsJson()) {
            // Store the uploaded logo in the 'public' storage disk
            $imagePath = $request->file('logo')->store('public');

            // Update the company's logo property with the image path
            $company->logo = $imagePath;
        }
        $company->website = $request->input('website');

        // Save the updated company information to the database
        $company->save();

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Company updated successfully', 'Company' => CompanyResource::make($company)], 201);
        } else {
            // Redirect to the index page for companies
            return redirect()->route('companies.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        // Delete the company from the database
        $company->delete();

        // Redirect to the 'companies.index' route with a success message
        return redirect()->route('companies.index')->withSuccess(__('Company deleted successfully.'));
    }

    /**
     * Upload a company's logo image.
     *
     * @param Company $company
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageUpload(Company $company, Request $request)
    {
        // Validate the uploaded logo image
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);

        // Store the uploaded logo image in the "public" storage disk
        $imagePath = $request->file('logo')->store('public');

        // Update the company's logo with the image path
        $company->logo = $imagePath;
        $company->save();

        return response()->json([
            'message' => 'Company logo updated successfully',
            'Company' => CompanyResource::make($company)
        ], 201);
    }
}
