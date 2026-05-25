<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    private string $apiUrl = "http://127.0.0.1:8000/api/services";

    public function index(Request $request): View
    {
        $query = [];
        if ($request->has("status")) {
            $query["status"] = $request->query("status");
        }

        $response = Http::get($this->apiUrl, $query);
        $services = $response->successful() ? $response->json("data") : [];

        return view("services.index", ["active" => "services", "services" => $services]);
    }

    public function store(Request $request): RedirectResponse
    {
        $response = Http::post($this->apiUrl, [
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "status" => $request->status === "active",
        ]);

        if ($response->successful()) {
            return redirect()
                ->route("services.index")
                ->with("toast_success", $response->json("message"));
        }

        if ($response->status() === 422) {
            return back()
                ->withErrors($response->json("errors"))
                ->withInput()
                ->with("toast_error", $response->json("message"))
                ->with("open_modal", "addDataModal");
        }

        return back()
            ->withInput()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to create service."
                );
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}", [
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "status" => $request->status === "active",
        ]);

        if ($response->successful()) {
            return redirect()
                ->route("services.index")
                ->with("toast_success", $response->json("message"));
        }

        if ($response->status() === 422) {
            return back()
                ->withErrors($response->json("errors"))
                ->withInput()
                ->with("toast_error", $response->json("message") ?? "Failed to update service.")
                ->with("open_modal", "editDataModal-{$id}")
                ->with("edit_service_id", $id);
        }

        return back()
            ->withInput()
            ->with("toast_error", $response->json("message") ?? "Failed to update service.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return redirect()
                ->route("services.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()->with(
            "toast_error",
            $response->json("message") ?? "Failed to delete service."
        );
    }

    public function activate(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/activate");

        if ($response->successful()) {
            return redirect()
                ->route("services.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()->with(
            "toast_error",
            $response->json("message") ?? "Failed to activate service."
        );
    }

    public function deactivate(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()
                ->route("services.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()->with(
            "toast_error",
            $response->json("message") ?? "Failed to deactivate service."
        );
    }
}