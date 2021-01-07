<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectResourceCollection;
use App\Models\Project;
use function auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{

    public function index() :JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            'fetched successfully',
            new ProjectResourceCollection(Project::all())
        );
    }

    public function store(Request $request) :JsonResponse
    {
        $request->validate([
            'name'=>['required'],
            'description'=>['nullable'],
        ], $request->all());

      Project::create([
          'name'=>$request->name,
          'description'=>$request->description??null,
          'user_id'=>auth()->id()
      ]);

      return $this->response(Response::HTTP_CREATED, 'created successfully');
    }

    public function show(Project $project) :JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            'success',
            [ 'project' => new ProjectResource($project)]
        );
    }

    public function update(Request $request, Project $project) :JsonResponse
    {
        $project->update($request->only(['name', 'description']));

        return $this->response(
            Response::HTTP_OK,
            'updated successfully',
            [ 'project' => new ProjectResource($project->refresh())]
        );
    }

    public function destroy(Project $project) :JsonResponse
    {
        $project->delete();

        return $this->response(
            Response::HTTP_OK,
            'archived successfully'
        );
    }
}
