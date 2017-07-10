<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * AttachmentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attachments = [];

        if ($request->hasFile('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                $filename = str_random() . filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);

                $payload = [
                    'filename' => $filename,
                    'bytes' => $file->getClientSize(),
                    'mime' => $file->getClientMimeType()
                ];

                $file->move(attachments_path(), $filename);

                if ($request->input('article_id')) {
                    $attachments[] = \App\Article::findOrFail($request->input('article_id'))->attachments()->create($payload);
                } else if ($request->input('product_id')) {
                    $attachments[] = \App\Product::findOrFail($request->input('product_id'))->attachments()->create($payload);
                } else if ($request->input('market_id')) {
                    $attachments[] = \App\Market::findOrFail($request->input('market_id'))->attachments()->create($payload);
                } else if ($request->input('review_id')) {
                    $attachments[] = \App\Review::findOrFail($request->input('review_id'))->attachments()->create($payload);
                } else {
                    $attachments[] = \App\Attachment::create($payload);
                }


            }
        }

        return response()->json($attachments, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Update Attachment to main image
     *
     * @param  \App\Attachment $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Attachment $attachment)
    {
        $product = $attachment->attachable;
        $main = $product->attachments->first();

        if ($main == $attachment) {
            return response()->json($attachment, 200, [], JSON_PRETTY_PRINT);
        }

        $temp = $attachment->id;

        $attachment->id = $main->id;

        $main->id = Attachment::max('id') + 10;
        $main->save();
        $attachment->save();

        $main->id = $temp;
        $main->save();

        $product->ad_img_id = $attachment->id;
        $product->save();

        return response()->json($attachment, 200, [], JSON_PRETTY_PRINT);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        $path = attachments_path($attachment->name);

        if (\File::exists($path)) {
            \File::delete($path);
        }


        $attachment->delete();

        return response()->json([
        ], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  $file
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show($file)
    {
        $path = attachments_path($file);

        if (!\File::exists($path)) {
            abort(404);
        }

        $image = \Image::make($path);

        return response($image->encode('png'), 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
