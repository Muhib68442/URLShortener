<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{

    // REDIRECT 
    public function redirect($short_code)
    {
        $url = Url::where('short_code', $short_code)->first();

        // URL Not found
        if (!$url) {
            return response()->json([
                'message' => 'URL not found',
            ], 404);
        }

        // Expired url
        if ($url->expires_at && $url->expires_at->isPast()) {
            return response()->json([
                'message' => 'URL expired',
            ], 410);
        }

        $url->incrementClicks();

        return redirect()->away($url->original_url);
        // NOTE: By-default 302
    }

    // LIST URLS [GET]
    public function list_urls()
    {
        $urls = Url::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'message' => 'List of URLs registered with ' . auth()->user()->email,
            'urls' => $urls,
            'count' => $urls->count(),
        ], 200);
    }

    // CREATE URL [POST]
    public function create_url(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        $url = new Url();
        $url->user_id = auth()->user()->id;
        $url->original_url = $request->original_url;
        $url->save();

        return response()->json([
            'message' => 'URL created successfully',
            'url' => $url,
            'url_registered_with' => auth()->user()->email
        ], 201);
    }

    // VIEW URL [GET]
    public function view_url($url)
    {
        $url = Url::where('short_code', $url)->where('user_id', auth()->user()->id)->first();
        if (!$url) {
            return response()->json([
                'message' => 'URL not found',
            ]);
        }

        return response()->json([
            'message' => 'URL details',
            'url_registered_with' => auth()->user()->email,
            'original_url' => $url->original_url,
            'short_code' => $url->short_code,
            'count' => $url->clicks,
            'expires_at' => $url->expires_at,
            'created_at' => $url->created_at,
            'updated_at' => $url->updated_at
        ], 200);
    }

    // UPDATE URL [PATCH]
    public function update_url(Request $request, $url)
    {
        $request->validate([
            'original_url' => 'sometimes|required|url',
            'expires_at' => 'sometimes|required|date'
        ]);

        $url = Url::where('short_code', $url)->where('user_id', auth()->user()->id)->first();
        if (!$url) {
            return response()->json([
                'message' => 'URL not found',
            ], 404);
        }

        if ($request->has('original_url')) {
            $url->original_url = $request->original_url;
        }
        if ($request->has('expires_at')) {
            $url->expires_at = $request->expires_at;
        }
        $url->save();

        return response()->json([
            'message' => 'URL updated successfully',
            'original_url' => $url->original_url,
            'short_code' => $url->short_code,
            'expires_at' => $url->expires_at,
            'updated_at' => $url->updated_at
        ], 200);
    }

    // DELETE URL [DELETE]
    public function delete_url($url)
    {
        $url = Url::where('short_code', $url)->where('user_id', auth()->user()->id)->first();
        if (!$url) {
            return response()->json([
                'message' => 'URL not found',
            ], 404);
        }

        $url->delete();
        return response()->json([
            'message' => 'URL deleted successfully',
        ], 204);
    }

}
