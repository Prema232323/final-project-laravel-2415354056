<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Enum;
use App\enums\SubscriptionStatus;

class SubscriptionController extends Controller
{
    private string $apiUrl = "http://127.0.0.1:8000/api/subscriptions";
    private string $customerApiUrl = "http://127.0.0.1:8000/api/customers";
    private string $serviceApiUrl = "http://127.0.0.1:8000/api/services";

    public function index(Request $request): View
    {
        $response = Http::get($this->apiUrl);
        $subscriptions = $response->successful() ? $response->json("data") : [];

        $customerResponse = Http::get($this->customerApiUrl, ["status" => "active"]);
        $customers = $customerResponse->successful() ? $customerResponse->json("data") : [];

        $serviceResponse = Http::get($this->serviceApiUrl, ["status" => "active"]);
        $services = $serviceResponse->successful() ? $serviceResponse->json("data") : [];

        return view("subscriptions.index", ["active" => "subscriptions", "subscriptions" => $subscriptions, "customers" => $customers, "services" => $services]);
    }

    public function store(Request $request): RedirectResponse
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        if ($startDate && str_contains($startDate, "T")) {
            $part = explode("/", $startDate);
            $startDate = $part[2] . "-" . $part[1] . "-" . $part[0];
        }
        if ($endDate && str_contains($endDate, "T")) {
            $part = explode("/", $endDate);
            $endDate = $part[2] . "-" . $part[1] . "-" . $part[0];
        }

        $response = Http::post($this->apiUrl, [
            "customer_id" => $request->customer_id,
            "service_id" => $request->service_id,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "status" => $request->status,
        ]);

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
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
                $response->json("message")?? "Failed to create subscription."
                );
    }

    public function activate(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/activate");

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to activate subscription."
                );
    }

    public function deactivate(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to deactivate subscription."
                );
    }

    public function trial(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/trial");

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to set subscription to trial."
                );
    }

    public function isolir(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/isolir");

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to isolir subscription."
                );
    }

    public function dismantle(int $id): RedirectResponse
    {
        $response = Http::patch("{$this->apiUrl}/{$id}/dismantle");

        if ($response->successful()) {
            return redirect()
                ->route("subscriptions.index")
                ->with("toast_success", $response->json("message"));
        }

        return back()
            ->with(
                "toast_error", 
                $response->json("message")?? "Failed to dismantle subscription."
                );
    }
}