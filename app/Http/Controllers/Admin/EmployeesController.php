<?php /** @noinspection PhpUndefinedFieldInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateEmployeeRequest;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class EmployeesController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index() {
        return view('admin.employees.index', [
            'users' => User::employees()->whereHas('manager', function ($q) {
                $q->where('id', auth()->user()->id);
            })->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create() {
        return view('admin.employees.create', [
            'user' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\CreateEmployeeRequest $request
     * @return RedirectResponse
     */
    public function store(CreateEmployeeRequest $request): RedirectResponse {
        $employee = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        $employee->manager()->associate(auth()->user())->push();

        return redirect()->route('admin.employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user) {
        return view('admin.employees.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\UpdateEmployeeRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateEmployeeRequest $request, User $user): RedirectResponse {
        $user->name = $request['name'];
        $user->email = $request['email'];
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        $user->save();

        return redirect()->route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function destroy(User $user): RedirectResponse {
        $user->delete();
        return redirect()->route('admin.employees.index');
    }
}
