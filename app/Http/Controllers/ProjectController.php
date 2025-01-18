<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;

class ProjectController extends Controller
{
    public function dashboard()
    {
        $projects = Project::with('images')->get(); // Eager load images
        return view('dashboard', compact('projects'));
    }


    public function store(Request $request)
    {
        // Validate input
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'images.*' => 'nullable|image|max:2048', // Validate multiple images
        ]);

        // Create project
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        // Handle file uploads for multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects', 'public');
                $project->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Project added successfully!');
    }

    public function destroy(Project $project)
    {
        // Delete associated images
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path); // Delete the image file
            $image->delete(); // Delete the image record
        }

        // Delete the project record
        $project->delete();

        return redirect()->route('dashboard')->with('destroy', 'Project removed successfully!');
    }

    public function edit(Project $project)
    {
        return view('edit-project', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        try {
            // Debug incoming request data
            logger('Update Request Data: ', $request->all());
    
            // Validate the input
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'nullable|string',
                'images.*' => 'nullable|image|max:2048',
            ]);
    
            // Update project details
            $project->update([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
            ]);
    
            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('projects', 'public');
                    $project->images()->create(['path' => $path]);
                }
            }
    
            // Handle image removal
            if ($request->input('remove_images')) {
                $imageIdsToRemove = $request->input('remove_images');
                foreach ($imageIdsToRemove as $imageId) {
                    $image = $project->images()->find($imageId);
                    if ($image) {
                        \Storage::disk('public')->delete($image->path);
                        $image->delete();
                    }
                }
            }
    
            return redirect()->route('dashboard')->with('update', 'Project updated successfully!');
        } catch (\Exception $e) {
            logger('Update Error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Failed to update the project.');
        }
    }
        
                
    public function portfolio(Project $project)
    {
        $project->load('images'); // Load related images
        return view('portfolio', compact('project'));
    }
    
}
