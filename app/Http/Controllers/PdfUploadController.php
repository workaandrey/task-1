<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PdfUploadController extends Controller
{
    public function __invoke(Request $request, \stdClass $pdfService)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf|max:10000'
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('file');

        if($pdfService->searchFor($file, 'Proposal')) {
            $file->move('uploads');
            $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();

            $asset = Asset::where('name', $fileName)->where('size', $file->getSize())->fisrt();
            if(!$asset) {
                $asset = new Asset();
                $asset->name = $fileName;
            }

            $asset->size = $file->getSize();
            $asset->save();
        }

        return response()->json(['success' => 'success'], 200);
    }
}
