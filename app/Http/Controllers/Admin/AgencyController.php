<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgencyController extends Controller
{
    public function index(): View
    {
        return view('admin.agencies.index', [
            'agencies' => Agency::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Agency::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return back();
    }

    public function show(Agency $agency): View
    {
        return view('admin.agencies.show', ['agency' => $agency]);
    }

    public function update(Request $request, Agency $agency): RedirectResponse
    {
        $agency->update($request->all());

        return back();
    }

    public function destroy(Agency $agency): RedirectResponse
    {
        $agency->delete();

        return back();
    }
}
