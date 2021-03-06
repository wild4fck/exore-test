<?php
/** @noinspection DuplicatedCode */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRecordRequest;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Record;
use App\Models\User;
use App\Services\RecordsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecordsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View
     * @noinspection PhpUndefinedFieldInspection
     */
    public function index() {
        return view('admin.records.index', [
            'records' => Record::with(['category', 'author'])
                ->whereHas('author', function ($q) {
                    $q->where('id', auth()->user()->id)
                        ->orWhereIn('id', array_column(auth()->user()->myEmployees->toArray(), 'id'));
                })
                ->paginate(10)
        ]);
    }

    /**
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @noinspection PhpUndefinedFieldInspection
     */
    public function indexByCategory(Category $category) {
        return view('admin.records.index', [
            'postfix' => 'of ' . $category->name,
            'records' => Record::with(['category', 'author'])
                ->whereHas('category', function ($q) use ($category) {
                    $q->where('id', $category->id);
                })
                ->whereHas('author', function ($q) {
                    $q->where('id', auth()->user()->id)
                        ->orWhereIn('id', array_column(auth()->user()->myEmployees->toArray(), 'id'));
                })
                ->paginate(10)
        ]);
    }

    /**&
     * @param \App\Models\User $author
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @noinspection PhpUndefinedFieldInspection
     */
    public function indexByAuthor(User $author) {
        $this->authorize('view-by-author', $author);

        if ($author->id === auth()->user()->id) {
            return redirect(route('admin.records.index'));
        }

        return view('admin.records.index', [
            'postfix' => 'by ' . $author->name,
            'records' => Record::with(['category', 'author'])
                ->whereHas('author', function ($q) use ($author) {
                    $q->where('id', $author->id);
                })->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function create() {
        return view('admin.records.create', [
            'record' => [],
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\CreateRecordRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(CreateRecordRequest $request): RedirectResponse {
        $gallery = Gallery::create();

        $record = Record::create([
            'name' => $request['name']
        ]);

        $record->category()->associate(Category::find($request['category_id']))->push();
        $record->gallery()->associate($gallery)->push();
        $record->author()->associate(auth()->user())->push();

        RecordsService::afterCreateRecord($request, $gallery);

        return redirect()->route('admin.records.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Record $record
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Record $record) {
        $this->authorize('view', $record);

        return view('admin.records.show', [
            'record' => $record
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Record $record
     * @return Application|\Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Record $record) {
        $this->authorize('update', $record);
        return view('admin.records.edit', [
            'record' => $record,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Record $record
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function update(Request $request, Record $record): RedirectResponse {
        $this->authorize('update', $record);

        $lastImages = RecordsService::beforeUpdateRecord($request, $record);

        $record->update([
            'name' => $request['name']
        ]);

        $record->category()->associate(Category::find($request['category_id']))->push();

        if ($lastImages) {
            RecordsService::afterUpdateRecord($lastImages);
        }

        return redirect()->route('admin.records.edit', $record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Record $record
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Record $record): RedirectResponse {
        $this->authorize('delete', $record);

        $record->delete();
        RecordsService::afterDeleteRecord($record);

        return redirect()->route('admin.records.index');
    }
}
